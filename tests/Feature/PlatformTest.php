<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Platform;

class PlatformTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;

    public function setUp()
    {
        parent::setUp();
        $this->platform = factory(Platform::class)->create();
    }

    /**
     * @test
     */
    public function canBrowse()
    {
        $this->get('/platforms')->assertStatus(200);
        // edit
        // create
    }
}
