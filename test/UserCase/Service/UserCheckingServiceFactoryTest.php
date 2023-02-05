<?php

declare(strict_types=1);

namespace UseCaseTest\Service;

use App\Domain\Repository\UserRepository;
use App\UseCase\Service\UserCheckingService;
use App\UseCase\Service\UserCheckingServiceFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class UserCheckingServiceFactoryTest extends TestCase
{
    public function testSuccess()
    {
        $userRepository = $this->createMock(UserRepository::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [UserRepository::class, $userRepository],
                ]
            );

        $controller = (new UserCheckingServiceFactory())($container);

        self::assertInstanceOf(UserCheckingService::class, $controller);
    }
}
