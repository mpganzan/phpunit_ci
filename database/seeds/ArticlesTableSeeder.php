<?php

use App\User;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $users->each(function ($user) {
            factory('App\Article', 2)->create([
                'user_id' => $user->id
            ]);
        });
    }
}
