<?php

declare(strict_types=1);

namespace ScormEngineSdk\Constants;

final class ErrorMessage
{
    public const COURSE_ZIP_FILE_DOES_NOT_EXIST = 'Course zip file does not exist';
    public const FAILED_TO_ENCODE_JSON_PAYLOAD = 'Failed to encode JSON payload';
    public const HTTP_TRANSPORT_FAILED_PREFIX = 'HTTP transport failed: ';
    public const INVALID_JSON_RESPONSE_FROM_SCORM_ENGINE = 'Invalid JSON response from SCORM Engine';
    public const SCORM_ENGINE_REQUEST_FAILED = 'SCORM Engine request failed';
    public const SCORM_ENGINE_SDK_REQUEST = 'SCORM Engine SDK request';
    public const UNABLE_TO_READ_FILE_FOR_MULTIPART_UPLOAD = 'Unable to read file for multipart upload';

    private function __construct()
    {
    }
}
