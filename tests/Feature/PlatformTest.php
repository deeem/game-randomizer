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

        $user = factory('App\User')->create();
        $this->actingAs($user);
    }

    /**
     * @test
     */
    public function unauthMayNotParticipate()
    {
        auth()->logout();
        $this->get('/users')->assertRedirect('/login');
        $this->get('/user/create')->assertRedirect('/login');
        $this->post('/user/store')->assertRedirect('/login');
        $this->get('/user/1/edit')->assertRedirect('/login');
        $this->post('/user/1/update')->assertRedirect('/login');
        $this->get('/user/1/destroy')->assertRedirect('/login');
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

    /**
     * @test
     */
    public function canValidate()
    {
        $this->post('/platform/store', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post("/platform/{$this->platform->id}/update", ['name' => null])
            ->assertSessionHasErrors('name');
    }
}
