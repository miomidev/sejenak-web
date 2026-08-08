<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index()
    {
        $likes = Like::with(['user', 'post', 'comment'])->orderBy('created_at', 'desc')->paginate(20);
        return view('likes.index', compact('likes'));
    }

    public function create()
    {
        $posts = Post::all();
        $comments = Comment::all();
        $users = User::all();
        return view('likes.create', compact('posts', 'comments', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'nullable|exists:posts,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        // Ensure only one of post_id or comment_id is provided
        if (empty($validated['post_id']) && empty($validated['comment_id'])) {
            return redirect()->back()->with('error', 'Either post or comment must be selected.');
        }

        if (!empty($validated['post_id']) && !empty($validated['comment_id'])) {
            return redirect()->back()->with('error', 'Cannot like both post and comment at the same time.');
        }

        // Check if like already exists
        $existingLike = Like::where('user_id', $validated['user_id'])
            ->where(function ($query) use ($validated) {
                $query->where('post_id', $validated['post_id'])
                      ->orWhere('comment_id', $validated['comment_id']);
            })
            ->first();

        if ($existingLike) {
            return redirect()->back()->with('error', 'Already liked this item.');
        }

        Like::create($validated);
        return redirect()->route('likes.index')->with('success', 'Like created successfully.');
    }

    public function show(Like $like)
    {
        $like->load(['user', 'post', 'comment']);
        return view('likes.show', compact('like'));
    }

    public function destroy(Like $like)
    {
        $like->delete();
        return redirect()->route('likes.index')->with('success', 'Like removed successfully.');
    }

    public function toggleLike(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'nullable|exists:posts,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        $like = Like::where('user_id', $validated['user_id'])
            ->where('post_id', $validated['post_id'])
            ->where('comment_id', $validated['comment_id'])
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Like removed successfully.';
        } else {
            Like::create($validated);
            $message = 'Like added successfully.';
        }

        return redirect()->back()->with('success', $message);
    }
}