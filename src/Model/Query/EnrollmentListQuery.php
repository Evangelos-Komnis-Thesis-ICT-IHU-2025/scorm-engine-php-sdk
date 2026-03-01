<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Query;

use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\QueryDefaults;
use ScormEngineSdk\Constants\StringValue;

final class EnrollmentListQuery extends BaseQuery
{
    public function __construct(
        int $page = 0,
        int $size = 20,
        string $sort = QueryDefaults::SORT_CREATED_AT_DESC,
        private ?string $userId = null,
        private ?string $courseId = null
    ) {
        parent::__construct($page, $size, $sort);
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    public function getCourseId(): ?string
    {
        return $this->courseId;
    }

    public function setCourseId(?string $courseId): void
    {
        $this->courseId = $courseId;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_filter(
            parent::toArray() + [
                FieldKey::USER_ID => $this->getUserId(),
                FieldKey::COURSE_ID => $this->getCourseId(),
            ],
            fn (mixed $value): bool => $value !== null && $value !== StringValue::EMPTY
        );
    }
}
