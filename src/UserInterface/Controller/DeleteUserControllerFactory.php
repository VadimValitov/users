<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Handler\DeleteUserHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteUserControllerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new DeleteUserController(
            $container->get(DeleteUserHandler::class),
        );
    }
}
