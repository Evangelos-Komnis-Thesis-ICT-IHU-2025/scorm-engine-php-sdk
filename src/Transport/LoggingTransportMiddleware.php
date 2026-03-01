<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

use Psr\Log\LoggerInterface;

final class LoggingTransportMiddleware implements TransportMiddlewareInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function wrap(TransportInterface $next): TransportInterface
    {
        return new LoggingTransport($next, $this->logger);
    }
}
