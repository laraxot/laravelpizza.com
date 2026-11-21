<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatCompletionClient
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $baseUrl,
        private readonly int $timeout,
        private readonly int $retryAttempts,
    ) {}

    public function request(string $prompt, string $type): string
    {
        $attempt = 0;

        while ($attempt < $this->retryAttempts) {
            try {
                $content = $this->attemptChatCompletion($prompt);
                if ($content !== '') {
                    return $content;
                }

                Log::warning('AI API request failed', [
                    'type' => $type,
                    'attempt' => $attempt + 1,
                ]);
            } catch (Exception $exception) {
                Log::error('AI API request error', [
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'error' => $exception->getMessage(),
                ]);
            }

            $attempt++;
            sleep(pow(2, $attempt));
        }

        throw new Exception('AI API request failed after '.$this->retryAttempts.' attempts');
    }

    private function attemptChatCompletion(string $prompt): string
    {
        $response = Http::timeout($this->timeout)
            ->withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl.'/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Sei un assistente AI specializzato nella gestione di ticket per amministrazioni pubbliche italiane. Rispondi sempre in formato JSON valido.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3,
                'max_tokens' => 2000,
            ]);

        if (! $response->successful()) {
            Log::warning('AI API HTTP failure', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return '';
        }

        return $this->extractChatCompletionContent($response->json());
    }

    private function extractChatCompletionContent(mixed $payload): string
    {
        $content = is_array($payload) ? Arr::get($payload, 'choices.0.message.content') : null;

        return is_string($content) ? $content : '';
    }
}
