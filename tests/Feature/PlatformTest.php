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
    public function unauthMayNotParticipateWithPlatforms()
    {
        auth()->logout();
        $this->get('/platforms')->assertRedirect('/login');
        $this->get('/platform/create')->assertRedirect('/login');
        $this->post('/platform/store')->assertRedirect('/login');
        $this->get('/platform/1/edit')->assertRedirect('/login');
        $this->post('/platform/1/update')->assertRedirect('/login');
        $this->get('/platform/1/destroy')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canBrowsePlatformResources()
    {
        $this->get('/platforms')->assertStatus(200);
        $this->get('/platform/create')->assertStatus(200);
        $this->get("/platform/{$this->platform->id}/edit")->assertStatus(200);
    }

    /**
     * @test
     */
    public function canDestroyPlatform()
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
    public function canStorePlatform()
    {
        $this->withoutExceptionHandling();
        $newPlatform = ['name' => 'newplatform'];

        $this->post('/platform/store', $newPlatform);

        $this->assertDatabaseHas('platforms', $newPlatform);
    }

    /**
     * @test
     */
    public function canUpdatePlatform()
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
    public function canValidatePlatform()
    {
        $this->post('/platform/store', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post("/platform/{$this->platform->id}/update", ['name' => null])
            ->assertSessionHasErrors('name');
    }
}
