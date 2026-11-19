<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Vision;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\AI\Enums\AiProviderEnum;
use Modules\AI\Exceptions\AiRequestException;
use Spatie\QueueableAction\QueueableAction;

/**
 * POST JSON verso un fornitore compatibile OpenAI (OpenRouter, Groq) con la sua chiave da `.env`.
 * Le intestazioni HTTP-Referer e X-Title servono solo a OpenRouter per riconoscere l'app.
 */
class OpenAiCompatibleRequestAction
{
    use QueueableAction;

    /**
     * @param  string  $path  percorso dopo la base URL, es. `/chat/completions`
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     *
     * @throws AiRequestException
     */
    public function execute(AiProviderEnum $provider, string $path, array $payload, int $timeout): array
    {
        $key = config($provider->keyConfig());
        if (! is_string($key) || $key === '') {
            if ($provider->requiresKey()) {
                throw new AiRequestException('Chiave API mancante: imposta '.$provider->envName().' ('.$provider->keyConfig().').');
            }
            // Server locale senza chiave: molti client (e colibri) vogliono comunque un Bearer non vuoto.
            $key = 'local';
        }

        $request = Http::timeout($provider->timeout($timeout))->withToken($key)->acceptJson();
        if ($provider->sendsAppHeaders()) {
            $request = $request->withHeaders([
                'HTTP-Referer' => $this->configString('app.url'),
                'X-Title' => $this->configString('app.name'),
            ]);
        }

        try {
            $response = $request->post($provider->baseUrl().$path, $payload);
        } catch (ConnectionException $e) {
            throw new AiRequestException($provider->value.': servizio non raggiungibile.', previous: $e);
        }

        if (! $response->successful()) {
            $message = data_get($response->json(), 'error.message');
            throw new AiRequestException($provider->value.': errore HTTP '.$response->status().(is_string($message) ? ' ('.$message.')' : ''), $response->status());
        }

        $json = $response->json();
        if (! is_array($json)) {
            throw new AiRequestException($provider->value.': risposta non JSON.');
        }

        /** @var array<string, mixed> $json */
        return $json;
    }

    private function configString(string $key): string
    {
        $value = config($key);

        return is_string($value) ? $value : '';
    }
}
