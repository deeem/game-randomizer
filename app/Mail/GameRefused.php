<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameRefused extends Mailable
{
    use Queueable, SerializesModels;

    public $gameName;
    public $rule;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gameName, $rule)
    {
        $this->gameName = $gameName;
        $this->rule = $rule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.refused');
    }
}
