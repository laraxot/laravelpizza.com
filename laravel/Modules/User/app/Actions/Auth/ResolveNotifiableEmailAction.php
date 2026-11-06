<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Indirizzo a cui spedire le email di autenticazione (reset password, verifica email).
 *
 * Prima `getEmailForPasswordReset()`, se il modello la espone, poi l'attributo `email`.
 * Null se il modello non ha nessuno dei due: chi chiama decide se e come segnalarlo.
 * Un valore che non e' una stringa e' un errore di dati, e la mail non deve partire.
 */
final class ResolveNotifiableEmailAction
{
    use QueueableAction;

    public function execute(Model $notifiable): ?string
    {
        if (method_exists($notifiable, 'getEmailForPasswordReset')) {
            $emailAddress = $notifiable->getEmailForPasswordReset();
            Assert::string($emailAddress, 'Email address must be a string.');

            return $emailAddress;
        }

        if (! isset($notifiable->email)) {
            return null;
        }

        $emailAddress = $notifiable->email;
        Assert::string($emailAddress, 'Email address must be a string.');

        return $emailAddress;
    }
}
