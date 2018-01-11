<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RolePermissionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider administratorPermissionProvider
     */
    public function aministratorPermissionsTest($expected, $permission)
    {
        $role_invites = factory('App\Role')->states('invite-management')->create();
        $role_users = factory('App\Role')->states('user-management')->create();
        $role_platforms = factory('App\Role')->states('platform-management')->create();
        $role_games = factory('App\Role')->states('game-management')->create();

        $admin = factory('App\User')->create();
        $admin->roles()->attach($role_invites->id);
        $admin->roles()->attach($role_users->id);
        $admin->roles()->attach($role_platforms->id);
        $admin->roles()->attach($role_games->id);

        $this->assertEquals($expected, $admin->hasAccess($permission));
    }

    /**
     * @test
     * @dataProvider moderatorPermissionProvider
     */
    public function moderatorPermissionTest($expected, $permission)
    {
        $role_games = factory('App\Role')->states('game-management')->create();

        $moderator = factory('App\User')->create();
        $moderator->roles()->attach($role_games->id);

        $this->assertEquals($expected, $moderator->hasAccess($permission));
    }

    public function administratorPermissionProvider()
    {
        return [
         [true, ['create-invite']],
         [true, ['destroy-invite']],
         [true, ['list-invites']],
         [true, ['list-users']],
         [true, ['create-user']],
         [true, ['edit-user']],
         [true, ['delete-user']],
         [true, ['list-platforms']],
         [true, ['create-platform']],
         [true, ['edit-platform']],
         [true, ['show-platform']],
         [true, ['delete-platform']],
         [true, ['approved-games']],
         [true, ['suggested-games']],
         [true, ['suggest-game']],
         [true, ['edit-game']],
         [true, ['delete-game']],
         [true, ['approve-game']],
        ];
    }

    public function moderatorPermissionProvider()
    {
        return [
         [false, ['create-invite']],
         [false, ['destroy-invite']],
         [false, ['list-invites']],
         [false, ['list-users']],
         [false, ['create-user']],
         [false, ['edit-user']],
         [false, ['delete-user']],
         [false, ['list-platforms']],
         [false, ['create-platform']],
         [false, ['edit-platform']],
         [false, ['show-platform']],
         [false, ['delete-platform']],
         [true, ['approved-games']],
         [true, ['suggested-games']],
         [true, ['suggest-game']],
         [true, ['edit-game']],
         [true, ['delete-game']],
         [true, ['approve-game']],
        ];
    }
}
