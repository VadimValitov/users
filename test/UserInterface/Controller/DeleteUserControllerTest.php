<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\Domain\Exception\WrongDeletingDateTimeException;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\DeleteUserHandler;
use App\UserInterface\Controller\DeleteUserController;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DeleteUserControllerTest extends TestCase
{
    private DeleteUserController $controller;

    private DeleteUserHandler&MockObject $handler;

    private ServerRequestInterface&MockObject $request;

    protected function setUp(): void
    {
        $this->handler = $this->createMock(DeleteUserHandler::class);
        $this->request = $this->createMock(ServerRequestInterface::class);

        $this->request->method('getAttribute')
            ->willReturn(1);

        $this->controller = new DeleteUserController(
            $this->handler,
        );
    }

    /**
     * @dataProvider getExceptionClass
     */
    public function testFailWhenHandlerThrowsException(string $exceptionClass, int $errorCode): void
    {
        $exception = new $exceptionClass();

        $this->handler->method('handle')
            ->willThrowException($exception);

        $response = $this->controller->handle($this->request);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($errorCode, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $this->handler->expects($this->once())
            ->method('handle');

        $response = $this->controller->handle($this->request);

        self::assertInstanceOf(EmptyResponse::class, $response);
        self::assertEquals(Response::STATUS_CODE_204, $response->getStatusCode());
    }

    private function getExceptionClass(): array
    {
        return [
            [
                'exceptionClass' => UserNotFoundException::class,
                'errorCode' => Response::STATUS_CODE_404,
            ],
            [
                'exceptionClass' => WrongDeletingDateTimeException::class,
                'errorCode' => Response::STATUS_CODE_500,
            ],
        ];
    }
}
