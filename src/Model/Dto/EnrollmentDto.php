<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class EnrollmentDto
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $courseId,
        private ?string $status,
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
