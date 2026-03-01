<?php

declare(strict_types=1);

namespace ScormEngineSdk\Exception;

use RuntimeException;
use ScormEngineSdk\Constants\ErrorCode;

class ApiException extends RuntimeException
{
    /** @var array<string,mixed> */
    private array $details;

    public function __construct(
        string $message,
        private readonly int $httpStatus,
        private readonly string $errorCode = ErrorCode::API_ERROR,
        array $details = [],
        private readonly ?string $responseBody = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $httpStatus, $previous);
        $this->details = $details;
    }

    public function httpStatus(): int
    {
        return $this->httpStatus;
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return array<string,mixed>
     */
    public function details(): array
    {
        return $this->details;
    }

    public function responseBody(): ?string
    {
        return $this->responseBody;
    }
}
