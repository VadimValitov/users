<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class UpdateUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): UpdateUserHandler
    {
        return new UpdateUserHandler(
            $container->get(UserCheckingService::class),
            $container->get(UserRepository::class),
            $container->get(EntityManager::class),
        );
    }
}
