<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Spatie\QueueableAction\QueueableAction;

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
     * @param  array<string, mixed>  $data
     * @param  list<string>  $channels
     * @param  array<string, mixed>  $options
     */
    public function send(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): ?Notification {
        $template = $this->getTemplate($templateCode);

        if (! $template instanceof NotificationTemplate) {
            throw new Exception("Template not found: {$templateCode}");
        }

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

    /**
     * Recupera le statistiche di invio per un template.
     *
     * @param  NotificationTemplate  $_template  Template delle notifiche Il template
     * @return array<string, mixed>
     */
    public function getTemplateStats(NotificationTemplate $_template): array
    {
        // $logs = $template->logs();

        // return [
        //     'total' => $logs->count(),
        //     'sent' => $logs->where('status', NotificationLogStatusEnum::SENT->value)->count(),
        //     'delivered' => $logs->where('status', NotificationLogStatusEnum::DELIVERED->value)->count(),
        //     'failed' => $logs->where('status', NotificationLogStatusEnum::FAILED->value)->count(),
        //     'opened' => $logs->where('status', NotificationLogStatusEnum::OPENED->value)->count(),
        //     'clicked' => $logs->where('status', NotificationLogStatusEnum::CLICKED->value)->count(),
        // ];

        return [
            'total' => 0,
            'sent' => 0,
            'delivered' => 0,
            'failed' => 0,
            'opened' => 0,
            'clicked' => 0,
        ];
    }

    /**
     * Recupera le statistiche di invio per un destinatario.
     *
     * @param  Model  $_recipient  Il destinatario
     * @return array<string, mixed>
     */
    public function getRecipientStats(Model $_recipient): array
    {
        // $logs = NotificationLog::forNotifiable($recipient)->get();

        // return [
        //     'total' => $logs->count(),
        //     'sent' => $logs->where('status', NotificationLogStatusEnum::SENT->value)->count(),
        //     'delivered' => $logs->where('status', NotificationLogStatusEnum::DELIVERED->value)->count(),
        //     'failed' => $logs->where('status', NotificationLogStatusEnum::FAILED->value)->count(),
        //     'opened' => $logs->where('status', NotificationLogStatusEnum::OPENED->value)->count(),
        //     'clicked' => $logs->where('status', NotificationLogStatusEnum::CLICKED->value)->count(),
        // ];

        return [
            'total' => 0,
            'sent' => 0,
            'delivered' => 0,
            'failed' => 0,
            'opened' => 0,
            'clicked' => 0,
        ];
    }
}
