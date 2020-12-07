<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;



$factory->define(Answer::class, function (Faker $faker) {
    return [
        'text' => Str::random(20),
        'is_correct' => Arr::random([true, false]),

        'quetion_id' => factory(App\Quetion::class),
    ];
});
