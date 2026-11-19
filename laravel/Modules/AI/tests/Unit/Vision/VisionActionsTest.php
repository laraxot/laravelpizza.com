<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Modules\AI\Actions\Vision\EditImageAction;
use Modules\AI\Actions\Vision\ExtractStructuredDataFromImagesAction;
use Modules\AI\Datas\AIConfigData;
use Modules\AI\Enums\AiProviderEnum;
use Modules\AI\Exceptions\AiRequestException;
use Modules\AI\Tests\Support\FakeTenantAiConfig;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\base64_decode;
use function Safe\file_put_contents;
use function Safe\tempnam;

uses(TestCase::class);

/** PNG 1x1 valido, scritto in un file temporaneo. */
function tinyPng(): string
{
    $path = tempnam(sys_get_temp_dir(), 'ai-img').'.png';
    file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

    return $path;
}

beforeEach(function (): void {
    config(['services.openrouter.key' => 'test-key', 'services.groq.key' => 'groq-key', 'app.name' => 'Test']);
    FakeTenantAiConfig::bind([
        'vision_providers' => ['openrouter', 'groq'],
        'vision_models' => ['openrouter' => 'vendor/vision-model', 'groq' => 'qwen/qwen3.8-27b'],
        'image_model' => 'vendor/image-model',
        'free_models_only' => false,
    ]);
});

it('sends text first, images as data URIs and a strict json schema, and returns the decoded object', function (): void {
    Http::fake(['openrouter.ai/api/v1/chat/completions' => Http::response([
        'choices' => [['message' => ['content' => '```json'."\n".'{"items":[{"name":"Tiramisù","price":6.5}]}'."\n".'```']]],
    ])]);

    $result = app(ExtractStructuredDataFromImagesAction::class)->execute(
        [tinyPng()],
        'Leggi le voci.',
        'items',
        ['type' => 'object', 'properties' => ['items' => ['type' => 'array']], 'required' => ['items'], 'additionalProperties' => false],
    );

    Assert::assertSame(['items' => [['name' => 'Tiramisù', 'price' => 6.5]]], $result);

    Http::assertSent(function (Request $request): bool {
        $data = $request->data();

        $messages = $data['messages'] ?? null;
        $secondMessage = is_array($messages) ? ($messages[1] ?? null) : null;
        $secondMessage = is_array($secondMessage) ? $secondMessage : [];
        $contentParts = $secondMessage['content'] ?? null;
        $contentParts = is_array($contentParts) ? array_values($contentParts) : [];

        $textPart = $contentParts[0] ?? null;
        $imagePart = $contentParts[1] ?? null;
        $imageUrl = null;
        if (is_array($imagePart) && is_array($imagePart['image_url'] ?? null)) {
            $imageUrl = $imagePart['image_url']['url'] ?? null;
        }

        $responseFormat = $data['response_format'] ?? null;
        $responseFormat = is_array($responseFormat) ? $responseFormat : [];
        $jsonSchema = $responseFormat['json_schema'] ?? null;
        $jsonSchema = is_array($jsonSchema) ? $jsonSchema : [];
        $provider = $data['provider'] ?? null;
        $provider = is_array($provider) ? $provider : [];

        return $request->hasHeader('Authorization', 'Bearer test-key')
            && ($data['model'] ?? null) === 'vendor/vision-model'
            && $textPart === ['type' => 'text', 'text' => 'Leggi le voci.']
            && is_string($imageUrl)
            && str_starts_with($imageUrl, 'data:image/png;base64,')
            && ($jsonSchema['strict'] ?? null) === true
            && ($provider['require_parameters'] ?? null) === true;
    });
});

it('fails clearly without any API key, without calling the providers', function (): void {
    config(['services.openrouter.key' => null, 'services.groq.key' => '']);
    Http::fake();

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('OPENROUTER_API_KEY', $e->getMessage());
    }

    Http::assertNothingSent();
});

it('turns an HTTP error into an AiRequestException with the provider message', function (): void {
    config(['services.groq.key' => null]);
    Http::fake(['*' => Http::response(['error' => ['message' => 'No endpoints found']], 404)]);

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('No endpoints found', $e->getMessage());
    }
});

it('rejects non-image files before any request', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'ai-txt');
    file_put_contents($path, 'solo testo');
    Http::fake();

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute([$path], 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('non supportato', $e->getMessage());
    }

    Http::assertNothingSent();
});

it('edits an image through the images endpoint and returns the decoded bytes', function (): void {
    Http::fake(['openrouter.ai/api/v1/images' => Http::response(['data' => [['b64_json' => base64_encode('PNGDATA'), 'media_type' => 'image/png']]])]);

    $result = app(EditImageAction::class)->execute(tinyPng(), 'Pulisci il logo.');

    Assert::assertSame(['mime' => 'image/png', 'bytes' => 'PNGDATA'], $result);
    Http::assertSent(function (Request $request): bool {
        $data = $request->data();
        $references = $data['input_references'] ?? null;
        $references = is_array($references) ? array_values($references) : [];
        $firstReference = $references[0] ?? null;

        return ($data['model'] ?? null) === 'vendor/image-model'
            && is_string($firstReference)
            && str_starts_with($firstReference, 'data:image/png;base64,')
            && ($data['prompt'] ?? null) === 'Pulisci il logo.';
    });
});

it('falls back to Groq when OpenRouter fails, without the OpenRouter-only provider field', function (): void {
    Http::fake([
        'openrouter.ai/*' => Http::response(['error' => ['message' => 'Rate limit']], 429),
        'api.groq.com/openai/v1/chat/completions' => Http::response(['choices' => [['message' => ['content' => '{"ok":true}']]]]),
    ]);

    $result = app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);

    Assert::assertSame(['ok' => true], $result);
    Http::assertSent(fn (Request $request): bool => str_contains($request->url(), 'api.groq.com')
        && $request->hasHeader('Authorization', 'Bearer groq-key')
        && $request['model'] === 'qwen/qwen3.8-27b'
        && ! isset($request['provider'])
        && ! $request->hasHeader('X-Title'));
});

it('skips Groq when there are more images than it accepts and reports every reason', function (): void {
    Http::fake(['openrouter.ai/*' => Http::response(['error' => ['message' => 'Overloaded']], 503)]);
    $images = [tinyPng(), tinyPng(), tinyPng(), tinyPng()];

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute($images, 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('groq: massimo 3 immagini', $e->getMessage());
    }

    Http::assertSentCount(1);
});

it('marks the failure as rate limited when a provider answered 429', function (): void {
    config(['services.groq.key' => null]);
    Http::fake(['*' => Http::response(['error' => ['message' => 'Rate limit reached']], 429)]);

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione');
    } catch (AiRequestException $e) {
        Assert::assertTrue($e->isRateLimited());
    }
});

it('with free models only, sends OpenRouter only free models, as a fallback list', function (): void {
    FakeTenantAiConfig::bind([
        'vision_providers' => ['openrouter'],
        'vision_models' => ['openrouter' => ['vendor/paid-model', 'nvidia/nemotron-3.5-super-vl:free', 'openrouter/free']],
        'free_models_only' => true,
    ]);
    Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => '{"ok":true}']]]])]);

    app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);

    Http::assertSent(fn (Request $request): bool => $request['model'] === 'nvidia/nemotron-3.5-super-vl:free'
        && $request['models'] === ['nvidia/nemotron-3.5-super-vl:free', 'openrouter/free']);
});

it('with free models only, never calls a paid model and refuses image generation', function (): void {
    FakeTenantAiConfig::bind([
        'vision_providers' => ['openrouter'],
        'vision_models' => ['openrouter' => 'vendor/paid-model'],
        'image_model' => 'vendor/paid-image',
        'free_models_only' => true,
    ]);
    Http::fake();

    try {
        app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'x', 's', ['type' => 'object']);
        Assert::fail('nessuna eccezione vision');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('nessun modello utilizzabile', $e->getMessage());
    }

    try {
        app(EditImageAction::class)->execute(tinyPng(), 'x');
        Assert::fail('nessuna eccezione edit');
    } catch (AiRequestException $e) {
        Assert::assertStringContainsString('Nessun modello gratuito', $e->getMessage());
    }

    Http::assertNothingSent();
});

it('defaults to free models: Groq first, then OpenRouter free models', function (): void {
    FakeTenantAiConfig::bind([]);
    $config = AIConfigData::make();

    Assert::assertTrue($config->free_models_only);
    Assert::assertSame(['groq', 'openrouter'], $config->vision_providers);
    foreach (explode(',', $config->vision_models['openrouter']) as $model) {
        Assert::assertTrue(AiProviderEnum::OpenRouter->isFreeModel($model));
    }
});

// Server locale (colibri, Ollama, llama.cpp): nessuna chiave, indirizzo da config, schema nel prompt.
it('reads images through a local OpenAI-compatible server without an API key', function (): void {
    config([
        'services.local_ai' => ['url' => 'http://192.168.1.50:8000/v1/', 'key' => null, 'timeout' => 900, 'response_format' => 'json_object'],
    ]);
    FakeTenantAiConfig::bind([
        'vision_providers' => ['local'],
        'vision_models' => ['local' => 'qwen3.8-27b'],
        'free_models_only' => true,
    ]);
    Http::fake(['192.168.1.50:8000/v1/chat/completions' => Http::response([
        'choices' => [['message' => ['content' => '{"items":[]}']]],
    ])]);

    $schema = ['type' => 'object', 'properties' => ['items' => ['type' => 'array']], 'required' => ['items'], 'additionalProperties' => false];
    $result = app(ExtractStructuredDataFromImagesAction::class)->execute([tinyPng()], 'Leggi.', 'items', $schema);

    Assert::assertSame(['items' => []], $result);
    Http::assertSent(function (Request $request): bool {
        $data = $request->data();
        $system = data_get($data, 'messages.0.content');

        return $request->url() === 'http://192.168.1.50:8000/v1/chat/completions'
            && $request->hasHeader('Authorization', 'Bearer local')
            && data_get($data, 'response_format') === ['type' => 'json_object']
            && is_string($system) && str_contains($system, '"additionalProperties":false')
            && data_get($data, 'model') === 'qwen3.8-27b';
    });
});

it('describes the local provider: no key needed, json mode and timeout from config', function (): void {
    config(['services.local_ai' => ['response_format' => 'none', 'timeout' => 30]]);

    expect(AiProviderEnum::Local->requiresKey())->toBeFalse()
        ->and(AiProviderEnum::Groq->requiresKey())->toBeTrue()
        ->and(AiProviderEnum::Local->baseUrl())->toBe('http://127.0.0.1:8000/v1')
        ->and(AiProviderEnum::Local->jsonMode())->toBe('none')
        ->and(AiProviderEnum::Groq->jsonMode())->toBe('json_schema')
        ->and(AiProviderEnum::Local->timeout(120))->toBe(120)
        ->and(AiProviderEnum::Groq->timeout(120))->toBe(120)
        ->and(AiProviderEnum::Local->isFreeModel('anything'))->toBeTrue();

    config(['services.local_ai' => ['response_format' => 'weird']]);
    expect(AiProviderEnum::Local->jsonMode())->toBe('none')
        ->and(AiProviderEnum::Local->timeout(120))->toBe(600);
});
