<?php

namespace App\Domains;

use Permission;
use RoleDefinition;

final class RoleRegistry
{
    /** @return array<string, RoleDefinition> */
    public static function all(): array
    {
        return [
            'admin' => new RoleDefinition(
                name: 'admin',
                level: 100,
                permissions: Permission::cases()
            ),
            'member' => new RoleDefinition(
                name: 'member',
                level: 80,
                permissions: Permission::cases()
            ),
            'viewer' => new RoleDefinition(
                name: 'viewer',
                level: 10,
                permissions: [
                    Permission::ViewTask,
                ]
            ),
        ];
    }

    public static function get(string $name): RoleDefinition
    {
        return self::all()[$name] ?? throw new InvalidArgumentException("Unknown role [{$name}].");
    }
}
