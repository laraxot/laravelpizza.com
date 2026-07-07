<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use OpenAI\OpenAI;

use function Safe\preg_split;

/**
 * ContextCompressor.
 *
 * Lightweight utility to "compress" long text before sending to LLM APIs.
 * - If an OpenAI PHP client is installed and OPENAI_API_KEY set, it will attempt
 *   a model-based compression (best-effort, non-fatal).
 * - Otherwise it falls back to a naive extractive summarization (sentence-based)
 *   to reduce character length under a target.
 *
 * This class is intentionally conservative to avoid hard runtime dependencies.
 */
class ContextCompressor
{
    /**
     * Compress text to approximately targetChars characters.
     *
     * @param int $targetChars approximate target length in characters
     */
    public static function compress(string $text, int $targetChars = 20000): string
    {
<<<<<<< HEAD
        // Quick return if already short
=======
>>>>>>> 40b96bcd6 (.)
        if (mb_strlen($text) <= $targetChars) {
            return $text;
        }

<<<<<<< HEAD
        // Try model-based compression if OpenAI PHP client is available and key set
        try {
            if (class_exists('OpenAI\OpenAI') && getenv('OPENAI_API_KEY')) {
                $apiKey = getenv('OPENAI_API_KEY');
                // Use OpenAI client if installed. This code is defensive: if client API differs,
                // avoid throwing fatal errors and fall back to local compression.
                try {
                    $client = OpenAI::client($apiKey);
                    // Best-effort call: many SDKs expose different methods; attempt Responses API
                    if (is_object($client) && method_exists($client, 'responses')) {
                        $prompt = "Compress the following text preserving key facts and meaning. Target characters: {$targetChars}\n\n".$text;
                        $responsesClient = $client->responses();
                        if (! is_object($responsesClient) || ! method_exists($responsesClient, 'create')) {
                            throw new \RuntimeException('Responses client unavailable');
                        }

                        $response = $responsesClient->create([
                            'model' => 'gpt-4o-mini',
                            'input' => $prompt,
                            'max_output_tokens' => 3200,
                        ]);

                        // Attempt to extract text safely
                        if (is_array($response) && isset($response['output']) && is_array($response['output'])) {
                            // naive extraction
                            foreach ($response['output'] as $o) {
                                if (is_array($o) && isset($o['content']) && is_array($o['content'])) {
                                    foreach ($o['content'] as $c) {
                                        if (is_array($c) && isset($c['text']) && is_string($c['text'])) {
                                            $textOut = (string) $c['text'];
                                            if (mb_strlen($textOut) > 0) {
                                                return mb_substr($textOut, 0, $targetChars);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    // ignore and fallback
                }
            }
        } catch (\Throwable $e) {
            // ignore and fallback
        }

        // Fallback: extractive sentence accumulator
=======
        $compressed = self::tryOpenAiCompression($text, $targetChars);
        if (null !== $compressed) {
            return mb_substr($compressed, 0, $targetChars);
        }

        return self::extractiveFallback($text, $targetChars);
    }

    private static function tryOpenAiCompression(string $text, int $targetChars): ?string
    {
        try {
            $apiKey = getenv('OPENAI_API_KEY');
            if (! class_exists('OpenAI\OpenAI') || ! is_string($apiKey) || '' === $apiKey) {
                return null;
            }

            $client = OpenAI::client($apiKey);
            if (! is_object($client)) {
                return null;
            }

            $clientVars = get_object_vars($client);
            $responses = $clientVars['responses'] ?? null;
            if (! is_object($responses) || ! method_exists($responses, 'create')) {
                return null;
            }

            $prompt = "Compress the following text preserving key facts and meaning. Target characters: {$targetChars}\n\n".$text;
            $response = $responses->create([
                'model' => 'gpt-4o-mini',
                'input' => $prompt,
                'max_output_tokens' => 3200,
            ]);

            return self::extractCompressedText($response);
        } catch (\Throwable) {
            return null;
        }
    }

    private static function extractCompressedText(mixed $response): ?string
    {
        if (! is_array($response) || ! isset($response['output']) || ! is_array($response['output'])) {
            return null;
        }

        foreach ($response['output'] as $outputItem) {
            if (! is_array($outputItem) || ! isset($outputItem['content']) || ! is_array($outputItem['content'])) {
                continue;
            }

            foreach ($outputItem['content'] as $contentItem) {
                if (is_array($contentItem) && isset($contentItem['text']) && is_string($contentItem['text'])) {
                    $textOut = trim($contentItem['text']);
                    if ('' !== $textOut) {
                        return $textOut;
                    }
                }
            }
        }

        return null;
    }

    private static function extractiveFallback(string $text, int $targetChars): string
    {
>>>>>>> 40b96bcd6 (.)
        $sentences = preg_split('/(?<=[.!?])\s+/u', strip_tags($text));
        $out = '';
        foreach ($sentences as $s) {
            if (! is_string($s)) {
                continue;
            }
<<<<<<< HEAD
=======

>>>>>>> 40b96bcd6 (.)
            $s = trim($s);
            if ('' === $s) {
                continue;
            }
            if (mb_strlen($out.' '.$s) > $targetChars) {
                break;
            }
            $out = '' === $out ? $s : ($out.' '.$s);
        }

        if (0 === mb_strlen($out)) {
            return mb_substr($text, 0, $targetChars);
        }

        return $out;
    }
}
