<?php

declare(strict_types=1);

namespace Modules\Notify\Factories;

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Actions\SMS\SendGammuSMSAction;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\Actions\SMS\SendNexmoSMSAction;
use Modules\Notify\Actions\SMS\SendPlivoSMSAction;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;
use Modules\Notify\Actions\SMS\SendTwilioSMSAction;
use Modules\Notify\Models\Contracts\SmsActionContract;

/**
 * Factory per la creazione di azioni SMS.
 *
 * Mappa esplicita driver → `Send{Provider}SMSAction`. Il driver arriva da
 * `SmsChannel` (override per-notifica via `getProvider()`) o, in mancanza, da
 * `config('sms.default')` (env `SMS_DRIVER`).
 *
 * Niente risoluzione per convenzione di naming: `ucfirst('smsfactor')` dava
 * `SendSmsfactorSMSAction` (classe inesistente, la vera è
 * `SendSmsFactorSMSAction`), quindi la factory era di fatto rotta proprio sul
 * driver di default — vedi
 * `Modules/Notify/docs/wiki/concepts/sms-channel-driver-selection.md`.
 */
class SmsActionFactory
{
    /**
     * @var array<string, class-string<SmsActionContract>>
     */
    protected array $driverActions = [
        'smsfactor' => SendSmsFactorSMSAction::class,
        'netfun' => SendNetfunSMSAction::class,
        'twilio' => SendTwilioSMSAction::class,
        'nexmo' => SendNexmoSMSAction::class,
        'plivo' => SendPlivoSMSAction::class,
        'gammu' => SendGammuSMSAction::class,
        'agiletelecom' => SendAgiletelecomSMSAction::class];

    /** @var array<string, string> */
    protected array $driverAliases = [
        'smsfac' => 'smsfactor',
        'vonage' => 'nexmo'];

    /**
     * Crea l'azione SMS per il driver dato (o quello di `config('sms.default')`).
     *
     * @param  string|null  $driver  se null, `config('sms.default')`
     *
     * @throws Exception se il driver non ha una action mappata
     */
    public function create(?string $driver = null): SmsActionContract
    {
        $configDefault = Config::get('sms.default', 'smsfactor');
        $driver ??= \is_string($configDefault) ? $configDefault : 'smsfactor';

        $key = $this->normalizeDriverName($driver);
        $className = $this->driverActions[$key] ?? null;

        if ($className === null) {
            throw new Exception(
                "Unsupported SMS driver [{$key}]. Aggiungerlo a ".self::class.'::$driverActions.',
            );
        }

        $instance = app($className);

        if (! $instance instanceof SmsActionContract) {
            throw new Exception("Class {$className} does not implement SmsActionContract.");
        }

        return $instance;
    }

    /**
     * Normalizza il nome del driver (minuscolo, senza trattini/underscore/spazi)
     * e risolve eventuali alias.
     */
    private function normalizeDriverName(string $driver): string
    {
        $normalized = str_replace(['-', '_', ' '], '', strtolower($driver));

        return $this->driverAliases[$normalized] ?? $normalized;
    }
}
