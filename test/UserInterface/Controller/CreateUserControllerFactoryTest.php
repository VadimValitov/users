<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Handler\CreateUserHandler;
use App\UserInterface\Controller\CreateUserController;
use App\UserInterface\Controller\CreateUserControllerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CreateUserControllerFactoryTest extends TestCase
{
    public function testSuccess()
    {
        $handler = $this->createMock(CreateUserHandler::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [CreateUserHandler::class, $handler],
                ]
            );

        $controller = (new CreateUserControllerFactory())($container);

        self::assertInstanceOf(CreateUserController::class, $controller);
    }
}
