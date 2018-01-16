<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RuleTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('rule-management')->create();
        $user = factory('App\User')->create();
        $user->roles()->attach($role);
        $this->actingAs($user);
    }

    /**
     * @test
     */
    public function canAddRule()
    {
        $this->withoutExceptionHandling();

        $rule = ['title' => 'foo', 'body' => 'bar'];

        $this->post('/rules', $rule);

        $this->assertDatabaseHas(
            'rules',
            ['title' => 'foo', 'body' => 'bar']
        );
    }

    // edit
    // delete
    // list
    // canBrowse
    // guestCanList and Cannot participate
}
