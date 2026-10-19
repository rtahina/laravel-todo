<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\CreateTask;
use App\Actions\Task\DTO\TaskData;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Events\TaskCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class CreateTaskController extends Controller
{
    /**
     * Create a new task.
     */
    public function __invoke(TaskRequest $request, CreateTask $action): JsonResponse
    {
        $currentUser = Auth::user();
        if (is_null($currentUser)) {
            throw new UserNotFoundException('Creating a task needs a user.');
        }
        $taskData = new TaskData(
            0,
            $currentUser->id,
            $request->title
        );
        $task = $action->handle($taskData);

        TaskCreated::dispatch($task);

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
