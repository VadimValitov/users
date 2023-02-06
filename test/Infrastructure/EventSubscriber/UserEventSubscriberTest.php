<?php

declare(strict_types=1);

namespace InfrastructureTest\EventSubscriber;

use App\Infrastructure\EventSubscriber\UserEventSubscriber;
use Doctrine\ORM\Events;
use PHPUnit\Framework\TestCase;

class UserEventSubscriberTest extends TestCase
{
    private UserEventSubscriber $userEventSubscriber;

    protected function setUp(): void
    {
        $this->userEventSubscriber = new UserEventSubscriber();
    }

    public function testGetSubscribedEvents(): void
    {
        $events = $this->userEventSubscriber->getSubscribedEvents();
        $expected = [
            Events::preUpdate,
            Events::postUpdate
        ];

        self::assertEquals($expected, $events);
    }
}
