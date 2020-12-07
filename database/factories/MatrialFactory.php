<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Matrial;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Matrial::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
    ];
});
