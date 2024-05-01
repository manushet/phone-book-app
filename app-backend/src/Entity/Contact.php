<?php

declare(strict_types=1);

namespace App\Entity;

class Contact
{
    private string $name;

    private string $phoneNumber;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function __serialize(): array
    {
        return [
            "name" => $this->name,
            "phoneNumber" => $this->phoneNumber,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->setName($data["name"]);

        $this->setPhoneNumber($data["phoneNumber"]);
    }
}