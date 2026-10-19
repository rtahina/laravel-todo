<?php

namespace App\Infrastructures\Task\Notifications;

use Pusher\Pusher;

class PusherServer
{
    private Pusher $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            env('PUSHER_KEY', ''),
            env('PUSHER_SECRET', ''),
            env('PUSHER_APP_ID', ''),
            [
                'cluster' => env('PUSHER_CLUSTER', ''),
            ]
        );
    }

    public function send(PusherPayload $payload)
    {
        $this->pusher->trigger($payload->channel, $payload->event, ['message' => $payload->message]);
    }
}
