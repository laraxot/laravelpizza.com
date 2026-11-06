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
}
