<?php

declare(strict_types=1);

namespace App\Domains\Task;

use App\Actions\Task\DTO\TaskData;

interface TaskNotificationInterface
{
    public function send(TaskData $task): void;
}
