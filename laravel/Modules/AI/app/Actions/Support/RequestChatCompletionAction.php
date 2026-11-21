<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Support;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

final class RequestChatCompletionAction
{
    use QueueableAction;

    public function execute(string $prompt, string $type): string
    {
        $apiKey = $this->configString('ai.openai_api_key', 'services.openai.api_key', '');
        $baseUrl = $this->configString('ai.openai_base_url', 'services.openai.base_url', 'https://api.openai.com/v1');
        $timeout = $this->configInt('ai.timeout', 'services.openai.timeout', 30);
        $retryAttempts = $this->configInt('ai.retry_attempts', 'services.openai.retry_attempts', 3);
        $attempt = 0;

        while ($attempt < $retryAttempts) {
            try {
                $content = $this->attemptChatCompletion($prompt, $apiKey, $baseUrl, $timeout);
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
            sleep(2 ** $attempt);
        }

        throw new Exception('AI API request failed after '.$retryAttempts.' attempts');
    }

    private function attemptChatCompletion(string $prompt, string $apiKey, string $baseUrl, int $timeout): string
    {
        $response = Http::timeout($timeout)
            ->withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($baseUrl.'/chat/completions', [
                'model' => $this->configString('ai.chat_model', 'services.openai.chat_model', 'gpt-4o-mini'),
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

        $json = $response->json();

        return $this->extractChatCompletionContent(\is_array($json) ? $json : null);
    }

    /**
     * @param  array<array-key, mixed>|null  $payload
     */
    private function extractChatCompletionContent(?array $payload): string
    {
        $content = $payload !== null ? Arr::get($payload, 'choices.0.message.content') : null;

        return is_string($content) ? $content : '';
    }

    private function configString(string $primaryKey, string $fallbackKey, string $default): string
    {
        $value = config($primaryKey, config($fallbackKey, $default));

        return is_string($value) ? $value : $default;
    }

    private function configInt(string $primaryKey, string $fallbackKey, int $default): int
    {
        $value = config($primaryKey, config($fallbackKey, $default));

        return is_numeric($value) ? (int) $value : $default;
    }
}
