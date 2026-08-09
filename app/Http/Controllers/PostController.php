<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
   public function toggleLike(Post $post)
{
    $like = Like::where('user_id', Auth::id())
                ->where('post_id', $post->id)
                ->first();

    if ($like) {
        $like->delete();
    } else {
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);
    }

    return response()->json([
        'likes_count' => $post->likes()->count(),
        'liked' => !$like
    ]);
}

public function toggleCommentLike(Comment $comment)
{
    $like = Like::where('user_id', Auth::id())
                ->where('comment_id', $comment->id)
                ->first();

    if ($like) {
        $like->delete();
    } else {
        Like::create([
            'user_id' => Auth::id(),
            'comment_id' => $comment->id,
        ]);
    }

    return response()->json([
        'likes_count' => $comment->likes()->count(),
        'liked' => !$like
    ]);
}

public function loadComment(Post $post) {
    $post->load('user');

    $comments = $post->comments()
        ->with(['user', 'replies.user'])
        ->latest()
        ->get();

    return response()->json([
        'post' => $post,
        'comments' => $comments
    ]);
}

    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        // 'user_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_anonymous' => 'boolean',
    ]);
$validated['user_id'] = Auth::id();
    // Set default value untuk is_anonymous jika tidak ada
    $validated['is_anonymous'] = $request->has('is_anonymous') ? true : false;

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('posts', 'public');
    }

    Post::create($validated);
    return redirect()->route('user.comunity')->with('success', 'Post created successfully.');
}
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes.user']);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = $id instanceof Post ? $id : Post::findOrFail($id);

        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, $id)
    {
        $post = $id instanceof Post ? $id : Post::findOrFail($id);

        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean',
        ]);

        $validated['is_anonymous'] = $request->has('is_anonymous') ? true : false;

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);
        return redirect()->route('user.comunity')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = $id instanceof Post ? $id : Post::findOrFail($id);

        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('user.comunity')->with('success', 'Post deleted successfully.');
    }
}
