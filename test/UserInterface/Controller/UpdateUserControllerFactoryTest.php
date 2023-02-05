<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Handler\UpdateUserHandler;
use App\UserInterface\Controller\UpdateUserController;
use App\UserInterface\Controller\UpdateUserControllerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class UpdateUserControllerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $handler = $this->createMock(UpdateUserHandler::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [UpdateUserHandler::class, $handler],
                ]
            );

        $controller = (new UpdateUserControllerFactory())($container);

        self::assertInstanceOf(UpdateUserController::class, $controller);
    }
}
