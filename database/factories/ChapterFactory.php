<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chapter;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Chapter::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),

        'matrial_id' => factory(App\Matrial::class),
    ];
});
