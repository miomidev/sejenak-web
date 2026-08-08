<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id === 1) {
            $replies = Reply::with(['comment.post', 'user'])->latest()->paginate(15);
        } else {
            $replies = Reply::with(['comment.post', 'user'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return response()->json([
            'success' => true,
            'data' => $replies
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        $reply = Reply::create($validated);

        return response()->json([
            'success' => true,
            'data' => $reply->load('user'),
            'message' => 'Reply created successfully.'
        ], 201);
    }

    public function show(Reply $reply)
    {
        $user = Auth::user();

        if ($user->role_id !== 1 && $reply->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $reply->load(['comment.post', 'user'])
        ]);
    }

    public function update(Request $request, Reply $reply)
    {
        $user = Auth::user();

        if ($user->role_id !== 1 && $reply->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $reply->update($validated);

        return response()->json([
            'success' => true,
            'data' => $reply,
            'message' => 'Reply updated successfully.'
        ]);
    }

    public function destroy(Reply $reply)
    {
        $user = Auth::user();

        if ($user->role_id !== 1 && $reply->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $reply->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reply deleted successfully.'
        ]);
    }
}
