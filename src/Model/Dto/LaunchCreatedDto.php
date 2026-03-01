<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class LaunchCreatedDto
{
    public function __construct(
        private string $launchId,
        private string $attemptId,
        private ?string $standard,
        private string $launchUrl,
        private string $launchToken,
        private ?string $expiresAt
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

    public function getStandard(): ?string
    {
        return $this->standard;
    }

    public function setStandard(?string $standard): void
    {
        $this->standard = $standard;
    }

    public function getLaunchUrl(): string
    {
        return $this->launchUrl;
    }

    public function setLaunchUrl(string $launchUrl): void
    {
        $this->launchUrl = $launchUrl;
    }

    public function getLaunchToken(): string
    {
        return $this->launchToken;
    }

    public function setLaunchToken(string $launchToken): void
    {
        $this->launchToken = $launchToken;
    }

    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }
}
