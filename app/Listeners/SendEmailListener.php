<?php

namespace App\Listeners;

use App\Jobs\SendEmailJob;
use App\Models\User;

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
        $user = User::query()->first();
        SendEmailJob::dispatch(email: $user->email, subject: $event->subject, body: $event->body);
    }
}
