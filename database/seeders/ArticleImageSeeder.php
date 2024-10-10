<?php

namespace Database\Seeders;

use App\Models\ArticleImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articleImages = [
            [
                'article_id' => 1,
                'image' => 'uploads/articles/article-image-1.jpg',
            ],
            [
                'article_id' => 1,
                'image' => 'uploads/articles/article-image-2.png',
            ],
            [
                'article_id' => 1,
                'image' => 'uploads/articles/article-image-3.jpg',
            ],
        ];

        foreach ($articleImages as $articleImage) {
            ArticleImage::create($articleImage);
        }
    }
}
