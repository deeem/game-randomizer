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
}
