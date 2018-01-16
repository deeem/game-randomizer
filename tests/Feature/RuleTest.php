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
        $this->put("/rules/{$this->rule->id}", ['title' => 'foo']);

        $this->assertDatabaseHas(
            'rules',
            ['id' => $this->rule->id, 'title' => 'foo']
        );
    }

    /**
     * @test
     */
    public function canDestroyRule()
    {
        $this->delete("/rules/{$this->rule->id}");

        $this->assertDatabaseMissing(
            'rules',
            ['id' => $this->rule->id, 'title' => $this->rule->title]
        );
    }

    // create
    // edit
    // list
    // canBrowse
    // guestCanList and Cannot participate
    // validation
}
