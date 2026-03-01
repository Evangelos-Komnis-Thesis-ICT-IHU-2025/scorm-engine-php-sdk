<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class AttemptDto
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $courseId,
        private ?string $enrollmentId,
        private ?int $attemptNo,
        private ?string $status,
        private ?string $startedAt,
        private ?string $endedAt,
        private ?string $completionStatus,
        private ?string $successStatus,
        private ?float $scoreRaw,
        private ?float $scoreScaled,
        private ?int $totalTimeSeconds,
        private ?string $lastLocation,
        private ?string $lastCommittedAt,
        private ?string $createdAt,
        private ?string $updatedAt
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
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

    public function getEnrollmentId(): ?string
    {
        return $this->enrollmentId;
    }

    public function setEnrollmentId(?string $enrollmentId): void
    {
        $this->enrollmentId = $enrollmentId;
    }

    public function getAttemptNo(): ?int
    {
        return $this->attemptNo;
    }

    public function setAttemptNo(?int $attemptNo): void
    {
        $this->attemptNo = $attemptNo;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getStartedAt(): ?string
    {
        return $this->startedAt;
    }

    public function setStartedAt(?string $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    public function getEndedAt(): ?string
    {
        return $this->endedAt;
    }

    public function setEndedAt(?string $endedAt): void
    {
        $this->endedAt = $endedAt;
    }

    public function getCompletionStatus(): ?string
    {
        return $this->completionStatus;
    }

    public function setCompletionStatus(?string $completionStatus): void
    {
        $this->completionStatus = $completionStatus;
    }

    public function getSuccessStatus(): ?string
    {
        return $this->successStatus;
    }

    public function setSuccessStatus(?string $successStatus): void
    {
        $this->successStatus = $successStatus;
    }

    public function getScoreRaw(): ?float
    {
        return $this->scoreRaw;
    }

    public function setScoreRaw(?float $scoreRaw): void
    {
        $this->scoreRaw = $scoreRaw;
    }

    public function getScoreScaled(): ?float
    {
        return $this->scoreScaled;
    }

    public function setScoreScaled(?float $scoreScaled): void
    {
        $this->scoreScaled = $scoreScaled;
    }

    public function getTotalTimeSeconds(): ?int
    {
        return $this->totalTimeSeconds;
    }

    public function setTotalTimeSeconds(?int $totalTimeSeconds): void
    {
        $this->totalTimeSeconds = $totalTimeSeconds;
    }

    public function getLastLocation(): ?string
    {
        return $this->lastLocation;
    }

    public function setLastLocation(?string $lastLocation): void
    {
        $this->lastLocation = $lastLocation;
    }

    public function getLastCommittedAt(): ?string
    {
        return $this->lastCommittedAt;
    }

    public function setLastCommittedAt(?string $lastCommittedAt): void
    {
        $this->lastCommittedAt = $lastCommittedAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
