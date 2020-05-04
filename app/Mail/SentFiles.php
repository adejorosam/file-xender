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
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attachment, $sender, $content)
    {
        //
        $this->attachment = $attachment;
        $this->sender = $sender;
        $this->content = $content;
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
                    // dd($item);
                    $email->attach($item);
                    // dd($item)
                }
                // dd($item->getRealPath());
        return $email;
    }
}
