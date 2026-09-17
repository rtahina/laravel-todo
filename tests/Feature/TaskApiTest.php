<?php

namespace Tests\Feature;

use App\Actions\Task\V1\CreateTask;
use App\Actions\User\DTO\UserData;
use App\Infrastructure\Task\Persistence\V1\TaskMapper;
use App\Infrastructure\Task\Persistence\V1\TaskRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function api_tasks_can_be_listed(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $userData = UserData::fromModel($user);
        $repository = new TaskRepository(new TaskMapper);
        $taskCreator = new CreateTask($repository);
        for ($i = 1; $i <= 3; $i++) {
            $taskCreator->handle('Test Task #'.$i, $userData);
        }

        $response = $this->get('/api/v1/tasks');

        $response->assertStatus(200);
    }

    /** @test */
    public function api_task_can_be_created(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $payload = [
            'user_id' => $user->id,
            'title' => 'New task',
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New task']);
    }

    /** @test */
    public function api_task_status_can_be_toggled(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $repository = new TaskRepository(new TaskMapper);
        $taskCreator = new CreateTask($repository);
        $userData = UserData::fromModel($user);
        $task = $taskCreator->handle('Test Task', $userData);
        $response = $this->patchJson('/api/v1/tasks/'.$task->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['isCompleted' => ! $task->isCompleted]);
    }

    /** @test */
    public function api_task_can_be_deleted(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $repository = new TaskRepository(new TaskMapper);
        $taskCreator = new CreateTask($repository);
        $userData = UserData::fromModel($user);
        $task = $taskCreator->handle('Test Task', $userData);

        $response = $this->deleteJson('/api/v1/tasks/'.$task->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Tache supprimee.']);
    }

    /** @test */
    public function api_task_not_found_on_toggle_status(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->patchJson('/api/v1/tasks/1');
        $response->assertStatus(404);
    }

    /** @test */
    public function api_task_not_found_on_delete(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->deleteJson('/api/v1/tasks/1');
        $response->assertStatus(404);
    }

    /** @test */
    public function api_flag_invalid_title_on_task_creation(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $payload = ['title' => 'he'];
        $response = $this->postJson('/api/v1/tasks', $payload);
        $response->assertStatus(422);
    }

    /** @test */
    public function api_required_title_on_task_creation(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $payload = [];
        $response = $this->postJson('/api/v1/tasks', $payload);
        $response->assertStatus(422);
    }
}
