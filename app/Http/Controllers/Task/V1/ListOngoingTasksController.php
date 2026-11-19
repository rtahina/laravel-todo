<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Applications\Task\ListTasks;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class ListOngoingTasksController extends Controller
{
    /**
     * Display all ongoing tasks.
     */
    public function __invoke(ListTasks $action): JsonResponse
    {
        $currentUser = Auth::user();
        $args = [
            'user_id' => $currentUser?->id,
            'is_completed' => false,
        ];
        $tasks = $action->handle($args);

        return TaskResource::collection($tasks)->response();
    }
}
