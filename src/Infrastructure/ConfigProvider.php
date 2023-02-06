<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Repository\UserRepository;
use App\Infrastructure\EventSubscriber;
use App\Infrastructure\Repository;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => [
                'eventmanager' => [
                    'orm_default' => [
                        'subscribers' => [
                            EventSubscriber\UserEventSubscriber::class,
                        ],
                    ],
                ]
            ]
        ];
    }

    private function getDependencies(): array
    {
        return [
            'aliases' => [
                UserRepository::class => Repository\DoctrineUserRepository::class,
            ],
            'invokables' => [
            ],
            'factories'  => [
                EventSubscriber\UserEventSubscriber::class => EventSubscriber\UserEventSubscriberFactory::class,
                Repository\DoctrineUserRepository::class => Repository\DoctrineUserRepositoryFactory::class,
            ],
        ];
    }
}
