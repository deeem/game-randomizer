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

        $this->platform = factory('App\Platform')->create();
        $this->user = factory('App\User')->create();
        $this->game = factory('App\Game')->create();

        $this->actingAs($this->user);
    }
    /**
     * @test
     */
    public function canBrowseGameResources()
    {
        $this->get('/games')->assertStatus(200);
        $this->get('/game/create')->assertStatus(200);
        $this->get("/game/{$this->game->id}/edit")->assertSee($this->game->name);
    }

    /**
     * @test
     */
    public function unauthMayNotParticipateWithGames()
    {
        auth()->logout();
        $this->get('/games')->assertRedirect('/login');
        $this->get('/game/create')->assertRedirect('/login');
        $this->post('/game/store')->assertRedirect('/login');
        $this->get('/game/1/edit')->assertRedirect('/login');
        $this->post('/game/1/update')->assertRedirect('/login');
        $this->get('/game/1/destroy')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canDestroyGame()
    {
        $this->get("/game/{$this->game->id}/destroy");

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
            '/game/store',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => null
            ]
        );

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => $this->user->id
            ]
        );
    }

    /**
     * @test
     */
    public function canUpdateGame()
    {
        $this->post(
            "/game/{$this->game->id}/update",
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
        $this->post('/game/store', ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post("/game/{$this->game->id}/update", ['name' => null])
            ->assertSessionHasErrors('name');

        $this->post('/game/store', ['platform_id' => null])
            ->assertSessionHasErrors('platform_id');

        $this->post("/game/{$this->game->id}/update", ['platform_id' => null])
            ->assertSessionHasErrors('platform_id');

        $this->post('/game/store', ['platform_id' => 999])
            ->assertSessionHasErrors('platform_id');

        $this->post("/game/{$this->game->id}/update", ['platform_id' => 999])
            ->assertSessionHasErrors('platform_id');
    }
}
