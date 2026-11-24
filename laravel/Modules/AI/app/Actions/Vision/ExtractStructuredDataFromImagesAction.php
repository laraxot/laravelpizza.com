<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Vision;

use Modules\AI\Datas\AIConfigData;
use Modules\AI\Enums\AiProviderEnum;
use Modules\AI\Exceptions\AiRequestException;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\PcreException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;
use function Safe\json_encode;
use function Safe\preg_replace;

/**
 * Legge una o piu' immagini e restituisce i dati richiesti come array conforme a uno schema JSON.
 *
 * Agnostica: non sa cosa c'e' nelle immagini. Il modulo che la usa passa istruzioni e schema
 * (es. Restaurant: le pagine di un menu cartaceo -> sezioni e piatti).
 *
 * Endpoint compatibile OpenAI (`/chat/completions`) di OpenRouter o Groq, provati in ordine
 * (`ai.vision_providers`): se uno fallisce si passa al successivo. Immagini come `image_url` con
 * data URI, testo prima delle immagini, `response_format` json_schema strict; su OpenRouter anche
 * `provider.require_parameters`, perche' instradi solo verso chi rispetta lo schema.
 */
class ExtractStructuredDataFromImagesAction
{
    use QueueableAction;

    public function __construct(private readonly ImageDataUriAction $dataUri) {}

    /**
     * @param  list<string>  $imagePaths  file su disco (png, jpeg, webp, gif)
     * @param  array<string, mixed>  $schema  JSON Schema dell'oggetto atteso (strict: tutti i campi in
     *                                        `required`, `additionalProperties: false`, null per i facoltativi)
     * @param  list<AiProviderEnum>|null  $providers  ordine dei fornitori; null = `ai.vision_providers`
     * @return array<string, mixed>
     *
     * @throws AiRequestException se tutti i fornitori falliscono (messaggio con il motivo di ciascuno)
     */
    public function execute(array $imagePaths, string $instructions, string $schemaName, array $schema, ?array $providers = null): array
    {
        if ($imagePaths === []) {
            throw new AiRequestException('Nessuna immagine da leggere.');
        }

        $config = AIConfigData::make();
        $providers ??= array_values(array_filter(array_map(AiProviderEnum::tryFrom(...), $config->vision_providers)));
        if ($providers === []) {
            throw new AiRequestException('Nessun fornitore AI configurato per le immagini (ai.vision_providers).');
        }

        // Le immagini si codificano una volta sola, prima di qualunque chiamata.
        $content = [['type' => 'text', 'text' => $instructions]];
        foreach ($imagePaths as $path) {
            $content[] = ['type' => 'image_url', 'image_url' => ['url' => $this->dataUri->execute($path)]];
        }

        $errors = [];
        $rateLimited = false;
        foreach ($providers as $provider) {
            $max = $provider->maxImages();
            if ($max !== null && \count($imagePaths) > $max) {
                $errors[] = $provider->value.': massimo '.$max.' immagini per richiesta';

                continue;
            }

            try {
                return $this->request($provider, $config, $content, $schemaName, $schema);
            } catch (AiRequestException $e) {
                $errors[] = $e->getMessage();
                $rateLimited = $rateLimited || $e->isRateLimited();
            }
        }

        // 429 se almeno un fornitore ha solo chiesto di aspettare: chi chiama puo' riprovare piu' tardi.
        throw new AiRequestException('Lettura delle immagini non riuscita. '.implode('; ', $errors), $rateLimited ? 429 : 0);
    }

    /**
     * @param  list<array<string, mixed>>  $content
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private function request(AiProviderEnum $provider, AIConfigData $config, array $content, string $schemaName, array $schema): array
    {
        $models = app(ResolveModelsAction::class)->execute($provider, $config->vision_models[$provider->value] ?? null, $config->free_models_only);
        if ($models === []) {
            throw new AiRequestException($provider->value.': nessun modello utilizzabile in ai.vision_models (solo gratuiti: '.($config->free_models_only ? 'si' : 'no').').');
        }

        $payload = [
            'model' => $models[0],
            // OpenRouter: elenco di riserva, si passa al successivo se il primo non e' disponibile.
            ...($provider === AiProviderEnum::OpenRouter && \count($models) > 1 ? ['models' => $models] : []),
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt($provider, $schema)],
                ['role' => 'user', 'content' => $content],
            ],
            'temperature' => 0,
            ...match ($provider->jsonMode()) {
                'json_schema' => ['response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => ['name' => $schemaName, 'strict' => true, 'schema' => $schema],
                ]],
                'json_object' => ['response_format' => ['type' => 'json_object']],
                default => [],
            },
            ...$provider->extraPayload(),
        ];

        $json = app(OpenAiCompatibleRequestAction::class)->execute($provider, '/chat/completions', $payload, $config->vision_timeout);

        $text = data_get($json, 'choices.0.message.content');
        if (! is_string($text) || trim($text) === '') {
            throw new AiRequestException($provider->value.': risposta senza contenuto.');
        }

        try {
            $decoded = json_decode($this->stripFence($text), true);
        } catch (JsonException|PcreException $e) {
            throw new AiRequestException($provider->value.': risposta non in formato JSON.', previous: $e);
        }
        if (! is_array($decoded)) {
            throw new AiRequestException($provider->value.': risposta non in formato JSON.');
        }

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /**
     * Se il server non applica lo schema (server locali), lo schema va scritto nel prompt.
     *
     * @param  array<string, mixed>  $schema
     */
    private function systemPrompt(AiProviderEnum $provider, array $schema): string
    {
        $prompt = 'Rispondi solo con JSON conforme allo schema. Non inventare dati che non leggi nelle immagini: lascia vuoto o null.';
        if ($provider->jsonMode() === 'json_schema') {
            return $prompt;
        }

        return $prompt."\nSchema JSON:\n".json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /** Alcuni modelli racchiudono il JSON in ```json ... ``` anche con lo schema richiesto. */
    private function stripFence(string $text): string
    {
        $text = trim($text);
        if (! str_starts_with($text, '```')) {
            return $text;
        }

        $stripped = preg_replace('/^```[a-z]*\s*|\s*```$/i', '', $text);

        return is_string($stripped) ? $stripped : $text;
    }
}
