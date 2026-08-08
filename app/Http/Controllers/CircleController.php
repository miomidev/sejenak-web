<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\User;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    public function index()
    {
        $circles = Circle::with(['owner', 'members'])->withCount('members')->paginate(10);
        return view('circles.index', compact('circles'));
    }

    public function create()
    {
        $users = User::all();
        return view('circles.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
        ]);

        $circle = Circle::create($validated);
        
        // Add owner as moderator
        $circle->members()->attach($validated['owner_id'], ['role' => 'moderator']);

        return redirect()->route('circles.index')->with('success', 'Circle created successfully.');
    }

    public function show(Circle $circle)
    {
        $circle->load(['owner', 'members' => function ($query) {
            $query->withPivot('role');
        }]);
        return view('circles.show', compact('circle'));
    }

    public function edit(Circle $circle)
    {
        $users = User::all();
        return view('circles.edit', compact('circle', 'users'));
    }

    public function update(Request $request, Circle $circle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
        ]);

        $circle->update($validated);
        return redirect()->route('circles.index')->with('success', 'Circle updated successfully.');
    }

    public function destroy(Circle $circle)
    {
        $circle->delete();
        return redirect()->route('circles.index')->with('success', 'Circle deleted successfully.');
    }

    public function addMember(Circle $circle, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:member,moderator',
        ]);

        if ($circle->members()->where('user_id', $validated['user_id'])->exists()) {
            return redirect()->back()->with('error', 'User is already a member of this circle.');
        }

        $circle->members()->attach($validated['user_id'], ['role' => $validated['role']]);
        return redirect()->back()->with('success', 'Member added successfully.');
    }

    public function removeMember(Circle $circle, User $user)
    {
        if ($circle->owner_id === $user->id) {
            return redirect()->back()->with('error', 'Cannot remove the circle owner.');
        }

        $circle->members()->detach($user->id);
        return redirect()->back()->with('success', 'Member removed successfully.');
    }

    public function updateMemberRole(Circle $circle, User $user, Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:member,moderator',
        ]);

        $circle->members()->updateExistingPivot($user->id, ['role' => $validated['role']]);
        return redirect()->back()->with('success', 'Member role updated successfully.');
    }

    public function myCircles(User $user)
    {
        $circles = $user->circles()->with(['owner', 'members'])->paginate(10);
        return view('circles.my-circles', compact('user', 'circles'));
    }
}