<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Handler\GetUserHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetUserControllerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new GetUserController(
            $container->get(GetUserHandler::class),
        );
    }
}
