<?php

namespace App\Jobs;

use App\Services\Message\EmailService;
use App\Services\Message\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $subject;
    public $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $body)
    {
        $this->email = $email;
        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *intervention
     * @return void
     */
    public function handle(): void
    {
        $this->send();
    }

    public function send(): void
    {
        $emailService = new EmailService();
        $details = [
            'title' => $this->subject,
            'body' => $this->body
        ];
        $emailService->setDetails($details);
        $emailService->setFrom('noreply@example.com', 'example');
        $emailService->setSubject($this->subject);
        $emailService->setTo($this->email);
        $messagesService = new MessageService($emailService);
        $messagesService->send();
    }
}

