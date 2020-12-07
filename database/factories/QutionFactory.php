<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quetion;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

$factory->define(Quetion::class, function (Faker $faker) {
    return [
        'text' => Str::random(20),
        'difficulty' => Arr::random(['easy', 'hard']),
        'time' => rand(10,100),
        'chapter_id' => factory(App\Chapter::class),
    ];
});
