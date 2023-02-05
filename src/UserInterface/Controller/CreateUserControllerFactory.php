<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Handler\CreateUserHandler;
use App\UserInterface\Validator\CreateUserValidator;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateUserControllerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new CreateUserController(
            $container->get(CreateUserHandler::class),
            new CreateUserValidator(),
        );
    }
}
