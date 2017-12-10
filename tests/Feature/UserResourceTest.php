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
        $this->get('/user/create')->assertRedirect('/login');
        $this->post('/user/store')->assertRedirect('/login');
        $this->get('/user/1/edit')->assertRedirect('/login');
        $this->post('/user/1/update')->assertRedirect('/login');
        $this->get('/user/1/destroy')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function canBrowseUsersResources()
    {
        $this->get('/users')->assertStatus(200);
        $this->get('/user/create')->assertStatus(200);
        $this->get("/user/{$this->user->id}/edit")->assertSee($this->user->email);
    }

    /**
     * @test
     */
    public function canDestroyUser()
    {
        $this->get("/user/{$this->user->id}/destroy");

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

        $this->post('/user/store', $newUser);

        unset($newUser['password']);

        $this->assertDatabaseHas('users', $newUser);
    }

    /**
     * @test
     */
    public function canUpdateUser()
    {
        $this->post(
            "/user/{$this->user->id}/update",
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
}
