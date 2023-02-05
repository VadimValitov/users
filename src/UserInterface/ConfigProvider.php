<?php

declare(strict_types=1);

namespace App\UserInterface;

use App\UserInterface\Controller;

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
                Controller\CreateUserController::class => Controller\CreateUserControllerFactory::class,
            ],
        ];
    }
}
