<?php

namespace App\Infrastructures\Task\Notifications;

use App\Actions\Task\DTO\TaskData;
use App\Domains\Task\TaskNotificationInterface;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;

use function Illuminate\Log\log;

class PusherNotification implements TaskNotificationInterface
{
    public function __construct(
        public PusherServer $pusher
    ) {}

    public function send(TaskData $task): void
    {
        try {
            $payload = new PusherPayload(
                channel: 'todoapp-notification',
                event: 'new-task-created',
                message: $task->title
            );

            $this->pusher->send($payload);
        } catch (RequestException $e) {
            log($e->getMessage(), ['Task creation notification']);
        } catch (InvalidArgumentException $e) {
            log($e->getMessage(), ['Task creation notification']);
        }
    }
}
