<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Utilities;

use Spatie\QueueableAction\QueueableAction;

class DiffAssocRecursiveAction
{
    use QueueableAction;

    /**
     * Recursively compute difference of arrays with additional index check.
     *
     * @param  array<int|string, mixed>  $array1
     * @param  array<int|string, mixed>  $array2
     * @return array<int|string, mixed>
     */
    public function execute(array $array1, array $array2): array
    {
        /** @var array<int|string, mixed> $outputDiff */
        $outputDiff = [];
        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                if (is_array($value)) {
                    if (! is_array($array2[$key])) {
                        $outputDiff[$key] = $value;
                    } else {
                        /** @var array<int|string, mixed> $nestedArray2 */
                        $nestedArray2 = $array2[$key];
                        $recursiveDiff = app(self::class)->execute($value, $nestedArray2);
                        if (count($recursiveDiff)) {
                            $outputDiff[$key] = $recursiveDiff;
                        }
                    }
                } else {
                    if ($value !== $array2[$key]) {
                        $outputDiff[$key] = $value;
                    }
                }
            } else {
                $outputDiff[$key] = $value;
            }
        }

        return $outputDiff;
    }
}
