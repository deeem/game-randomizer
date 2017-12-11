<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameResourceTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->platform = factory('App\Platform')->create();
        $this->user = factory('App\User')->create();
    }
    /**
     * @test
     */
    public function canBrowseGameResources()
    {
        $this->get('/games')->assertStatus(200);
        $this->get('/game/create')->assertStatus(200);
        // edit
    }

    /**
     * @test
     */
    public function canStoreGame()
    {
        $newGame = [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
            'user_id' => null
        ];

        $this->post('/game/store', $newGame);

        $this->assertDatabaseHas('games', $newGame);
    }
}
