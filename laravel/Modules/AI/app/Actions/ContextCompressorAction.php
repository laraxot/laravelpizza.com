<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_split;

/**
 * ContextCompressorAction.
 *
 * Lightweight utility to "compress" long text before sending to LLM APIs.
 */
class ContextCompressorAction
{
    use QueueableAction;

    /**
     * Compress text to approximately targetChars characters.
     *
     * @param  int  $targetChars  approximate target length in characters
     */
    public static function compress(string $text, int $targetChars = 20000): string
    {
        if (mb_strlen($text) <= $targetChars) {
            return $text;
        }

        $compressed = self::tryOpenAiCompression($text, $targetChars);
        if ($compressed !== null) {
            return mb_substr($compressed, 0, $targetChars);
        }

        return self::extractiveFallback($text, $targetChars);
    }

    private static function tryOpenAiCompression(string $text, int $targetChars): ?string
    {
        try {
            $apiKey = getenv('OPENAI_API_KEY');
            if (! class_exists(\OpenAI::class) || ! is_string($apiKey) || $apiKey === '') {
                return null;
            }

            $prompt = "Compress the following text preserving key facts and meaning. Target characters: {$targetChars}\n\n".$text;
            $response = \OpenAI::client($apiKey)->responses()->create([
                'model' => 'gpt-4o-mini',
                'input' => $prompt,
                'max_output_tokens' => 3200,
            ]);

            $compressed = trim($response->outputText ?? '');

            return $compressed === '' ? null : $compressed;
        } catch (\Throwable) {
            return null;
        }
    }

    private static function extractiveFallback(string $text, int $targetChars): string
    {
        $sentences = preg_split('/(?<=[.!?])\s+/u', strip_tags($text));
        $out = '';
        foreach ($sentences as $s) {
            if (! is_string($s)) {
                continue;
            }

            $s = trim($s);
            if ($s === '') {
                continue;
            }
            if (mb_strlen($out.' '.$s) > $targetChars) {
                break;
            }
            $out = $out === '' ? $s : ($out.' '.$s);
        }

        if (mb_strlen($out) === 0) {
            return mb_substr($text, 0, $targetChars);
        }

        return $out;
    }

    public function execute(): void {}
}
