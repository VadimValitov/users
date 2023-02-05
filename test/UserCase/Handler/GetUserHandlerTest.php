<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\GetUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\GetUserHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetUserHandlerTest extends TestCase
{
    private GetUserHandler $handler;

    private UserRepository&MockObject $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->handler = new GetUserHandler(
            $this->userRepository,
        );
    }

    public function testFailWhenUserNotFound(): void
    {
        self::expectException(UserNotFoundException::class);

        $dto = new GetUserHandlerDto(1);
        $this->handler->handle($dto);
    }

    public function testFailWhenUserNotActive(): void
    {
        $user = $this->createMock(User::class);
        $user->method('isActive')
            ->willReturn(false);

        $this->userRepository->method('find')
            ->willReturn($user);

        self::expectException(UserNotFoundException::class);

        $dto = new GetUserHandlerDto(1);
        $this->handler->handle($dto);
    }

    public function testSuccess(): void
    {
        $user = $this->createMock(User::class);
        $user->method('isActive')
            ->willReturn(true);

        $this->userRepository->method('find')
            ->willReturn($user);

        $dto = new GetUserHandlerDto(1);
        $result = $this->handler->handle($dto);

        self::assertTrue($result->isActive());
    }
}
