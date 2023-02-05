<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CreateUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreateUserHandler
    {
        return new CreateUserHandler(
            $container->get(UserRepository::class),
            $container->get(EntityManager::class),
        );
    }
}
