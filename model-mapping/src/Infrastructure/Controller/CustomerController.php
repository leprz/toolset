<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController
{
    #[Route('customer/{id}', methods: ["PUT"])]
    public function create(
        string $id
    ): JsonResponse {
        return new JsonResponse(null, 204);
    }
}
