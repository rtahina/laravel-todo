<?php

namespace Tests\Feature;

use App\Actions\User\CreateUser;
use App\Actions\User\DTO\UserData;
use App\Actions\User\ListUsers;
use App\Domain\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = app(UserRepositoryInterface::class);
    }

    /** @test */
    public function it_can_list_users(): void
    {
        User::factory(3)->create();

        $listUser = new ListUsers($this->userRepository);
        $users = $listUser->handle();
        $this->assertEquals(3, count($users));
    }

    /** @test */
    public function it_can_create_a_user(): void
    {
        $userCreator = new CreateUser($this->userRepository);
        $userData = new UserData(0, 'John Doe', 'tester@doe.com', Hash::make('password'));
        $userCreator->handle($userData);
        $users = User::all();
        $this->assertEquals(1, $users->count());
    }
}
