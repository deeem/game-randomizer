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
        factory('App\User', 10)->create();
        factory('App\Platform', 10)->create();
        factory('App\Game', 100)->create();
        factory('App\Game', 50)->states('unaproved')->create();
    }
}
