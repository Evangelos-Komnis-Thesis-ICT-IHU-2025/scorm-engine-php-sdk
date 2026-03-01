<?php

declare(strict_types=1);

namespace ScormEngineSdk\Auth;

use Psr\Http\Message\RequestInterface;
use ScormEngineSdk\Constants\AuthScheme;
use ScormEngineSdk\Constants\HttpHeader;

final readonly class LaunchTokenAuthStrategy implements AuthStrategyInterface
{
    public function __construct(private string $launchToken)
    {
    }

    public function apply(RequestInterface $request): RequestInterface
    {
        return $request->withHeader(HttpHeader::AUTHORIZATION, AuthScheme::BEARER_PREFIX . $this->launchToken);
    }
}
