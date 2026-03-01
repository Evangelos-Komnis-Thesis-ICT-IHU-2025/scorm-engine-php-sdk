<?php

declare(strict_types=1);

namespace ScormEngineSdk\Auth;

use Psr\Http\Message\RequestInterface;

interface AuthStrategyInterface
{
    public function apply(RequestInterface $request): RequestInterface;
}
