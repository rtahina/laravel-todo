<?php

namespace App\Infrastructures\Task\Notifications;

use App\Actions\Task\DTO\TaskData;
use App\Domains\Task\TaskNotificationInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Pusher\ApiErrorException;

class PusherNotification implements TaskNotificationInterface
{
    public function __construct(
        public PusherServer $pusher
    ) {}

    public function send(TaskData $task): bool
    {
        try {
            $payload = new PusherPayload(
                channel: 'todoapp-notification',
                event: 'new-task-created',
                message: $task->title
            );

            $response = $this->pusher->send($payload);

            return $response instanceof \StdClass;

        } catch (RequestException|InvalidArgumentException|ApiErrorException|GuzzleException $e) {
            Log::error($e->getMessage(), ['context' => 'Task creation notification']);

            return false;
        }
    }
}
