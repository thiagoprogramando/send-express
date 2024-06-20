<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Product extends Mailable {

    use Queueable, SerializesModels;


    public function __construct(public readonly array $data) {
        
    }

    public function envelope(): Envelope {
        return new Envelope(
            from: new Address($this->data['fromEmail'], $this->data['fromName']),
            subject: $this->data['subject'],
            replyTo: [
                new Address($this->data['fromUserEmail'], $this->data['fromUserName'])
            ]
        );
    }

    public function content(): Content {
        return new Content(
            html: 'mails.product',
        );
    }

    public function attachments(): array {
        return [];
    }
}
