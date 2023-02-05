<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Handler\GetUserHandler;
use App\UserInterface\Controller\GetUserController;
use App\UserInterface\Controller\GetUserControllerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class GetUserControllerFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $handler = $this->createMock(GetUserHandler::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [GetUserHandler::class, $handler],
                ]
            );

        $controller = (new GetUserControllerFactory())($container);

        self::assertInstanceOf(GetUserController::class, $controller);
    }
}
