<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Controller;

use App\Api\Controller\AbstractController;
use App\Api\Exception\ApiRequestException;
use App\Api\OptionParameter\Service\OptionParameterServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class OptionParameterController extends AbstractController
{
    private const string PARAM = 'param';

    public function __construct(
        private readonly OptionParameterServiceInterface $optionParameterService,
    )
    {
    }

    #[Route('/api/option/parameter', name: 'app_option_parameter', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $params = $request->get(self::PARAM, []);

        try {
            $parameterValues = $this->optionParameterService->getParametersValues($params);
        } catch (ApiRequestException $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return $this->json($parameterValues);
    }

    #[Route('/api/option/parameter/debug', name: 'app_option_parameter_debug', methods: ['GET'])]
    public function debug(): JsonResponse
    {
        return $this->json($this->optionParameterService->getFullRelationsTree());
    }
}
