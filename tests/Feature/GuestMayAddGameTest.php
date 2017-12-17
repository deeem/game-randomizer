<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GuestMayAddGameTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canBrowseAddGameForm()
    {
        $this->get('/games/create')->assertStatus(200);
    }

    /**
     * @test
     */
    public function canStoreGame()
    {
        $platform = factory('App\Platform')->create();

        $game = [
            'name' => 'foo',
            'platform_id' => $platform->id
        ];

        $this->post('/games', $game);

        $this->assertDatabaseHas('games', $game);
    }
}
