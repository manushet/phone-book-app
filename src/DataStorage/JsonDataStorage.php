<?php

declare(strict_types=1);

namespace Src\DataStorage;

use Src\DataStorage\DataStorageInterface;

class JsonDataStorage implements DataStorageInterface
{
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function fetchAll(): array
    {
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    public function fetchOne(int $index): array
    {
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    public function create(array $data): void
    {
        $contacts = $this->fetchAll();
        $contacts[] = $data;
        file_put_contents($this->file, json_encode($contacts));
    }

    public function delete(int $index): void
    {
        $contacts = $this->fetchAll();
        unset($contacts[$index]);
        file_put_contents($this->file, json_encode(array_values($contacts)));
    }
}
