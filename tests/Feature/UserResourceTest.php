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
    public function canBrowse()
    {
        $this->get('/users')->assertStatus(200);
        $this->get('/user/create')->assertStatus(200);
        $this->get("/user/{$this->user->id}/edit")->assertSee($this->user->email);
    }


    /**
     * @test
     */
    public function canDestroy()
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
    public function canStore()
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
    public function canUpdate()
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
