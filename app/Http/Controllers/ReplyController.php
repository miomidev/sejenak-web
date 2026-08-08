<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index()
    {
        $replies = Reply::with(['comment', 'user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('replies.index', compact('replies'));
    }

    public function create()
    {
        $comments = Comment::all();
        $users = User::all();
        return view('replies.create', compact('comments', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:1000',
        ]);
        
        $reply = Reply::create([
            'comment_id' => $request->comment_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        
        $reply->load('user');
        
        return response()->json([
            'success' => true,
            'reply' => $reply,
            'message' => 'Balasan berhasil ditambahkan.'
        ]);
    }
    public function show(Reply $reply)
    {
        $reply->load(['comment.post', 'user']);
        return view('replies.show', compact('reply'));
    }

    public function edit(Reply $reply)
    {
        $comments = Comment::all();
        $users = User::all();
        return view('replies.edit', compact('reply', 'comments', 'users'));
    }

    public function update(Request $request, Reply $reply)
    {
        $validated = $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $reply->update($validated);
        return redirect()->route('replies.index')->with('success', 'Reply updated successfully.');
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return redirect()->route('replies.index')->with('success', 'Reply deleted successfully.');
    }
}