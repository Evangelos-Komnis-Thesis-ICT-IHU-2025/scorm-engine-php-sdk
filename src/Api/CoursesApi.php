<?php

declare(strict_types=1);

namespace ScormEngineSdk\Api;

use ScormEngineSdk\Constants\ApiEndpoint;
use ScormEngineSdk\Constants\ErrorCode;
use ScormEngineSdk\Constants\ErrorMessage;
use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\MediaType;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Exception\ValidationException;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Model\Dto\CourseDto;
use ScormEngineSdk\Model\Pagination\PageResult;
use ScormEngineSdk\Model\Query\CourseListQuery;

final readonly class CoursesApi
{
    private const IMPORT_SUFFIX = '/import';
    private const MULTIPART_FILE_FIELD_NAME = FieldKey::FILE;

    public function __construct(private ApiHttpClient $httpClient, private DtoMapperInterface $mapper)
    {
    }

    public function importCourse(
        string $zipPath,
        ?string $code = null,
        ?string $versionLabel = null,
        ?string $filename = null
    ): CourseDto
    {
        if (!is_file($zipPath)) {
            throw new ValidationException(
                message: ErrorMessage::COURSE_ZIP_FILE_DOES_NOT_EXIST,
                httpStatus: 400,
                errorCode: ErrorCode::ZIP_FILE_NOT_FOUND,
                details: [FieldKey::PATH => $zipPath]
            );
        }

        $fields = [];
        if ($code !== null && $code !== StringValue::EMPTY) {
            $fields[FieldKey::CODE] = $code;
        }
        if ($versionLabel !== null && $versionLabel !== StringValue::EMPTY) {
            $fields[FieldKey::VERSION_LABEL] = $versionLabel;
        }

        $resolvedFilename = $filename !== null && trim($filename) !== StringValue::EMPTY ? trim($filename) : basename($zipPath);

        $response = $this->httpClient->postMultipart(
            path: $this->courseImportPath(),
            fields: $fields,
            files: [[
                FieldKey::NAME => self::MULTIPART_FILE_FIELD_NAME,
                FieldKey::PATH => $zipPath,
                FieldKey::FILENAME => $resolvedFilename,
                FieldKey::CONTENT_TYPE => MediaType::APPLICATION_ZIP,
            ]]
        );

        return $this->mapper->mapCourse($response);
    }

    public function listCourses(?CourseListQuery $query = null): PageResult
    {
        $query = $query ?? new CourseListQuery();
        $response = $this->httpClient->get(ApiEndpoint::COURSES, $query->toArray());

        return $this->mapper->mapPageResult($response, $this->mapper->mapCourse(...));
    }

    public function getCourse(string $courseId): CourseDto
    {
        $response = $this->httpClient->get($this->coursePath($courseId));
        return $this->mapper->mapCourse($response);
    }

    private function courseImportPath(): string
    {
        return ApiEndpoint::COURSES . self::IMPORT_SUFFIX;
    }

    private function coursePath(string $courseId): string
    {
        return ApiEndpoint::COURSES . StringValue::PATH_SEPARATOR . rawurlencode($courseId);
    }
}
