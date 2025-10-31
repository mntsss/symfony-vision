<?php

declare(strict_types=1);

namespace App\Shared\Util;

trait ArrayUtilTrait
{
    /**
     * @param array<array> $array
     *
     * @return array<array>
     */
    private function sanitizeUniqueArrayValues(array $array): array
    {
        return array_map(
            function (array $values): array {
                $values = array_values(array_unique($values));
                sort($values);

                return $values;
            },
            $array,
        );
    }
}
