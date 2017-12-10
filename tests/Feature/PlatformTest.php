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
        $this->get('/platform/create')->assertStatus(200);
        $this->get("/platform/{$this->platform->id}/edit")->assertStatus(200);
    }

    /**
     * @test
     */
    public function canDestroy()
    {
        $this->get("/platform/{$this->platform->id}/destroy");

        $this->assertDatabaseMissing(
            'platforms',
            ['id' => $this->platform->id, 'name' => $this->platform->name]
        );
    }

    /**
     * @test
     */
    public function canStore()
    {
        $this->withoutExceptionHandling();
        $newPlatform = ['name' => 'newplatform'];

        $this->post('/platform/store', $newPlatform);

        $this->assertDatabaseHas('platforms', $newPlatform);
    }

    /**
     * @test
     */
    public function canUpdate()
    {
        $this->post(
            "/platform/{$this->platform->id}/update",
            ['name' => 'foo']
        );

        $this->assertDatabaseHas(
            'platforms',
            ['id' => $this->platform->id, 'name' => 'foo']
        );
    }
}
