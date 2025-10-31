<?php

declare(strict_types=1);

namespace App\Api\OptionParameter\Service\RelationTree;

use App\Shared\Util\ArrayUtilTrait;

class RelationTreeFilter
{
    use ArrayUtilTrait;

    /**
     * @param array<int, array> $relationTree
     * @param array<int> $selectedIds
     *
     * @return array<string, array<string>>
     */
    public function findRelationsTreeValidParameterValues(array $relationTree, array $selectedIds): array
    {
        $parameterValueMap = [];
        foreach ($relationTree as $node) {
            $paths = [];
            $this->getAllNodePaths($node, $paths);

            foreach ($paths as $path) {
                if ($this->pathContainsAllIds($path, $selectedIds)) {
                    $parameterValueMap = $this->collectValidPathsParameterValues($path, $parameterValueMap);
                }
            }
        }

        return $this->sanitizeUniqueArrayValues($parameterValueMap);
    }

    private function collectValidPathsParameterValues(array $pathNodes, array $parameterValueMap): array
    {
        foreach ($pathNodes as $node) {
            $parameterValueMap[$node['parameter_name']][] = $node['value'];
        }

        return $parameterValueMap;
    }

    /**
     * @param array $node
     * @param array $paths
     * @param array $currentPath
     *
     * @return void
     */
    private function getAllNodePaths(array $node, array &$paths, array $currentPath = []): void
    {
        $currentPath[] = &$node['data'];

        if (empty($node['children'])) {
            $paths[] = $currentPath;

            return;
        }

        foreach ($node['children'] as $child) {
            $this->getAllNodePaths($child, $paths, $currentPath);
        }
    }

    /**
     * @param array<array<string, mixed>> $path
     * @param array<int> $selectedIds
     *
     * @return bool
     */
    private function pathContainsAllIds(array $path, array $selectedIds): bool
    {
        if (!$selectedIds) {
            return true;
        }
        $pathIds = array_column($path, 'id');
        foreach ($selectedIds as $id) {
            if (!in_array($id, $pathIds, true)) {
                return false;
            }
        }
        return true;
    }
}
