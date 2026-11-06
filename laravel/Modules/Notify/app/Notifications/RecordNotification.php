<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Emails\SpatieEmail;

class RecordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<int, array{path?: string, data?: mixed, as?: string|null, mime?: string|null}> */
    public array $attachments = [];

    protected Model $record;

    protected string $slug;

    public function __construct(Model $record, string $slug)
    {
        $this->record = $record;
        $this->slug = Str::slug($slug);
    }

    /**
     * Modello per cui è stata costruita la notifica.
     *
     * `SendRecordNotificationAction` invia sempre con
     * `Notification::route($channel, $to)->notify(...)`: il notifiable in
     * `NotificationSent` è un `AnonymousNotifiable`, mai `$record`. I listener
     * (es. `UpdateContactInviteCountersListener`) leggono il modello da qui.
     */
    public function getRecord(): Model
    {
        return $this->record;
    }

    /**
     * Get the notification's delivery channels.
     *
     * Determines channels based on the notifiable's routing capabilities.
     * Uses `routeNotificationFor()` method to check if the notifiable supports each channel.
     *
     * @param  object  $notifiable  The entity to be notified
     * @return array<string|class-string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];
        if (! method_exists($notifiable, 'routeNotificationFor')) {
            return $channels;
        }
        if ($notifiable->routeNotificationFor('mail')) {
            $channels[] = 'mail';
        }
        if ($notifiable->routeNotificationFor('sms')) {
            $channels[] = SmsChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * Delegates completely to SpatieEmail for content generation.
     * This follows the Zen Delegation pattern: RecordNotification is a bridge,
     * SpatieEmail handles all template resolution, placeholder replacement, and layout logic.
     *
     * @param  object  $notifiable  The entity to be notified
     * @return SpatieEmail Configured SpatieEmail instance ready to send
     */
    public function toMail(object $notifiable): SpatieEmail
    {
        $email = new SpatieEmail($this->record, $this->slug);
        $email = $email->mergeData($this->data);

        $email = $email->addAttachments($this->attachments);

        // Set recipient for envelope() method in SpatieEmail
        // Note: Laravel's Notification system handles recipient routing via Notification::route(),
        // but we set it here for SpatieEmail's envelope() method which uses $this->recipient
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('mail');
            if (is_string($to) && $to !== '') {
                $email->setRecipient($to);
            }
        }

        return $email;
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): ?SmsData
    {
        $email = new SpatieEmail($this->record, $this->slug);

        $email = $email->mergeData($this->data);

        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        // dddx($notifiable);//Illuminate\Notifications\AnonymousNotifiable
        $to = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('sms');
        }
        $fallbackTo = config('sms.fallback_to');
        if (is_string($fallbackTo)) {
            $to = $fallbackTo;
        }
        if ($to === null) {
            return null;
        }

        // Build SMS content using SpatieEmail (which handles template resolution and placeholder replacement)
        $smsBody = $email->buildSms();

        // Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 17
        // (AC7, 2026-09-15): un survey senza sms_template configurato non lancia
        // nessuna eccezione qui — buildSms() ritorna semplicemente stringa vuota
        // (Mustache::render('', ...)). Senza questo controllo, un SMS reale con
        // corpo vuoto veniva spedito per davvero al gateway. `trim()` per non far
        // passare un corpo fatto di soli spazi.
        if (trim($smsBody) === '') {
            return null;
        }

        // Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 9:
        // il mittente era il letterale 'Xot'. Ora SpatieEmail lo risolve dal
        // MailTemplate (colonna sms_from), con fallback a config('sms.from').
        $smsFrom = $email->buildSmsFrom();

        // Wrap in SmsData for the SmsChannel (ensure all values are strings for type safety)
        /** @var array<string, string> $smsDataArray */
        $smsDataArray = [
            'recipient' => $to,
            'body' => $smsBody];

        if ($smsFrom !== null) {
            $smsDataArray['from'] = $smsFrom;
        }

        return SmsData::from($smsDataArray);
    }

    /**
     * Merge additional data with record attributes for placeholder replacement.
     *
     * @param  array<string, mixed>  $data  Additional data to merge
     * @return $this
     */
    public function mergeData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Add attachments to the notification.
     *
     * @param  array<int, array{path?: string, data?: mixed, as?: string|null, mime?: string|null}>  $attachments
     * @return $this
     */
    public function addAttachments(array $attachments): self
    {
        $this->attachments = array_merge($this->attachments, $attachments);

        return $this;
    }
}
