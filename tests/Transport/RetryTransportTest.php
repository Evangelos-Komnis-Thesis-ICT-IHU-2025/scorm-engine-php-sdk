<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Transport;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Transport\RetryTransportMiddleware;
use ScormEngineSdk\Transport\TransportPipelineBuilder;
use ScormEngineSdk\Tests\Support\FakeTransport;

final class RetryTransportTest extends TestCase
{
    public function testRetriesGetRequestOnRetryableStatusCode(): void
    {
        $baseTransport = new FakeTransport([
            new Response(503, ['Content-Type' => 'application/json'], '{}'),
            new Response(200, ['Content-Type' => 'application/json'], '{}'),
        ]);

        $transport = (new TransportPipelineBuilder())
            ->addMiddleware(new RetryTransportMiddleware(maxAttempts: 2, retryableStatusCodes: [503]))
            ->build($baseTransport);

        $response = $transport->send(new Request('GET', 'http://localhost/test'));

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(2, $baseTransport->requestCount());
    }

    public function testDoesNotRetryPostRequestByDefault(): void
    {
        $baseTransport = new FakeTransport([
            new Response(503, ['Content-Type' => 'application/json'], '{}'),
            new Response(200, ['Content-Type' => 'application/json'], '{}'),
        ]);

        $transport = (new TransportPipelineBuilder())
            ->addMiddleware(new RetryTransportMiddleware(maxAttempts: 2, retryableStatusCodes: [503]))
            ->build($baseTransport);

        $response = $transport->send(new Request('POST', 'http://localhost/test'));

        self::assertSame(503, $response->getStatusCode());
        self::assertSame(1, $baseTransport->requestCount());
    }
}
