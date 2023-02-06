<?php

declare(strict_types=1);

namespace InfrastructureTest\EventSubscriber;

use App\Infrastructure\EventSubscriber\UserEventSubscriber;
use App\Infrastructure\EventSubscriber\UserEventSubscriberFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class UserEventSubscriberFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $controller = (new UserEventSubscriberFactory())($container);

        self::assertInstanceOf(UserEventSubscriber::class, $controller);
    }
}
