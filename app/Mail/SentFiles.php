<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentFiles extends Mailable
{
    use Queueable, SerializesModels;

    public $attachment;
    public $sender;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attachment, $sender)
    {
        //
        $this->attachment = $attachment;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        $email = $this->view('emails.attached')
                ->from($this->sender);
                foreach ($this->attachment as $item) {
                    $email->attach($item);
                }
        return $email;
    }
}
