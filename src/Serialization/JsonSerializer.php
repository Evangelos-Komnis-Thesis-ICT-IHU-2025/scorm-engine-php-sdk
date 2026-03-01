<?php

declare(strict_types=1);

namespace ScormEngineSdk\Serialization;

use JsonException;
use ScormEngineSdk\Constants\ErrorCode;
use ScormEngineSdk\Constants\ErrorMessage;
use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Exception\ValidationException;

final class JsonSerializer
{
    /**
     * @param array<string,mixed> $payload
     */
    public function encode(array $payload): string
    {
        try {
            return json_encode($payload, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ValidationException(
                message: ErrorMessage::FAILED_TO_ENCODE_JSON_PAYLOAD,
                httpStatus: 400,
                errorCode: ErrorCode::JSON_ENCODE_ERROR,
                details: [FieldKey::REASON => $e->getMessage()],
                previous: $e
            );
        }
    }

    /**
     * @return array<string,mixed>
     */
    public function decodeObject(string $json): array
    {
        if ($json === StringValue::EMPTY) {
            return [];
        }

        try {
            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ValidationException(
                message: ErrorMessage::INVALID_JSON_RESPONSE_FROM_SCORM_ENGINE,
                httpStatus: 502,
                errorCode: ErrorCode::INVALID_JSON_RESPONSE,
                details: [FieldKey::REASON => $e->getMessage()],
                responseBody: $json,
                previous: $e
            );
        }

        return is_array($decoded) ? $decoded : [];
    }
}
