<?php

declare(strict_types=1);

namespace Modules\AI\Support;

use Throwable;

use function Safe\json_decode;

class AiJsonResponseDecoder
{
    /**
     * @return array<string, mixed>
     */
    public static function decodeObject(string $result): array
    {
        $normalized = trim($result);
        if ($normalized === '') {
            return [];
        }

        try {
            $decoded = json_decode($normalized, true, 512, JSON_THROW_ON_ERROR);

            return is_array($decoded) ? self::stringKeyArray($decoded) : [];
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @param  array<mixed, mixed>  $decoded
     * @return array<string, mixed>
     */
    private static function stringKeyArray(array $decoded): array
    {
        $output = [];
        foreach ($decoded as $key => $value) {
            if (is_string($key)) {
                $output[$key] = $value;
            }
        }

        return $output;
    }
}
