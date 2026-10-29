<?php

namespace App\Infrastructures\Task\Notifications;

use Pusher\Pusher;

class PusherServer
{
    private Pusher $pusher;

    public function __construct()
    {
        $pusherKey = config('pusher.key', '');
        settype($pusherKey, 'string');
        $pusherSecret = config('pusher.secret', '');
        settype($pusherSecret, 'string');
        $pusherAppId = config('pusher.app_id', '');
        settype($pusherAppId, 'string');
        $this->pusher = new Pusher(
            $pusherKey,
            $pusherSecret,
            $pusherAppId,
            [
                'cluster' => config('pusher.cluster', ''),
            ]
        );
    }

    public function send(PusherPayload $payload): void
    {
        $this->pusher->trigger($payload->channel, $payload->event, ['message' => $payload->message]);
    }
}
