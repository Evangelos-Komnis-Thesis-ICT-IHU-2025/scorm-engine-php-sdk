<?php

declare(strict_types=1);

namespace ScormEngineSdk\Http;

use ScormEngineSdk\Auth\AuthStrategyInterface;

final class ApiRequest
{
    /**
     * @param array<string,mixed> $query
     * @param array<string,string> $headers
     */
    public function __construct(
        private string $method,
        private string $path,
        private array $query = [],
        private ?string $body = null,
        private array $headers = [],
        private ?AuthStrategyInterface $authStrategy = null,
        private bool $expectJson = true
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<string,mixed>
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return array<string,string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getAuthStrategy(): ?AuthStrategyInterface
    {
        return $this->authStrategy;
    }

    public function expectsJson(): bool
    {
        return $this->expectJson;
    }
}
