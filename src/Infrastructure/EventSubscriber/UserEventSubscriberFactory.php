<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use Psr\Container\ContainerInterface;

class UserEventSubscriberFactory
{
    public function __invoke(ContainerInterface $container): UserEventSubscriber
    {
        return new UserEventSubscriber();
    }
}
