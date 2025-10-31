<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Service\Reader;

use App\Api\Exception\ApiBadRequestException;
use App\Api\OptionParameter\Entity\OptionParameter;
use App\Api\OptionParameter\Repository\OptionValueRepository;

readonly class OptionParameterReader
{
    public function __construct(
        private OptionValueRepository $optionValueRepository,
    )
    {
    }

    /**
     * @return array<OptionParameter>
     */
    public function findAllWithParameters(): array
    {
        return $this->optionValueRepository->findAllWithParameters();
    }

    /**
     * @param array<string, string> $criteria
     *
     * @return array<int>
     */
    public function findOptionValueIdsByParameterNames(array $criteria): array
    {
        if (!$criteria) {
            return [];
        }

        $optionValueIds = $this->optionValueRepository->findOptionValueIdsByParameterNames($criteria);
        if (count($optionValueIds) === count($criteria)) {
            return $optionValueIds;
        }

        throw new ApiBadRequestException('Invalid request parameters');
    }
}
