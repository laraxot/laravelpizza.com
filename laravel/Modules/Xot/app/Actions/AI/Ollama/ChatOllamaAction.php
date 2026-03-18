<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\AI\Ollama;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

use Spatie\QueueableAction\QueueableAction;

class ChatOllamaAction
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
     *     think?: string,
     *     options?: array<string, float|int>
     * } $options
     *
     * @return array{
     *     content: string,
     *     thinking: string|null,
     *     done: bool,
     *     tokens: array{prompt: int, generated: int, total: int},
     *     duration: array{total: int, prompt: int, generation: int}
     * }
     */
    public function execute(string $message, array $options = []): array
    {
        $optionOverrides = $options['options'] ?? [];
        if (! is_array($optionOverrides)) {
            $optionOverrides = [];
        }

        $payload = [
            'model' => $options['model'] ?? config('services.ollama.model', 'qwen2.5'),
            'messages' => [
                ['role' => 'user', 'content' => $message],
            ],
            'options' => array_merge($this->defaultOptions, $optionOverrides),
            'stream' => $options['stream'] ?? false,
        ];

        if (isset($options['think'])) {
            $payload['think'] = $options['think'];
        }

        try {
            $response = $this->client->post('/api/chat', ['json' => $payload]);
            $decoded = json_decode($response->getBody()->getContents(), true);
            $data = $decoded;
            if (! is_array($data)) {
                $data = [];
            }

            $messageData = isset($data['message']) && is_array($data['message']) ? $data['message'] : [];

            return [
                'content' => is_string($messageData['content'] ?? null) ? $messageData['content'] : '',
                'thinking' => is_string($messageData['thinking'] ?? null) ? $messageData['thinking'] : null,
                'done' => (bool) ($data['done'] ?? false),
                'tokens' => [
                    'prompt' => (int) ($data['prompt_eval_count'] ?? 0),
                    'generated' => (int) ($data['eval_count'] ?? 0),
                    'total' => (int) ($data['prompt_eval_count'] ?? 0) + (int) ($data['eval_count'] ?? 0),
                ],
                'duration' => [
                    'total' => (int) ($data['total_duration'] ?? 0),
                    'prompt' => (int) ($data['prompt_eval_duration'] ?? 0),
                    'generation' => (int) ($data['eval_duration'] ?? 0),
                ],
            ];
        } catch (GuzzleException|JsonException $e) {
            Log::error('Ollama Chat API error', ['error' => $e->getMessage()]);
            throw new \RuntimeException('Ollama API error: '.$e->getMessage(), 0, $e);
        }
    }

    public function executeOptimized(string $message): array
    {
        return $this->execute($message, [
            'options' => [
                'num_predict' => 256,
                'temperature' => 0.3,
                'top_k' => 20,
                'top_p' => 0.7,
                'num_ctx' => 1024,
            ],
            'think' => 'low',
        ]);
    }

    public function executeMinimal(string $message): array
    {
        return $this->execute($message, [
            'options' => [
                'num_predict' => 128,
                'temperature' => 0.1,
                'top_k' => 10,
                'top_p' => 0.5,
                'num_ctx' => 512,
            ],
            'think' => 'low',
        ]);
    }
}
