<?php

namespace App\Listeners;

use App\Jobs\SendEmailJob;
use App\Services\ShareService;

class SendEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admin = ShareService::findSystemAdmin();
        SendEmailJob::dispatch(email: $admin->email, subject: $event->subject, body: $event->body);
    }
}
