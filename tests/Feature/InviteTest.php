<?php

namespace Tests\Feature;

use App\Invite;
use App\Mail\InviteCreated;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InviteTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory('App\User')->create());
    }

    /**
     * @test
     */
    public function canCreateInvite()
    {
        $this->post('/invites', ['email' => 'foo@example.com']);

        $this->assertDatabaseHas(
            'invites',
            ['email' => 'foo@example.com']
        );
    }

    /**
     * @test
     */
    public function canSentInviteEmail()
    {
        Mail::fake();

        $email = 'foo@bar.com';

        $this->post('/invites', ['email' => $email]);

        Mail::assertSent(InviteCreated::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

    /**
     * @test
     */
    public function canAcceptInvite()
    {
        $invite = Invite::create([
            'email' => 'foo@example.com',
            'token' => str_random()
        ]);

        auth()->logout();

        $this->get("/invites/{$invite->token}/accept")
            ->assertRedirect('http://web/users/2/edit');
    }

    /**
     * @test
     */
    public function confirmThatAcceptedInviteDeleted()
    {
        $data = [
            'email' => 'foo@example.com',
            'token' => str_random()
        ];

        $invite = Invite::create($data);

        $this->get("/invites/{$invite->token}/accept");

        $this->assertDatabaseMissing('invites', $data);
    }

    /**
     * @test
     */
    public function validateInviteForm()
    {
        $this->post('/invites', ['email' => null])
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function guestCanNotCreateInvites()
    {
        auth()->logout();

        $this->get('/invites')->assertRedirect('login');
        $this->get('/invites/create')->assertRedirect('login');
        $this->post('/invites')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function canDestroyInvites()
    {
        $invite = factory('App\Invite')->create();

        $email = $invite->email;
        $id = $invite->id;

        $this->delete("/invites/{$invite->id}");

        $this->assertDatabaseMissing(
            'invites',
            ['id' => $id, 'email' => $email]
        );
    }

    /**
     * @test
     */
    public function invitedUserHasGamesManagementPermissions()
    {
        factory('App\Role')->states('game-management')->create();

        $data = [
            'email' => 'foo@example.com',
            'token' => str_random()
        ];

        $invite = Invite::create($data);

        $this->get("/invites/{$invite->token}/accept");

        $user = \App\User::where('email', 'foo@example.com')->first();

        $this->assertTrue($user->hasAccess(['delete-game']));
    }
}
