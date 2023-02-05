<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Dto\GetUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\GetUserHandler;
use App\UserInterface\View\SingleErrorView;
use App\UserInterface\View\UserView;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetUserController implements RequestHandlerInterface
{
    public function __construct(
        private GetUserHandler $handler,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $dto = new GetUserHandlerDto(
                (int) $request->getAttribute('id'),
            );

            $user = $this->handler->handle($dto);
        } catch (UserNotFoundException $exception) {
            return new JsonResponse(new SingleErrorView($exception->getMessage()), Response::STATUS_CODE_404);
        }

        return new JsonResponse(new UserView($user), Response::STATUS_CODE_200);
    }
}
