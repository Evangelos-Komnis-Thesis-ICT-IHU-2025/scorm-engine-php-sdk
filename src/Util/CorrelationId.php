<?php

declare(strict_types=1);

namespace ScormEngineSdk\Util;

final class CorrelationId
{
    public function generate(): string
    {
        return bin2hex(random_bytes(16));
    }
}
