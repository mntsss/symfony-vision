<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Service;

use App\Api\OptionParameter\Service\Reader\OptionParameterReader;
use App\Api\OptionParameter\Service\RelationTree\RelationTreeBuilder;
use App\Api\OptionParameter\Service\RelationTree\RelationTreeFilter;

readonly class OptionParameterService implements OptionParameterServiceInterface
{
    public function __construct(
        private OptionParameterReader $optionParameterReader,
        private RelationTreeBuilder $relationTreeBuilder,
        private RelationTreeFilter $relationTreeFilter,
    )
    {
    }

    /**
     * @param array<string, string> $criteria
     *
     * @return array<string, array<string>>
     */
    public function getParametersValues(array $criteria): array
    {
        $idOptionValues = $this->optionParameterReader->findOptionValueIdsByParameterNames($criteria);
        $optionValueRelationTree = $this->getFullRelationsTree();

        return $this->relationTreeFilter->findRelationsTreeValidParameterValues($optionValueRelationTree, $idOptionValues);
    }

    /**
     * @return array
     */
    public function getFullRelationsTree(): array
    {
        return $this->relationTreeBuilder->buildRelationsTree();
    }
}
