<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\CreateTask;
use App\Actions\User\DTO\UserData;
use App\Domain\User\Exceptions\UserNotFoundException;
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
        $user = new UserData($currentUser->id, $currentUser->name, $currentUser->email);
        $task = $action->handle($request->get('title'), $user);

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
