<?php

declare(strict_types=1);

namespace Modules\Notify\Factories;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\SMS\SmsActionContract;

/**
 * Factory per la creazione di azioni SMS.
 *
 * Questa factory centralizza la logica di selezione del driver SMS
 * e la creazione dell'azione corrispondente, seguendo il pattern di risoluzione dinamica
 * delle classi basato su convenzioni di naming.
 */
final class SmsActionFactory
{
    /**
     * Lista dei provider SMS supportati ufficialmente.
     *
     * Questa lista serve come documentazione e validazione
     * per garantire che i provider utilizzati siano quelli supportati.
     *
     * @var array<string>
     */
    protected array $supportedDrivers = [
        'smsfactor',
        'twilio',
        'nexmo',
        'plivo',
        'gammu',
        'netfun',
    ];

    /**
     * Mappatura di alias ai nomi dei driver effettivi.
     *
     * @var array<string, string>
     */
    protected array $driverAliases = [
        'vonage' => 'nexmo',
        'smsfac' => 'smsfactor',
        'textmessage' => 'twilio',
        'clickatell' => 'twilio',
        'aws' => 'aws',
        'amazon' => 'aws',
    ];

    /**
     * Crea un'azione SMS basata sul driver specificato o su quello predefinito.
     * Utilizza una risoluzione dinamica delle classi basata sulla convenzione di naming
     * per istanziare l'action corretta.
     *
     * @param string|null $driver Driver SMS da utilizzare (se null, viene utilizzato quello predefinito)
     * @return SmsActionContract Azione SMS corrispondente al driver
     * @throws Exception Se il driver specificato non è supportato o la classe non esiste
     */
    public function create(null|string $driver = null): SmsActionContract
    {
        $driver ??= Config::get('sms.default', 'netfun');

        // Normalizza il nome del driver e assicura formato camelCase
        $normalizedDriver = $this->normalizeDriverName(is_string($driver) ? $driver : '');

        // Avvisa per driver non standard
        if (!in_array($normalizedDriver, $this->supportedDrivers, strict: true)) {
            Log::warning('Attempting to use non-standard SMS driver: ' . (is_string($driver) ? $driver : ''));
        }

        // Costruisci il nome della classe seguendo la convenzione
        $className = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($normalizedDriver) . 'SMSAction';

        // Verifica se la classe esiste
        if (!class_exists($className)) {
            Log::error('SMS driver class not found', [
                'driver' => $driver,
                'normalized' => $normalizedDriver,
                'className' => $className,
            ]);

            throw new Exception(
                'Unsupported SMS driver: ' . (is_string($driver) ? $driver : '') . ". Class {$className} not found.",
            );
        }

        $instance = app($className);

        // Verifica che l'istanza implementi l'interfaccia corretta
        if (!($instance instanceof SmsActionContract)) {
            throw new Exception("Class {$className} does not implement SmsActionContract.");
        }

        return $instance;
    }

    /**
     * Normalizza il nome del driver eliminando trattini e underscore
     * e gestendo eventuali casi speciali/alias.
     *
     * @param string $driver Nome del driver da normalizzare
     * @return string Nome normalizzato
     */
    private function normalizeDriverName(string $driver): string
    {
        // Rimuovi trattini e underscore
        $normalized = str_replace(['-', '_', ' '], '', strtolower($driver));

        // Gestisci casi speciali e alias tramite la mappa di alias
        return $this->driverAliases[$normalized] ?? $normalized;
    }
}
