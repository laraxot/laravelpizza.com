<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class PasswordResetConfirmWidget extends XotBaseWidget
{
    public ?string $token = null;
    public ?string $email = null;
    public string $currentState = 'form';
    public ?string $errorMessage = null;

    protected string $view = 'pub_theme::filament.widgets.auth.password.reset-confirm';

    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->token = $token;
        $this->email = $email;

        if ($this->email) {
            $this->form->fill(['email' => $this->email]);
        }
    }

    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required(),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->same('password'),
        ];
    }

    public function confirmPasswordReset(): void
    {
        if ('form' !== $this->currentState) {
            return;
        }

        $this->currentState = 'loading';
        $data = $this->form->getState();

        $response = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $data['email'],
                'password' => $data['password'],
            ],
            static function (Authenticatable $user, string $password): void {
                $user->setAttribute('password', Hash::make($password));
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            },
        );

        if (Password::PASSWORD_RESET === $response) {
            $this->currentState = 'success';
            Notification::make()->title('Password reset success')->success()->send();
        } else {
            $this->currentState = 'error';
            Notification::make()->title('Password reset error')->danger()->send();
        }
    }
}
