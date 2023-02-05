<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\DeleteUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\DeleteUserHandler;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteUserHandlerTest extends TestCase
{
    private DeleteUserHandler $handler;

    private UserRepository&MockObject $userRepository;

    private EntityManager&MockObject $entityManager;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->handler = new DeleteUserHandler(
            $this->userRepository,
            $this->entityManager
        );
    }

    public function testFailWhenUserNotFound(): void
    {
        self::expectException(UserNotFoundException::class);

        $dto = new DeleteUserHandlerDto(1);
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

        $dto = new DeleteUserHandlerDto(1);
        $this->handler->handle($dto);
    }

    public function testSuccess(): void
    {
        $user = $this->createMock(User::class);

        $user->method('isActive')
            ->willReturn(true);

        $user->expects(self::once())
            ->method('setDeleted');

        $this->userRepository->method('find')
            ->willReturn($user);

        $this->entityManager->expects(self::once())
            ->method('flush');

        $dto = new DeleteUserHandlerDto(1);
        $this->handler->handle($dto);
    }
}
