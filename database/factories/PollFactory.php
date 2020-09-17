<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Poll;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;

$factory->define(Poll::class, function (Faker $faker) {
    return [
        'titulo' => $faker->name,
        'data_inicio' => $faker->dateTime(),
        'description' => $faker->dateTime()
    ];
});
