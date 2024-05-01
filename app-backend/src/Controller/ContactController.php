<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Http\Request\Request;
use App\Http\Response\JsonResponse;
use App\Controller\AbstractController;
use App\Exceptions\BadRequestException;
use App\Repository\ContactRepositoryInterface;

class ContactController extends AbstractController
{
    public function __construct(private ContactRepositoryInterface $repository)
    {
    }

    public function index(): JsonResponse
    {
        $contacts = $this->repository->findAll();

        $response = new JsonResponse($contacts);

        return $response;
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->getBody();

        if (!isset($data)) {
            throw new BadRequestException();
        }

        $newContact = new Contact();
        $newContact->setName($data["name"]);
        $newContact->setPhoneNumber($data["phoneNumber"]);

        return new JsonResponse($this->repository->create($newContact));
    }

    public function delete(Request $request): JsonResponse
    {
        $data = $request->getBody();

        if (!isset($data)) {
            throw new BadRequestException();
        }

        return new JsonResponse($this->repository->delete($data["phoneNumber"]));
    }
}