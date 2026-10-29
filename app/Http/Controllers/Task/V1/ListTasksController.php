<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\ListTasks;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class ListTasksController extends Controller
{
    /**
     * Display all the tasks.
     */
    public function __invoke(ListTasks $action): JsonResponse
    {
        $currentUser = Auth::user();
        $args = [
            'user_id' => $currentUser?->id,
        ];
        $tasks = $action->handle($args);

        return TaskResource::collection($tasks)->response();
    }
}
