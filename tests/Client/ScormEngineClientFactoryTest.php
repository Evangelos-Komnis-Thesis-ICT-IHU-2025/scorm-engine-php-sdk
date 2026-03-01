<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Client;

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Client\ScormEngineClientFactory;
use ScormEngineSdk\Configuration\Configuration;
use ScormEngineSdk\Exception\UnexpectedResponseException;
use ScormEngineSdk\Tests\Support\FakeTransport;

final class ScormEngineClientFactoryTest extends TestCase
{
    public function testDefaultConfigurationRetriesGetRequests(): void
    {
        $transport = new FakeTransport([
            new Response(503, ['Content-Type' => 'application/json'], '{}'),
            new Response(200, ['Content-Type' => 'application/json'], '{}'),
        ]);

        $factory = new HttpFactory();
        $client = (new ScormEngineClientFactory())->createDefault(
            configuration: new Configuration('http://localhost:8080/api/v1'),
            transport: $transport,
            requestFactory: $factory,
            streamFactory: $factory
        );

        $page = $client->courses()->listCourses();

        self::assertSame(2, $transport->requestCount());
        self::assertSame(0, $page->getTotalItems());
    }

    public function testCanDisableRetryFromConfiguration(): void
    {
        $transport = new FakeTransport([
            new Response(503, ['Content-Type' => 'application/json'], json_encode([
                'error' => [
                    'code' => 'TEMPORARY_UNAVAILABLE',
                    'message' => 'Temporary unavailable',
                    'details' => [],
                ],
            ], JSON_THROW_ON_ERROR)),
            new Response(200, ['Content-Type' => 'application/json'], '{}'),
        ]);

        $factory = new HttpFactory();
        $client = (new ScormEngineClientFactory())->createDefault(
            configuration: new Configuration(
                baseUrl: 'http://localhost:8080/api/v1',
                enableRetry: false
            ),
            transport: $transport,
            requestFactory: $factory,
            streamFactory: $factory
        );

        try {
            $client->courses()->listCourses();
            self::fail('Expected UnexpectedResponseException was not thrown.');
        } catch (UnexpectedResponseException) {
            self::assertTrue(true);
        }

        self::assertSame(1, $transport->requestCount());
    }
}
