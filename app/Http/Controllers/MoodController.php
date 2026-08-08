<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\User;
use Illuminate\Http\Request;

class MoodController extends Controller
{
    public function index()
    {
        $moods = Mood::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('moods.index', compact('moods'));
    }

    public function create()
    {
        $users = User::all();
        $moodTypes = ['happy', 'sad', 'anxious', 'stressed', 'calm', 'angry', 'tired', 'energetic', 'relaxed'];
        return view('moods.create', compact('users', 'moodTypes'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'mood' => 'required|in:happy,sad,anxious,stressed,calm,angry,tired,energetic,relaxed',
        'note' => 'nullable|string',
    ]);

    $mood = Mood::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Mood saved successfully',
        'data' => $mood
    ], 201); // 201 = Created
}


    public function show(Mood $mood)
    {
        $mood->load('user');
        return view('moods.show', compact('mood'));
    }

    public function edit(Mood $mood)
    {
        $users = User::all();
        $moodTypes = ['happy', 'sad', 'anxious', 'stressed', 'calm', 'angry', 'tired', 'energetic', 'relaxed'];
        return view('moods.edit', compact('mood', 'users', 'moodTypes'));
    }

    public function update(Request $request, Mood $mood)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'mood' => 'required|in:happy,sad,anxious,stressed,calm,angry,tired,energetic,relaxed',
            'note' => 'nullable|string',
        ]);

        $mood->update($validated);
        return redirect()->route('moods.index')->with('success', 'Mood updated successfully.');
    }

    public function destroy(Mood $mood)
    {
        $mood->delete();
        return redirect()->route('moods.index')->with('success', 'Mood deleted successfully.');
    }

    public function userMoods(User $user)
    {
        $moods = $user->moods()->orderBy('created_at', 'desc')->paginate(15);
        return view('moods.user-moods', compact('user', 'moods'));
    }

    public function moodStatistics(User $user)
    {
        $moodCounts = $user->moods()
            ->selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->get()
            ->pluck('count', 'mood');

        $recentMoods = $user->moods()
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();

        return view('moods.statistics', compact('user', 'moodCounts', 'recentMoods'));
    }
}