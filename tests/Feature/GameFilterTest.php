<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canFilterGamesByPlatforms()
    {
        $this->withoutExceptionHandling();

        $role = factory('App\Role')->states('game-management')->create();
        $user = factory('App\User')->create();
        $user->roles()->attach($role);
        $this->actingAs($user);

        factory('App\Suggester')->create();
        $firstPlatform = factory('App\Platform')->create();
        $firstPlatformGame = factory('App\Game')->create(['platform_id' => $firstPlatform->id]);
        $secondPlatform = factory('App\Platform')->create();
        $secondPlatformGame = factory('App\Game')->create(['platform_id' => $secondPlatform->id]);

        $this->get("/games/{$firstPlatform->slug}")
            ->assertSee($firstPlatformGame->name)
            ->assertDontSee($secondPlatformGame->name);
    }
}
