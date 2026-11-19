<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Modules\AI\Actions\GeneratePredictionsAction;
use Modules\AI\Actions\MakeAIRequestAction;
use Modules\AI\Actions\Predict\GeneratePredictionDraftsAction;
use Modules\AI\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di AI del tenant corrente: `config/{tenant}/ai.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). I default sono i valori che
 * prima erano scritti nelle Action: nulla cambia finche' nessuno salva. La chiave API OpenAI non
 * e' qui: resta in `.env` (`services.openai.api_key`).
 *
 * @see SettingPage
 * @see GeneratePredictionsAction
 * @see GeneratePredictionDraftsAction
 * @see MakeAIRequestAction
 */
class AIConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Modello di completion di GeneratePredictionsAction. */
    public string $model = 'gpt-3.5-turbo-instruct';

    /** Modello chat di GeneratePredictionDraftsAction. */
    public string $chat_model = 'gpt-4o-mini';

    /** Temperatura di GeneratePredictionsAction (0.7 prima in quella Action). */
    public float $temperature = 0.7;

    /** Temperatura di GeneratePredictionDraftsAction (0.6 prima in quella Action, diversa di proposito). */
    public float $chat_temperature = 0.6;

    /** Token massimi generati da GeneratePredictionsAction. */
    public int $max_tokens = 1500;

    /** Timeout in secondi delle richieste di MakeAIRequestAction. */
    public int $timeout = 30;

    /** Tentativi di MakeAIRequestAction prima di fallire (backoff esponenziale tra l'uno e l'altro). */
    public int $retry_attempts = 3;

    /** Base URL dell'API compatibile OpenAI usata da MakeAIRequestAction. */
    public string $openai_base_url = 'https://api.openai.com/v1';

    /**
     * Fornitori per la lettura di immagini, in ordine: si prova il primo, se fallisce (errore, chiave
     * mancante, troppe immagini per quel fornitore) il successivo. Valori di AiProviderEnum.
     * Le chiavi restano in `.env`: OPENROUTER_API_KEY, GROQ_API_KEY.
     *
     * @var list<string>
     */
    public array $vision_providers = ['groq', 'openrouter'];

    /**
     * Modelli di lettura immagini per fornitore: devono accettare immagini e `response_format` json_schema.
     * Piu' modelli per un fornitore separati da virgola (la pagina impostazioni modifica stringhe): su
     * OpenRouter si mandano come `models` e OpenRouter passa da solo al successivo se il primo e' esaurito.
     *
     * Solo modelli gratuiti (scelta di Marco, 2026-11-17), verificati sul catalogo OpenRouter il 2026-11-17:
     * - Groq `qwen/qwen3.8-27b`: piano gratuito, provato dal vivo (10/10 piatti); preview, max 3 immagini.
     * - OpenRouter: modelli `:free` con immagini e structured outputs, poi `openrouter/free` (sceglie da
     *   solo un modello gratuito adatto). I modelli gratuiti hanno limiti di richieste al giorno.
     *
     * @var array<string, string>
     */
    public array $vision_models = [
        'groq' => 'qwen/qwen3.8-27b',
        'openrouter' => 'nvidia/nemotron-3.5-super-vl:free,inclusionai/ling-3.2-flash:free,openrouter/free',
        // Server locale (si attiva aggiungendo 'local' a vision_providers): nome del modello come lo
        // conosce il server. colibri serve un modello alla volta; Ollama per esempio 'qwen2.5vl:7b'.
        'local' => 'qwen3.8-27b',
    ];

    /**
     * Solo modelli gratuiti: un modello OpenRouter senza `:free` (o diverso da `openrouter/free`) viene
     * scartato prima della chiamata, cosi' una configurazione sbagliata non genera costi.
     */
    public bool $free_models_only = true;

    /**
     * Fornitori dell'assistente clienti (Assistant\AnswerQuestionAction), in ordine: se il primo fallisce
     * o non ha la chiave si prova il successivo; se nessuno risponde si usa MakeAIRequestAction (OpenAI).
     * Groq per primo: e' il piu' veloce, e la risposta all'utente in chat deve arrivare subito.
     *
     * @var list<string>
     */
    public array $assistant_providers = ['groq', 'openrouter'];

    /**
     * Modello di testo per fornitore. Groq: `openai/gpt-oss-120b` e' il modello di testo di produzione
     * (i Llama sono stati ritirati nel 2026), gratuito nel piano free; OpenRouter: `openrouter/free`.
     *
     * @var array<string, string>
     */
    public array $assistant_models = [
        'groq' => 'openai/gpt-oss-120b',
        // Router dei modelli gratuiti di OpenRouter (vedi free_models_only).
        'openrouter' => 'openrouter/free',
    ];

    /** Timeout in secondi di una risposta dell'assistente: il visitatore aspetta in chat. */
    public int $assistant_timeout = 30;

    /**
     * Modello che modifica o genera immagini (EditImageAction, solo OpenRouter). Nessun modello gratuito
     * genera immagini: con `free_models_only` EditImageAction rifiuta la chiamata.
     */
    public string $image_model = 'google/gemini-2.5-flash-image';

    /** Timeout in secondi delle richieste con immagini: piu' lunghe di una chat di solo testo. */
    public int $vision_timeout = 120;
}
