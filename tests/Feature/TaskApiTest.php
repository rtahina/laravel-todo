<?php

namespace Tests\Feature;

use App\Actions\Task\V1\CreateTask;
use App\Actions\Task\V1\DTO\TaskData;
use App\Domains\Task\TaskRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepositoryInterface $taskRepository;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = app(TaskRepositoryInterface::class);
        $this->user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /** @test */
    public function api_tasks_can_be_listed(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        for ($i = 1; $i <= 3; $i++) {
            $taskName = 'Test Task #'.$i;
            $taskData = new TaskData(0, $this->user->id, $taskName);
            $taskCreator->handle($taskData);
        }

        $response = $this->get('/api/v1/tasks');

        $response->assertStatus(200);
    }

    /** @test */
    public function api_task_can_be_created(): void
    {
        $payload = [
            'title' => 'New task',
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New task']);
    }

    /** @test */
    public function api_task_status_can_be_toggled(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        $taskData = new TaskData(0, $this->user->id, 'Test Task');
        $task = $taskCreator->handle($taskData);
        $response = $this->patchJson('/api/v1/tasks/'.$task->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['isCompleted' => ! $task->isCompleted]);
    }

    /** @test */
    public function api_task_can_be_deleted(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        $taskData = new TaskData(0, $this->user->id, 'Test Task');
        $task = $taskCreator->handle($taskData);

        $response = $this->deleteJson('/api/v1/tasks/'.$task->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Task successfully delete.']);
    }

    /** @test */
    public function api_task_not_found_on_toggle_status(): void
    {
        $response = $this->patchJson('/api/v1/tasks/1');
        $response->assertStatus(404);
    }

    /** @test */
    public function api_task_not_found_on_delete(): void
    {
        $response = $this->deleteJson('/api/v1/tasks/1');
        $response->assertStatus(404);
    }

    /** @test */
    public function api_flag_invalid_title_on_task_creation(): void
    {
        $payload = ['title' => 'he'];
        $response = $this->postJson('/api/v1/tasks', $payload);
        $response->assertStatus(422);
    }

    /** @test */
    public function api_required_title_on_task_creation(): void
    {
        $payload = [];
        $response = $this->postJson('/api/v1/tasks', $payload);
        $response->assertStatus(422);
    }
}
