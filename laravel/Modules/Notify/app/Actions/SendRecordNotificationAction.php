<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Enums\ChannelEnum;
use Modules\Notify\Notifications\RecordNotification;
use Spatie\QueueableAction\QueueableAction;

class SendRecordNotificationAction
{
    use QueueableAction;

    /**
     * Send notifications to a single record for specified channels.
     *
     * @param  Model  $record  The model (e.g., Client) to notify.
     * @param  string  $mailTemplateSlug  the slug identifier of the mail template to use for content
     * @param  array<int, ChannelEnum|string>  $channels  an array of ChannelEnum cases for delivery
     */
    public function execute(
        Model $record,
        string $mailTemplateSlug,
        array $channels,
    ): void {
        // Prepare the Laravel Notification instance
        $notification = new RecordNotification($record, $mailTemplateSlug);

        foreach ($channels as $channelEnum) {
            if (! $channelEnum instanceof ChannelEnum) {
                // Log warning or throw exception if an invalid channel is passed
                continue;
            }

            // Chiave di routing per Notification::route(): deve combaciare con
            // quella che il canale interroga via routeNotificationFor(). Sia
            // RecordNotification::via() sia SmsChannel::send() cercano il
            // destinatario sotto 'sms' (e 'mail' per la posta), cioè il valore
            // del case dell'enum. `getNotificationChannel()` restituisce invece
            // la FQCN del canale custom (SmsChannel::class): passata come chiave
            // di route non verrebbe mai trovata e via() tornerebbe [] — l'SMS
            // sparirebbe in silenzio. Il canale effettivo resta deciso da via().
            $laravelChannel = $channelEnum->value;

            // Determine recipient based on channel and record
            $to = $channelEnum->getRecipient($record);
            if ($to === null || $to === '') {
                // Log: Recipient not found for channel
                continue;
            }

            // Use Notification::route() for both standard and custom channels
            // This is the Laravel-recommended way to send notifications to specific addresses/numbers
            Notification::route($laravelChannel, $to)->notify($notification);
        }
    }
}
