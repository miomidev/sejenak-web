<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($reply->user_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk mengubah balasan ini.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $reply->update(['content' => $request->content]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'reply' => $reply,
                'message' => 'Balasan berhasil diperbarui.'
            ]);
        }

        return redirect()->back()->with('success', 'Balasan berhasil diperbarui.');
    }

    public function destroy(Request $request, Reply $reply)
    {
        if ($reply->user_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk menghapus balasan ini.');
        }

        $reply->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Balasan berhasil dihapus.');
    }
}
