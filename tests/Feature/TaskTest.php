<?php

namespace Tests\Feature;

use App\Actions\Task\CreateTask;
use App\Actions\Task\DeleteTask;
use App\Actions\Task\DTO\TaskData;
use App\Actions\Task\ListTasks;
use App\Actions\Task\ToggleTaskStatus;
use App\Domains\Task\Exceptions\TaskNotFoundException;
use App\Domains\Task\TaskRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepositoryInterface $taskRepository;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = app(TaskRepositoryInterface::class);
        $this->user = User::factory()->create();
    }

    /** @test */
    public function tasks_can_be_listed(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);

        for ($i = 1; $i <= 3; $i++) {
            $taskName = 'Test Task #'.$i;
            $taskData = new TaskData(0, $this->user->id, $taskName);
            $taskCreator->handle($taskData);
        }

        $listTask = new ListTasks($this->taskRepository);
        $tasks = $listTask->handle();
        $this->assertEquals(3, count($tasks));
    }

    /** @test */
    public function a_task_can_be_created(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        $taskData = new TaskData(0, $this->user->id, 'Test task');
        $taskCreator->handle($taskData);
        $listTask = new ListTasks($this->taskRepository);
        $tasks = $listTask->handle();
        $this->assertEquals(1, count($tasks));
    }

    /** @test */
    public function a_task_status_can_be_toggled(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        $taskData = new TaskData(0, $this->user->id, 'Test task');
        $task = $taskCreator->handle($taskData);
        $toggleTaskStatus = new ToggleTaskStatus($this->taskRepository);
        $updatedTask = $toggleTaskStatus->handle($task->id);
        $this->assertNotEquals($task->isCompleted, $updatedTask->isCompleted);
    }

    /** @test */
    public function a_task_can_be_deleted(): void
    {
        $taskCreator = new CreateTask($this->taskRepository);
        $taskData = new TaskData(0, $this->user->id, 'Test task');
        $task = $taskCreator->handle($taskData);
        $deleteTask = new DeleteTask($this->taskRepository);
        $deleteTask->handle($task->id);
        $listTask = new ListTasks($this->taskRepository);
        $tasks = $listTask->handle();
        $this->assertEquals(0, count($tasks));
    }

    /** @test */
    public function a_task_not_found_exception_thrown_on_toggle(): void
    {
        $this->expectException(TaskNotFoundException::class);
        $toggleTaskStatus = new ToggleTaskStatus($this->taskRepository);
        $toggleTaskStatus->handle(1);
    }

    /** @test */
    public function a_task_not_found_exception_thrown_on_delete(): void
    {
        $this->expectException(TaskNotFoundException::class);
        $deleteTask = new ToggleTaskStatus($this->taskRepository);
        $deleteTask->handle(1);
    }
}
