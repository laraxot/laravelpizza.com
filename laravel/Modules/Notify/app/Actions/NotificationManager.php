<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Exceptions\NotificationTemplateNotFoundException;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/notification-manager.md
 *
 * @contract docs/contracts/notification-manager.md
 */
class NotificationManager
{
    use QueueableAction;

    /**
     * Entry point Spatie QueueableAction (coda e sync).
     *
     * Scopo: orchestrare invio da template code verso un destinatario Eloquent.
     * Delega a {@see send()}. Vive in Actions/, mai in Services/ (la copia
     * riesumata sotto Services/ produceva i 7 errori PHPStan su array nudi).
     *
     * @param  array<string, mixed>  $data
     * @param  list<string>  $channels
     * @param  array<string, mixed>  $options
     */
    public function execute(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): ?Notification {
        return $this->send($recipient, $templateCode, $data, $channels, $options);
    }

    /**
     * Invia una notifica a un destinatario risolvendo il template attivo.
     *
     * ## Perche' qui non si cerca piu' il template
     *
     * C'era un `getTemplate()` seguito da `throw new Exception("Template not
     * found: ...")`, e subito dopo la chiamata a `SendNotificationAction` con
     * lo **stesso codice**: l'action rifa' la stessa identica query. Quindi
     * ogni invio costava due interrogazioni, e il template trovato qui veniva
     * buttato via. L'unico effetto del doppio controllo era un messaggio di
     * errore diverso per lo stesso guasto (base_quaeris_fila5#103, #112).
     *
     * Ora il template lo risolve un punto solo — l'action — che lancia
     * {@see NotificationTemplateNotFoundException}.
     *
     * @param  array<string, mixed>  $data
     * @param  list<string>  $channels
     * @param  array<string, mixed>  $options
     *
     * @throws NotificationTemplateNotFoundException se il template non esiste o non e' attivo
     */
    public function send(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): ?Notification {
        $action = app(SendNotificationAction::class);
        $channelList = array_values($channels);
        $notification = $action->handle($recipient, $templateCode, $data, $channelList, $options);

        return $notification instanceof Notification ? $notification : null;
    }

    /**
     * Invia una notifica a più destinatari.
     *
     * @param  array<int, Model>  $recipients  I destinatari delle notifiche
     * @param  string  $templateCode  Il codice del template da utilizzare
     * @param  array<string, mixed>  $data  I dati per compilare il template
     * @param  list<string>  $channels  I canali da utilizzare (opzionale)
     * @param  array<string, mixed>  $options  Opzioni aggiuntive per l'invio
     * @return list<Notification>
     */
    public function sendMultiple(
        array $recipients,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): array {
        $notifications = [];

        foreach ($recipients as $recipient) {
            if (! ($recipient instanceof Model)) {
                continue;
            }
            $notification = $this->send($recipient, $templateCode, $data, $channels, $options);

            if ($notification instanceof Notification) {
                $notifications[] = $notification;
            }
        }

        return $notifications;
    }

    /**
     * Recupera un template per codice.
     *
     * @param  string  $code  Il codice del template
     */
    public function getTemplate(string $code): ?NotificationTemplate
    {
        return NotificationTemplate::where('code', $code)->where('is_active', true)->first();
    }

    /**
     * Recupera i template per categoria.
     *
     * @param  string  $category  La categoria dei template
     * @return Collection<int, NotificationTemplate>
     */
    public function getTemplatesByCategory(string $category): Collection
    {
        return NotificationTemplate::where('category', $category)->where('is_active', true)->get();
    }

    /**
     * Recupera i template per canale.
     *
     * @param  string  $channel  Il canale di notifica
     * @return Collection<int, NotificationTemplate>
     */
    public function getTemplatesByChannel(string $channel): Collection
    {
        return NotificationTemplate::forChannel($channel)->where('is_active', true)->get();
    }

    /*
     * `getTemplateStats()` e `getRecipientStats()` non ci sono piu'.
     *
     * Erano due metodi pubblici il cui corpo era commentato per intero e che
     * restituivano sei zeri fissi: chi li chiamava riceveva un cruscotto che
     * diceva «nessuna notifica inviata» qualunque fosse la realta' — peggio di
     * un metodo assente, perche' un metodo assente si nota (base_quaeris_fila5#103).
     *
     * Il conteggio vero si fa sui log delle notifiche; quando servira', andra'
     * scritto contro quelli, con un test che lo dimostri.
     */
}
