<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OpenRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $agent;
    public $req;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agent, $req)
    {
        $this->agent = $agent;
        $this->req = $req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->agent->email, $this->agent->name)
            ->subject('New Request')
            ->from('admin@example.com')
            ->view('email.open')
            ->with('agent', $this->agent)
            ->with('req', $this->req);
    }
}
