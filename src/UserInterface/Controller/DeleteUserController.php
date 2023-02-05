<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Domain\Exception\WrongDeletingDateTimeException;
use App\UseCase\Dto\DeleteUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\DeleteUserHandler;
use App\UserInterface\View\SingleErrorView;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteUserController implements RequestHandlerInterface
{
    public function __construct(
        private DeleteUserHandler $handler,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $dto = new DeleteUserHandlerDto(
                (int) $request->getAttribute('id'),
            );

            $this->handler->handle($dto);
        } catch (UserNotFoundException $exception) {
            return new JsonResponse(new SingleErrorView($exception->getMessage()), Response::STATUS_CODE_404);
        } catch (WrongDeletingDateTimeException) {
            return new JsonResponse(new SingleErrorView('Internal error'), Response::STATUS_CODE_500);
        }

        return new EmptyResponse();
    }
}
