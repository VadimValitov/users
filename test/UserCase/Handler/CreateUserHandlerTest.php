<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\CreateUserHandlerDto;
use App\UseCase\Handler\CreateUserHandler;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserHandlerTest extends TestCase
{
    private CreateUserHandler $handler;

    private UserCheckingService&MockObject $userCheckingService;

    private UserRepository&MockObject $userRepository;

    private EntityManager&MockObject $entityManager;

    protected function setUp(): void
    {
        $this->userCheckingService = $this->createMock(UserCheckingService::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->handler = new CreateUserHandler(
            $this->userCheckingService,
            $this->userRepository,
            $this->entityManager
        );
    }

    public function testFailWhenServiceThrowsException(): void
    {
        $this->userCheckingService->method('check')
            ->willThrowException(new Exception());

        self::expectException(Exception::class);

        $dto = new CreateUserHandlerDto(
            'badusername',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testSuccess(): void
    {
        $this->userRepository->expects(self::once())
            ->method('add');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $dto = new CreateUserHandlerDto(
            'username',
            'email@local.lan',
            'notes text'
        );

        $user = $this->handler->handle($dto);

        self::assertEquals($dto->name, $user->getName());
        self::assertEquals($dto->email, $user->getEmail());
        self::assertEquals($dto->notes, $user->getNotes());
    }
}
