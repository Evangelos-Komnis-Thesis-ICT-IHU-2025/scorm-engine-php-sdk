<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScormEngineSdk\Constants\ErrorMessage;

final class LoggingTransport implements TransportInterface
{
    private const LOG_CONTEXT_DURATION_MS = 'durationMs';
    private const LOG_CONTEXT_METHOD = 'method';
    private const LOG_CONTEXT_PATH = 'path';
    private const LOG_CONTEXT_STATUS = 'status';

    public function __construct(private readonly TransportInterface $next, private readonly LoggerInterface $logger)
    {
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        $started = microtime(true);
        $response = $this->next->send($request);
        $durationMs = (int) round((microtime(true) - $started) * 1000);

        $this->logger->debug(ErrorMessage::SCORM_ENGINE_SDK_REQUEST, [
            self::LOG_CONTEXT_METHOD => $request->getMethod(),
            self::LOG_CONTEXT_PATH => $request->getUri()->getPath(),
            self::LOG_CONTEXT_STATUS => $response->getStatusCode(),
            self::LOG_CONTEXT_DURATION_MS => $durationMs,
        ]);

        return $response;
    }
}
