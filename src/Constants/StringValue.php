<?php

declare(strict_types=1);

namespace ScormEngineSdk\Constants;

final class StringValue
{
    public const AMPERSAND = '&';
    public const BOUNDARY_PREFIX = '--------------------------';
    public const DOUBLE_DASH = '--';
    public const EMPTY = '';
    public const PATH_SEPARATOR = '/';
    public const QUERY_SEPARATOR = '?';
    public const WINDOWS_LINE_ENDING = "\r\n";

    private function __construct()
    {
    }
}
