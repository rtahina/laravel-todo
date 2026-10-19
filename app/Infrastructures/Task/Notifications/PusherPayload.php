<?php

namespace App\Infrastructures\Task\Notifications;

use InvalidArgumentException;

class PusherPayload
{
    public function __construct(
        public string $channel,
        public string $event,
        public string $message = ''
    ) {
        if ($channel === '') {
            throw new InvalidArgumentException('A channel is needed to push a notification');
        }
        if ($event === '') {
            throw new InvalidArgumentException('An event is needed to push a notification');
        }
    }
}
