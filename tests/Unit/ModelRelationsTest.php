<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ModelRelationsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $platform;
    protected $games;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->platform = factory('App\Platform')->create();
        $this->games = factory('App\Game', 10)->create();
    }

    /**
     * @test
     */
    public function gameBelongsToUser()
    {
        $game = $this->games->random();

        $this->assertInstanceOf('App\User', $game->user);
    }

    /**
     * @test
     */
    public function gameBelongsToPlatform()
    {
        $game = $this->games->random();

        $this->assertInstanceOf('App\Platform', $game->platform);
    }

    /**
     * @test
     */
    public function platformHasManyGames()
    {
        $this->assertInstanceOf('App\Game', $this->platform->games->first());
    }

    /**
     * @test
     */
    public function userHasManyGames()
    {
        $this->assertInstanceOf('App\Game', $this->user->games->first());
    }
}
