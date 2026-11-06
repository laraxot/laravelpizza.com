<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\AI\Datas\AIConfigData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Esegue la richiesta HTTP verso l'API OpenAI chat/completions con retry ed exponential backoff.
 *
 * Riproduce in modo identico la logica di `AIService::makeAIRequest()` (log, tentativi,
 * backoff) in forma indipendente e riutilizzabile da ogni azione queueable AI.
 */
final class MakeAIRequestAction
{
    use QueueableAction;

    /**
     * @param  array{title?: string, description?: string, category?: string}  $context  Metadati di log contestuali
     */
    public function execute(string $prompt, string $type, array $context = []): string
    {
        $apiKey = config('ai.openai_api_key') ?: config('services.openai.api_key', '');
        $settings = AIConfigData::make();
        $baseUrl = $settings->openai_base_url;
        $timeout = $settings->timeout;
        $retryAttempts = $settings->retry_attempts;

        Assert::string($apiKey, 'API key must be a string');
        Assert::string($baseUrl, 'Base URL must be a string');
        Assert::integer($timeout, 'Timeout must be an integer');
        Assert::integer($retryAttempts, 'Retry attempts must be an integer');

        $attempt = 0;

        while ($attempt < $retryAttempts) {
            try {
                $response = Http::timeout($timeout)
                    ->withHeaders([
                        'Authorization' => 'Bearer '.$apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post($baseUrl.'/chat/completions', [
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

                if ($response->successful()) {
                    $data = $response->json();
                    Assert::isArray($data, 'API response must be an array');

                    if (isset($data['choices']) && is_array($data['choices']) &&
                        isset($data['choices'][0]) && is_array($data['choices'][0]) &&
                        isset($data['choices'][0]['message']) && is_array($data['choices'][0]['message']) &&
                        isset($data['choices'][0]['message']['content'])) {
                        $content = $data['choices'][0]['message']['content'];
                        Assert::string($content, 'API content must be a string');

                        return $content;
                    }

                    return '';
                }

                Log::warning('AI API request failed', array_merge([
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ], $context));
            } catch (\Exception $e) {
                Log::error('AI API request error', array_merge([
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'error' => $e->getMessage(),
                ], $context));
            }

            $attempt++;
            // Exponential backoff (2, 4, 8, ... secondi)
            if ($attempt < $retryAttempts) {
                sleep((int) pow(2, $attempt));
            }
        }

        throw new \Exception('AI API request failed after '.$retryAttempts.' attempts');
    }
}
