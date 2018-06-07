<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'content' => $faker->paragraph(10, true),
    ];
});
