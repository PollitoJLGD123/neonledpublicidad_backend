<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailService extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $message;
    public $title;
    public $image;
    public $subject;

    public function __construct($message, $title, $image, $subject)
    {
        $this->message = is_string($message) ? $message : '';
        $this->title = is_string($title) ? $title : '';
        $this->image = is_string($image) ? $image : '';
        $this->subject = is_string($subject) ? strip_tags($subject) : '';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.mail',
            with: [
                'message' => $this->message,
                'title' => $this->title,
                'image' => $this->image
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
