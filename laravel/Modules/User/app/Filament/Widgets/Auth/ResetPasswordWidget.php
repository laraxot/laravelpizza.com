<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Schemas\Schema;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * ResetPasswordWidget — token + nuova password (click sul link email).
 *
 * Schema da `Schemas\UserForm::getResetPasswordFormSchema()` — SSoT.
 *
 * @property Schema $form
 */
class ResetPasswordWidget extends XotBaseSchemaWidget
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
        return 'getResetPasswordFormSchema';
    }

    /**
     * Il token arriva dal percorso `/auth/password/{token}`, l'email (se c'e') dal `?email=` del link.
     */
    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->form->fill([
            'token' => $token ?? (string) request()->route('token'),
            'email' => $email ?? (string) request()->query('email', ''),
        ]);
    }

    /**
     * La password in chiaro arriva dallo schema (nessun hash li'): si cifra una volta sola qui. `setPasswordAttribute` di
     * BaseUser lascia com'e' i valori da 32 caratteri in su, quindi un secondo `Hash::make` salvava l'hash dell'hash (login impossibile).
     * Token scaduto, email sconosciuta e richiesta frenata danno lo stesso messaggio: nessuna enumerazione degli account.
     */
    public function resetPassword(): void
    {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();
        $credentials = [
            'token' => is_string($data['token'] ?? null) ? $data['token'] : '',
            'email' => is_string($data['email'] ?? null) ? $data['email'] : '',
            'password' => is_string($data['password'] ?? null) ? $data['password'] : '',
        ];

        $status = Password::reset($credentials, function (Authenticatable $user, string $password): void {
            if (! $user instanceof Model) {
                return;
            }

            // Lo schema non hasha (niente `dehydrateStateUsing`): qui si hasha una sola volta.
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            $this->addError('data.email', __('user::password_recovery.invalid_link'));

            return;
        }

        session()->flash('status', __('user::password_recovery.reset_done'));
        $this->redirect(LaravelLocalization::localizeURL(route('login'), $this->resolveLocale()));
    }

    /** Lingua della pagina, tra quelle supportate: dopo il reset si torna al login nella stessa lingua. */
    private function resolveLocale(): string
    {
        $locale = trim(app()->getLocale(), '/');

        return in_array($locale, LaravelLocalization::getSupportedLanguagesKeys(), true) ? $locale : 'it';
    }
}
