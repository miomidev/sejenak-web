<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['post', 'user', 'replies'])->orderBy('created_at', 'desc')->paginate(15);
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $posts = Post::all();
        $users = User::all();
        return view('comments.create', compact('posts', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);
        
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        
        $comment->load('user');
        
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Komentar berhasil ditambahkan.'
        ]);
    }

    public function show(Comment $comment)
    {
        $comment->load(['post', 'user', 'replies.user', 'likes']);
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $posts = Post::all();
        $users = User::all();
        return view('comments.edit', compact('comment', 'posts', 'users'));
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk mengubah komentar ini.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update(['content' => $request->content]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'message' => 'Komentar berhasil diperbarui.'
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $comment->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
