<?php

namespace App\Infrastructures\Task\Notifications;

use Pusher\Pusher;

class PusherServer
{
    public function __construct(
        private Pusher $pusher
    ){}

    public function send(PusherPayload $payload): object
    {
        return $this->pusher->trigger(
            $payload->channel, 
            $payload->event, 
            ['message' => $payload->message]
        );
    }
}
