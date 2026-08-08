<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index()
    {
        $likes = Like::with(['user', 'post', 'comment'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $likes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id'    => 'nullable|exists:posts,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        $validated['user_id'] = Auth::id();

        if (empty($validated['post_id']) && empty($validated['comment_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Either post or comment must be selected.'
            ], 422);
        }

        if (!empty($validated['post_id']) && !empty($validated['comment_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot like both post and comment at the same time.'
            ], 422);
        }

        $existingLike = Like::where('user_id', $validated['user_id'])
            ->where(function ($query) use ($validated) {
                $query->where('post_id', $validated['post_id'])
                      ->orWhere('comment_id', $validated['comment_id']);
            })
            ->first();

        if ($existingLike) {
            return response()->json([
                'success' => false,
                'message' => 'Already liked this item.'
            ], 409);
        }

        $like = Like::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Like created successfully.',
            'data' => $like
        ], 201);
    }

    public function destroy($id)
    {
        $like = Like::findOrFail($id);

        if ($like->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like removed successfully.'
        ]);
    }

    public function toggleLike(Request $request)
{
    $validated = $request->validate([
        'post_id'    => 'nullable|exists:posts,id',
        'comment_id' => 'nullable|exists:comments,id',
    ]);

    $validated['user_id'] = Auth::id();

    $postId = $validated['post_id'] ?? null;
    $commentId = $validated['comment_id'] ?? null;

    $like = Like::where('user_id', $validated['user_id'])
        ->when($postId, fn($q) => $q->where('post_id', $postId))
        ->when($commentId, fn($q) => $q->where('comment_id', $commentId))
        ->first();

    if ($like) {
        $like->delete();
        $message = 'Like removed successfully.';
    } else {
        $like = Like::create($validated);
        $message = 'Like added successfully.';
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'data'    => $like
    ]);
}

}
