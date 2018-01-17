<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $platform;

    public function setUp()
    {
        parent::setUp();

        factory('App\Suggester')->create();
        $this->user = factory('App\User')->create();
        $this->actingAs($this->user);
        $this->platform = factory('App\Platform')->create();
    }

    /**
     * @test
     */
    public function canSelectUnapprovedGames()
    {
        factory('App\Game')->create();
        factory('App\Game')->states('unapproved')->create();

        $unapprovedGames = \App\Game::unapproved()->get();

        $this->assertNull($unapprovedGames->first()->user_id);
    }

    /**
     * @test
     */
    public function canSelectRecentApprovedGames()
    {
        factory('App\Game')->create();
        factory('App\Game')->states('unapproved')->create();

        $approvedGames = \App\Game::recentApproved()->get();

        $this->assertEquals($this->user->id, $approvedGames->first()->user_id);
    }
}
