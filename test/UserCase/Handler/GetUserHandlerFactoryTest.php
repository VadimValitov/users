<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Handler\GetUserHandler;
use App\UseCase\Handler\GetUserHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class GetUserHandlerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [UserRepository::class, $userRepository],
                ]
            );

        $controller = (new GetUserHandlerFactory())($container);

        self::assertInstanceOf(GetUserHandler::class, $controller);
    }
}
