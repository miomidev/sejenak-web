<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'user_id' => 3,
                'title' => 'Today I practiced',
                'content' => 'Today I practiced mindfulness for 20 minutes. Feeling much more centered and peaceful!',
                'image' => 'posts/mindfulness.jpg',
                'is_anonymous' => false,
                'is_banned' => false,
                'is_pinned' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Struggling with anxiety today.',
                'content' => 'Struggling with anxiety today. Any tips for managing overwhelming thoughts?',
                'image' => null,
                'is_anonymous' => true,
                'is_banned' => false,
                'is_pinned' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'user_id' => 2,
                'title' => 'I recommend practicing deep breathing exercises when feeling anxious.',
                'content' => 'As a counselor, I recommend practicing deep breathing exercises when feeling anxious. Remember: this too shall pass.',
                'image' => 'posts/breathing.jpg',
                'is_anonymous' => false,
                'is_banned' => false,
                'is_pinned' => true,
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => 3,
                'title'=>'Just completed the 7-day',
                'content' => 'Just completed the 7-day gratitude challenge! Highly recommend it to everyone.',
                'image' => 'posts/gratitude.jpg',
                'is_anonymous' => false,
                'is_banned' => false,
                'is_pinned' => false,
                'created_at' => now()->subDays(3),
            ],
        ];

        DB::table('posts')->insert($posts);
    }
}