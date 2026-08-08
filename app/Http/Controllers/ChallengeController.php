<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::withCount('users')->orderBy('date', 'desc')->paginate(10);
        return view('challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        Challenge::create($validated);
        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully.');
    }

    public function show(Challenge $challenge)
    {
        $challenge->load(['users' => function ($query) {
            $query->withPivot('status');
        }]);
        return view('challenges.show', compact('challenge'));
    }

    public function edit(Challenge $challenge)
    {
        return view('challenges.edit', compact('challenge'));
    }

    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $challenge->update($validated);
        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully.');
    }

    public function destroy(Challenge $challenge)
    {
        $challenge->delete();
        return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully.');
    }

    public function join(Challenge $challenge, User $user)
    {
        if ($challenge->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'User already joined this challenge.');
        }

        $challenge->users()->attach($user->id, ['status' => 'pending']);
        return redirect()->back()->with('success', 'Successfully joined the challenge.');
    }

    public function complete(Challenge $challenge, User $user)
    {
        $challenge->users()->updateExistingPivot($user->id, ['status' => 'completed']);
        return redirect()->back()->with('success', 'Challenge marked as completed.');
    }

    public function leave(Challenge $challenge, User $user)
    {
        $challenge->users()->detach($user->id);
        return redirect()->back()->with('success', 'Successfully left the challenge.');
    }

    public function participants(Challenge $challenge)
    {
        $participants = $challenge->users()->withPivot('status')->paginate(15);
        return view('challenges.participants', compact('challenge', 'participants'));
    }
}