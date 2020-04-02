<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'title' => $faker->title,
        'author' => $faker->name,
        'description' => $faker->text,
    ];
});
