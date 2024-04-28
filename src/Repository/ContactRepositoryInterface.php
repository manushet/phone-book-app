<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use App\Repository\RepositoryInterface;

interface ContactRepositoryInterface extends RepositoryInterface
{
    public static function findOne(int $id): ?Contact;

    public static function findAll(): ?array;

    public static function create(Contact $contact): Contact;

    public static function delete(int $id): void;
}
