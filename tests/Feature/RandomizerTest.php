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

        $this->get('/list')->assertSee($platform->name);
    }

    /**
     * @test
     */
    public function canSeeRandomizerPlatformsEmptyMessage()
    {
        $this->get('/list')->assertSee('Список пуст');
    }
}
