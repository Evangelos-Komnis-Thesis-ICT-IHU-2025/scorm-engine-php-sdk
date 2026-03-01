<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class NormalizedProgressDto
{
    /**
     * @param array<string,mixed>|null $score
     * @param array<string,mixed>|null $time
     * @param array<string,mixed> $raw
     */
    public function __construct(
        private ?string $completionStatus,
        private ?string $successStatus,
        private ?array $score,
        private ?array $time,
        private ?string $lastLocation,
        private ?string $bookmark,
        private array $raw
    ) {
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

    /**
     * @return array<string,mixed>|null
     */
    public function getScore(): ?array
    {
        return $this->score;
    }

    /**
     * @param array<string,mixed>|null $score
     */
    public function setScore(?array $score): void
    {
        $this->score = $score;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getTime(): ?array
    {
        return $this->time;
    }

    /**
     * @param array<string,mixed>|null $time
     */
    public function setTime(?array $time): void
    {
        $this->time = $time;
    }

    public function getLastLocation(): ?string
    {
        return $this->lastLocation;
    }

    public function setLastLocation(?string $lastLocation): void
    {
        $this->lastLocation = $lastLocation;
    }

    public function getBookmark(): ?string
    {
        return $this->bookmark;
    }

    public function setBookmark(?string $bookmark): void
    {
        $this->bookmark = $bookmark;
    }

    /**
     * @return array<string,mixed>
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * @param array<string,mixed> $raw
     */
    public function setRaw(array $raw): void
    {
        $this->raw = $raw;
    }
}
