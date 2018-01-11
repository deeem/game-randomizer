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

        $role = factory('App\Role')->states('platform-management')->create();
        $user = factory('App\User')->create();
        $user->roles()->attach($role);
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
        $this->get("/platforms/{$this->platform->slug}/edit")->assertRedirect('/login');
        $this->put("/platforms/{$this->platform->slug}")->assertRedirect('/login');
        $this->delete("/platforms/{$this->platform->slug}")->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canBrowsePlatformResources()
    {
        $this->get('/platforms')->assertStatus(200);
        $this->get('/platforms/create')->assertStatus(200);
        $this->get("/platforms/{$this->platform->slug}/edit")->assertStatus(200);
    }

    /**
     * @test
     */
    public function canDestroyPlatform()
    {
        $this->delete("/platforms/{$this->platform->slug}");

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
            'name' => 'newplatform'
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
            "/platforms/{$this->platform->slug}",
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
        $this->post('/platforms', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->put("/platform/{$this->platform->slug}", ['name' => null])
            ->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function canGenerateSlug()
    {
        $this->put(
            "/platforms/{$this->platform->slug}",
            ['name' => 'Foo Bar']
        );

        $this->assertDatabaseHas(
            'platforms',
            ['id' => $this->platform->id, 'slug' => 'foo-bar']
        );
    }
}
