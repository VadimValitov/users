<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;
use App\UseCase\Handler\UpdateUserHandler;
use App\UserInterface\Controller\UpdateUserController;
use App\UserInterface\Validator\UserDataValidator;
use App\UserInterface\View\SingleErrorView;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class UpdateUserControllerTest extends TestCase
{
    private UpdateUserController $controller;

    private UpdateUserHandler&MockObject $handler;

    private UserDataValidator&MockObject $validator;

    private ServerRequestInterface&MockObject $request;

    protected function setUp(): void
    {
        $this->handler = $this->createMock(UpdateUserHandler::class);
        $this->validator = $this->createMock(UserDataValidator::class);
        $this->request = $this->createMock(ServerRequestInterface::class);

        $this->request->method('getAttribute')
            ->willReturn(1);

        $this->controller = new UpdateUserController(
            $this->handler,
            $this->validator,
        );
    }

    public function testFailWithWrongRequest(): void
    {
        $requestData = [
            'email' => 'wrong',
        ];

        $this->request->method('getParsedBody')
            ->willReturn($requestData);

        $this->validator->method('validate')
            ->with($requestData)
            ->willReturn([]);

        $response = $this->controller->handle($this->request);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(Response::STATUS_CODE_400, $response->getStatusCode());
    }

    /**
     * @dataProvider getExceptionClass
     */
    public function testFailWhenHandlerThrowsException(string $exceptionClass, int $errorCode): void
    {
        $requestData = [
            'name' => 'username',
            'email' => 'email@local.ru',
            'notes' => null,
        ];

        $this->request->method('getParsedBody')
            ->willReturn($requestData);

        $this->validator->method('validate')
            ->with($requestData)
            ->willReturn($requestData);

        $exception = new $exceptionClass();

        $this->handler->method('handle')
            ->willThrowException($exception);

        $response = $this->controller->handle($this->request);
        $expectedResult = new SingleErrorView($exception->getMessage());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($errorCode, $response->getStatusCode());
        self::assertEquals($expectedResult->toArray(), $response->getPayload()->toArray());
    }

    public function testSuccess(): void
    {
        $requestData = [
            'name' => 'username',
            'email' => 'email@local.ru',
            'notes' => 'notes text',
        ];

        $this->request->method('getParsedBody')
            ->willReturn($requestData);

        $this->validator->method('validate')
            ->with($requestData)
            ->willReturn($requestData);

        $this->handler->expects($this->once())
            ->method('handle');

        $response = $this->controller->handle($this->request);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(Response::STATUS_CODE_200, $response->getStatusCode());
    }

    private function getExceptionClass(): array
    {
        return [
            [
                'exceptionClass' => WrongNameException::class,
                'errorCode' => Response::STATUS_CODE_400,
            ],
            [
                'exceptionClass' => WrongEmailException::class,
                'errorCode' => Response::STATUS_CODE_400,
            ],
            [
                'exceptionClass' => UserNameExistsException::class,
                'errorCode' => Response::STATUS_CODE_422,
            ],
            [
                'exceptionClass' => EmailExistsException::class,
                'errorCode' => Response::STATUS_CODE_422,
            ],
            [
                'exceptionClass' => UserNotFoundException::class,
                'errorCode' => Response::STATUS_CODE_404,
            ],
        ];
    }
}
