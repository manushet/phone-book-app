<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\Request\Request;
use App\Http\Response\JsonResponse;
use App\Controller\AbstractController;

class ContactController implements AbstractController
{
    public function viewAll(Request $request): JsonResponse
    {
        $response = new JsonResponse('view all contacts response');

        return $response;
    }
}