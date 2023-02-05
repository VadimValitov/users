<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Handler\CreateUserHandler;
use App\UseCase\Handler\CreateUserHandlerFactory;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CreateUserHandlerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $userCheckingService = $this->createMock(UserCheckingService::class);
        $userRepository = $this->createMock(UserRepository::class);
        $entityManager = $this->createMock(EntityManager::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [UserCheckingService::class, $userCheckingService],
                    [UserRepository::class, $userRepository],
                    [EntityManager::class, $entityManager],
                ]
            );

        $controller = (new CreateUserHandlerFactory())($container);

        self::assertInstanceOf(CreateUserHandler::class, $controller);
    }
}
