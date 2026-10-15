<?php

namespace App\Policies;

use App\Infrastructure\Task\Persistence\V1\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Only task's owner can update it.
     */
    public function update(User $user, Task $task): Response
    {
        return $user->id === $task->user_id
        ? Response::allow()
        : Response::deny('You do not own this task.');
    }

    /**
     * Only task's owner can delete it.
     */
    public function delete(User $user, Task $task): Response
    {
        return $user->id === $task->user_id
        ? Response::allow()
        : Response::deny('You can delete only your own tasks.');
    }
}
