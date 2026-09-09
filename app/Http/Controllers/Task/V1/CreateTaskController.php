<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\CreateTask;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

final class CreateTaskController extends Controller
{
    /**
     * Create a new task.
     */
    public function __invoke(TaskRequest $request, CreateTask $action): JsonResponse
    {
        $task = $action->handle($request->get('title'));

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
