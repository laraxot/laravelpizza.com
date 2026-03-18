<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\AI\Ollama;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

use Spatie\QueueableAction\QueueableAction;

class GenerateOllamaAction
{
    use QueueableAction;

    private Client $client;

    /** @var array<string, float|int> */
    private array $defaultOptions = [
        'num_predict' => 256,
        'temperature' => 0.3,
        'top_k' => 20,
        'top_p' => 0.7,
        'num_ctx' => 1024,
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.ollama.url', 'http://localhost:11434'),
            'timeout' => 120.0,
        ]);
    }

    /**
     * @param array{
     *     model?: string,
     *     stream?: bool,
     *     options?: array<string, float|int>
     * } $options
     *
     * @return array{
     *     response: string,
     *     done: bool,
     *     tokens: array{prompt: int, generated: int}
     * }
     */
    public function execute(string $prompt, array $options = []): array
    {
        $optionOverrides = $options['options'] ?? [];
        if (! is_array($optionOverrides)) {
            $optionOverrides = [];
        }

        $payload = [
            'model' => $options['model'] ?? config('services.ollama.model', 'qwen2.5'),
            'prompt' => $prompt,
            'options' => array_merge($this->defaultOptions, $optionOverrides),
            'stream' => $options['stream'] ?? false,
        ];

        try {
            $response = $this->client->post('/api/generate', ['json' => $payload]);
            $decoded = json_decode($response->getBody()->getContents(), true);
            $data = $decoded;
            if (! is_array($data)) {
                $data = [];
            }

            return [
                'response' => is_string($data['response'] ?? null) ? $data['response'] : '',
                'done' => (bool) ($data['done'] ?? false),
                'tokens' => [
                    'prompt' => (int) ($data['prompt_eval_count'] ?? 0),
                    'generated' => (int) ($data['eval_count'] ?? 0),
                ],
            ];
        } catch (GuzzleException|JsonException $e) {
            Log::error('Ollama Generate API error', ['error' => $e->getMessage()]);
            throw new \RuntimeException('Ollama API error: '.$e->getMessage(), 0, $e);
        }
    }

    public function executeOptimized(string $prompt): array
    {
        return $this->execute($prompt, [
            'options' => [
                'num_predict' => 256,
                'temperature' => 0.3,
                'top_k' => 20,
                'top_p' => 0.7,
            ],
        ]);
    }

    public function executeMinimal(string $prompt): array
    {
        return $this->execute($prompt, [
            'options' => [
                'num_predict' => 128,
                'temperature' => 0.1,
                'top_k' => 10,
                'top_p' => 0.5,
            ],
        ]);
    }
}
