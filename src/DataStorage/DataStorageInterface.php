<?php

declare(strict_types=1);

namespace  Src\DataStorage;

interface DataStorageInterface
{
    public function fetchAll(): array;

    public function fetchOne(int $index): array;

    public function create(array $data): void;

    public function delete(int $index): void;
}
