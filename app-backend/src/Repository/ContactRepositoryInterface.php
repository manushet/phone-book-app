<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use App\Repository\RepositoryInterface;

interface ContactRepositoryInterface extends RepositoryInterface
{
    public function findAll(): ?array;

    public function findOneByPhoneNumber(string $phone): ?array;

    public function create(Contact $contact): array;

    public function delete(string $phone): array;
}