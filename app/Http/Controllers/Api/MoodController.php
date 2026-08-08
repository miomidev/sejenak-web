<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function index()
    {
        $moods = Mood::with('user')
            ->where('user_id', Auth::id()) // hanya mood user login
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $moods,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood' => 'required|in:happy,sad,anxious,stressed,calm,angry,tired,energetic,relaxed',
            'note' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        $mood = Mood::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mood saved successfully',
            'data' => $mood,
        ], 201);
    }

    public function show($id)
    {
        $mood = Mood::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('user')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $mood,
        ]);
    }

    public function destroy($id)
    {
        $mood = Mood::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $mood->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mood deleted successfully',
        ]);
    }

    public function statistics()
    {
        $user = Auth::user();

        $moodCounts = $user->moods()
            ->selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->get()
            ->pluck('count', 'mood');

        $recentMoods = $user->moods()
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();

        return response()->json([
            'success' => true,
            'mood_counts' => $moodCounts,
            'recent_moods' => $recentMoods,
        ]);
    }
}
