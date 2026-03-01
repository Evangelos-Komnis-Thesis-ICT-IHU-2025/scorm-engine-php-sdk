<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScormEngineSdk\Constants\ErrorMessage;
use ScormEngineSdk\Exception\TransportException;

final readonly class Psr18Transport implements TransportInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException(ErrorMessage::HTTP_TRANSPORT_FAILED_PREFIX . $e->getMessage(), previous: $e);
        }
    }
}
