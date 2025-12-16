<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\NotificationTemplate;

class NotificationManager
{
    /**
     * Invia una notifica a un destinatario.
     *
     * @param Model $recipient Il destinatario della notifica
     * @param string $templateCode Il codice del template da utilizzare
     * @param array<string, mixed> $data I dati per compilare il template
     * @param array<int, string> $channels I canali da utilizzare (opzionale)
     * @param array<string, mixed> $options Opzioni aggiuntive per l'invio
     *
     * @return array<string, mixed>
     */
    public function send(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): array {
        $template = $this->getTemplate($templateCode);

        if (!$template) {
            throw new Exception("Template not found: {$templateCode}");
        }

        $action = app(SendNotificationAction::class);
        $action->execute($recipient, $templateCode, $data, $channels, $options);

        return [];
    }

    /**
     * Invia una notifica a più destinatari.
     *
     * @param array<int, Model> $recipients I destinatari delle notifiche
     * @param string $templateCode Il codice del template da utilizzare
     * @param array<string, mixed> $data I dati per compilare il template
     * @param array<int, string> $channels I canali da utilizzare (opzionale)
     * @param array<string, mixed> $options Opzioni aggiuntive per l'invio
     *
     * @return array<int, array<string, mixed>>
     */
    public function sendMultiple(
        array $recipients,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): array {
        /** @var array<int, array<string, mixed>> $logs */
        $logs = [];

        foreach ($recipients as $recipient) {
            if (!($recipient instanceof Model)) {
                continue;
            }
            $logs[] = $this->send($recipient, $templateCode, $data, $channels, $options);
        }

        return $logs;
    }

    /**
     * Recupera un template per codice.
     *
     * @param string $code Il codice del template
     * @return NotificationTemplate|null
     */
    public function getTemplate(string $code): null|NotificationTemplate
    {
        return NotificationTemplate::where('code', $code)->where('is_active', true)->first();
    }

    /**
     * Recupera i template per categoria.
     *
     * @param string $category La categoria dei template
     * @return Collection<NotificationTemplate>
     */
    public function getTemplatesByCategory(string $category)
    {
        return NotificationTemplate::where('category', $category)->where('is_active', true)->get();
    }

    /**
     * Recupera i template per canale.
     *
     * @param string $channel Il canale di notifica
     * @return Collection<NotificationTemplate>
     */
    public function getTemplatesByChannel(string $channel)
    {
        return NotificationTemplate::forChannel($channel)->where('is_active', true)->get();
    }

    /**
     * Recupera le statistiche di invio per un template.
     *
     * @param NotificationTemplate $_template Template delle notifiche Il template
     * @return array<string, mixed>
     */
    public function getTemplateStats(NotificationTemplate $_template): array
    {
        // $logs = $template->logs();
        
        // return [
        //     'total' => $logs->count(),
        //     'sent' => $logs->where('status', NotificationLog::STATUS_SENT)->count(),
        //     'delivered' => $logs->where('status', NotificationLog::STATUS_DELIVERED)->count(),
        //     'failed' => $logs->where('status', NotificationLog::STATUS_FAILED)->count(),
        //     'opened' => $logs->where('status', NotificationLog::STATUS_OPENED)->count(),
        //     'clicked' => $logs->where('status', NotificationLog::STATUS_CLICKED)->count(),
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
     * @param Model $_recipient Il destinatario
     * @return array<string, mixed>
     */
    public function getRecipientStats(Model $_recipient): array
    {
        // $logs = NotificationLog::forNotifiable($recipient)->get();
        
        // return [
        //     'total' => $logs->count(),
        //     'sent' => $logs->where('status', NotificationLog::STATUS_SENT)->count(),
        //     'delivered' => $logs->where('status', NotificationLog::STATUS_DELIVERED)->count(),
        //     'failed' => $logs->where('status', NotificationLog::STATUS_FAILED)->count(),
        //     'opened' => $logs->where('status', NotificationLog::STATUS_OPENED)->count(),
        //     'clicked' => $logs->where('status', NotificationLog::STATUS_CLICKED)->count(),
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
