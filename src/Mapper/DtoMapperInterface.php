<?php

declare(strict_types=1);

namespace ScormEngineSdk\Mapper;

use ScormEngineSdk\Model\Dto\AttemptDto;
use ScormEngineSdk\Model\Dto\AttemptProgressDto;
use ScormEngineSdk\Model\Dto\CourseDto;
use ScormEngineSdk\Model\Dto\EnrollmentDto;
use ScormEngineSdk\Model\Dto\LaunchContextDto;
use ScormEngineSdk\Model\Dto\LaunchCreatedDto;
use ScormEngineSdk\Model\Dto\UserDto;
use ScormEngineSdk\Model\Pagination\PageResult;

interface DtoMapperInterface
{
    /** @param array<string,mixed> $payload */
    public function mapCourse(array $payload): CourseDto;

    /** @param array<string,mixed> $payload */
    public function mapUser(array $payload): UserDto;

    /** @param array<string,mixed> $payload */
    public function mapEnrollment(array $payload): EnrollmentDto;

    /** @param array<string,mixed> $payload */
    public function mapLaunchCreated(array $payload): LaunchCreatedDto;

    /** @param array<string,mixed> $payload */
    public function mapLaunchContext(array $payload): LaunchContextDto;

    /** @param array<string,mixed> $payload */
    public function mapAttempt(array $payload): AttemptDto;

    /** @param array<string,mixed> $payload */
    public function mapAttemptProgress(array $payload): AttemptProgressDto;

    /**
     * @template T
     * @param array<string,mixed> $payload
     * @param callable(array<string,mixed>):T $itemMapper
     * @return PageResult<T>
     */
    public function mapPageResult(array $payload, callable $itemMapper): PageResult;
}
