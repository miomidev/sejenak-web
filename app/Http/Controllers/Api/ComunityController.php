<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;

class ComunityController extends Controller
{
    public function index()
    {
        // ambil postingan komunitas
        $posts = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.likes',
            'comments.replies.user'
        ])
        ->notBanned()
        ->latest()
        ->take(100)
        ->get();

        // hitung top users
        $topUsers = User::withCount([
            'journals',
            'posts',
            'comments',
            'likes',
        ])
        ->withCount([
            'posts as post_likes_count' => function ($q) {
                $q->join('likes', 'posts.id', '=', 'likes.post_id');
            },
            'comments as comment_likes_count' => function ($q) {
                $q->join('likes', 'comments.id', '=', 'likes.comment_id');
            },
        ])
        ->get()
        ->map(function ($user) {
            $user->score =
                ($user->journals_count * 3) +
                ($user->posts_count * 2) +
                ($user->comments_count * 1) +
                ($user->likes_count * 1) +
                ($user->post_likes_count * 2) +
                ($user->comment_likes_count * 2) +
                ($user->reply_likes_count ?? 0 * 2);

            return $user;
        })
        ->sortByDesc('score')
        ->take(10)
        ->values();

        return response()->json([
            'status' => 'success',
            'posts' => $posts,
            'top_users' => $topUsers
        ]);
    }
}
