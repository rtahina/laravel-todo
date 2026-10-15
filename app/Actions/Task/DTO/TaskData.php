<?php

declare(strict_types=1);

namespace App\Actions\Task\DTO;

use App\Domains\Task\Task;
use DateTimeImmutable;

final class TaskData
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $title,
        public readonly bool $isCompleted = false,
        public readonly DateTimeImmutable $createdAt = new DateTimeImmutable,
    ) {}

    public static function fromEntity(Task $task): self
    {
        return new self(
            id: $task->id(),
            userId: $task->userId(),
            title: $task->title(),
            isCompleted: (bool) $task->isCompleted(),
            createdAt: new DateTimeImmutable($task->createdAt()->format(DATE_ATOM))
        );
    }
}
