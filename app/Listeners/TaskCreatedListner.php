<?php

namespace App\Listeners;

use App\Domains\Task\TaskNotificationInterface;
use App\Events\TaskCreated;

class TaskCreatedListner
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public TaskNotificationInterface $notification
    ) {}

    /**
     * Handle the event.
     */
    public function handle(TaskCreated $event): void
    {
        $this->notification->send($event->task);
    }
}
