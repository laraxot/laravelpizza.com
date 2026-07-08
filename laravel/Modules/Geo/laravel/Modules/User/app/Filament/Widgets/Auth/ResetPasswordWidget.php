<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
    protected string $view = 'user::widgets.auth.reset-password-widget';

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

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @return RedirectResponse|void
     */
    public function resetPassword()
    {
        $data = $this->form->getState();

        $reset_data = Arr::only($data, ['email', 'password', 'password_confirmation', 'token']);
        $status = Password::reset($reset_data, function (Authenticatable $user, string $password): void {
            if (! $user instanceof Model) {
                return;
            }

            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        });

        if (Password::PASSWORD_RESET === $status) {
            session()->flash('status', __($status));

            return redirect()->route('login');
        }
        $this->addError('email', __(is_string($status) ? $status : 'passwords.generic_error'));
    }
}
