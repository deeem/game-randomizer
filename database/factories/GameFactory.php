<?php

use Faker\Generator as Faker;

$factory->define(App\Game::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'platform_id' => function() {
            return App\Platform::all()->random()->id;
        },
        'user_id' => function() {
            return App\User::all()->random()->id;
        }
    ];
});

$factory->state(App\Game::class, 'unapproved', function (Faker $faker) {
    return [
        'user_id' => null
    ];
});
