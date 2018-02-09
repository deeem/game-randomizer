<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RandomizerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canSeeRandomizerPlatfomsList()
    {
        $platform = factory('App\Platform')->create();

        $this->get('/roll')->assertSee($platform->name);
    }

    /**
     * @test
     */
    public function canSeeRandomizerPlatformsEmptyNotification()
    {
        $this->get('/roll')->assertSee('Список пуст');
    }

    /**
     * @test
     */
    public function canSeeRandomizerResult()
    {
        factory('App\Suggester')->create();
        $user = factory('App\User')->create();
        $platform = factory('App\Platform')->create();
        $game = factory('App\Game')->create();

        $this->get("/roll/{$platform->slug}")->assertSee($game->name);
    }

    /**
     * @test
     */
    public function canSeeRandomizerEmptyNotification()
    {
        factory('App\Suggester')->create();
        $user = factory('App\User')->create();
        $platform = factory('App\Platform')->create();
        $game = factory('App\Game')->states('unapproved')->create();

        $this->get("/roll/{$platform->slug}")->assertSee('Список пуст');
    }
}
