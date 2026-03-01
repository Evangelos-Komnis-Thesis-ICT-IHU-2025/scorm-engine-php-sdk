<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

interface TransportMiddlewareInterface
{
    public function wrap(TransportInterface $next): TransportInterface;
}
