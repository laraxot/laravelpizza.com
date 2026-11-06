<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Illuminate\Support\Facades\Http;
use Modules\AI\Actions\GeneratePredictionsAction;
use Modules\AI\Actions\MakeAIRequestAction;
use Modules\AI\Actions\Predict\GeneratePredictionDraftsAction;
use Modules\AI\Tests\Support\FakeTenantAiConfig;
use Modules\AI\Tests\TestCase;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Resources\Chat;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Testing\ClientFake;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

/*
 * I lettori delle impostazioni AI passano da AIConfigData::make() (file del tenant), non da config():
 * qui si pilota il file tenant finto e si guarda cosa parte verso le API.
 */

describe('GeneratePredictionsAction reads the tenant settings', function (): void {
    /**
     * `execute()` non e' percorribile fino in fondo (PredictionData::from() richiama
     * fromOpenAIResponse(), che richiama from(): ricorsione), quindi si legge la configurazione
     * che l'Action costruirebbe per la richiesta.
     *
     * @return array{apiKey: string, model: string, temperature: float, maxTokens: int}
     */
    function resolveCompletionConfig(): array
    {
        $method = new ReflectionMethod(GeneratePredictionsAction::class, 'resolveOpenAiConfig');
        $config = $method->invoke(app(GeneratePredictionsAction::class));
        Assert::assertIsArray($config);

        /** @var array{apiKey: string, model: string, temperature: float, maxTokens: int} $config */
        return $config;
    }

    test('_it_uses_the_defaults_when_the_tenant_file_is_empty', function (): void {
        FakeTenantAiConfig::bind([]);

        $config = resolveCompletionConfig();

        Assert::assertSame('gpt-3.5-turbo-instruct', $config['model']);
        Assert::assertSame(0.7, $config['temperature']);
        Assert::assertSame(1500, $config['maxTokens']);
    });

    test('_it_uses_the_model_temperature_and_max_tokens_saved_for_the_tenant', function (): void {
        FakeTenantAiConfig::bind([
            'model' => 'tenant-instruct',
            'temperature' => 0.2,
            'max_tokens' => 321,
        ]);

        $config = resolveCompletionConfig();

        Assert::assertSame('tenant-instruct', $config['model']);
        Assert::assertSame(0.2, $config['temperature']);
        Assert::assertSame(321, $config['maxTokens']);
    });

    test('_the_api_key_still_comes_from_services_and_never_from_the_tenant_file', function (): void {
        FakeTenantAiConfig::bind(['openai_api_key' => 'sk-in-tenant-file']);
        config(['services.openai.api_key' => 'sk-from-env']);

        Assert::assertSame('sk-from-env', resolveCompletionConfig()['apiKey']);
    });
});

describe('GeneratePredictionDraftsAction reads the tenant settings', function (): void {
    /**
     * @param  array<string, mixed>  $tenant
     */
    function sendDraftsRequest(array $tenant): ClientFake
    {
        FakeTenantAiConfig::bind($tenant);
        config()->set('openai.api_key', 'sk-test');
        $client = OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => ['role' => 'assistant', 'content' => '[]'],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        try {
            app(GeneratePredictionDraftsAction::class)->execute(1);
        } catch (\Throwable) {
            // La risposta finta non produce bozze valide: qui conta solo la richiesta inviata.
        }

        return $client;
    }

    test('_it_sends_the_default_chat_model_and_temperature_when_the_tenant_file_is_empty', function (): void {
        $client = sendDraftsRequest([]);

        $client->assertSent(Chat::class, fn (string $method, array $parameters): bool => $parameters['model'] === 'gpt-4o-mini'
            && $parameters['temperature'] === 0.6);
    });

    test('_it_sends_the_chat_model_and_chat_temperature_saved_for_the_tenant', function (): void {
        $client = sendDraftsRequest(['chat_model' => 'tenant-chat', 'chat_temperature' => 1.1, 'temperature' => 0.1]);

        $client->assertSent(Chat::class, fn (string $method, array $parameters): bool => $parameters['model'] === 'tenant-chat'
            && $parameters['temperature'] === 1.1);
    });
});

describe('MakeAIRequestAction reads the tenant settings', function (): void {
    test('_it_stops_after_the_number_of_attempts_saved_for_the_tenant', function (): void {
        FakeTenantAiConfig::bind(['retry_attempts' => 1]);
        Http::fake(['*' => Http::response('boom', 500)]);

        $message = null;
        try {
            (new MakeAIRequestAction)->execute('prompt', 'classification');
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        Assert::assertSame('AI API request failed after 1 attempts', $message);
        Http::assertSentCount(1);
    });
});
