<?php

namespace Tests\Feature;

use App\Actions\Task\DTO\TaskData;
use App\Events\TaskCreated;
use App\Models\User;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_creating_a_task_dispatches_event(): void
    {
        Event::fake([TaskCreated::class]);

        $this->postJson('/api/v1/tasks', ['title' => 'New task'])->assertCreated();

        Event::assertDispatched(TaskCreated::class, fn ($e) => $e->task->title === 'New task');
    }

    public function test_broadcast_definition(): void
    {
        $event = new TaskCreated(new TaskData(
            id: 0,
            userId: 0,
            title: 'New task'
        )
        );

        $this->assertEquals('private-task-creation', $event->broadcastOn()[0]->name);
        $this->assertEquals('new-task-created', $event->broadcastAs());
        $this->assertEquals(['message' => 'New task'], $event->broadcastWith());
    }

    public function test_event_is_queued_for_broadcast(): void
    {
        Queue::fake();

        TaskCreated::dispatch(new TaskData(
            id: 0,
            userId: 0,
            title: 'New task'
        ));

        Queue::assertPushed(BroadcastEvent::class);
    }
}
