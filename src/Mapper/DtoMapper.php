<?php

declare(strict_types=1);

namespace ScormEngineSdk\Mapper;

use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Model\Dto\AttemptDto;
use ScormEngineSdk\Model\Dto\AttemptProgressDto;
use ScormEngineSdk\Model\Dto\CourseDto;
use ScormEngineSdk\Model\Dto\EnrollmentDto;
use ScormEngineSdk\Model\Dto\LaunchContextDto;
use ScormEngineSdk\Model\Dto\LaunchCreatedDto;
use ScormEngineSdk\Model\Dto\NormalizedProgressDto;
use ScormEngineSdk\Model\Dto\UserDto;
use ScormEngineSdk\Model\Pagination\PageResult;

final class DtoMapper implements DtoMapperInterface
{
    public function mapCourse(array $payload): CourseDto
    {
        return new CourseDto(
            id: (string) ($payload[FieldKey::ID] ?? StringValue::EMPTY),
            code: $this->stringOrNull($payload[FieldKey::CODE] ?? null),
            title: $this->stringOrNull($payload[FieldKey::TITLE] ?? null),
            description: $this->stringOrNull($payload[FieldKey::DESCRIPTION] ?? null),
            standard: $this->stringOrNull($payload[FieldKey::STANDARD] ?? null),
            versionLabel: $this->stringOrNull($payload[FieldKey::VERSION_LABEL] ?? null),
            entrypointPath: $this->stringOrNull($payload[FieldKey::ENTRYPOINT_PATH] ?? null),
            manifestHash: $this->stringOrNull($payload[FieldKey::MANIFEST_HASH] ?? null),
            metadataJson: $this->stringOrNull($payload[FieldKey::METADATA_JSON] ?? null),
            storageBucket: $this->stringOrNull($payload[FieldKey::STORAGE_BUCKET] ?? null),
            storageObjectKeyZip: $this->stringOrNull($payload[FieldKey::STORAGE_OBJECT_KEY_ZIP] ?? null),
            createdAt: $this->stringOrNull($payload[FieldKey::CREATED_AT] ?? null),
            updatedAt: $this->stringOrNull($payload[FieldKey::UPDATED_AT] ?? null)
        );
    }

    public function mapUser(array $payload): UserDto
    {
        return new UserDto(
            id: (string) ($payload[FieldKey::ID] ?? StringValue::EMPTY),
            externalRef: $this->stringOrNull($payload[FieldKey::EXTERNAL_REF] ?? null),
            username: (string) ($payload[FieldKey::USERNAME] ?? StringValue::EMPTY),
            email: (string) ($payload[FieldKey::EMAIL] ?? StringValue::EMPTY),
            firstName: $this->stringOrNull($payload[FieldKey::FIRST_NAME] ?? null),
            lastName: $this->stringOrNull($payload[FieldKey::LAST_NAME] ?? null),
            locale: $this->stringOrNull($payload[FieldKey::LOCALE] ?? null),
            createdAt: $this->stringOrNull($payload[FieldKey::CREATED_AT] ?? null),
            updatedAt: $this->stringOrNull($payload[FieldKey::UPDATED_AT] ?? null)
        );
    }

    public function mapEnrollment(array $payload): EnrollmentDto
    {
        return new EnrollmentDto(
            id: (string) ($payload[FieldKey::ID] ?? StringValue::EMPTY),
            userId: (string) ($payload[FieldKey::USER_ID] ?? StringValue::EMPTY),
            courseId: (string) ($payload[FieldKey::COURSE_ID] ?? StringValue::EMPTY),
            status: $this->stringOrNull($payload[FieldKey::STATUS] ?? null),
            createdAt: $this->stringOrNull($payload[FieldKey::CREATED_AT] ?? null),
            updatedAt: $this->stringOrNull($payload[FieldKey::UPDATED_AT] ?? null)
        );
    }

    public function mapLaunchCreated(array $payload): LaunchCreatedDto
    {
        return new LaunchCreatedDto(
            launchId: (string) ($payload[FieldKey::LAUNCH_ID] ?? StringValue::EMPTY),
            attemptId: (string) ($payload[FieldKey::ATTEMPT_ID] ?? StringValue::EMPTY),
            standard: $this->stringOrNull($payload[FieldKey::STANDARD] ?? null),
            launchUrl: (string) ($payload[FieldKey::LAUNCH_URL] ?? StringValue::EMPTY),
            launchToken: (string) ($payload[FieldKey::LAUNCH_TOKEN] ?? StringValue::EMPTY),
            expiresAt: $this->stringOrNull($payload[FieldKey::EXPIRES_AT] ?? null)
        );
    }

    public function mapLaunchContext(array $payload): LaunchContextDto
    {
        return new LaunchContextDto(
            launchId: (string) ($payload[FieldKey::LAUNCH_ID] ?? StringValue::EMPTY),
            attemptId: (string) ($payload[FieldKey::ATTEMPT_ID] ?? StringValue::EMPTY),
            user: is_array($payload[FieldKey::USER] ?? null) ? $payload[FieldKey::USER] : null,
            course: is_array($payload[FieldKey::COURSE] ?? null) ? $payload[FieldKey::COURSE] : null,
            player: is_array($payload[FieldKey::PLAYER] ?? null) ? $payload[FieldKey::PLAYER] : null,
            runtime: is_array($payload[FieldKey::RUNTIME] ?? null) ? $payload[FieldKey::RUNTIME] : null
        );
    }

    public function mapAttempt(array $payload): AttemptDto
    {
        return new AttemptDto(
            id: (string) ($payload[FieldKey::ID] ?? StringValue::EMPTY),
            userId: (string) ($payload[FieldKey::USER_ID] ?? StringValue::EMPTY),
            courseId: (string) ($payload[FieldKey::COURSE_ID] ?? StringValue::EMPTY),
            enrollmentId: $this->stringOrNull($payload[FieldKey::ENROLLMENT_ID] ?? null),
            attemptNo: isset($payload[FieldKey::ATTEMPT_NO]) ? (int) $payload[FieldKey::ATTEMPT_NO] : null,
            status: $this->stringOrNull($payload[FieldKey::STATUS] ?? null),
            startedAt: $this->stringOrNull($payload[FieldKey::STARTED_AT] ?? null),
            endedAt: $this->stringOrNull($payload[FieldKey::ENDED_AT] ?? null),
            completionStatus: $this->stringOrNull($payload[FieldKey::COMPLETION_STATUS] ?? null),
            successStatus: $this->stringOrNull($payload[FieldKey::SUCCESS_STATUS] ?? null),
            scoreRaw: isset($payload[FieldKey::SCORE_RAW]) ? (float) $payload[FieldKey::SCORE_RAW] : null,
            scoreScaled: isset($payload[FieldKey::SCORE_SCALED]) ? (float) $payload[FieldKey::SCORE_SCALED] : null,
            totalTimeSeconds: isset($payload[FieldKey::TOTAL_TIME_SECONDS]) ? (int) $payload[FieldKey::TOTAL_TIME_SECONDS] : null,
            lastLocation: $this->stringOrNull($payload[FieldKey::LAST_LOCATION] ?? null),
            lastCommittedAt: $this->stringOrNull($payload[FieldKey::LAST_COMMITTED_AT] ?? null),
            createdAt: $this->stringOrNull($payload[FieldKey::CREATED_AT] ?? null),
            updatedAt: $this->stringOrNull($payload[FieldKey::UPDATED_AT] ?? null)
        );
    }

    public function mapAttemptProgress(array $payload): AttemptProgressDto
    {
        $normalizedPayload = is_array($payload[FieldKey::NORMALIZED_PROGRESS] ?? null)
            ? $payload[FieldKey::NORMALIZED_PROGRESS]
            : null;

        $normalized = $normalizedPayload === null
            ? null
            : new NormalizedProgressDto(
                completionStatus: $this->stringOrNull($normalizedPayload[FieldKey::COMPLETION_STATUS] ?? null),
                successStatus: $this->stringOrNull($normalizedPayload[FieldKey::SUCCESS_STATUS] ?? null),
                score: is_array($normalizedPayload[FieldKey::SCORE] ?? null) ? $normalizedPayload[FieldKey::SCORE] : null,
                time: is_array($normalizedPayload[FieldKey::TIME] ?? null) ? $normalizedPayload[FieldKey::TIME] : null,
                lastLocation: $this->stringOrNull($normalizedPayload[FieldKey::LAST_LOCATION] ?? null),
                bookmark: $this->stringOrNull($normalizedPayload[FieldKey::BOOKMARK] ?? null),
                raw: is_array($normalizedPayload[FieldKey::RAW] ?? null) ? $normalizedPayload[FieldKey::RAW] : []
            );

        return new AttemptProgressDto(
            attemptId: (string) ($payload[FieldKey::ATTEMPT_ID] ?? StringValue::EMPTY),
            normalizedProgress: $normalized
        );
    }

    public function mapPageResult(array $payload, callable $itemMapper): PageResult
    {
        $itemsPayload = is_array($payload[FieldKey::ITEMS] ?? null) ? $payload[FieldKey::ITEMS] : [];
        $mappedItems = [];

        foreach ($itemsPayload as $item) {
            if (is_array($item)) {
                $mappedItems[] = $itemMapper($item);
            }
        }

        return new PageResult(
            items: $mappedItems,
            page: (int) ($payload[FieldKey::PAGE] ?? 0),
            size: (int) ($payload[FieldKey::SIZE] ?? count($mappedItems)),
            totalItems: (int) ($payload[FieldKey::TOTAL_ITEMS] ?? count($mappedItems)),
            totalPages: (int) ($payload[FieldKey::TOTAL_PAGES] ?? 1)
        );
    }

    private function stringOrNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return is_string($value) ? $value : (string) $value;
    }
}
