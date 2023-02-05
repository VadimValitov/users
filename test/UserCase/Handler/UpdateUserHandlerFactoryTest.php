<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Handler\UpdateUserHandler;
use App\UseCase\Handler\UpdateUserHandlerFactory;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class UpdateUserHandlerFactoryTest extends TestCase
{
    public function testSuccess()
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

        $controller = (new UpdateUserHandlerFactory())($container);

        self::assertInstanceOf(UpdateUserHandler::class, $controller);
    }
}
