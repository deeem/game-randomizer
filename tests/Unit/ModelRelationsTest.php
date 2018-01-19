<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ModelRelationsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $suggester;
    protected $platform;
    protected $games;

    public function setUp()
    {
        parent::setUp();

        $this->suggester = factory('App\Suggester')->create();
        $this->user = factory('App\User')->create();
        $this->platform = factory('App\Platform')->create();
        $this->games = factory('App\Game', 10)->create();
    }

    /**
     * @test
     */
    public function gameBelongsToUser()
    {
        $game = $this->games->random();

        $this->assertInstanceOf('App\User', $game->user);
    }

    /**
     * @test
     */
    public function gameBelongsToPlatform()
    {
        $game = $this->games->random();

        $this->assertInstanceOf('App\Platform', $game->platform);
    }

    /**
     * @test
     */
    public function gameBelongsToSuggester()
    {
        $game = $this->games->random();

        $this->assertInstanceOf('App\Suggester', $game->suggester);
    }

    /**
     * @test
     */
    public function suggesterHasManyGames()
    {
        $this->assertInstanceOf('App\Game', $this->suggester->games->first());
    }

    /**
     * @test
     */
    public function platformHasManyGames()
    {
        $this->assertInstanceOf('App\Game', $this->platform->games->first());
    }

    /**
     * @test
     */
    public function userHasManyGames()
    {
        $this->assertInstanceOf('App\Game', $this->user->games->first());
    }

    /**
     * @test
     */
    public function userBelongsToManyRoles()
    {

        $role_invites = factory('App\Role')->states('invite-management')->create();
        $role_users = factory('App\Role')->states('user-management')->create();
        $user = factory('App\User')->create();
        $user->roles()->attach($role_invites->id);
        $user->roles()->attach($role_users->id);

        $this->assertInstanceOf('App\Role', $user->roles->random());
    }

    /**
     * @test
     */
    public function rolesBelongsToManyUsers()
    {
        $role = factory('App\Role')->states('game-management')->create();
        factory('App\User', 3)->create()->each(function($user) use ($role) {
            $user->roles()->attach($role->id);
        });

        $this->assertInstanceOf('App\User', $role->users->random());
    }
}
