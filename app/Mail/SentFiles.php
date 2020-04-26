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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attachment)
    {
        //
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        $email = $this->view('emails.attached')
                ->from('sender@domain.com');
                foreach ($this->attachment as $item) {
                    $email->attach($item);
                }
        return $email;
    }
}
