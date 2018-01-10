<?php

use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
        'permissions' => []
    ];
});

$factory->state(App\Role::class, 'invite-management', function (Faker $faker) {
    return [
        'name' => 'Invite management',
        'slug' => 'invites',
        'permissions' => [
            'create-invite' => true,
            'destroy-invite' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'user-management', function (Faker $faker) {
    return [
        'name' => 'User management',
        'slug' => 'users',
        'permissions' => [
            'list-users' => true,
            'create-user' => true,
            'edit-user' => true,
            'show-user' => true,
            'delete-user' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'platform-management', function (Faker $faker) {
    return [
        'name' => 'Platform management',
        'slug' => 'platforms',
        'permissions' => [
            'list-platforms' => true,
            'create-platform' => true,
            'edit-platform' => true,
            'show-platform' => true,
            'delete-platform' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'game-management', function (Faker $faker) {
    return [
        'name' => 'Game management',
        'slug' => 'games',
        'permissions' => [
            'list-games' => true,
            'create-game' => true,
            'edit-game' => true,
            'show-game' => true,
            'delete-game' => true,
        ]
    ];
});
