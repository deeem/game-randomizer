<?php

namespace Tests\Feature;

use App\Mail\GameRefused;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameRefuseTest extends TestCase
{
    use DatabaseMigrations;

    protected $platform;
    protected $suggester;
    protected $user;
    protected $game;

    public function setUp()
    {
        parent::setUp();

        $role = factory('App\Role')->states('game-management')->create();

        $this->platform = factory('App\Platform')->create();
        $this->suggester = factory('App\Suggester')->create();
        $this->user = factory('App\User')->create();
        $this->game = factory('App\Game')->create();
        $this->user->roles()->attach($role);

        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function canRefuseGame()
    {
        $game = factory('App\Game')->states('unapproved')->create();

        $this->delete("/games/{$game->id}/refuse");

        $this->assertDatabaseMissing(
            'games',
            ['id' => $game->id]
        );
    }

    /**
     * @test
     */
    public function canSendRefusedMail()
    {
        Mail::fake();
        $email = $this->suggester->email;
        $game = factory('App\Game')->states('unapproved')->create();

        $this->delete("/games/{$game->id}/refuse");

        Mail::assertSent(GameRefused::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
