<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canSelectUnapprovedGames()
    {
        $this->actingAs(factory('App\User')->create());

        factory('App\Platform')->create();
        factory('App\Game')->create();
        factory('App\Game')->states('unapproved')->create();

        $unapprovedGames = \App\Game::unapproved()->get();

        $this->assertNull($unapprovedGames->first()->user_id);

    }
}
