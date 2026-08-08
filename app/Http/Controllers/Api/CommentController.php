<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['post', 'user', 'replies.user', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }
public function getByPost($postId)
{
    $comments = Comment::with(['user', 'replies.user', 'likes'])
        ->where('post_id', $postId)
        ->orderBy('created_at', 'asc')
        ->get();

    if ($comments->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No comments found for this post.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $comments,
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $comment->load('user'),
            'message' => 'Comment created successfully',
        ], 201);
    }

    public function show(Comment $comment)
    {
        $comment->load(['post', 'user', 'replies.user', 'likes']);
        return response()->json([
            'success' => true,
            'data' => $comment,
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        // pastikan hanya pemilik komentar yang bisa update
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $comment,
            'message' => 'Comment updated successfully',
        ]);
    }

    public function destroy(Comment $comment)
    {
        // pastikan hanya pemilik komentar yang bisa hapus
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }
}
