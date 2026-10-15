<?php

declare(strict_types=1);

namespace App\Domains\Task;

use App\Actions\Task\V1\DTO\TaskData;
use DateTimeImmutable;

final class Task
{
    private function __construct(
        private readonly ?int $id,
        private ?int $userId,
        private string $title,
        private bool $isCompleted,
        private readonly DateTimeImmutable $createdAt
    ) {}

    public static function create(TaskData $task): self
    {
        return new self(
            id: 0,
            userId: $task->userId,
            title: $task->title,
            isCompleted: false,
            createdAt: new DateTimeImmutable
        );
    }

    public static function reconstitute(
        int $id,
        int $userId,
        string $title,
        bool $isComplete,
        DateTimeImmutable $createdAt
    ): self {
        return new self($id, $userId, $title, $isComplete, $createdAt);
    }

    public static function toggleStatus(Task $task): self
    {
        return new self(
            $task->id(),
            $task->userId(),
            $task->title(),
            ! $task->isCompleted(), // Toggle is_completed
            $task->createdAt()
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
