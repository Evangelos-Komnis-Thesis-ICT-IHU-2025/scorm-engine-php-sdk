<?php

declare(strict_types=1);

namespace ScormEngineSdk\Configuration;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use ScormEngineSdk\Auth\AuthStrategyInterface;
use ScormEngineSdk\Constants\HttpMethod;
use ScormEngineSdk\Constants\StringValue;

final readonly class Configuration
{
    /** @var array<int,int> */
    private const DEFAULT_RETRYABLE_STATUS_CODES = [502, 503, 504];
    /** @var array<int,string> */
    private const DEFAULT_RETRYABLE_METHODS = [HttpMethod::GET->value];

    /**
     * @param array<string,string> $defaultHeaders
     * @param array<int,int> $retryableStatusCodes
     * @param array<int,string> $retryableMethods
     */
    public function __construct(
        private string $baseUrl,
        private ?AuthStrategyInterface $defaultAuthStrategy = null,
        private array $defaultHeaders = [],
        private ?LoggerInterface $logger = null,
        private ?string $correlationId = null,
        private bool $enableRetry = true,
        private int $retryMaxAttempts = 3,
        private int $retryDelayMs = 0,
        private array $retryableStatusCodes = [],
        private array $retryableMethods = [],
        private bool $enableTransportLogging = true
    ) {
    }

    public function baseUrl(): string
    {
        return rtrim($this->baseUrl, StringValue::PATH_SEPARATOR);
    }

    public function defaultAuthStrategy(): ?AuthStrategyInterface
    {
        return $this->defaultAuthStrategy;
    }

    /**
     * @return array<string,string>
     */
    public function defaultHeaders(): array
    {
        return $this->defaultHeaders;
    }

    public function logger(): LoggerInterface
    {
        return $this->logger ?? new NullLogger();
    }

    public function correlationId(): ?string
    {
        return $this->correlationId;
    }

    public function enableRetry(): bool
    {
        return $this->enableRetry;
    }

    public function retryMaxAttempts(): int
    {
        return $this->retryMaxAttempts > 1 ? $this->retryMaxAttempts : 1;
    }

    public function retryDelayMs(): int
    {
        return $this->retryDelayMs > 0 ? $this->retryDelayMs : 0;
    }

    /**
     * @return array<int,int>
     */
    public function retryableStatusCodes(): array
    {
        return $this->retryableStatusCodes === []
            ? self::DEFAULT_RETRYABLE_STATUS_CODES
            : $this->retryableStatusCodes;
    }

    /**
     * @return array<int,string>
     */
    public function retryableMethods(): array
    {
        return $this->retryableMethods === []
            ? self::DEFAULT_RETRYABLE_METHODS
            : $this->retryableMethods;
    }

    public function enableTransportLogging(): bool
    {
        return $this->enableTransportLogging;
    }
}
