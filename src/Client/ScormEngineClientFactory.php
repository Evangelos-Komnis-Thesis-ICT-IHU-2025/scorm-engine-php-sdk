<?php

declare(strict_types=1);

namespace ScormEngineSdk\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ScormEngineSdk\Api\AttemptsApi;
use ScormEngineSdk\Api\CoursesApi;
use ScormEngineSdk\Api\EnrollmentsApi;
use ScormEngineSdk\Api\LaunchesApi;
use ScormEngineSdk\Api\UsersApi;
use ScormEngineSdk\Configuration\Configuration;
use ScormEngineSdk\Exception\ApiExceptionFactory;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Http\ApiRequestBuilderFactory;
use ScormEngineSdk\Http\MultipartBodyBuilder;
use ScormEngineSdk\Mapper\DtoMapper;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Serialization\JsonSerializer;
use ScormEngineSdk\Transport\LoggingTransportMiddleware;
use ScormEngineSdk\Transport\RetryTransportMiddleware;
use ScormEngineSdk\Transport\TransportInterface;
use ScormEngineSdk\Transport\TransportPipelineBuilder;
use ScormEngineSdk\Util\CorrelationId;

final class ScormEngineClientFactory
{
    public function createDefault(
        Configuration $configuration,
        TransportInterface $transport,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        ?DtoMapperInterface $mapper = null
    ): ScormEngineClient {
        $mapper = $mapper ?? new DtoMapper();
        $serializer = new JsonSerializer();

        $transportPipelineBuilder = new TransportPipelineBuilder();
        if ($configuration->enableRetry()) {
            $transportPipelineBuilder->addMiddleware(new RetryTransportMiddleware(
                maxAttempts: $configuration->retryMaxAttempts(),
                retryableStatusCodes: $configuration->retryableStatusCodes(),
                retryableMethods: $configuration->retryableMethods(),
                retryDelayMs: $configuration->retryDelayMs()
            ));
        }

        if ($configuration->enableTransportLogging()) {
            $transportPipelineBuilder->addMiddleware(new LoggingTransportMiddleware($configuration->logger()));
        }

        $resolvedTransport = $transportPipelineBuilder->build($transport);

        $httpClient = new ApiHttpClient(
            configuration: $configuration,
            transport: $resolvedTransport,
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
            serializer: $serializer,
            multipartBodyBuilder: new MultipartBodyBuilder(),
            correlationId: new CorrelationId(),
            requestBuilderFactory: new ApiRequestBuilderFactory(),
            apiExceptionFactory: new ApiExceptionFactory($serializer)
        );

        return new ScormEngineClient(
            coursesApi: new CoursesApi($httpClient, $mapper),
            usersApi: new UsersApi($httpClient, $mapper),
            enrollmentsApi: new EnrollmentsApi($httpClient, $mapper),
            launchesApi: new LaunchesApi($httpClient, $mapper),
            attemptsApi: new AttemptsApi($httpClient, $mapper)
        );
    }
}
