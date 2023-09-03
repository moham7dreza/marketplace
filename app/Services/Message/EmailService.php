<?php

namespace App\Services\Message;

use App\Mail\MailViewProvider;
use Illuminate\Support\Facades\Mail;

class EmailService implements MessageInterface
{

    private $details;
    private $subject;
    private array $from = [
        ['address' => null, 'name' => null,]
    ];
    private $to;
    private $emailFiles;

    public function fire()
    {
        Mail::to($this->to)->send(new MailViewProvider($this->details, $this->subject, $this->from, $this->emailFiles));
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setDetails($details): void
    {
        $this->details = $details;
    }


    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }


    public function getFrom(): array
    {
        return $this->from;
    }

    public function setFrom($address, $name): void
    {
        $this->from = [
            [
                'address' => $address,
                'name' => $name,
            ]
        ];
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to): void
    {
        $this->to = $to;
    }

    public function getEmailFiles()
    {
        return $this->emailFiles;
    }

    public function setEmailFiles($emailFiles): void
    {
        $this->emailFiles = $emailFiles;
    }
}
