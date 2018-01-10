<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
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

        $moderators = factory('App\User', 10)->create();
        $moderators->each(function($user) use ($role_games) {
            $user->roles()->attach($role_games->id);
        });
    }
}
