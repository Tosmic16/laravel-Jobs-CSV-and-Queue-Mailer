<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComputanEmail extends Mailable
{
    use Queueable, SerializesModels;
public $mes;
public $sub;
public $fro;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mes,$sub,$fro)
    {
        $this->mes = $mes;
        $this->sub = $sub;
        $this->fro = $fro;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->sub,
            from: $this->fro
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.sent',
        );
    }
    public function build()
    {
     
        return $this->view('email.sent')
            ->with(['html'=>$this->mes]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
