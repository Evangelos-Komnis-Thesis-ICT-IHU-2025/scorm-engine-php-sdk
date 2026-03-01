<?php

declare(strict_types=1);

namespace ScormEngineSdk\Constants;

final class HttpHeader
{
    public const ACCEPT = 'Accept';
    public const AUTHORIZATION = 'Authorization';
    public const CONTENT_TYPE = 'Content-Type';
    public const X_CORRELATION_ID = 'X-Correlation-Id';

    private function __construct()
    {
    }
}
