<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\ListTasks;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

final class ListTasksController extends Controller
{
    /**
     * Display all the tasks.
     */
    public function __invoke(ListTasks $action): JsonResponse
    {
        $tasks = $action->handle();

        return TaskResource::collection($tasks)->response();
    }
}
