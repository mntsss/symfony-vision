<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Service\RelationTree;

use App\Api\OptionParameter\Entity\OptionValue;
use App\Api\OptionParameter\Repository\OptionValueRelationRepository;
use App\Api\OptionParameter\Repository\OptionValueRepository;

readonly class RelationTreeBuilder
{
    public function __construct(
        private OptionValueRepository $optionValueRepository,
        private OptionValueRelationRepository $optionValueRelationRepository,
    )
    {
    }

    /**
     * @return array
     */
    public function buildRelationsTree(): array
    {
        $optionValues = $this->optionValueRepository->findAllWithParameters();
        $nodes = $this->mapOptionValuesByToNodes($optionValues);
        $optionValueRelations = $this->optionValueRelationRepository->findAll();

        $processedChildrenIds = [];
        foreach ($optionValueRelations as $optionValueRelation) {
            $processedChildrenIds[] = $childId = $optionValueRelation->getChildId();
            $parentId = $optionValueRelation->getParentId();

            if (isset($nodes[$parentId]) && isset($nodes[$childId])) {
                $nodes[$parentId]['children'][] = &$nodes[$childId];
            }
        }

        return $this->propagateTreeParents($processedChildrenIds, $nodes);
    }

    /**
     * @param array<OptionValue> $optionValues
     *
     * @return array<int, OptionValue>
     */
    private function mapOptionValuesByToNodes(array $optionValues): array
    {
        $nodes = [];
        foreach ($optionValues as $optionValue) {
            $nodes[$optionValue->getIdOptionValue()] = [
                'data' => [
                    'id' => $optionValue->getIdOptionValue(),
                    'parameter_name' => $optionValue->getParameter()->getName(),
                    'value' => $optionValue->getValue(),
                ],
                'children' => [],
            ];
        }

        return $nodes;
    }

    /**
     * @param array<int> $processedChildrenIds
     * @param array $nodes
     *
     * @return array
     */
    private function propagateTreeParents(array $processedChildrenIds, array $nodes): array
    {
        $tree = [];
        foreach ($nodes as $id => $node) {
            if (!in_array($id, $processedChildrenIds, true)) {
                $tree[] = $node;
            }
        }

        return $tree;
    }
}
