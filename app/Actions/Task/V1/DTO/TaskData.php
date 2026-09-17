<?php

declare(strict_types=1);

namespace App\Actions\Task\V1\DTO;

use App\Domain\Task\V1\Task;

final class TaskData
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $title,
        public readonly bool $isCompleted,
        public readonly string $createdAt,
    ) {}

    public static function fromEntity(Task $task): self
    {
        return new self(
            id: $task->id(),
            userId: $task->userId(),
            title: $task->title(),
            isCompleted: (bool) $task->isCompleted(),
            createdAt: $task->createdAt()->format(DATE_ATOM)
        );
    }
}
