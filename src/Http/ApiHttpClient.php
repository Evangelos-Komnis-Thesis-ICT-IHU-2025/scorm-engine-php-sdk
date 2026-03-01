<?php

declare(strict_types=1);

namespace ScormEngineSdk\Http;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ScormEngineSdk\Auth\AuthStrategyInterface;
use ScormEngineSdk\Configuration\Configuration;
use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\HttpHeader;
use ScormEngineSdk\Constants\HttpMethod;
use ScormEngineSdk\Constants\MediaType;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Exception\ApiExceptionFactory;
use ScormEngineSdk\Serialization\JsonSerializer;
use ScormEngineSdk\Transport\TransportInterface;
use ScormEngineSdk\Util\CorrelationId;

final class ApiHttpClient
{
    public function __construct(
        private readonly Configuration $configuration,
        private readonly TransportInterface $transport,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly JsonSerializer $serializer,
        private readonly MultipartBodyBuilder $multipartBodyBuilder,
        private readonly CorrelationId $correlationId,
        private readonly ApiRequestBuilderFactory $requestBuilderFactory,
        private readonly ApiExceptionFactory $apiExceptionFactory
    ) {
    }

    /**
     * @param array<string,mixed> $query
     * @return array<string,mixed>
     */
    public function get(string $path, array $query = [], ?AuthStrategyInterface $auth = null): array
    {
        $apiRequest = $this->requestBuilderFactory
            ->create()
            ->setMethod(HttpMethod::GET->value)
            ->setPath($path)
            ->setQuery($query)
            ->setAuthStrategy($auth)
            ->setExpectJson(true)
            ->build();

        return $this->send($apiRequest);
    }

    /**
     * @param array<string,mixed> $payload
     * @param array<string,mixed> $query
     * @return array<string,mixed>
     */
    public function postJson(string $path, array $payload, array $query = [], ?AuthStrategyInterface $auth = null): array
    {
        $apiRequest = $this->requestBuilderFactory
            ->create()
            ->setMethod(HttpMethod::POST->value)
            ->setPath($path)
            ->setQuery($query)
            ->setBody($this->serializer->encode($payload))
            ->addHeader(HttpHeader::CONTENT_TYPE, MediaType::APPLICATION_JSON)
            ->setAuthStrategy($auth)
            ->setExpectJson(true)
            ->build();

        return $this->send($apiRequest);
    }

    /**
     * @param array<string,string> $fields
     * @param array<int,array{name:string,path:string,filename?:string,contentType?:string}> $files
     * @return array<string,mixed>
     */
    public function postMultipart(
        string $path,
        array $fields,
        array $files,
        ?AuthStrategyInterface $auth = null
    ): array {
        $multipart = $this->multipartBodyBuilder->build($fields, $files);

        $apiRequest = $this->requestBuilderFactory
            ->create()
            ->setMethod(HttpMethod::POST->value)
            ->setPath($path)
            ->setBody($multipart[FieldKey::BODY])
            ->addHeader(HttpHeader::CONTENT_TYPE, $multipart[FieldKey::CONTENT_TYPE])
            ->setAuthStrategy($auth)
            ->setExpectJson(true)
            ->build();

        return $this->send($apiRequest);
    }

    public function postNoBody(string $path, ?AuthStrategyInterface $auth = null): void
    {
        $apiRequest = $this->requestBuilderFactory
            ->create()
            ->setMethod(HttpMethod::POST->value)
            ->setPath($path)
            ->setAuthStrategy($auth)
            ->setExpectJson(false)
            ->build();

        $this->send($apiRequest);
    }

    /**
     * @return array<string,mixed>
     */
    private function send(ApiRequest $apiRequest): array
    {
        $url = $this->buildUrl($apiRequest->getPath(), $apiRequest->getQuery());
        $request = $this->requestFactory->createRequest($apiRequest->getMethod(), $url)
            ->withHeader(HttpHeader::ACCEPT, MediaType::APPLICATION_JSON)
            ->withHeader(HttpHeader::X_CORRELATION_ID, $this->configuration->correlationId() ?? $this->correlationId->generate());

        foreach ($this->configuration->defaultHeaders() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        foreach ($apiRequest->getHeaders() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($apiRequest->getBody() !== null) {
            $request = $request->withBody($this->streamFactory->createStream($apiRequest->getBody()));
        }

        $strategy = $apiRequest->getAuthStrategy() ?? $this->configuration->defaultAuthStrategy();
        if ($strategy !== null) {
            $request = $strategy->apply($request);
        }

        $response = $this->transport->send($request);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw $this->apiExceptionFactory->fromResponse($response);
        }

        if (!$apiRequest->expectsJson()) {
            return [];
        }

        $rawBody = (string) $response->getBody();
        return $this->serializer->decodeObject($rawBody);
    }

    /**
     * @param array<string,mixed> $query
     */
    private function buildUrl(string $path, array $query): string
    {
        $base = $this->configuration->baseUrl();
        $url = $base . StringValue::PATH_SEPARATOR . ltrim($path, StringValue::PATH_SEPARATOR);

        if ($query === []) {
            return $url;
        }

        $queryString = http_build_query($query, arg_separator: StringValue::AMPERSAND, encoding_type: PHP_QUERY_RFC3986);
        return $queryString === StringValue::EMPTY ? $url : $url . StringValue::QUERY_SEPARATOR . $queryString;
    }
}
