<?php

namespace Tests\Unit\Api\V1;

use App\Domain\Factories\UserFactory as DomainUserFactory;
use App\Domain\Repositories\User\UserRepositoryInterface;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    // use RefreshDatabase;

    // private UserRepositoryInterface $userRepository;

    // public function __construct(
    //     UserRepositoryInterface $userRepository
    // ){
    //     $this->userRepository = $userRepository;
    // }

    // public function test_it_can_create_new_user()
    // {
    //     $user = DomainUserFactory::make(
    //         (new UserFactory())->definition()
    //     );
    //     $result = $this->userRepository->createNewUser($user);

    //     $this->assertSame($user->name, $result->name);
    //     $this->assertSame($user->email, $result->email);
    // }
}
