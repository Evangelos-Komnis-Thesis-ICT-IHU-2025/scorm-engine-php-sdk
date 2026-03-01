<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScormEngineSdk\Exception\TransportException;

final class RetryTransport implements TransportInterface
{
    /** @var array<int,int> */
    private array $retryableStatusCodes;

    /** @var array<int,string> */
    private array $retryableMethods;

    /**
     * @param array<int,int> $retryableStatusCodes
     * @param array<int,string> $retryableMethods
     */
    public function __construct(
        private readonly TransportInterface $next,
        private readonly int $maxAttempts = 3,
        array $retryableStatusCodes = [502, 503, 504],
        array $retryableMethods = ['GET'],
        private readonly int $retryDelayMs = 0
    ) {
        $this->retryableStatusCodes = $retryableStatusCodes;
        $this->retryableMethods = $retryableMethods;
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $attempt = 1;

        while (true) {
            $this->rewindRequestBody($request);

            try {
                $response = $this->next->send($request);
            } catch (TransportException $exception) {
                if (!$this->shouldRetry($request->getMethod(), $attempt)) {
                    throw $exception;
                }

                $this->delay();
                $attempt++;
                continue;
            }

            if (!$this->shouldRetryResponse($request->getMethod(), $response->getStatusCode(), $attempt)) {
                return $response;
            }

            $this->delay();
            $attempt++;
        }
    }

    private function shouldRetry(string $method, int $attempt): bool
    {
        if ($attempt >= $this->maxAttempts) {
            return false;
        }

        return in_array($method, $this->retryableMethods, true);
    }

    private function shouldRetryResponse(string $method, int $statusCode, int $attempt): bool
    {
        if (!$this->shouldRetry($method, $attempt)) {
            return false;
        }

        return in_array($statusCode, $this->retryableStatusCodes, true);
    }

    private function delay(): void
    {
        if ($this->retryDelayMs <= 0) {
            return;
        }

        usleep($this->retryDelayMs * 1000);
    }

    private function rewindRequestBody(RequestInterface $request): void
    {
        $body = $request->getBody();

        if ($body->isSeekable()) {
            $body->rewind();
        }
    }
}
