<?php

declare(strict_types=1);

namespace ScormEngineSdk\Auth;

use Psr\Http\Message\RequestInterface;

final class NullAuthStrategy implements AuthStrategyInterface
{
    public function apply(RequestInterface $request): RequestInterface
    {
        return $request;
    }
}
