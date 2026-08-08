<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComunityController extends Controller
{
    public function user()
    {
        $posts = Post::with([
            'user:id,name,username,avatar',
            'likes',
            'comments.user:id,name,username,avatar',
            'comments.likes',
            'comments.replies.user:id,name,username,avatar'
        ])->notBanned()
          ->latest()
          ->take(100)
          ->get();
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
            }
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
                ($user->reply_likes_count * 2);

            return $user;
        })
        ->sortByDesc('score')
        ->take(10);
        return view('comunity.user', compact(['posts','topUsers']));
    }
}
