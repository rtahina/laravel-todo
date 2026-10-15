<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\DeleteTask;
use App\Domains\Task\Exceptions\TaskNotFoundException;
use App\Http\Controllers\Controller;
use App\Infrastructures\Task\Persistence\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

final class DeleteTaskController extends Controller
{
    /**
     * Delete task.
     */
    public function __invoke(Task $task, DeleteTask $action): JsonResponse
    {
        Gate::authorize('delete', $task);

        try {
            $action->handle($task->id);

            $data = [
                'message' => 'Task successfully delete.',
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (TaskNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
