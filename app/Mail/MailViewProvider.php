<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailViewProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    protected $files;

    public function __construct($details, $subject, $from, $files = null)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
        $this->files = $files;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->from[0]['address'], $this->from[0]['name']),
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.send-email-to-user',
            with: [
                'subject' => $this->details['subject'],
                'body' => $this->details['body'],
            ],
        );
    }

//    public function build(): MailViewProvider
//    {
//        return $this->subject($this->subject)->markdown('mail.send-email-to-user');
//    }

    public function attachments(): array
    {
        $publicFiles = [];
        if ($this->files) {
            foreach ($this->files as $file) {
                $publicFiles[] = public_path($file);
            }
        }
        return $publicFiles;
    }
}
