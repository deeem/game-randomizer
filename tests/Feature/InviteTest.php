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
        $this->post('/invite', ['email' => 'foo@example.com']);

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

        $this->post('/invite', ['email' => $email]);

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

        $this->get("/accept/{$invite->token}")
            ->assertSee('Good job! Invite accepted!');
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

        $this->get("/accept/{$invite->token}");

        $this->assertDatabaseMissing('invites', $data);
    }
}
