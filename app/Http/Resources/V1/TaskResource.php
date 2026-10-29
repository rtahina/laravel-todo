<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Actions\Task\DTO\TaskData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TaskData
 */
final class TaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'isCompleted' => $this->isCompleted,
            'createdAt' => $this->createdAt,
        ];
    }
}
