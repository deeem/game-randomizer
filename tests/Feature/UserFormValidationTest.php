<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserFormValidationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('user-management')->create();
        $this->user = factory('App\User')->create();
        $this->user->roles()->attach($role);
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function storeValidationUserForm()
    {
        $this->store(['name' => null])->assertSessionHasErrors('name');
        $this->store(['email' => null])->assertSessionHasErrors('email');
        $this->store(['password' => null])->assertSessionHasErrors('password');
    }

    /**
     * @test
     */
    public function updateValidationUserForm()
    {
        $this->update(['name' => null])->assertSessionHasErrors('name');
        $this->update(['email' => null])->assertSessionHasErrors('email');
    }

    public function store($overrides = [])
    {
        $user = factory('App\User')->make($overrides);

        $response = $this->post('/users', $user->toArray());

        return $response;
    }

    public function update($overrides = [])
    {
        $user = factory('App\User')->create();

        $response = $this->put("/users/{$user->id}", $overrides);

        return $response;
    }
}
