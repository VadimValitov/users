<?php

declare(strict_types=1);

namespace UserInterfaceTest\Controller;

use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Handler\GetUserHandler;
use App\UserInterface\Controller\GetUserController;
use App\UserInterface\View\SingleErrorView;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GetUserControllerTest extends TestCase
{
    private GetUserController $controller;

    private GetUserHandler&MockObject $handler;

    private ServerRequestInterface&MockObject $request;

    protected function setUp(): void
    {
        $this->handler = $this->createMock(GetUserHandler::class);
        $this->request = $this->createMock(ServerRequestInterface::class);

        $this->request->method('getAttribute')
            ->willReturn(1);

        $this->controller = new GetUserController(
            $this->handler,
        );
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
                'exceptionClass' => UserNotFoundException::class,
                'errorCode' => Response::STATUS_CODE_404,
            ],
        ];
    }
}
