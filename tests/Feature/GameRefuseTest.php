<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameRefuseTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;
    protected $suggester;
    protected $user;
    protected $game;

    public function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('game-management')->create();

        $this->platform = factory('App\Platform')->create();
        $this->suggester = factory('App\Suggester')->create();
        $this->user = factory('App\User')->create();
        $this->game = factory('App\Game')->create();
        $this->user->roles()->attach($role);

        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function canRefuseGame()
    {
        $this->withoutExceptionHandling();

        $game = factory('App\Game')->states('unapproved')->create();

        $this->delete("/games/{$game->id}/refuse");

        $this->assertDatabaseMissing(
            'games',
            ['id' => $game->id]
        );
    }
}
