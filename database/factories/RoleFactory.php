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
        'slug' => 'invite-management',
        'permissions' => [
            'create-invite' => true,
            'destroy-invite' => true,
            'list-invites' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'user-management', function (Faker $faker) {
    return [
        'name' => 'User management',
        'slug' => 'user-management',
        'permissions' => [
            'list-users' => true,
            'create-user' => true,
            'edit-user' => true,
            'delete-user' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'platform-management', function (Faker $faker) {
    return [
        'name' => 'Platform management',
        'slug' => 'platform-management',
        'permissions' => [
            'list-platforms' => true,
            'create-platform' => true,
            'edit-platform' => true,
            'delete-platform' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'game-management', function (Faker $faker) {
    return [
        'name' => 'Game management',
        'slug' => 'game-management',
        'permissions' => [
            'approved-games' => true,
            'suggested-games' => true,
            'suggest-game' => true,
            'edit-game' => true,
            'delete-game' => true,
            'approve-game' => true,
        ]
    ];
});

$factory->state(App\Role::class, 'rule-management', function (Faker $faker) {
    return [
        'name' => 'Rule management',
        'slug' => 'rule-management',
        'permissions' => [
            'create-rule' => true,
            'edit-rule' => true,
            'delete-rule' => true,
        ]
    ];
});
