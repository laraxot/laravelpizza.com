<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

class ArrayService
{
    /**
     * @return array{0: int, 1: int}|false
     */
    public static function rangeIntersect(int $a, int $b, int $c, int $d): array|bool
    {
        $maxStart = max($a, $c);
        $minEnd = min($b, $d);

        if ($maxStart <= $minEnd) {
            return [$maxStart, $minEnd];
        }

        return false;
    }

    public static function diff_assoc_recursive(array $array1, array $array2): array
    {
        $outputDiff = [];
        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                if (is_array($value)) {
                    if (! is_array($array2[$key])) {
                        $outputDiff[$key] = $value;
                    } else {
                        $recursiveDiff = self::diff_assoc_recursive($value, $array2[$key]);
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
