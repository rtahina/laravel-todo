<?php

namespace Tests\Feature;

use App\Actions\Task\V1\CreateTask;
use App\Actions\Task\V1\DeleteTask;
use App\Actions\Task\V1\ListTasks;
use App\Actions\Task\V1\ToggleTaskStatus;
use App\Domain\Task\V1\Exceptions\TaskNotFoundException;
use App\Infrastructure\Task\Persistence\V1\TaskMapper;
use App\Infrastructure\Task\Persistence\V1\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tasks_can_be_listed(): void
    {
        $repository = new TaskRepository(new TaskMapper());
        $taskCreator = new CreateTask($repository);
        for($i = 1; $i <= 3; $i++) {
            $taskCreator->handle('Test Task #' . $i);
        }
        $listTask = new ListTasks($repository);
        $tasks = $listTask->handle();
        $this->assertEquals(3, count($tasks));
    }
    
    /** @test */
    public function a_task_can_be_created(): void
    {
        $repository = new TaskRepository(new TaskMapper());
        $taskCreator = new CreateTask($repository);
        $taskCreator->handle('Test Task');
        $listTask = new ListTasks($repository);
        $tasks = $listTask->handle();
        $this->assertEquals(1, count($tasks));
    }

    /** @test */
    public function a_task_status_can_be_toggled(): void
    {
        $repository = new TaskRepository(new TaskMapper());
        $taskCreator = new CreateTask($repository);
        $task = $taskCreator->handle('Test Task');
        $toggleTaskStatus = new ToggleTaskStatus($repository);
        $updatedTask = $toggleTaskStatus->handle($task->id);
        $this->assertNotEquals($task->isCompleted, $updatedTask->isCompleted);
    }

    /** @test */
    public function a_task_can_be_deleted(): void
    {
        $repository = new TaskRepository(new TaskMapper());
        $taskCreator = new CreateTask($repository);
        $task = $taskCreator->handle('Test Task');
        $deleteTask = new DeleteTask($repository);
        $deleteTask->handle($task->id);
        $listTask = new ListTasks($repository);
        $tasks = $listTask->handle();
        $this->assertEquals(0, count($tasks));
    }

    /** @test */
    public function a_task_not_found_exception_thrown_on_toggle(): void
    {
        $this->expectException(TaskNotFoundException::class);
        $repository = new TaskRepository(new TaskMapper());
        $toggleTaskStatus = new ToggleTaskStatus($repository);
        $toggleTaskStatus->handle(1);
    }

    /** @test */
    public function a_task_not_found_exception_thrown_on_delete(): void
    {
        $this->expectException(TaskNotFoundException::class);
        $repository = new TaskRepository(new TaskMapper());
        $deleteTask = new ToggleTaskStatus($repository);
        $deleteTask->handle(1);
    }
}
