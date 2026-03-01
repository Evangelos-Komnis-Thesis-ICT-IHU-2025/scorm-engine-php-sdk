<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

use ScormEngineSdk\Constants\HttpMethod;

final class RetryTransportMiddleware implements TransportMiddlewareInterface
{
    /** @var array<int,int> */
    private array $retryableStatusCodes;

    /** @var array<int,string> */
    private array $retryableMethods;

    /**
     * @param array<int,int> $retryableStatusCodes
     * @param array<int,string> $retryableMethods
     */
    public function __construct(
        private readonly int $maxAttempts = 3,
        array $retryableStatusCodes = [502, 503, 504],
        array $retryableMethods = [HttpMethod::GET->value],
        private readonly int $retryDelayMs = 0
    ) {
        $this->retryableStatusCodes = $retryableStatusCodes;
        $this->retryableMethods = $retryableMethods;
    }

    public function wrap(TransportInterface $next): TransportInterface
    {
        return new RetryTransport(
            next: $next,
            maxAttempts: $this->maxAttempts,
            retryableStatusCodes: $this->retryableStatusCodes,
            retryableMethods: $this->retryableMethods,
            retryDelayMs: $this->retryDelayMs
        );
    }
}
