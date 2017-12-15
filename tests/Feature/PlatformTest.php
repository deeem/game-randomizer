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
        $this->get('/platforms/create')->assertRedirect('/login');
        $this->post('/platforms')->assertRedirect('/login');
        $this->get('/platforms/1/edit')->assertRedirect('/login');
        $this->put('/platforms/1')->assertRedirect('/login');
        $this->delete('/platforms/1')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canBrowsePlatformResources()
    {
        $this->get('/platforms')->assertStatus(200);
        $this->get('/platforms/create')->assertStatus(200);
        $this->get("/platforms/{$this->platform->id}/edit")->assertStatus(200);
    }

    /**
     * @test
     */
    public function canDestroyPlatform()
    {
        $this->delete("/platforms/{$this->platform->id}");

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
        $newPlatform = [
            'name' => 'newplatform',
            'slug' => 'newslug'
        ];

        $this->post('/platforms', $newPlatform);

        $this->assertDatabaseHas('platforms', $newPlatform);
    }

    /**
     * @test
     */
    public function canUpdatePlatform()
    {
        $this->put(
            "/platforms/{$this->platform->id}",
            ['name' => 'foo', 'slug' => 'newslug']
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
        $this->post('/platforms', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->put("/platform/{$this->platform->id}", ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post('/platforms', ['slug' => null])
            ->assertSessionHasErrors('slug');

        $this->put("/platform/{$this->platform->id}", ['slug' => null])
            ->assertSessionHasErrors('slug');
    }
}
