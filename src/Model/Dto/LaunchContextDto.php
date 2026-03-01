<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class LaunchContextDto
{
    /**
     * @param array<string,mixed>|null $user
     * @param array<string,mixed>|null $course
     * @param array<string,mixed>|null $player
     * @param array<string,mixed>|null $runtime
     */
    public function __construct(
        private string $launchId,
        private string $attemptId,
        private ?array $user,
        private ?array $course,
        private ?array $player,
        private ?array $runtime
    ) {
    }

    public function getLaunchId(): string
    {
        return $this->launchId;
    }

    public function setLaunchId(string $launchId): void
    {
        $this->launchId = $launchId;
    }

    public function getAttemptId(): string
    {
        return $this->attemptId;
    }

    public function setAttemptId(string $attemptId): void
    {
        $this->attemptId = $attemptId;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getUser(): ?array
    {
        return $this->user;
    }

    /**
     * @param array<string,mixed>|null $user
     */
    public function setUser(?array $user): void
    {
        $this->user = $user;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getCourse(): ?array
    {
        return $this->course;
    }

    /**
     * @param array<string,mixed>|null $course
     */
    public function setCourse(?array $course): void
    {
        $this->course = $course;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getPlayer(): ?array
    {
        return $this->player;
    }

    /**
     * @param array<string,mixed>|null $player
     */
    public function setPlayer(?array $player): void
    {
        $this->player = $player;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getRuntime(): ?array
    {
        return $this->runtime;
    }

    /**
     * @param array<string,mixed>|null $runtime
     */
    public function setRuntime(?array $runtime): void
    {
        $this->runtime = $runtime;
    }
}
