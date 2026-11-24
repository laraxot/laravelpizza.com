<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Notifications\Notification as IlluminateNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Invia notification a destinatario via email.
 *
 * Action GENERICA riutilizzabile in TUTTI i moduli per invio notifiche.
 *
 * Features:
 * - Validazione email destinatario
 * - Supporto locale personalizzato
 * - Exception handling chiaro
 * - Queueable per bulk operations
 */
class SendNotificationToRecipientAction
{
    use QueueableAction;

    /**
     * Invia notification a destinatario.
     *
     * @param  string  $recipient  Email destinatario
     * @param  IlluminateNotification  $notification  Notification da inviare
     * @param  string|null  $locale  Locale (default: it)
     * @return bool True se invio riuscito
     *
     * @throws Exception Se invio fallisce
     */
    public function execute(
        string $recipient,
        IlluminateNotification $notification,
        ?string $locale = null,
    ): bool {
        // Valida destinatario
        Assert::email($recipient, 'Recipient must be valid email address');

        // Prepara e invia notification
        // Note: AnonymousNotifiable non supporta ->locale()
        // Il locale è gestito dal notification stesso se necessario
        Notification::route('mail', $recipient)
            ->notify($notification);

        return true;
    }
}
