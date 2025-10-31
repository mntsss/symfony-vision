<?php

declare(strict_types=1);

namespace App\Api\Exception;

use Symfony\Component\HttpFoundation\Response;

class ApiBadRequestException extends ApiRequestException
{
    protected $code = Response::HTTP_BAD_REQUEST;
}
