<?php

declare(strict_types=1);

namespace Modules\AI\Services;

final class AIServiceJsonDecoder
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
            $decoded = \Safe\json_decode($normalized, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                return [];
            }

            $output = [];
            foreach ($decoded as $key => $value) {
                if (! is_string($key)) {
                    continue;
                }

                $output[$key] = $value;
            }

            return $output;
        } catch (\Throwable) {
            return [];
        }
    }
}
