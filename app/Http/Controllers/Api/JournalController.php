<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
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
            // UPDATE
            $journal = Journal::where('id', $validated['id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $journal->update([
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ]);

            $message = 'Journal updated successfully';
        } else {
            // CREATE
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

    public function stats()
    {
        $month = 12; // Desember
        $year = now()->year;

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
