<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameResourceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function canBrowseGameResources()
    {
        $this->get('/games')->assertStatus(200);
    }
}
