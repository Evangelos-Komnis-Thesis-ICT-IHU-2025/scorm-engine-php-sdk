<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class AttemptProgressDto
{
    public function __construct(private string $attemptId, private ?NormalizedProgressDto $normalizedProgress)
    {
    }

    public function getAttemptId(): string
    {
        return $this->attemptId;
    }

    public function setAttemptId(string $attemptId): void
    {
        $this->attemptId = $attemptId;
    }

    public function getNormalizedProgress(): ?NormalizedProgressDto
    {
        return $this->normalizedProgress;
    }

    public function setNormalizedProgress(?NormalizedProgressDto $normalizedProgress): void
    {
        $this->normalizedProgress = $normalizedProgress;
    }
}
