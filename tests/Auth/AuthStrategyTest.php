<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Auth;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Auth\BearerTokenAuthStrategy;
use ScormEngineSdk\Auth\LaunchTokenAuthStrategy;
use ScormEngineSdk\Auth\NullAuthStrategy;

final class AuthStrategyTest extends TestCase
{
    public function testBearerStrategyAddsAuthorizationHeader(): void
    {
        $request = new Request('GET', 'http://localhost');
        $strategy = new BearerTokenAuthStrategy('abc123');

        $updated = $strategy->apply($request);

        self::assertSame('Bearer abc123', $updated->getHeaderLine('Authorization'));
    }

    public function testLaunchStrategyAddsAuthorizationHeader(): void
    {
        $request = new Request('GET', 'http://localhost');
        $strategy = new LaunchTokenAuthStrategy('launch-token');

        $updated = $strategy->apply($request);

        self::assertSame('Bearer launch-token', $updated->getHeaderLine('Authorization'));
    }

    public function testNullStrategyReturnsSameRequestWithoutAuthorization(): void
    {
        $request = new Request('GET', 'http://localhost');
        $strategy = new NullAuthStrategy();

        $updated = $strategy->apply($request);

        self::assertSame('', $updated->getHeaderLine('Authorization'));
    }
}
