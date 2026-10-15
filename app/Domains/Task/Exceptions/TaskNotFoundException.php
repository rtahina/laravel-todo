<?php

declare(strict_types=1);

namespace App\Domains\Task\Exceptions;

final class TaskNotFoundException extends \DomainException
{
    public static function withId(int $id): self
    {
        return new self("La tache avec l'id {$id} est introuvable.");
    }
}
