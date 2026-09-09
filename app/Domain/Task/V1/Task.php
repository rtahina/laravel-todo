<?php

declare(strict_types=1);

namespace App\Domain\Task\V1;

use DateTimeImmutable;

final class Task
{
    private function __construct(
        private readonly ?int $id,
        private string $title,
        private bool $isCompleted,
        private readonly DateTimeImmutable $createdAt
    ) {}

    public static function create(string $title): self
    {
        return new self(
            id: 0,
            title: $title,
            isCompleted: false,
            createdAt: new DateTimeImmutable()
        );
    }

    public static function reconstitute(
        int $id,
        string $title,
        bool $isComplete,
        DateTimeImmutable $createdAt
    ): self {
        return new self($id, $title, $isComplete, $createdAt);
    }

    public static function toggleStatus(Task $task): self {
        return new self(
            $task->id(), 
            $task->title(), 
            !$task->isCompleted(), // Toggle is_completed
            $task->createdAt()
        );
    }

    public function id(): int
    {
        return $this->id;
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
