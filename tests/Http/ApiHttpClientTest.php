<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Http;

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Configuration\Configuration;
use ScormEngineSdk\Exception\ApiExceptionFactory;
use ScormEngineSdk\Exception\NotFoundException;
use ScormEngineSdk\Exception\ValidationException;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Http\ApiRequestBuilderFactory;
use ScormEngineSdk\Http\MultipartBodyBuilder;
use ScormEngineSdk\Serialization\JsonSerializer;
use ScormEngineSdk\Tests\Support\FakeTransport;
use ScormEngineSdk\Util\CorrelationId;

final class ApiHttpClientTest extends TestCase
{
    public function testMapsErrorPayloadToDomainException(): void
    {
        $transport = new FakeTransport([
            new Response(404, ['Content-Type' => 'application/json'], json_encode([
                'error' => [
                    'code' => 'COURSE_NOT_FOUND',
                    'message' => 'Course not found',
                    'details' => ['courseId' => 'missing'],
                ],
            ], JSON_THROW_ON_ERROR)),
        ]);

        $factory = new HttpFactory();
        $serializer = new JsonSerializer();
        $httpClient = new ApiHttpClient(
            configuration: new Configuration('http://localhost:8080/api/v1'),
            transport: $transport,
            requestFactory: $factory,
            streamFactory: $factory,
            serializer: $serializer,
            multipartBodyBuilder: new MultipartBodyBuilder(),
            correlationId: new CorrelationId(),
            requestBuilderFactory: new ApiRequestBuilderFactory(),
            apiExceptionFactory: new ApiExceptionFactory($serializer)
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Course not found');

        $httpClient->get('/courses/missing');
    }

    public function testThrowsValidationExceptionForInvalidJsonResponses(): void
    {
        $transport = new FakeTransport([
            new Response(200, ['Content-Type' => 'application/json'], '{not-json'),
        ]);

        $factory = new HttpFactory();
        $serializer = new JsonSerializer();
        $httpClient = new ApiHttpClient(
            configuration: new Configuration('http://localhost:8080/api/v1'),
            transport: $transport,
            requestFactory: $factory,
            streamFactory: $factory,
            serializer: $serializer,
            multipartBodyBuilder: new MultipartBodyBuilder(),
            correlationId: new CorrelationId(),
            requestBuilderFactory: new ApiRequestBuilderFactory(),
            apiExceptionFactory: new ApiExceptionFactory($serializer)
        );

        $this->expectException(ValidationException::class);
        $httpClient->get('/courses');
    }
}
