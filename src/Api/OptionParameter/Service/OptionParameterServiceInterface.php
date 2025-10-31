<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Service;

interface OptionParameterServiceInterface
{
    /**
     * @param array<string, string> $criteria
     *
     * @return array<string, array<string>>
     */
    public function getParametersValues(array $criteria): array;

    /**
     * @return array
     */
    public function getFullRelationsTree(): array;
}
