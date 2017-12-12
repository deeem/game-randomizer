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
        $this->get('/add')->assertStatus(200);
    }

    /**
     * @test
     */
    public function canStoreGame()
    {
        $platform = factory('App\Platform')->create();

        $game = [
            'name' => 'foo',
            'platform_id' => $platform->id;
        ];

        $this->post('/store', $game);

        $this->assertDatabaseHas('games', $game);
    }
}
