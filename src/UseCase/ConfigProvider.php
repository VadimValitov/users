<?php

declare(strict_types=1);

namespace App\UseCase;

use App\UseCase\Handler;
use App\UseCase\Service;

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
            'invokables' => [
            ],
            'factories'  => [
                Handler\CreateUserHandler::class => Handler\CreateUserHandlerFactory::class,
                Handler\UpdateUserHandler::class => Handler\UpdateUserHandlerFactory::class,
                Service\UserCheckingService::class => Service\UserCheckingServiceFactory::class,
            ],
        ];
    }
}
