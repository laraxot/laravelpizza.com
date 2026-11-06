<?php

declare(strict_types=1);

/**
 * Action for decoding AI JSON responses safely.
 *
 * Provides a defensive JSON decode wrapper that returns an empty array on failure
 * and ensures string keys for the resulting array.
 */

namespace Modules\AI\Actions;

use Safe;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

/**
 * Safely decode AI JSON responses.
 *
 * Decodes JSON with error handling and ensures string keys for the resulting array.
 * Returns an empty array on invalid JSON or empty input.
 *
 * @example
 * // Decode a JSON response
 * $data = app(\Modules\AI\Actions\AiJsonResponseDecoderAction::class)
 *     ->execute('{"key": "value"}');
 * // Returns: ['key' => 'value']
 *
 * // Returns empty array on invalid JSON
 * $data = AiJsonResponseDecoderAction::decodeObject('invalid');
 * // Returns: []
 */
final class AiJsonResponseDecoderAction
{
    use QueueableAction;

    /**
     * Decode a JSON string into an array with string keys.
     *
     * @param  string  $result  The JSON string to decode
     * @return array<string, mixed> The decoded array or empty array on failure
     */
    public function execute(string $result): array
    {
        return self::decodeObject($result);
    }

    /**
     * Decode a JSON string into an array with string keys.
     *
     * @param  string  $result  The JSON string to decode
     * @return array<string, mixed> The decoded array or empty array on failure
     */
    public static function decodeObject(string $result): array
    {
        $normalized = trim($result);
        if ($normalized === '') {
            return [];
        }

        try {
            $decoded = Safe\json_decode($normalized, true, 512, JSON_THROW_ON_ERROR);

            return is_array($decoded) ? self::stringKeyArray($decoded) : [];
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * Filter array to string keys only.
     *
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
