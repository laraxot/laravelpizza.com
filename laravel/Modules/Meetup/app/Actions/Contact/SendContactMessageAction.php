<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Contact;

use Illuminate\Support\Facades\Notification;
use Modules\Meetup\Notifications\ContactMessageNotification;
use Spatie\QueueableAction\QueueableAction;

/**
 * Messaggio dal modulo "Contatti" alla casella degli organizzatori (`xra.contact_email`, di default MAIL_FROM_ADDRESS).
 * Il mittente finisce in Reply-To: chi risponde scrive direttamente alla persona.
 */
class SendContactMessageAction
{
    use QueueableAction;

    public function execute(string $name, string $email, string $message, string $locale): void
    {
        Notification::route('mail', self::recipient())
            ->notify(new ContactMessageNotification($name, $email, $message, $locale));
    }

    public static function recipient(): string
    {
        $configured = config('xra.contact_email');
        if (is_string($configured) && filter_var($configured, FILTER_VALIDATE_EMAIL) !== false) {
            return $configured;
        }

        $from = config('mail.from.address');

        return is_string($from) ? $from : 'hello@example.com';
    }
}
