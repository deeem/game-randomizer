<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserResourceTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function unauthMayNotParticipateWithUsers()
    {
        auth()->logout();
        $this->get('/users')->assertRedirect('/login');
        $this->get('/users/create')->assertRedirect('/login');
        $this->get('/users/1/edit')->assertRedirect('/login');
        $this->post('/users')->assertRedirect('/login');
        $this->put('/users/1')->assertRedirect('/login');
        $this->delete('/users/1')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canBrowseUsersResources()
    {
        $this->get('/users')->assertStatus(200);
        $this->get('/users/create')->assertStatus(200);
        $this->get("/users/{$this->user->id}/edit")->assertSee($this->user->email);
    }

    /**
     * @test
     */
    public function canDestroyUser()
    {
        $this->delete("/users/{$this->user->id}");

        $this->assertDatabaseMissing(
            'users',
            ['id' => $this->user->id, 'name' => $this->user->name]
        );
    }

    /**
     * @test
     */
    public function canStoreUser()
    {
        $newUser = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret'
        ];

        $this->post('/users', $newUser);

        unset($newUser['password']);

        $this->assertDatabaseHas('users', $newUser);
    }

    /**
     * @test
     */
    public function canUpdateUser()
    {
        $this->put(
            "/users/{$this->user->id}",
            [
                'name' => 'newname',
                'email' => $this->user->email,
                'password' => 'secret'
            ]
        );

        $this->assertDatabaseHas(
            'users',
            ['id' => $this->user->id, 'name' => 'newname']
        );
    }

    /**
     * @test
     */
    public function createdUserHasGamesManagementPermissions()
    {
        factory('App\Role')->states('game-management')->create();

        $this->post(
            '/users',
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'secret'
            ]
        );

        $user = \App\User::where('email', 'john@example.com')->first();

        $this->assertTrue($user->hasAccess(['delete-game']));
    }
}
