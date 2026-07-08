<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

class ClassifyTicketAction
{
    use QueueableAction;

    public function __construct(
        private readonly string $title,
        private readonly string $description,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function handle(): array
    {
        $cacheKey = 'ai:classification:'.md5($this->title.$this->description);

        $result = Cache::remember($cacheKey, 3600, function (): string {
            $prompt = $this->buildClassificationPrompt();
            return $this->makeAIRequest($prompt, 'classification');
        });

        // Decode JSON string to array
        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($result, true);

        return $decoded;
    }

    private function buildClassificationPrompt(): string
    {
        return "Classifica il seguente ticket per il servizio di gestione ticket cittadini:

Titolo: {$this->title}
Descrizione: {$this->description}

Categorie disponibili:
- infrastruttura (strade, ponti, illuminazione, segnaletica)
- ambiente (rifiuti, inquinamento, verde pubblico)
- trasporti (trasporto pubblico, parcheggi, ciclabili)
- sicurezza (sicurezza urbana, emergenze)
- servizi (uffici pubblici, documenti, pratiche)
- altro

Rispondi in formato JSON con:
{
  \"category\": \"categoria_principale\",
  \"subcategory\": \"sottocategoria\",
  \"confidence\": 0.95,
  \"tags\": [\"tag1\", \"tag2\"],
  \"urgency_indicators\": [\"indicatore1\", \"indicatore2\"]
}";
    }

    private function makeAIRequest(string $prompt, string $type): string
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

                Log::warning('AI API request failed', [
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

            } catch (\Exception $e) {
                Log::error('AI API request error', [
                    'type' => $type,
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
