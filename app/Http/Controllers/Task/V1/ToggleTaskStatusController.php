<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\ToggleTaskStatus;
use App\Domains\Task\Exceptions\TaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResource;
use App\Infrastructures\Task\Persistence\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

final class ToggleTaskStatusController extends Controller
{
    /**
     * Toggle task status (is_completed).
     */
    public function __invoke(Task $task, ToggleTaskStatus $action): JsonResponse
    {
        Gate::authorize('update', $task);

        try {
            $task = $action->handle($task->id);
        } catch (TaskNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_OK);
    }
}
