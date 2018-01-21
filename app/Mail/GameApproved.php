<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $gameName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gameName)
    {
        $this->gameName = $gameName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.approved');
    }
}
