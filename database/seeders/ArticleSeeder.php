<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => fake()->sentence(8),
                'description' => '<p>' . fake()->text() . '</p>',
                'featured_image' => 'uploads/articles/article-1.jpg',
                'user_id' => 1,
            ],
            [
                'title' => fake()->sentence(8),
                'description' => '<p>' . fake()->text() . '</p>',
                'featured_image' => 'uploads/articles/article-2.jpeg',
                'user_id' => rand(1, 3),
            ],
            [
                'title' => fake()->sentence(8),
                'description' => '<p>' . fake()->text() . '</p>',
                'user_id' => rand(1, 3),
            ],
            [
                'title' => fake()->sentence(8),
                'description' => '<p>' . fake()->text() . '</p>',
                'user_id' => rand(1, 3),
            ],
            [
                'title' => fake()->sentence(8),
                'description' => '<p>' . fake()->text() . '</p>',
                'user_id' => rand(1, 3),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
