<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Dto;

final class CourseDto
{
    public function __construct(
        private string $id,
        private ?string $code,
        private ?string $title,
        private ?string $description,
        private ?string $standard,
        private ?string $versionLabel,
        private ?string $entrypointPath,
        private ?string $manifestHash,
        private ?string $metadataJson,
        private ?string $storageBucket,
        private ?string $storageObjectKeyZip,
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getStandard(): ?string
    {
        return $this->standard;
    }

    public function setStandard(?string $standard): void
    {
        $this->standard = $standard;
    }

    public function getVersionLabel(): ?string
    {
        return $this->versionLabel;
    }

    public function setVersionLabel(?string $versionLabel): void
    {
        $this->versionLabel = $versionLabel;
    }

    public function getEntrypointPath(): ?string
    {
        return $this->entrypointPath;
    }

    public function setEntrypointPath(?string $entrypointPath): void
    {
        $this->entrypointPath = $entrypointPath;
    }

    public function getManifestHash(): ?string
    {
        return $this->manifestHash;
    }

    public function setManifestHash(?string $manifestHash): void
    {
        $this->manifestHash = $manifestHash;
    }

    public function getMetadataJson(): ?string
    {
        return $this->metadataJson;
    }

    public function setMetadataJson(?string $metadataJson): void
    {
        $this->metadataJson = $metadataJson;
    }

    public function getStorageBucket(): ?string
    {
        return $this->storageBucket;
    }

    public function setStorageBucket(?string $storageBucket): void
    {
        $this->storageBucket = $storageBucket;
    }

    public function getStorageObjectKeyZip(): ?string
    {
        return $this->storageObjectKeyZip;
    }

    public function setStorageObjectKeyZip(?string $storageObjectKeyZip): void
    {
        $this->storageObjectKeyZip = $storageObjectKeyZip;
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
