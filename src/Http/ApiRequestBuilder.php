<?php

declare(strict_types=1);

namespace ScormEngineSdk\Http;

use ScormEngineSdk\Auth\AuthStrategyInterface;
use ScormEngineSdk\Constants\HttpMethod;
use ScormEngineSdk\Constants\StringValue;

final class ApiRequestBuilder
{
    private string $method = HttpMethod::GET->value;
    private string $path = StringValue::EMPTY;
    /** @var array<string,mixed> */
    private array $query = [];
    private ?string $body = null;
    /** @var array<string,string> */
    private array $headers = [];
    private ?AuthStrategyInterface $authStrategy = null;
    private bool $expectJson = true;

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param array<string,mixed> $query
     */
    public function setQuery(array $query): self
    {
        $this->query = $query;
        return $this;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param array<string,string> $headers
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setAuthStrategy(?AuthStrategyInterface $authStrategy): self
    {
        $this->authStrategy = $authStrategy;
        return $this;
    }

    public function setExpectJson(bool $expectJson): self
    {
        $this->expectJson = $expectJson;
        return $this;
    }

    public function build(): ApiRequest
    {
        return new ApiRequest(
            method: $this->method,
            path: $this->path,
            query: $this->query,
            body: $this->body,
            headers: $this->headers,
            authStrategy: $this->authStrategy,
            expectJson: $this->expectJson
        );
    }
}
