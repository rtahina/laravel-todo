<?php

declare(strict_types=1);

namespace App\Domain\User;

final class User
{
    private function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email
    ) {}

    public static function create(string $name, string $email): self
    {
        return new self(
            id: 0,
            name: $name,
            email: $email
        );
    }

    public static function reconstitute(
        int $id,
        string $name,
        string $email
    ): self {
        return new self($id, $name, $email);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
