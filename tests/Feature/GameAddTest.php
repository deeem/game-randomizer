<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameAddTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;
    protected $suggester;
    protected $user;
    protected $game;

    public function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('game-management')->create();

        $this->suggester = factory('App\Suggester')->create();
        $this->platform = factory('App\Platform')->create();
        $this->user = factory('App\User')->create();
        $this->user->roles()->attach($role);
        $this->game = factory('App\Game')->create();

        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function canSeeUnapprovedGameInSuggestedGameList()
    {
        $game = factory('App\Game')->states('unapproved')->create();

        $this->get('/games/suggested')->assertSee($game->name);
    }

    /**
     * @test
     */
    public function whenGuestCreateGameItIsNotApproved()
    {
        auth()->logout();

        $this->post('games', [
            'name' => 'foo',
            'platform_id' => $this->platform->id
        ]);

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => null
            ]
        );
    }

    /**
     * @test
     */
    public function whenUserCreateGameItIsApproved()
    {
        $this->post('/games', [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
        ]);

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'user_id' => $this->user->id,
            ]
        );
    }

    /**
     * @test
     */
    public function whenUserCreateGameItIsHasSuggestedByThatUser()
    {
        $this->post('/games', [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
        ]);

        $game = \App\Game::where([
            'name' => 'foo',
            'platform_id' => $this->platform->id,
        ])->first();

        $this->assertEquals($this->user->name, $game->suggester->name);
    }

    /**
     * @test
     */
    public function whenUserCreateGameNoAdditionalSuggesterCreated()
    {
        factory('App\Suggester')->create([
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);

        $this->post('/games', [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
        ]);

        $suggesters = \App\Suggester::where([
            'name' => $this->user->name,
            'email' => $this->user->email,
        ])->get();

        $this->assertEquals(1, $suggesters->count());
    }

    /**
     * @test
     */
    public function whenUserApproveGameItHasUserId()
    {
        $game = factory('App\Game')->states('unapproved')->create();

        $this->get("/games/{$game->id}/approve");

        $this->assertDatabaseHas(
            'games',
            [
                'name' => $game->name,
                'platform_id' => $this->platform->id,
                'user_id' => $this->user->id
            ]
        );
    }

    /**
     * @test
     */
    public function guestCanBrowseAddGameForm()
    {
        $this->get('/games/create')->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestCanStoreGame()
    {
        $platform = factory('App\Platform')->create();

        $game = [
            'name' => 'foo',
            'platform_id' => $platform->id
        ];

        $this->post('/games', $game);

        $this->assertDatabaseHas('games', $game);
    }

    /**
     * @test
     */
    public function guestAddedGameWithEmptySuggesterInfoItHasEmptySuggesterId()
    {
        auth()->logout();

        $this->post(
            '/games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
            ]
        );

        $this->assertDatabaseHas(
            'games',
            [
                'name' => 'foo',
                'platform_id' => $this->platform->id,
                'suggester_id' => null
            ]
        );
    }

    /**
     * @test
     */
    public function guestAddedGameWithSuggesterInfoItHasSuggesterInfo()
    {
        auth()->logout();

        $data = [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
            'suggester_name' => 'John',
            'suggester_email' => 'john@example.com',
        ];

        $this->post('/games', $data);

        $game = \App\Game::where([
            'name' => $data['name'],
            'platform_id' => $data['platform_id']
        ])->first();

        $this->assertEquals($game->suggester->name, $data['suggester_name']);
    }

    /**
     * @test
     */
    public function whenGuestCreateGameNoAdditionalSuggestersCreated()
    {
        $data = [
            'name' => 'foo',
            'platform_id' => $this->platform->id,
            'suggester_name' => 'John',
            'suggester_email' => 'john@example.com',
        ];

        factory('App\Suggester')->create([
            'name' => $data['suggester_name'],
            'email' => $data['suggester_email']
        ]);

        auth()->logout();

        $this->post('/games', $data);

        $game = \App\Game::where([
            'name' => $data['name'],
            'platform_id' => $data['platform_id']
        ])->first();

        // assert that created game has suggester
        $this->assertEquals($game->suggester->name, $data['suggester_name']);

        $suggesters = \App\Suggester::where([
            'name' => $data['suggester_name'],
            'email' => $data['suggester_email'],
        ])->get();

        // assert that it used existing suggester
        $this->assertEquals(1, $suggesters->count());
    }
}
