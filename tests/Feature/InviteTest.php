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

        $this->get("/invites/{$invite->token}/accept")
            ->assertRedirect('http://web/users/1/edit');
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
}
