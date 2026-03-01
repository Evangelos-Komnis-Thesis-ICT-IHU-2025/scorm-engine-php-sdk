<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Form;

use ScormEngineSdk\Constants\FieldKey;

final class CreateLaunchForm
{
    public function __construct(
        private string $userId,
        private string $courseId,
        private bool $forceNewAttempt = false
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getCourseId(): string
    {
        return $this->courseId;
    }

    public function setCourseId(string $courseId): void
    {
        $this->courseId = $courseId;
    }

    public function isForceNewAttempt(): bool
    {
        return $this->forceNewAttempt;
    }

    public function setForceNewAttempt(bool $forceNewAttempt): void
    {
        $this->forceNewAttempt = $forceNewAttempt;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            FieldKey::USER_ID => $this->getUserId(),
            FieldKey::COURSE_ID => $this->getCourseId(),
            FieldKey::FORCE_NEW_ATTEMPT => $this->isForceNewAttempt(),
        ];
    }
}
