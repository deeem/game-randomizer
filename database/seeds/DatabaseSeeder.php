<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);

        factory('App\Platform', 10)->create();
        factory('App\Suggester', 100)->create();
        factory('App\Game', 100)->create();
        factory('App\Game', 50)->states('unapproved')->create();
        factory('App\Game', 20)->states('anonimously')->create();
        factory('App\Invite', 20)->create();
        factory('App\Rule', 10)->create();
    }
}
