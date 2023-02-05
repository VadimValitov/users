<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class GetUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetUserHandler
    {
        return new GetUserHandler(
            $container->get(UserRepository::class),
        );
    }
}
