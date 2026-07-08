<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class MakeAIRequestAction
{
    use QueueableAction;

    public function __construct(
        private readonly string $prompt,
        private readonly string $type,
    ) {}

    public function handle(): string
    {
        $apiKey = config('ai.openai_api_key', '');
        $baseUrl = config('ai.openai_base_url', 'https://api.openai.com/v1');
        $timeout = config('ai.timeout', 30);
        $retryAttempts = config('ai.retry_attempts', 3);

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
                                'content' => $this->prompt,
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

                Log::warning('AI API request failed', [
                    'type' => $this->type,
                    'attempt' => $attempt + 1,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

            } catch (\Exception $e) {
                Log::error('AI API request error', [
                    'type' => $this->type,
                    'attempt' => $attempt + 1,
                    'error' => $e->getMessage(),
                ]);
            }

            $attempt++;
            sleep(pow(2, $attempt));
        }

        throw new \Exception('AI API request failed after '.$retryAttempts.' attempts');
    }
}
