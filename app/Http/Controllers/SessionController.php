<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with(['user', 'counselor', 'messages'])->paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        $users = User::where('role_id', 1)->get(); // Regular users
        $counselors = User::where('role_id', 2)->get(); // Counselors
        return view('sessions.create', compact('users', 'counselors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'konselor_id' => 'required|exists:users,id',
            'status' => 'required|in:ongoing,closed',
        ]);

        Session::create($validated);
        return redirect()->route('sessions.index')->with('success', 'Session created successfully.');
    }

    public function show(Session $session)
    {
        $session->load(['user', 'counselor', 'messages.sender']);
        return view('sessions.show', compact('session'));
    }

    public function edit(Session $session)
    {
        $users = User::where('role_id', 1)->get();
        $counselors = User::where('role_id', 2)->get();
        return view('sessions.edit', compact('session', 'users', 'counselors'));
    }

    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'konselor_id' => 'required|exists:users,id',
            'status' => 'required|in:ongoing,closed',
        ]);

        $session->update($validated);
        return redirect()->route('sessions.index')->with('success', 'Session updated successfully.');
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully.');
    }

    public function close(Session $session)
    {
        $session->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Session closed successfully.');
    }
}