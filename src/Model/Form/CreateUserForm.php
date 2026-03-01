<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Form;

use ScormEngineSdk\Constants\FieldKey;

final class CreateUserForm
{
    public function __construct(
        private ?string $externalRef,
        private string $username,
        private string $email,
        private ?string $firstName,
        private ?string $lastName,
        private ?string $locale
    ) {
    }

    public function getExternalRef(): ?string
    {
        return $this->externalRef;
    }

    public function setExternalRef(?string $externalRef): void
    {
        $this->externalRef = $externalRef;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            FieldKey::EXTERNAL_REF => $this->getExternalRef(),
            FieldKey::USERNAME => $this->getUsername(),
            FieldKey::EMAIL => $this->getEmail(),
            FieldKey::FIRST_NAME => $this->getFirstName(),
            FieldKey::LAST_NAME => $this->getLastName(),
            FieldKey::LOCALE => $this->getLocale(),
        ];
    }
}
