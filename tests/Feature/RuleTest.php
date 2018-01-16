<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RuleTest extends TestCase
{
    use DatabaseMigrations;

    protected $rule;

    protected function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('rule-management')->create();
        $user = factory('App\User')->create();
        $user->roles()->attach($role);
        $this->actingAs($user);

        $this->rule = factory('App\Rule')->create();
    }

    /**
     * @test
     */
    public function canStoreRule()
    {
        $rule = ['title' => 'foo', 'body' => 'bar'];

        $this->post('/rules', $rule);

        $this->assertDatabaseHas(
            'rules',
            ['title' => 'foo', 'body' => 'bar']
        );
    }

    /**
     * @test
     */
    public function canUpdateRule()
    {
        $this->withoutExceptionHandling();

        $this->put("/rules/{$this->rule->id}", ['title' => 'foo']);

        $this->assertDatabaseHas(
            'rules',
            ['id' => $this->rule->id, 'title' => 'foo']
        );
    }

    // create
    // edit
    // delete
    // list
    // canBrowse
    // guestCanList and Cannot participate
}
