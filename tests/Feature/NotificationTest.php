<?php

namespace Tests\Feature;
use App\Actions\Task\DTO\TaskData;
use App\Domains\Task\TaskNotificationInterface;
use App\Events\TaskCreated;
use App\Infrastructures\Task\Notifications\PusherNotification;
use App\Infrastructures\Task\Notifications\PusherPayload;
use App\Infrastructures\Task\Notifications\PusherServer;
use App\Listeners\TaskCreatedListner;
use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Pusher\Pusher;
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
    
    public function test_it_triggers_pusher_with_the_right_arguments(): void
    {
        $pusher = Mockery::mock(Pusher::class);
        $pusher->shouldReceive('trigger')
            ->once()
            ->with('todoapp-notification', 'new-task-created', ['message' => 'New task'])
            ->andReturn(new \stdClass);

        $server = new PusherServer($pusher);

        $server->send(new PusherPayload(
            channel: 'todoapp-notification',
            event: 'new-task-created',
            message: 'New task',
        ));
    }

    public function test_it_sends_the_task_title_as_the_message(): void
    {
        $server = Mockery::mock(PusherServer::class);
        $server->shouldReceive('send')
            ->once()
            ->with(Mockery::on(fn (PusherPayload $p) =>
                $p->channel === 'todoapp-notification'
                && $p->event === 'new-task-created'
                && $p->message === 'New task'
            ))
            ->andReturn(new \stdClass);

        $task = new TaskData(
            id: 0,
            userId: 0,
            title: 'New task'
        );

        $this->assertTrue((new PusherNotification($server))->send($task));
    }

    public function test_it_logs_and_returns_false_when_pusher_fails(): void
    {
        Log::shouldReceive('error')->once();

        $server = Mockery::mock(PusherServer::class);
        $server->shouldReceive('send')
            ->andThrow(new RequestException('boom', new Request('POST', '/')));

        $task = new TaskData(
            id: 0,
            userId: 0,
            title: 'New task'
        );

        $this->assertFalse((new PusherNotification($server))->send($task));
    }

    public function test_listener_sends_the_notification(): void
    {
        $task = new TaskData(
            id: 0,
            userId: 0,
            title: 'New task'
        );

        $notification = Mockery::mock(TaskNotificationInterface::class);
        $notification->shouldReceive('send')->once()->with($task);

        (new TaskCreatedListner($notification))->handle(new TaskCreated($task));
    }

    public function test_task_created_has_its_listener(): void
    {
        Event::fake();

        Event::assertListening(TaskCreated::class, TaskCreatedListner::class);
    }

    public function test_creating_a_task_dispatches_task_created(): void
    {
        Event::fake([TaskCreated::class]);

        $this->postJson('/api/v1/tasks', ['title' => 'New task'])->assertCreated();

        Event::assertDispatched(TaskCreated::class, fn ($e) => $e->task->title === 'New task');
    }

    public function test_full_flow_notifies_without_hitting_pusher(): void
    {
        $this->mock(TaskNotificationInterface::class)
            ->shouldReceive('send')
            ->once();

        $this->postJson('/api/v1/tasks', ['title' => 'New task'])->assertCreated();
    }
}
