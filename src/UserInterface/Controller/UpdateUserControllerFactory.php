<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Handler\UpdateUserHandler;
use App\UserInterface\Validator\UserDataValidator;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UpdateUserControllerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new UpdateUserController(
            $container->get(UpdateUserHandler::class),
            new UserDataValidator(),
        );
    }
}
