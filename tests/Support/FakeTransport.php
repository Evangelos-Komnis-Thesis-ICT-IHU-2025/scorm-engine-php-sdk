<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Support;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScormEngineSdk\Transport\TransportInterface;

final class FakeTransport implements TransportInterface
{
    /** @var array<int,ResponseInterface> */
    private array $responses;

    /** @var array<int,RequestInterface> */
    private array $requests = [];

    /**
     * @param array<int,ResponseInterface> $responses
     */
    public function __construct(array $responses = [])
    {
        $this->responses = $responses;
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;

        if ($this->responses === []) {
            return new Response(200, ['Content-Type' => 'application/json'], '{}');
        }

        return array_shift($this->responses);
    }

    public function lastRequest(): ?RequestInterface
    {
        if ($this->requests === []) {
            return null;
        }

        return $this->requests[array_key_last($this->requests)];
    }

    public function requestCount(): int
    {
        return count($this->requests);
    }
}
