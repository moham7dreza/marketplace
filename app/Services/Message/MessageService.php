<?php

namespace App\Services\Message;

class MessageService
{
    private MessageInterface $message;

    /**
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function send(): mixed
    {
        return $this->message->fire();
    }
}

