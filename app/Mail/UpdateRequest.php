<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $req;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($req)
    {
        $this->req = $req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->req->email, $this->req->name)
                    ->subject('Request Updated')
                    ->from('admin@example.com')
                    ->view('email.update')
                    ->with('req', $this->req);
    }
}
