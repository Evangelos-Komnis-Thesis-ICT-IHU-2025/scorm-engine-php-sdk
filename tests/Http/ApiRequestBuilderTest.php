<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Http;

use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Constants\HttpMethod;
use ScormEngineSdk\Http\ApiRequestBuilderFactory;

final class ApiRequestBuilderTest extends TestCase
{
    public function testBuildsApiRequestWithConfiguredValues(): void
    {
        $request = (new ApiRequestBuilderFactory())
            ->create()
            ->setMethod(HttpMethod::POST->value)
            ->setPath('/courses')
            ->setQuery(['page' => 1])
            ->setBody('{"name":"Course"}')
            ->addHeader('Content-Type', 'application/json')
            ->setExpectJson(true)
            ->build();

        self::assertSame(HttpMethod::POST->value, $request->getMethod());
        self::assertSame('/courses', $request->getPath());
        self::assertSame(['page' => 1], $request->getQuery());
        self::assertSame('{"name":"Course"}', $request->getBody());
        self::assertSame(['Content-Type' => 'application/json'], $request->getHeaders());
        self::assertTrue($request->expectsJson());
    }
}
