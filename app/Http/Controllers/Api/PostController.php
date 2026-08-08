<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Ambil semua postingan
     */
    public function index()
    {
        $posts = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.likes',
            'comments.replies.user'
        ])
        ->notBanned()
        ->latest()
        ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    /**
     * Ambil semua postingan milik user yang login
     */
    public function getAllMyPost()
    {
        $userId = Auth::id();

        $posts = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.likes',
            'comments.replies.user'
        ])
        ->where('user_id', $userId)
        ->latest()
        ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    /**
     * Simpan postingan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_anonymous'] = $request->boolean('is_anonymous');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil dibuat',
            'data' => $post->load('user')
        ], 201);
    }

    /**
     * Tampilkan detail satu post
     */
    public function show($id)
    {
        $post = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // pastikan hanya pemilik post yang bisa update
        if ($post->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Tidak diizinkan'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil diperbarui',
            'data' => $post->load('user')
        ]);
    }

    /**
     * Hapus post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Tidak diizinkan'], 403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post berhasil dihapus'
        ]);
    }
}
