<?php

namespace Tests\Unit;

use App\Platform;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;

class PlatformTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canGetGamesStats()
    {
        $this->actingAs(factory('App\User')->create());
        factory('App\Platform', 3)->create();
        factory('App\Game', 20)->create();

        $stats = Platform::gamesStats();

        $this->assertInstanceOf(Collection::class, $stats);
        $this->assertEquals(3, $stats->count());
    }
}
