<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Password;
use Modules\User\Actions\Auth\ConsumeAuthSubmissionSlotAction;
use Modules\User\Enums\AuthThrottleScope;
use Modules\User\Filament\Resources\UserResource\Schemas\UserForm;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * ForgotPasswordWidget — invio link reset via email.
 *
 * Schema da `Schemas\UserForm::getForgotPasswordFormSchema()` — SSoT.
 *
 * @property Schema $form
 */
class ForgotPasswordWidget extends XotBaseSchemaWidget
{
    /**
     * @return class-string<UserForm>
     */
    protected static function formClass(): string
    {
        return UserForm::class;
    }

    protected static function schemaMethod(): string
    {
        return 'getForgotPasswordFormSchema';
    }

    /** Vero dopo un invio valido: la vista mostra l'esito neutro in `role="status"`. */
    public bool $sent = false;

    /**
     * Risposta identica per indirizzo registrato, sconosciuto o richiesta frenata dal broker: chi non e' loggato non deve poter
     * scoprire quali email hanno un account (DCP-290, FO-3-01). L'esito di `Password::sendResetLink` non si mostra mai.
     */
    public function sendResetLink(): void
    {
        // Freno per IP e per email PRIMA di validare e di scrivere (SEC-012): il broker limita solo per account, ogni 60 s.
        // Il blocco non dipende dall'esistenza dell'account, quindi non rivela nulla.
        $typed = is_array($this->data) && is_string($this->data['email'] ?? null) ? $this->data['email'] : '';
        $secondsToWait = app(ConsumeAuthSubmissionSlotAction::class)->execute(AuthThrottleScope::ForgotPassword, $typed, request()->ip());
        if ($secondsToWait > 0) {
            $this->addError('data.email', __('user::throttle.auth_form.retry.message', ['seconds' => $secondsToWait]));

            return;
        }

        /** @var array<string, mixed> $data */
        $data = $this->form->getState();
        $email = is_string($data['email'] ?? null) ? $data['email'] : '';

        Password::sendResetLink(['email' => $email]);

        $this->sent = true;
        $this->form->fill();
    }
}
