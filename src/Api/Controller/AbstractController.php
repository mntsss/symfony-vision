<?php

declare(strict_types=1);

namespace App\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractController extends SymfonyAbstractController
{
    protected function errorResponse(string $details, int $statusCode): JsonResponse
    {
        return $this->json([
            'details' => $details,
            'code' => $statusCode,
        ], $statusCode);
    }
}
