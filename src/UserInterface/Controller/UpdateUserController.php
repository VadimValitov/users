<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\UseCase\Dto\UpdateUserHandlerDto;
use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;
use App\UseCase\Handler\UpdateUserHandler;
use App\UserInterface\Validator\UserDataValidator;
use App\UserInterface\View\ErrorsView;
use App\UserInterface\View\SingleErrorView;
use App\UserInterface\View\UserView;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UpdateUserController implements RequestHandlerInterface
{
    public function __construct(
        private UpdateUserHandler $handler,
        private UserDataValidator $validator
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->validator->validate($request->getParsedBody() ?: []);

        if (!$data) {
            return new JsonResponse(new ErrorsView($this->validator->getErrors()), Response::STATUS_CODE_400);
        }

        try {
            $dto = new UpdateUserHandlerDto(
                (int) $request->getAttribute('id'),
                ...$data
            );

            $user = $this->handler->handle($dto);
        } catch (WrongNameException|WrongEmailException $exception) {
            return new JsonResponse(new SingleErrorView($exception->getMessage()), Response::STATUS_CODE_400);
        } catch (UserNameExistsException|EmailExistsException $exception) {
            return new JsonResponse(new SingleErrorView($exception->getMessage()), Response::STATUS_CODE_422);
        } catch (UserNotFoundException $exception) {
            return new JsonResponse(new SingleErrorView($exception->getMessage()), Response::STATUS_CODE_404);
        }

        return new JsonResponse(new UserView($user), Response::STATUS_CODE_200);
    }
}
