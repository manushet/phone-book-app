<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    private static $file = 'contacts.json';

    public static function findOne(int $id): ?Contact
    {
        $contacts = json_decode(file_get_contents(self::$file), true) ?: [];
        return array_map(function ($contact) {
            return new Contact($contact['name'], $contact['phone']);
        }, $contacts);
    }

    public static function findAll(): ?array
    {
        $contacts = json_decode(file_get_contents(self::$file), true) ?: [];
        return array_map(function ($contact) {
            return new Contact($contact['name'], $contact['phone']);
        }, $contacts);
    }

    public static function create(Contact $contact): Contact
    {
        $contacts = self::all();
        $contacts[] = ['name' => $contact->name, 'phone' => $contact->phone];
        file_put_contents(self::$file, json_encode($contacts));
    }

    public static function delete(int $id): void
    {
        $contacts = self::all();
        unset($contacts[$index]);
        file_put_contents(self::$file, json_encode(array_values($contacts)));
    }
}
