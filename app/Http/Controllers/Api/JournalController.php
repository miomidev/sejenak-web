<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Services\FastApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class JournalController extends Controller
{
    private FastApiService $fastApi;

    public function __construct(FastApiService $fastApi)
    {
        $this->fastApi = $fastApi;
    }

    public function index()
    {
        $journals = Journal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $journals,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'      => 'nullable|exists:journals,id',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        if (!empty($validated['id'])) {
            $journal = Journal::where('id', $validated['id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $journal->update([
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ]);

            $message = 'Journal updated successfully';
        } else {
            $journal = Journal::create([
                'user_id' => Auth::id(),
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ]);

            $message = 'Journal created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $journal,
        ], 200);
    }

    public function storeVoice(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:wav,mp3,m4a,ogg|max:25600',
        ]);

        $audioPath = $request->file('audio')->store('journal-audios', 'public');
        $audioContent = file_get_contents(storage_path("app/public/$audioPath"));
        $audioBase64 = base64_encode($audioContent);

        $token = JWTAuth::parseToken()->getToken();

        $transcriptionResponse = $this->fastApi->post('/transcribe', [
            'audio_base64' => $audioBase64,
            'language' => 'id',
        ], $token);

        if ($transcriptionResponse->json('status') !== 'success') {
            return response()->json([
                'success' => false,
                'message' => 'Transcription failed',
            ], 500);
        }

        $transcription = $transcriptionResponse->json('data');

        $organizeResponse = $this->fastApi->post('/journal/organize', [
            'content' => $transcription['text'],
            'audio_metadata' => [
                'duration' => $transcription['duration'],
                'language' => $transcription['language'],
            ],
        ], $token);

        $organized = $organizeResponse->json('status') === 'success'
            ? $organizeResponse->json('data')
            : [
                'title' => substr($transcription['text'], 0, 50),
                'mood' => 'neutral',
                'category' => 'reflection',
                'card_type' => 'mood',
                'tags' => ['jurnal'],
                'summary' => substr($transcription['text'], 0, 100),
            ];

        $journal = Journal::create([
            'user_id' => Auth::id(),
            'title' => $organized['title'],
            'content' => $transcription['text'],
            'audio_path' => $audioPath,
            'audio_duration' => $transcription['duration'],
            'transcription_model' => 'whisper-large-v3',
            'transcription_confidence' => $transcription['confidence'],
            'mood' => $organized['mood'],
            'category' => $organized['category'],
            'card_type' => $organized['card_type'],
            'is_voice_entry' => true,
            'ai_metadata' => $organized,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voice journal created successfully',
            'data' => $journal,
        ], 201);
    }

    public function cards(Request $request)
    {
        $journals = Journal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($journal) {
                return $journal->created_at->format('Y-m-d');
            });

        $cards = [];
        foreach ($journals as $date => $entries) {
            $cards[] = [
                'date' => $date,
                'entries' => $entries,
                'count' => $entries->count(),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $cards,
        ]);
    }

    public function insights(Request $request)
    {
        $entries = Journal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($journal) {
                return [
                    'id' => $journal->id,
                    'content' => $journal->content,
                    'mood' => $journal->mood,
                    'category' => $journal->category,
                    'card_type' => $journal->card_type,
                    'created_at' => $journal->created_at->toISOString(),
                ];
            })
            ->toArray();

        $token = JWTAuth::parseToken()->getToken();

        $response = $this->fastApi->post('/journal/insights', [
            'entries' => $entries,
        ], $token);

        return response()->json([
            'success' => true,
            'data' => $response->json('status') === 'success'
                ? $response->json('data')
                : ['mood_trend' => 'unknown', 'patterns' => [], 'suggestions' => []],
        ]);
    }

    public function show($id)
    {
        $journal = Journal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $journal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $journal = Journal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $journal->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Journal updated successfully',
            'data'    => $journal,
        ]);
    }

    public function destroy($id)
    {
        $journal = Journal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($journal->audio_path) {
            Storage::disk('public')->delete($journal->audio_path);
        }

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Journal deleted successfully',
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $journals = Journal::where('user_id', Auth::id())
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $journals,
        ]);
    }

    public function stats(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $journaledDays = Journal::where('user_id', Auth::id())
            ->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)
            ->pluck('updated_at')
            ->map(function ($date) {
                return $date->day;
            })
            ->toArray();

        return response()->json([
            'success' => true,
            'month' => $month,
            'year' => $year,
            'days' => $journaledDays,
        ]);
    }
}
