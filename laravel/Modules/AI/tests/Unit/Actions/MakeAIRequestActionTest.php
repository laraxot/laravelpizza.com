<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Modules\AI\Actions\ClassifyTicketAction;
use Modules\AI\Actions\MakeAIRequestAction;
use Modules\AI\Actions\SuggestSolutionsAction;
use Modules\AI\Tests\Support\FakeTenantAiConfig;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function fakeChatCompletion(string $content): void
{
    Http::fake(['*' => Http::response(['choices' => [['message' => ['content' => $content]]]])]);
}

describe('MakeAIRequestAction config', function (): void {
    test('_authenticates_with_services_openai_api_key_when_ai_key_is_missing', function (): void {
        config(['services.openai.api_key' => 'sk-from-services', 'ai.openai_api_key' => null]);
        fakeChatCompletion('{"ok":true}');

        $content = (new MakeAIRequestAction)->execute('prompt', 'classification');

        Assert::assertSame('{"ok":true}', $content);
        Http::assertSent(fn (Request $request): bool => $request->hasHeader('Authorization', 'Bearer sk-from-services')
            && $request->url() === 'https://api.openai.com/v1/chat/completions');
    });

    test('_keeps_gpt_4_with_temperature_0_3_and_2000_tokens_when_no_setting_is_saved', function (): void {
        config(['services.openai.api_key' => 'sk-from-services', 'ai.openai_api_key' => null]);
        FakeTenantAiConfig::bind([]);
        fakeChatCompletion('{}');

        (new MakeAIRequestAction)->execute('prompt', 'classification');

        Http::assertSent(fn (Request $request): bool => $request['model'] === 'gpt-4'
            && $request['temperature'] === 0.3
            && $request['max_tokens'] === 2000);
    });

    test('_ai_keys_override_services_openai_keys', function (): void {
        config([
            'services.openai.api_key' => 'sk-from-services',
            'ai.openai_api_key' => 'sk-from-ai',
        ]);
        FakeTenantAiConfig::bind(['openai_base_url' => 'https://llm.example.test/v1']);
        fakeChatCompletion('{}');

        (new MakeAIRequestAction)->execute('prompt', 'classification');

        Http::assertSent(fn (Request $request): bool => $request->hasHeader('Authorization', 'Bearer sk-from-ai')
            && $request->url() === 'https://llm.example.test/v1/chat/completions');
    });
});

describe('Ticket AI actions', function (): void {
    test('_classify_sends_the_classification_prompt_and_decodes_the_json_answer', function (): void {
        config(['cache.default' => 'array']);
        Cache::flush();
        fakeChatCompletion('{"category":"ambiente","confidence":0.9}');

        $result = app(ClassifyTicketAction::class)->execute('Rifiuti abbandonati', 'Via Roma 1');

        Assert::assertSame('ambiente', $result['category']);
        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            if (! is_array($payload)) {
                return false;
            }

            $messages = $payload['messages'] ?? null;
            if (! is_array($messages)) {
                return false;
            }

            $message = $messages[1] ?? null;
            if (! is_array($message)) {
                return false;
            }

            $prompt = $message['content'] ?? null;
            if (! is_string($prompt)) {
                return false;
            }

            return str_contains($prompt, 'Classifica il seguente ticket')
                && str_contains($prompt, 'Titolo: Rifiuti abbandonati')
                && str_contains($prompt, 'Descrizione: Via Roma 1');
        });
    });

    test('_suggest_sends_the_solutions_prompt_with_the_category', function (): void {
        config(['cache.default' => 'array']);
        Cache::flush();
        fakeChatCompletion('{"solutions":[]}');

        $result = app(SuggestSolutionsAction::class)->execute('Buca', 'Via Po', 'infrastruttura');

        Assert::assertSame([], $result['solutions']);
        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            if (! is_array($payload)) {
                return false;
            }

            $messages = $payload['messages'] ?? null;
            if (! is_array($messages)) {
                return false;
            }

            $message = $messages[1] ?? null;
            if (! is_array($message)) {
                return false;
            }

            $prompt = $message['content'] ?? null;
            if (! is_string($prompt)) {
                return false;
            }

            return str_contains($prompt, 'Suggerisci soluzioni per questo ticket di infrastruttura')
                && str_contains($prompt, 'Titolo: Buca');
        });
    });
});
