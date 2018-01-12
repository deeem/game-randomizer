<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameResourceTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;
    protected $user;
    protected $game;

    public function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('game-management')->create();

        $this->platform = factory('App\Platform')->create();
        $this->user = factory('App\User')->create();
        $this->game = factory('App\Game')->create();
        $this->user->roles()->attach($role);

        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function canBrowseGameResources()
    {
        $this->get('/games/create')->assertStatus(200);
        $this->get('/games/1/edit')->assertStatus(200);
    }

    /**
     * @test
     */
    public function unauthMayNotParticipateWithGames()
    {
        auth()->logout();
        $this->get('/games/1/edit')->assertRedirect('/login');
        $this->put('/games/1')->assertRedirect('/login');
        $this->delete('/games/1')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canDestroyGame()
    {
        $this->delete("/games/{$this->game->id}");

        $this->assertDatabaseMissing(
            'games',
            ['id' => $this->game->id, 'name' => $this->game->name]
        );
    }

    /**
     * @test
     */
    public function canStoreGame()
    {
        $this->post(
            '/games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => null,
                'suggested' => 'bar'
            ]
        );

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => $this->user->id,
                'suggested' => $this->user->name
            ]
        );
    }

    /**
     * @test
     */
    public function canUpdateGame()
    {
        $this->put(
            "/games/{$this->game->id}",
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id
            ]
        );

        $this->assertDatabaseHas(
            'games',
            [
                'id' => $this->game->id,
                'name' => 'foo'
            ]
        );
    }

    /**
     * @test
     */
    public function canValidateGame()
    {
        $this->post('/games', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->put("/games/{$this->game->id}", ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post('/games', ['platform_id' => null])
            ->assertSessionHasErrors('platform_id');

        $this->put("/games/{$this->game->id}", ['platform_id' => null])
            ->assertSessionHasErrors('platform_id');

        $this->post('/games', ['platform_id' => 999])
            ->assertSessionHasErrors('platform_id');

        $this->put("/games/{$this->game->id}", ['platform_id' => 999])
            ->assertSessionHasErrors('platform_id');

        $this->post('/games', ['name' => $this->game->name, 'platform_id' => $this->platform->id])
            ->assertSessionHasErrors('name');

        $this->put("/games/{$this->game->id}", ['name' => $this->game->name, 'platform_id' => $this->platform->id])
            ->assertSessionHasErrors('name');
    }
}
