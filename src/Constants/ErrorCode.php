<?php

declare(strict_types=1);

namespace ScormEngineSdk\Constants;

final class ErrorCode
{
    public const API_ERROR = 'API_ERROR';
    public const FILE_READ_ERROR = 'FILE_READ_ERROR';
    public const INVALID_JSON_RESPONSE = 'INVALID_JSON_RESPONSE';
    public const JSON_ENCODE_ERROR = 'JSON_ENCODE_ERROR';
    public const ZIP_FILE_NOT_FOUND = 'ZIP_FILE_NOT_FOUND';

    private function __construct()
    {
    }
}
