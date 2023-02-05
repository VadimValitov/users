<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Repository\UserRepository;
use App\Infrastructure\Repository;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
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
                Repository\DoctrineUserRepository::class => Repository\DoctrineUserRepositoryFactory::class,
            ],
        ];
    }
}
