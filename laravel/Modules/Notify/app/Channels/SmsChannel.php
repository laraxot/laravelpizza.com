<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Factories\SmsActionFactory;

/**
 * Canale di notifica per l'invio di messaggi SMS.
 *
 * Il driver effettivo è scelto da `SmsActionFactory` in base a
 * `config('sms.default')` (env `SMS_DRIVER`), oppure a un override
 * per-notifica se la notifica espone `getProvider(): ?string`
 * (es. `SmsNotification`). Così `SMS_DRIVER=netfun` con
 * `config('sms.drivers.netfun')` valorizzato fa passare gli SMS da Netfun,
 * senza toccare codice — vedi
 * `Modules/Notify/docs/wiki/concepts/sms-channel-driver-selection.md`.
 */
class SmsChannel
{
    /**
     * Crea una nuova istanza del canale.
     */
    public function __construct(private readonly SmsActionFactory $factory) {}

    /**
     * Invia la notifica attraverso il canale SMS.
     *
     * @param  Notification  $notification  Notifica da inviare
     * @return array<string, mixed>|null Risultato dell'invio restituito dall'azione del driver
     *                                   (`SmsActionContract::execute()`); di norma
     *                                   `array{status_code: int, status_txt: string}`
     *
     * @throws Exception Se la notifica non ha il metodo toSms o il driver non è supportato
     */
    public function send(object $notifiable, Notification $notification): ?array
    {
        if (! method_exists($notification, 'toSms')) {
            throw new Exception('Notification does not have toSms method');
        }

        $smsData = $notification->toSms($notifiable);

        // Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 17
        // (2026-09-15): toSms() e' tipizzato ?SmsData proprio per poter dire "niente
        // da inviare" (nessun destinatario, o corpo vuoto) senza che sia un errore
        // di programmazione — ma questo metodo trattava `null` come qualunque altro
        // valore non valido, lanciando un'eccezione invece di saltare in modo pulito.
        if ($smsData === null) {
            return null;
        }

        if (! ($smsData instanceof SmsData)) {
            throw new Exception('toSms method must return an instance of SmsData');
        }

        // Override del driver per-notifica se la notifica lo espone (es.
        // SmsNotification::getProvider()); altrimenti null e SmsActionFactory
        // usa config('sms.default').
        $driver = null;
        if (method_exists($notification, 'getProvider')) {
            $provider = $notification->getProvider();
            $driver = \is_string($provider) && $provider !== '' ? $provider : null;
        }

        return $this->factory->create($driver)->execute($smsData);
    }
}
