<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameApprovingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function whenGuestCreateGameItHasNoUserId()
    {
        $platform = factory('App\Platform')->create();

        $game = [
            'name' => 'foo',
            'platform_id' => $platform->id
        ];

        $this->post('games', $game);

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $platform->id,
                'user_id' => null
            ]
        );
    }

    /**
     * @test
     */
    public function whenUserCreateGameItHasIdOfCreatedUser()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);
        $platform = factory('App\Platform')->create();

        $game = [
            'name' => 'foo',
            'platform_id' => $platform->id
        ];

        $this->post('/games', $game);

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $platform->id,
                'user_id' => $user->id
            ]
        );
    }

    /**
     * @test
     */
    public function whenUserApproveGameItHasUserId()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);
        $platform = factory('App\Platform')->create();

        $game = factory('App\Game')->states('unapproved')->create();

        $this->get("/approve/{$game->id}");

        $this->assertDatabaseHas(
            'games',
            [
                'name' => $game->name,
                'platform_id' => $platform->id,
                'user_id' => $user->id
            ]
        );
    }
}
