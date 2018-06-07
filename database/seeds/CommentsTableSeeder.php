<?php

use App\Article;
use App\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();

        $articles->each(function ($article) {
            factory('App\Comment')->create([
                'article_id' => $article->id,
                'user_id' => User::inRandomOrder()->first()->id
            ]);
        });
    }
}
