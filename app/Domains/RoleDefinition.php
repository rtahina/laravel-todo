<?php

namespace App\Domains;

use Permission;

final readonly class RoleDefinition
{
    /**
     * @param  list<Permission>  $permissions
     */
    public function __construct(
        public string $name,
        public int $level,
        public array $permissions
    ) {}

    public function has(Permission $permision): bool
    {
        return in_array($permision, $this->permissions, true);
    }
}
