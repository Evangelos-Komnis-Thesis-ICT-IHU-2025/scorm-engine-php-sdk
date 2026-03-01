<?php

declare(strict_types=1);

namespace ScormEngineSdk\Http;

use ScormEngineSdk\Constants\ErrorCode;
use ScormEngineSdk\Constants\ErrorMessage;
use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\MediaType;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Exception\ValidationException;

final class MultipartBodyBuilder
{
    private const DISPOSITION_FIELD_TEMPLATE = 'Content-Disposition: form-data; name="%s"';
    private const DISPOSITION_FILE_TEMPLATE = 'Content-Disposition: form-data; name="%s"; filename="%s"';
    private const CONTENT_TYPE_PREFIX = 'Content-Type: ';
    private const FIELD_SEPARATOR = '; ';
    private const MULTIPART_BOUNDARY_PREFIX = 'boundary=';

    /**
     * @param array<string,string> $fields
     * @param array<int,array{name:string,path:string,filename?:string,contentType?:string}> $files
     * @return array{contentType:string,body:string}
     */
    public function build(array $fields, array $files): array
    {
        $boundary = StringValue::BOUNDARY_PREFIX . bin2hex(random_bytes(12));
        $eol = StringValue::WINDOWS_LINE_ENDING;
        $body = StringValue::EMPTY;

        foreach ($fields as $name => $value) {
            $body .= StringValue::DOUBLE_DASH . $boundary . $eol;
            $body .= sprintf(self::DISPOSITION_FIELD_TEMPLATE, $name) . $eol . $eol;
            $body .= $value . $eol;
        }

        foreach ($files as $file) {
            $path = $file[FieldKey::PATH];
            $contents = @file_get_contents($path);
            if ($contents === false) {
                throw new ValidationException(
                    message: ErrorMessage::UNABLE_TO_READ_FILE_FOR_MULTIPART_UPLOAD,
                    httpStatus: 400,
                    errorCode: ErrorCode::FILE_READ_ERROR,
                    details: [FieldKey::PATH => $path]
                );
            }

            $filename = $file[FieldKey::FILENAME] ?? basename($path);
            $contentType = $file[FieldKey::CONTENT_TYPE] ?? MediaType::APPLICATION_OCTET_STREAM;

            $body .= StringValue::DOUBLE_DASH . $boundary . $eol;
            $body .= sprintf(
                self::DISPOSITION_FILE_TEMPLATE,
                $file[FieldKey::NAME],
                $filename
            ) . $eol;
            $body .= self::CONTENT_TYPE_PREFIX . $contentType . $eol . $eol;
            $body .= $contents . $eol;
        }

        $body .= StringValue::DOUBLE_DASH . $boundary . StringValue::DOUBLE_DASH . $eol;

        return [
            FieldKey::CONTENT_TYPE => MediaType::MULTIPART_FORM_DATA . self::FIELD_SEPARATOR . self::MULTIPART_BOUNDARY_PREFIX . $boundary,
            FieldKey::BODY => $body,
        ];
    }
}
