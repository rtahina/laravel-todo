<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task\V1;

use App\Actions\Task\V1\DeleteTask;
use App\Domain\Task\V1\Exceptions\TaskNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

final class DeleteTaskController extends Controller
{
    /**
     * Delete task.
     */
    public function __invoke(int $id, DeleteTask $action): JsonResponse
    {
        try {
            $action->handle($id);
            
            $data = [
                'message' => 'Tache supprimee.',
            ];
            
            return response()->json($data, Response::HTTP_OK);
        } catch (TaskNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
