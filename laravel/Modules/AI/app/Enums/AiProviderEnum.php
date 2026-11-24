<?php

declare(strict_types=1);

namespace Modules\AI\Enums;

/**
 * Fornitori con API compatibile OpenAI (`/chat/completions`) usati dalle azioni sulle immagini.
 *
 * La chiave di ciascuno sta in `.env` e si legge da `config/services.php`; qui ci sono solo le
 * differenze di protocollo che il codice deve conoscere.
 *
 * `Local` e' un server sul proprio computer o in sede (colibri, Ollama, llama.cpp, LM Studio...):
 * gratis, nessun limite di richieste, le foto non escono dal locale; in cambio e' piu' lento.
 * Indirizzo e opzioni in `services.local_ai` (docs/local-llm-server.md).
 */
enum AiProviderEnum: string
{
    /** Instradatore verso molti modelli (Gemini, GPT, Claude, Qwen...): unico che modifica immagini. */
    case OpenRouter = 'openrouter';

    /** Inferenza veloce su modelli aperti; per le immagini un solo modello, in preview. */
    case Groq = 'groq';

    /** Server locale con API compatibile OpenAI (colibri, Ollama, llama.cpp, LM Studio). */
    case Local = 'local';

    public function baseUrl(): string
    {
        return match ($this) {
            self::OpenRouter => 'https://openrouter.ai/api/v1',
            self::Groq => 'https://api.groq.com/openai/v1',
            self::Local => rtrim(self::configString('services.local_ai.url', 'http://127.0.0.1:8000/v1'), '/'),
        };
    }

    /** Chiave di `config/services.php` che contiene la chiave API. */
    public function keyConfig(): string
    {
        return match ($this) {
            self::OpenRouter => 'services.openrouter.key',
            self::Groq => 'services.groq.key',
            self::Local => 'services.local_ai.key',
        };
    }

    /** Variabile `.env` da indicare nei messaggi di errore. */
    public function envName(): string
    {
        return match ($this) {
            self::OpenRouter => 'OPENROUTER_API_KEY',
            self::Groq => 'GROQ_API_KEY',
            self::Local => 'LOCAL_AI_KEY',
        };
    }

    /** Senza chiave non si parte; il server locale di solito non ne ha (se ne ha una, si manda). */
    public function requiresKey(): bool
    {
        return $this !== self::Local;
    }

    /** Immagini massime in una richiesta (Groq: 3 per il modello qwen); null = nessun limite noto. */
    public function maxImages(): ?int
    {
        return match ($this) {
            self::OpenRouter => null,
            self::Groq => 3,
            self::Local => null,
        };
    }

    /**
     * Campi aggiuntivi del payload: `provider.require_parameters` esiste solo su OpenRouter
     * (instrada solo verso chi rispetta lo schema); a Groq non va mandato.
     *
     * @return array<string, mixed>
     */
    public function extraPayload(): array
    {
        return match ($this) {
            self::OpenRouter => ['provider' => ['require_parameters' => true]],
            self::Groq, self::Local => [],
        };
    }

    /**
     * Il modello e' gratuito? OpenRouter: suffisso `:free` o il router `openrouter/free`.
     * Groq: si paga solo con un piano a consumo attivato sull'account, non per modello: true.
     */
    public function isFreeModel(string $model): bool
    {
        return match ($this) {
            self::OpenRouter => str_ends_with($model, ':free') || $model === 'openrouter/free',
            self::Groq, self::Local => true,
        };
    }

    /**
     * Come chiedere una risposta JSON: `json_schema` (schema rispettato dal server), `json_object`
     * (solo JSON valido: lo schema va nel prompt) o `none` (nessun response_format, lo schema nel prompt).
     * I server locali non supportano tutti response_format (colibri risponde 400 con qualunque grammatica):
     * `services.local_ai.response_format`, default `none` (schema nel prompt, funziona ovunque).
     */
    public function jsonMode(): string
    {
        if ($this !== self::Local) {
            return 'json_schema';
        }
        $mode = self::configString('services.local_ai.response_format', 'none');

        return \in_array($mode, ['json_schema', 'json_object', 'none'], true) ? $mode : 'none';
    }

    /** Timeout della richiesta: un modello locale su CPU legge una pagina in minuti, non secondi. */
    public function timeout(int $default): int
    {
        if ($this !== self::Local) {
            return $default;
        }
        $local = config('services.local_ai.timeout');

        return max($default, is_numeric($local) ? (int) $local : 600);
    }

    private static function configString(string $key, string $default): string
    {
        $value = config($key);

        return \is_string($value) && trim($value) !== '' ? trim($value) : $default;
    }

    /** Intestazioni aggiuntive: OpenRouter riconosce l'app da HTTP-Referer e X-Title. */
    public function sendsAppHeaders(): bool
    {
        return $this === self::OpenRouter;
    }
}
