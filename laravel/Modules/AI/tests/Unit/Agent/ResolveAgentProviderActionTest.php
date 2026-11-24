<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Agent;

use Modules\AI\Actions\Agent\ResolveAgentProviderAction;
use Modules\AI\Exceptions\AiRequestException;
use Modules\AI\Tests\Support\FakeTenantAiConfig;
use Modules\AI\Tests\TestCase;
use NeuronAI\Providers\OpenAILike;
use ReflectionProperty;

uses(TestCase::class);

beforeEach(function (): void {
    FakeTenantAiConfig::bind([]);
    config(['services.groq.key' => null, 'services.openrouter.key' => null]);
});

function providerBaseUri(OpenAILike $provider): string
{
    return (string) (new ReflectionProperty(OpenAILike::class, 'baseUri'))->getValue($provider);
}

it('sceglie Groq quando ha la chiave', function (): void {
    config(['services.groq.key' => 'gsk-test', 'services.openrouter.key' => 'sk-or-test']);

    $provider = app(ResolveAgentProviderAction::class)->execute();

    expect($provider)->toBeInstanceOf(OpenAILike::class)
        ->and(providerBaseUri($provider))->toContain('groq.com');
});

it('passa a OpenRouter se manca la chiave Groq', function (): void {
    config(['services.openrouter.key' => 'sk-or-test']);

    $provider = app(ResolveAgentProviderAction::class)->execute();

    expect($provider)->toBeInstanceOf(OpenAILike::class)
        ->and(providerBaseUri($provider))->toContain('openrouter.ai');
});

it('senza chiavi segnala la configurazione mancante', function (): void {
    app(ResolveAgentProviderAction::class)->execute();
})->throws(AiRequestException::class, 'GROQ_API_KEY');
