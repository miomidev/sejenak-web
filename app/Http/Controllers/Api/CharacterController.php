<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiCharacter;
use App\Models\CharacterConversation;
use App\Models\Journal;
use App\Services\FastApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CharacterController extends Controller
{
    private FastApiService $fastApi;

    public function __construct(FastApiService $fastApi)
    {
        $this->fastApi = $fastApi;
    }

    public function index()
    {
        $characters = AiCharacter::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $characters,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'personality' => 'required|string',
            'avatar_url' => 'nullable|string|max:255',
            'first_message' => 'nullable|string',
            'tone' => 'nullable|string|in:empathetic,analytical,playful,wise,direct',
            'expertise' => 'nullable|array',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();

        if (isset($validated['is_default']) && $validated['is_default']) {
            AiCharacter::where('user_id', Auth::id())
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $character = AiCharacter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Character created successfully',
            'data' => $character,
        ], 201);
    }

    public function show($id)
    {
        $character = AiCharacter::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $character,
        ]);
    }

    public function update(Request $request, $id)
    {
        $character = AiCharacter::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'personality' => 'sometimes|string',
            'avatar_url' => 'nullable|string|max:255',
            'first_message' => 'nullable|string',
            'tone' => 'nullable|string|in:empathetic,analytical,playful,wise,direct',
            'expertise' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        if (isset($validated['is_default']) && $validated['is_default']) {
            AiCharacter::where('user_id', Auth::id())
                ->where('is_default', true)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $character->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Character updated successfully',
            'data' => $character,
        ]);
    }

    public function destroy($id)
    {
        $character = AiCharacter::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        CharacterConversation::where('ai_character_id', $id)->delete();
        $character->delete();

        return response()->json([
            'success' => true,
            'message' => 'Character deleted successfully',
        ]);
    }

    public function chat(Request $request, $id)
    {
        $character = AiCharacter::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $history = CharacterConversation::where('user_id', Auth::id())
            ->where('ai_character_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->reverse()
            ->toArray();

        $token = JWTAuth::parseToken()->getToken();

        $response = $this->fastApi->post("/characters/{$id}/chat", [
            'character' => $character->toArray(),
            'message' => $validated['message'],
            'conversation_history' => $history,
        ], $token);

        $responseText = $response->json('status') === 'success'
            ? $response->json('data.response')
            : "*{$character->name} sedang tidak bisa menjawab. Coba lagi nanti.*";

        CharacterConversation::create([
            'user_id' => Auth::id(),
            'ai_character_id' => $id,
            'message' => $validated['message'],
            'is_from_character' => false,
        ]);

        CharacterConversation::create([
            'user_id' => Auth::id(),
            'ai_character_id' => $id,
            'message' => $responseText,
            'is_from_character' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'response' => $responseText,
            ],
        ]);
    }

    public function respondToJournal(Request $request, $characterId, $journalId)
    {
        $character = AiCharacter::where('id', $characterId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $journal = Journal::where('id', $journalId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $recentEntries = Journal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($j) {
                return [
                    'content' => $j->content,
                    'mood' => $j->mood,
                    'created_at' => $j->created_at->toISOString(),
                ];
            })
            ->toArray();

        $token = JWTAuth::parseToken()->getToken();

        $response = $this->fastApi->post("/characters/{$characterId}/respond", [
            'character' => $character->toArray(),
            'journal_entry' => [
                'id' => $journal->id,
                'content' => $journal->content,
                'mood' => $journal->mood,
                'category' => $journal->category,
            ],
            'recent_entries' => $recentEntries,
        ], $token);

        $responseText = $response->json('status') === 'success'
            ? $response->json('data.response')
            : "*{$character->name} sedang berpikir...*";

        CharacterConversation::create([
            'user_id' => Auth::id(),
            'ai_character_id' => $characterId,
            'journal_entry_id' => $journalId,
            'message' => $responseText,
            'is_from_character' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'response' => $responseText,
            ],
        ]);
    }

    public function conversations(Request $request, $id)
    {
        $character = AiCharacter::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $conversations = CharacterConversation::where('user_id', Auth::id())
            ->where('ai_character_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $conversations,
        ]);
    }
}
