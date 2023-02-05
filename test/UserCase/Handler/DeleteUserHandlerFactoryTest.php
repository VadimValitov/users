<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Handler\DeleteUserHandler;
use App\UseCase\Handler\DeleteUserHandlerFactory;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DeleteUserHandlerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $entityManager = $this->createMock(EntityManager::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [UserRepository::class, $userRepository],
                    [EntityManager::class, $entityManager],
                ]
            );

        $controller = (new DeleteUserHandlerFactory())($container);

        self::assertInstanceOf(DeleteUserHandler::class, $controller);
    }
}
