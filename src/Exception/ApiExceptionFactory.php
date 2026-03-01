<?php

declare(strict_types=1);

namespace ScormEngineSdk\Exception;

use Psr\Http\Message\ResponseInterface;
use ScormEngineSdk\Constants\ErrorCode;
use ScormEngineSdk\Constants\ErrorMessage;
use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Serialization\JsonSerializer;

final class ApiExceptionFactory
{
    public function __construct(private readonly JsonSerializer $serializer)
    {
    }

    public function fromResponse(ResponseInterface $response): ApiException
    {
        $status = $response->getStatusCode();
        $rawBody = (string) $response->getBody();
        $payload = $this->serializer->decodeObject($rawBody);

        $error = is_array($payload[FieldKey::ERROR] ?? null) ? $payload[FieldKey::ERROR] : [];
        $code = is_string($error[FieldKey::CODE] ?? null) ? $error[FieldKey::CODE] : ErrorCode::API_ERROR;
        $message = is_string($error[FieldKey::MESSAGE] ?? null)
            ? $error[FieldKey::MESSAGE]
            : ErrorMessage::SCORM_ENGINE_REQUEST_FAILED;
        $details = is_array($error[FieldKey::DETAILS] ?? null) ? $error[FieldKey::DETAILS] : [];

        return match ($status) {
            400, 422 => new ValidationException($message, $status, $code, $details, $rawBody),
            401, 403 => new UnauthorizedException($message, $status, $code, $details, $rawBody),
            404 => new NotFoundException($message, $status, $code, $details, $rawBody),
            409 => new ConflictException($message, $status, $code, $details, $rawBody),
            default => new UnexpectedResponseException($message, $status, $code, $details, $rawBody),
        };
    }
}
