<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions;

/**
 * Action for performing recursive array_diff_assoc operations.
 * Used for comparing configuration arrays and data structures.
 */
class DiffAssocRecursiveAction
{
    /**
     * Execute recursive array_diff_assoc operation.
     *
     * @param  array<array-key, mixed>  $array1
     * @param  array<array-key, mixed>  $array2
     * @return array<array-key, mixed>
     */
    public function execute(array $array1, array $array2): array
    {
        return $this->arrayDiffAssocRecursive($array1, $array2);
    }

    /**
     * Recursive array_diff_assoc implementation.
     *
     * @param  array<array-key, mixed>  $array1
     * @param  array<array-key, mixed>  $array2
     * @return array<array-key, mixed>
     */
    private function arrayDiffAssocRecursive(array $array1, array $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (! isset($array2[$key]) || ! is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    /** @var array<array-key, mixed> $value */
                    /** @var array<array-key, mixed> $array2Value */
                    $array2Value = $array2[$key];
                    $newDiff = $this->arrayDiffAssocRecursive($value, $array2Value);
                    if (! empty($newDiff)) {
                        $difference[$key] = $newDiff;
                    }
                }
            } elseif (! array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }
}
