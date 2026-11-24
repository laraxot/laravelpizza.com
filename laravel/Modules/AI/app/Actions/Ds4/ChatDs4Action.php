<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Ds4;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use RuntimeException;
use Safe\Exceptions\JsonException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;

class ChatDs4Action
{
    use QueueableAction;

    private Client $client;

    /** @var array<string, float|int> */
    private array $defaultOptions = [
        'max_tokens' => 256,
        'temperature' => 0.3,
        'top_p' => 0.7,
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Config::string('services.ds4.url', 'http://127.0.0.1:8000'),
            'headers' => [
                'Authorization' => 'Bearer '.Config::string('services.ds4.token', 'dsv4-local'),
                'Content-Type' => 'application/json',
            ],
            'timeout' => 120.0,
        ]);
    }

    /**
     * @param array{
     *     model?: string,
     *     stream?: bool,
     *     options?: array<string, float|int>
     * } $options
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

        $model = $options['model'] ?? config('services.ds4.model', 'deepseek-v4-flash');

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens' => $optionOverrides['max_tokens'] ?? $this->defaultOptions['max_tokens'],
            'temperature' => $optionOverrides['temperature'] ?? $this->defaultOptions['temperature'],
            'top_p' => $optionOverrides['top_p'] ?? $this->defaultOptions['top_p'],
            'stream' => $options['stream'] ?? false,
        ];

        try {
            $response = $this->client->post('/v1/chat/completions', ['json' => $payload]);
            $decoded = json_decode($response->getBody()->getContents(), true);
            $data = $decoded;
            if (! is_array($data)) {
                $data = [];
            }

            $choices = $data['choices'] ?? null;
            $firstChoice = is_array($choices) && is_array($choices[0] ?? null) ? $choices[0] : [];
            $messageData = is_array($firstChoice['message'] ?? null) ? $firstChoice['message'] : [];
            $usage = is_array($data['usage'] ?? null) ? $data['usage'] : [];

            return [
                'content' => is_string($messageData['content'] ?? null) ? $messageData['content'] : '',
                'thinking' => is_string($messageData['reasoning_content'] ?? null) ? $messageData['reasoning_content'] : null,
                'done' => true,
                'tokens' => [
                    'prompt' => SafeIntCastAction::cast($usage['prompt_tokens'] ?? 0),
                    'generated' => SafeIntCastAction::cast($usage['completion_tokens'] ?? 0),
                    'total' => SafeIntCastAction::cast($usage['total_tokens'] ?? 0),
                ],
                'duration' => [
                    'total' => 0,
                    'prompt' => 0,
                    'generation' => 0,
                ],
            ];
        } catch (GuzzleException|JsonException $e) {
            Log::error('ds4 Chat API error', ['error' => $e->getMessage()]);
            throw new RuntimeException('ds4 API error: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * @return array{
     *     content: string,
     *     thinking: string|null,
     *     done: bool,
     *     tokens: array{prompt: int, generated: int, total: int},
     *     duration: array{total: int, prompt: int, generation: int}
     * }
     */
    public function executeOptimized(string $message): array
    {
        return $this->execute($message, [
            'options' => [
                'max_tokens' => 256,
                'temperature' => 0.3,
                'top_p' => 0.7,
            ],
        ]);
    }

    /**
     * @return array{
     *     content: string,
     *     thinking: string|null,
     *     done: bool,
     *     tokens: array{prompt: int, generated: int, total: int},
     *     duration: array{total: int, prompt: int, generation: int}
     * }
     */
    public function executeMinimal(string $message): array
    {
        return $this->execute($message, [
            'options' => [
                'max_tokens' => 128,
                'temperature' => 0.1,
                'top_p' => 0.5,
            ],
        ]);
    }
}
