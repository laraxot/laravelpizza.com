<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Support;

use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;

final class OpenAiHttpFake
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function predictionPayload(array $overrides = []): array
    {
        $futureClosedAt = now()->addDays(45)->format('Y-m-d');
        $futureEndsAt = now()->addDays(75)->format('Y-m-d');

        return array_merge([
            'title' => 'Chi vincerà il campionato 2026?',
            'description' => 'Predizione sul vincitore del campionato con criterio di risoluzione ufficiale.',
            'content' => str_repeat('Contenuto editoriale dettagliato. ', 40),
            'excerpt' => 'Anteprima breve della predizione.',
            'category' => 'Sport',
            'tags' => ['sport', 'campionato', '2026'],
            'closed_at' => $futureClosedAt,
            'ends_at' => $futureEndsAt,
            'liquidity_parameter' => 0.5,
            'stocks_count' => 1000,
            'is_wagerable' => true,
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fakeCompletions(array $payload): void
    {
        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    ['text' => json_encode($payload, JSON_THROW_ON_ERROR)],
                ],
                'usage' => ['total_tokens' => 120],
            ]),
        ]);
    }

    public static function fakeOpenAiCompletion(
        string $text,
        int $promptTokens = 5,
        int $completionTokens = 20,
        int $totalTokens = 25,
    ): void {
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'text' => $text,
                        'index' => 0,
                        'logprobs' => null,
                        'finish_reason' => 'stop',
                    ],
                ],
                'usage' => [
                    'prompt_tokens' => $promptTokens,
                    'completion_tokens' => $completionTokens,
                    'total_tokens' => $totalTokens,
                ],
            ]),
        ]);
    }
}
