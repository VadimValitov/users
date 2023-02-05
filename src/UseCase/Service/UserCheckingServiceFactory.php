<?php

declare(strict_types=1);

namespace App\UseCase\Service;

use App\Domain\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class UserCheckingServiceFactory
{
    public function __invoke(ContainerInterface $container): UserCheckingService
    {
        return new UserCheckingService(
            $container->get(UserRepository::class),
        );
    }
}
