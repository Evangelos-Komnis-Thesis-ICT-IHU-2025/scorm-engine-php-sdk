<?php

declare(strict_types=1);

namespace ScormEngineSdk\Constants;

final class MediaType
{
    public const APPLICATION_JSON = 'application/json';
    public const APPLICATION_OCTET_STREAM = 'application/octet-stream';
    public const APPLICATION_ZIP = 'application/zip';
    public const MULTIPART_FORM_DATA = 'multipart/form-data';

    private function __construct()
    {
    }
}
