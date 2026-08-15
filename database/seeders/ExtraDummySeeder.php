<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Like;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ExtraDummySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        if ($users->isEmpty()) return;
        
        $mainUser = $users->first();
        $otherUser = $users->last();
        $admin = User::whereHas('role', function($q){ $q->where('name', 'super_admin')->orWhere('name', 'admin'); })->first() ?? $mainUser;

        // 1. Seed Blog Posts
        $this->command->info('Seeding Blog Posts...');
        $categories = BlogCategory::all();
        
        if ($categories->isNotEmpty()) {
            $catId = $categories->first()->id;
            
            $articles = [
                [
                    'title' => 'Cara Mengelola Stres di Tempat Kerja',
                    'content' => '<p>Stres di tempat kerja adalah hal yang wajar, namun jika dibiarkan dapat berdampak buruk pada kesehatan mental. Berikut adalah beberapa cara mengelolanya:</p><ul><li>Ambil jeda istirahat singkat</li><li>Lakukan peregangan</li><li>Bicarakan dengan rekan kerja</li></ul><p>Penting untuk selalu menjaga keseimbangan antara kehidupan dan pekerjaan.</p>',
                    'excerpt' => 'Stres di tempat kerja adalah hal yang wajar, namun jika dibiarkan dapat berdampak buruk pada kesehatan mental.',
                    'featured_image' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=2070',
                ],
                [
                    'title' => 'Pentingnya Meditasi Setiap Pagi',
                    'content' => '<p>Meditasi pagi membantu kita memulai hari dengan lebih fokus dan tenang. Cukup dengan 10 menit setiap hari, kamu bisa merasakan perbedaan yang luar biasa dalam produktivitas.</p>',
                    'excerpt' => 'Meditasi pagi membantu kita memulai hari dengan lebih fokus dan tenang.',
                    'featured_image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2020',
                ]
            ];

            foreach ($articles as $index => $article) {
                BlogPost::create([
                    'title' => $article['title'],
                    'slug' => Str::slug($article['title']) . '-' . Str::random(4),
                    'excerpt' => $article['excerpt'],
                    'content' => $article['content'],
                    'featured_image' => $article['featured_image'],
                    'category_id' => $categories->random()->id,
                    'user_id' => $admin->id,
                    'is_published' => true,
                    'published_at' => Carbon::now()->subDays($index),
                    'view_count' => rand(10, 100),
                ]);
            }
        }

        // 2. Seed Comments & Replies
        $this->command->info('Seeding Comments, Replies, and Likes...');
        $posts = Post::all();
        if ($posts->isNotEmpty()) {
            $post = $posts->first();

            // Comment
            $comment = Comment::create([
                'post_id' => $post->id,
                'user_id' => $otherUser->id,
                'content' => 'Wah setuju banget sama postingan ini! Sangat relate.'
            ]);

            // Reply to comment
            Reply::create([
                'comment_id' => $comment->id,
                'user_id' => $mainUser->id,
                'content' => 'Iya kan? Semoga kita semua bisa lebih baik lagi.'
            ]);

            // Likes on post
            Like::create([
                'user_id' => $otherUser->id,
                'post_id' => $post->id
            ]);

            Like::create([
                'user_id' => $mainUser->id,
                'post_id' => $post->id
            ]);

            // Likes on comment
            Like::create([
                'user_id' => $mainUser->id,
                'comment_id' => $comment->id
            ]);
        }

        $this->command->info('Extra Dummy Data berhasil dibuat!');
    }
}
