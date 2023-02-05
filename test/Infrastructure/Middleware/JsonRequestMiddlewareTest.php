<?php

declare(strict_types=1);

namespace InfrastructureTest\Middleware;

use App\Infrastructure\Middleware\JsonRequestMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function json_encode;

class JsonRequestMiddlewareTest extends TestCase
{
    private JsonRequestMiddleware $middleware;

    private ServerRequestInterface&MockObject $request;

    private RequestHandlerInterface&MockObject $handler;

    protected function setUp(): void
    {
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->handler = $this->createMock(RequestHandlerInterface::class);

        $this->request->method('getAttribute')
            ->willReturn(1);

        $this->middleware = new JsonRequestMiddleware();
    }

    public function testForNotJson(): void
    {
        $this->request->expects(self::never())
            ->method('getBody');

        $this->request->expects(self::never())
            ->method('withParsedBody');

        $this->handler->expects(self::once())
            ->method('handle');

        $this->middleware->process($this->request, $this->handler);
    }

    public function testForJson(): void
    {
        $this->request->method('getHeaderLine')
            ->willReturn('application/json');

        $body = $this->createMock(StreamInterface::class);
        $data = ['test' => 1];

        $body->method('getContents')
            ->willReturn(json_encode($data));

        $this->request->expects(self::once())
            ->method('getBody')
            ->willReturn($body);

        $this->request->expects(self::once())
            ->method('withParsedBody')
            ->with($data)
            ->willReturnSelf();

        $this->handler->expects(self::once())
            ->method('handle');

        $this->middleware->process($this->request, $this->handler);
    }
}
