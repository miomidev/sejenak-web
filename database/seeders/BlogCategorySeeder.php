<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Kesehatan Mental',
                'slug' => 'kesehatan-mental',
                'color' => '#3B82F6',
                'description' => 'Artikel seputar kesehatan mental dan psikologi'
            ],
            [
                'name' => 'Meditasi',
                'slug' => 'meditasi',
                'color' => '#8B5CF6',
                'description' => 'Panduan dan tips meditasi untuk pemula'
            ],
            [
                'name' => 'Pengembangan Diri',
                'slug' => 'pengembangan-diri',
                'color' => '#EC4899',
                'description' => 'Tips untuk pengembangan diri dan growth mindset'
            ],
            [
                'name' => 'Tips Harian',
                'slug' => 'tips-harian',
                'color' => '#10B981',
                'description' => 'Tips praktis untuk kehidupan sehari-hari'
            ],
            [
                'name' => 'Inspirasi',
                'slug' => 'inspirasi',
                'color' => '#F59E0B',
                'description' => 'Kisah inspiratif dan motivasi'
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }

        $this->command->info('Blog categories seeded successfully!');
    }
}