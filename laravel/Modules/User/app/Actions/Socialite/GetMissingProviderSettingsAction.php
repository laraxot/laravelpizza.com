<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

/**
 * Variabili d'ambiente che mancano (o sono segnaposto) perche' un provider OAuth funzioni (DCP-271).
 *
 * `config/services.php` dichiara sempre `services.<provider>` con env() = null: la sola presenza della chiave
 * non dice che il provider sia configurato, e Socialite costruisce comunque l'URL, senza `client_id`.
 */
class GetMissingProviderSettingsAction
{
    use QueueableAction;

    /** Esempi del modello .env e di config/services.php: non sono credenziali. */
    private const string PLACEHOLDER_PATTERN = '~^(your[-_]|google-client-id|xxx|changeme$)~i';

    /** Chiave di `services.<provider>` => suffisso della variabile d'ambiente (`GOOGLE_` + suffisso). */
    private const array SETTINGS = [
        'client_id' => 'CLIENT_ID',
        'client_secret' => 'CLIENT_SECRET',
        'redirect' => 'REDIRECT_URI',
    ];

    /**
     * @return list<string> nomi delle variabili d'ambiente da impostare, vuoto se il provider e' configurato
     */
    public function execute(string $provider): array
    {
        $settings = config('services.'.$provider);
        $settings = is_array($settings) ? $settings : [];

        $missing = [];
        foreach (self::SETTINGS as $key => $suffix) {
            if (! $this->isRealValue($settings[$key] ?? null)) {
                $missing[] = strtoupper($provider).'_'.$suffix;
            }
        }

        return $missing;
    }

    private function isRealValue(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $value = trim($value);

        return $value !== '' && preg_match(self::PLACEHOLDER_PATTERN, $value) === 0;
    }
}
