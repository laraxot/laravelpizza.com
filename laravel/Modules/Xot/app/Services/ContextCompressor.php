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
        // Quick return if already short
        if (mb_strlen($text) <= $targetChars) {
            return $text;
        }

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
        $sentences = preg_split('/(?<=[.!?])\s+/u', strip_tags($text));
        $out = '';
        foreach ($sentences as $s) {
            if (! is_string($s)) {
                continue;
            }
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
