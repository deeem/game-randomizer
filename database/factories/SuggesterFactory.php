<?php

use Faker\Generator as Faker;

$factory->define(App\Suggester::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
