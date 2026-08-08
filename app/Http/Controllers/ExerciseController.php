<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::withCount('users')->paginate(12);
        $types = ['breathing', 'mindfulness', 'grounding'];
        return view('exercises.index', compact('exercises', 'types'));
    }

    public function create()
    {
        $types = ['breathing', 'mindfulness', 'grounding'];
        return view('exercises.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:breathing,mindfulness,grounding',
            'description' => 'required|string',
            'media_path' => 'nullable|file|mimes:mp4,avi,mov,mp3,wav|max:20480',
        ]);

        if ($request->hasFile('media_path')) {
            $validated['media_path'] = $request->file('media_path')->store('exercises', 'public');
        }

        Exercise::create($validated);
        return redirect()->route('exercises.index')->with('success', 'Exercise created successfully.');
    }

    public function show(Exercise $exercise)
    {
        $exercise->load(['users' => function ($query) {
            $query->withPivot('status');
        }]);
        return view('exercises.show', compact('exercise'));
    }

    public function edit(Exercise $exercise)
    {
        $types = ['breathing', 'mindfulness', 'grounding'];
        return view('exercises.edit', compact('exercise', 'types'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:breathing,mindfulness,grounding',
            'description' => 'required|string',
            'media_path' => 'nullable|file|mimes:mp4,avi,mov,mp3,wav|max:20480',
        ]);

        if ($request->hasFile('media_path')) {
            if ($exercise->media_path) {
                Storage::disk('public')->delete($exercise->media_path);
            }
            $validated['media_path'] = $request->file('media_path')->store('exercises', 'public');
        } else {
            unset($validated['media_path']);
        }

        $exercise->update($validated);
        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        if ($exercise->media_path) {
            Storage::disk('public')->delete($exercise->media_path);
        }
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }

    public function startExercise(Exercise $exercise, User $user)
    {
        if ($exercise->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already started this exercise.');
        }

        $exercise->users()->attach($user->id, ['status' => 'started']);
        return redirect()->back()->with('success', 'Exercise started successfully.');
    }

    public function completeExercise(Exercise $exercise, User $user)
    {
        $exercise->users()->updateExistingPivot($user->id, ['status' => 'completed']);
        return redirect()->back()->with('success', 'Exercise marked as completed.');
    }

    public function byType($type)
    {
        $exercises = Exercise::where('type', $type)->paginate(12);
        $types = ['breathing', 'mindfulness', 'grounding'];
        return view('exercises.index', compact('exercises', 'types', 'type'));
    }

    public function userProgress(User $user)
    {
        $exercises = $user->exercises()->withPivot('status')->paginate(12);
        $completed = $user->exercises()->wherePivot('status', 'completed')->count();
        $started = $user->exercises()->wherePivot('status', 'started')->count();
        
        return view('exercises.user-progress', compact('user', 'exercises', 'completed', 'started'));
    }
    public function user()
    {
return view('exercises.user');
    }
}