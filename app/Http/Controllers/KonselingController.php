<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function user(){
        return view('messages.user');
    }
    public function index()
    {
        $messages = Message::with(['session', 'sender'])->paginate(20);
        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        $sessions = Session::all();
        $users = User::all();
        return view('messages.create', compact('sessions', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'sender_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'type' => 'required|in:text,image,audio',
        ]);

        Message::create($validated);
        return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
    }

    public function show(Message $message)
    {
        $message->load(['session', 'sender']);
        return view('messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        $sessions = Session::all();
        $users = User::all();
        return view('messages.edit', compact('message', 'sessions', 'users'));
    }

    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'sender_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'type' => 'required|in:text,image,audio',
        ]);

        $message->update($validated);
        return redirect()->route('messages.index')->with('success', 'Message updated successfully.');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
    }
}