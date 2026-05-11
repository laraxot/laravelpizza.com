<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Modules\Notify\Models\Notification as NotificationModel;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Notifications\GenericNotification;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per l'invio di notifiche multi-canale.
 */
class SendNotificationAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, string>  $channels
     * @param  array<string, mixed>  $options
     *
     * @throws Exception
     */
    public function handle(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): ?NotificationModel {
        $template = NotificationTemplate::query()
            ->where('code', $templateCode)
            ->where('is_active', true)
            ->first();

        if (! $template instanceof NotificationTemplate) {
            throw new Exception("Template {$templateCode} non trovato o non attivo");
        }

        if (! $template->shouldSend($data)) {
            return null;
        }

        /** @var array{subject: string, body_html: string|null, body_text: string|null} $compiled */
        $compiled = $template->compile($data);
        /** @var array<int, string> $templateChannels */
        $templateChannels = $template->channels;
        $channelsToUse = $channels !== [] ? $channels : $templateChannels;
        $storedNotification = null;

        foreach ($channelsToUse as $channel) {
            try {
                $notification = $this->sendViaChannel($recipient, $template, $channel, $compiled, $data, $options);

                if ($storedNotification === null && $notification instanceof NotificationModel) {
                    $storedNotification = $notification;
                }
            } catch (Exception $e) {
                Log::error("Errore invio notifica via {$channel}: ".$e->getMessage());
            }
        }

        return $storedNotification;
    }

    /**
     * @param  array{subject: string, body_html: string|null, body_text: string|null}  $compiled
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $options
     *
     * @throws Exception
     */
    protected function sendViaChannel(
        Model $recipient,
        NotificationTemplate $template,
        string $channel,
        array $compiled,
        array $data,
        array $options,
    ): ?NotificationModel {
        return match ($channel) {
            'mail' => $this->sendMail($recipient, $compiled, $options),
            'database' => $this->sendDatabase($recipient, $template, $compiled, $data, $options),
            'sms' => $this->sendSms($recipient, $compiled, $options),
            default => throw new Exception("Canale {$channel} non supportato"),
        };
    }

    /**
     * @param  array{subject: string, body_html: string|null, body_text: string|null}  $compiled
     * @param  array<string, mixed>  $options
     *
     * @throws Exception
     */
    protected function sendMail(Model $recipient, array $compiled, array $options): null
    {
        if (! method_exists($recipient, 'routeNotificationForMail')) {
            throw new Exception('Il destinatario non supporta le notifiche email');
        }

        /** @var mixed $email */
        $email = $recipient->routeNotificationForMail();
        if (! is_string($email) || $email === '') {
            throw new Exception('Email destinatario non disponibile');
        }

        $bodyHtml = $compiled['body_html'];
        $bodyText = $compiled['body_text'];
        $body = $bodyHtml ?? $bodyText ?? '';
        $subject = $compiled['subject'];
        $notificationData = array_merge($options, ['text_view' => $bodyText]);

        if (method_exists($recipient, 'notify')) {
            $recipient->notify(new GenericNotification($subject, $body, ['mail'], $notificationData));

            return null;
        }

        NotificationFacade::send($recipient, new GenericNotification($subject, $body, ['mail'], $notificationData));

        return null;
    }

    /**
     * @param  array{subject: string, body_html: string|null, body_text: string|null}  $compiled
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $options
     */
    protected function sendDatabase(
        Model $recipient,
        NotificationTemplate $template,
        array $compiled,
        array $data,
        array $options,
    ): NotificationModel {
        $bodyHtml = $compiled['body_html'];
        $message = $compiled['body_text'] ?? ($bodyHtml !== null ? strip_tags($bodyHtml) : '');
        $notification = new NotificationModel;
        $notification->forceFill([
            'type' => is_string($template->type) && $template->type !== '' ? $template->type : 'generic',
            'message' => $message,
            'notifiable_type' => $recipient->getMorphClass(),
            'notifiable_id' => $this->normalizeModelKey($recipient->getKey()),
            'user_id' => $this->normalizeModelKey($recipient->getAttribute('user_id')),
            'channels' => ['database'],
            'status' => 'sent',
            'sent_at' => now(),
            'data' => [
                'subject' => $compiled['subject'],
                'body_html' => $bodyHtml,
                'body_text' => $compiled['body_text'],
                'template_code' => $template->code,
                'template_id' => $template->getKey(),
                'payload' => $data,
                'options' => $options,
            ],
        ]);
        $notification->save();

        return $notification;
    }

    /**
     * @param  array{subject: string, body_html: string|null, body_text: string|null}  $compiled
     * @param  array<string, mixed>  $options
     *
     * @throws Exception
     */
    protected function sendSms(Model $recipient, array $compiled, array $options): null
    {
        if (! method_exists($recipient, 'routeNotificationForSms')) {
            throw new Exception('Il destinatario non supporta le notifiche SMS');
        }

        /** @var mixed $phone */
        $phone = $recipient->routeNotificationForSms();
        if (! is_string($phone) || $phone === '') {
            throw new Exception('Numero di telefono destinatario non disponibile');
        }

        $bodyHtml = $compiled['body_html'];
        $message = $compiled['body_text'] ?? ($bodyHtml !== null ? strip_tags($bodyHtml) : '');
        if (mb_strlen($message) > 320) {
            $message = mb_substr($message, 0, 317).'...';
        }

        $subject = $compiled['subject'];

        NotificationFacade::send($recipient, new GenericNotification($subject, $message, ['sms'], $options));

        return null;
    }

    protected function normalizeModelKey(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }
}
