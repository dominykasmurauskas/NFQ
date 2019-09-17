<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'ticket' => $faker->unique()->randomNumber(),
        'service' => $faker->numberBetween(0, 5),
        'estimated_visit_time' => $faker->dateTime()
    ];
});
