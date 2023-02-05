<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\UpdateUserHandlerDto;
use App\UseCase\Handler\UpdateUserHandler;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateUserHandlerTest extends TestCase
{
    private UpdateUserHandler $handler;

    private UserCheckingService&MockObject $userCheckingService;

    private UserRepository&MockObject $userRepository;

    private EntityManager&MockObject $entityManager;

    protected function setUp(): void
    {
        $this->userCheckingService = $this->createMock(UserCheckingService::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->handler = new UpdateUserHandler(
            $this->userCheckingService,
            $this->userRepository,
            $this->entityManager
        );
    }

    public function testFailWhenUserNotFound(): void
    {
        $this->userCheckingService->method('check')
            ->willThrowException(new Exception());

        self::expectException(Exception::class);

        $dto = new UpdateUserHandlerDto(
            1,
            'badusername',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testFailWhenServiceThrowsException(): void
    {
        $user = $this->createMock(User::class);
        $user->method('isActive')
            ->willReturn(true);

        $this->userRepository->method('find')
            ->willReturn($user);

        $this->userCheckingService->method('check')
            ->willThrowException(new Exception());

        self::expectException(Exception::class);

        $dto = new UpdateUserHandlerDto(
            1,
            'badusername',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testSuccess(): void
    {
        $dto = new UpdateUserHandlerDto(
            1,
            'username',
            'email@local.lan',
            'notes text'
        );

        $user = $this->createMock(User::class);
        $user->method('isActive')
            ->willReturn(true);

        $user->expects(self::once())
            ->method('update')
            ->with($dto->name, $dto->email, $dto->notes);

        $this->userRepository->method('find')
            ->willReturn($user);

        $this->entityManager->expects(self::once())
            ->method('flush');

        $this->handler->handle($dto);
    }
}
