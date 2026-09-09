<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\ToggleTaskStatus;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

final class ToggleTaskStatusController extends Controller
{
    /**
     * Toggle task status (is_completed).
     */
    public function __invoke(int $id, ToggleTaskStatus $action): JsonResponse
    {
        $task = $action->handle($id);

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_OK);
    }
}
