<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use App\Repository\ContactRepositoryInterface;
use Exception;

class ContactRepository implements ContactRepositoryInterface
{
    private const FILE = CONTACT_FILE;

    private function sanitizePhoneNumber(string $phoneNumber): string
    {
        return preg_replace("/[\D]+/", "", $phoneNumber);
    }

    public function findAll(): array
    {
        return json_decode(file_get_contents($this::FILE), true) ?: [];
    }

    public function findOneByPhoneNumber(string $phoneNumber): ?array
    {
        $contacts = $this->findAll();

        return array_filter($contacts, fn ($contact) => $contact["phoneNumber"] === $phoneNumber);
    }

    public function create(Contact $contact): array
    {
        $result = [
            "err" => true,
            "msg" => "Contact phone number {$contact->getPhoneNumber()} has been already created!",
        ];

        $sanitizedPhoneNumber = $this->sanitizePhoneNumber($contact->getPhoneNumber());

        $contactExists = $this->findOneByPhoneNumber($sanitizedPhoneNumber);

        if (!isset($contactExists) || (count($contactExists) === 0)) {
            $contacts = $this->findAll();

            $contacts[] = [
                "name" => $contact->getName(),
                "phoneNumber" => $sanitizedPhoneNumber,
                "originalPhoneNumber" => $contact->getPhoneNumber()
            ];

            try {
                file_put_contents($this::FILE, json_encode(array_values($contacts)));

                $result['err'] = false;
                $result['msg'] = "New contact`s been created successfully!";
            } catch (Exception $e) {
                $result['msg'] = "An error occured while creating a new contact!";
            }
        }

        return $result;
    }

    public function delete(string $phone): array
    {
        $result = [
            "err" => true,
            "msg" => "Contact phone number {$phone} not found!",
        ];

        $sanitizedPhoneNumber = $this->sanitizePhoneNumber($phone);

        $contacts = array_values(array_filter(
            $this->findAll(),
            fn ($contact) => $contact["phoneNumber"] !== $sanitizedPhoneNumber
        ));

        try {
            file_put_contents($this::FILE, json_encode($contacts));

            $result['err'] = false;
            $result['msg'] = "Contact {$phone} has been removed successfully!";
        } catch (Exception $e) {
            $result['msg'] = "An error occured while removing the contact!";
        }


        return $result;
    }
}