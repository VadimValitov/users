<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Handler\DeleteUserHandler;
use App\UserInterface\Controller\DeleteUserController;
use App\UserInterface\Controller\DeleteUserControllerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DeleteUserControllerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $handler = $this->createMock(DeleteUserHandler::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [DeleteUserHandler::class, $handler],
                ]
            );

        $controller = (new DeleteUserControllerFactory())($container);

        self::assertInstanceOf(DeleteUserController::class, $controller);
    }
}
