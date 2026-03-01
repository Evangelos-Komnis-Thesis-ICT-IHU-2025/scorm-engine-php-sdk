<?php

declare(strict_types=1);

namespace ScormEngineSdk\Http;

final class ApiRequestBuilderFactory
{
    public function create(): ApiRequestBuilder
    {
        return new ApiRequestBuilder();
    }
}
