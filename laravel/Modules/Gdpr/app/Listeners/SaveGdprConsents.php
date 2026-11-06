<?php

declare(strict_types=1);

namespace Modules\Gdpr\Listeners;

use Modules\Gdpr\Actions\Consent\SaveRegistrationConsentsAction;
use Modules\User\Events\UserRegistered;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;

/**
 * Listener per salvare i consensi GDPR quando un utente si registra.
 *
 * Questo listener implementa il pattern Event/Listener per decoupling
 * tra il modulo User (core) e il modulo Gdpr (opzionale).
 *
 * Il modulo User non dipende più direttamente dal modulo Gdpr.
 * Quando un utente viene registrato, l'evento UserRegistered viene dispatchato
 * e questo listener (presente solo se il modulo Gdpr è attivo) salva i consensi.
 *
 * @see UserRegistered
 * @see RegisterWidget
 */
class SaveGdprConsents
{
    /**
     * Handle the UserRegistered event.
     */
    public function handle(UserRegistered $event): void
    {
        app(SaveRegistrationConsentsAction::class)->execute(
            $event->user,
            $event->formData,
            $event->ipAddress,
            $event->userAgent,
        );
    }
}
