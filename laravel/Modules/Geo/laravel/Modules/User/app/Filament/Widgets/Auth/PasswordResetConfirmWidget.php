<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use Webmozart\Assert\Assert;

/**
 * PasswordResetConfirmWidget — conferma reset con token via URL.
 *
 * Schema da `Schemas\UserForm::getPasswordResetConfirmFormSchema()` — SSoT.
 *
 * @property Schema $form
 */
class PasswordResetConfirmWidget extends XotBaseSchemaWidget
{
    public ?array $data = [];

    public ?string $token = null;

    public ?string $email = null;

    public string $currentState = 'form';

    public ?string $errorMessage = null;

    /**
     * @return class-string<UserForm>
     */
    protected static function formClass(): string
    {
        return UserForm::class;
    }

    protected static function schemaMethod(): string
    {
        return 'getPasswordResetConfirmFormSchema';
    }

    public function mount(?string $token = null, ?string $email = null): void
    {
        parent::mount();
        $this->token = $token;
        $this->email = $email;

        if ($this->email) {
            $this->form->fill(['email' => $this->email]);
        }
    }

    public function confirmPasswordReset(): void
    {
        if ('form' !== $this->currentState) {
            return;
        }

        $this->currentState = 'loading';

        try {
            $data = $this->form->getState();

            $response = Password::broker()->reset(
                [
                    'token' => $this->token,
                    'email' => $data['email'],
                    'password' => $data['password'],
                ],
                static function (Authenticatable $user, string $password): void {
                    /* @var Model&Authenticatable $user */
                    $user->setAttribute('password', Hash::make($password));
                    $user->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                },
            );

            if (Password::PASSWORD_RESET === $response) {
                $this->currentState = 'success';

                Notification::make()
                    ->title(__('user::auth.password_reset.success.title'))
                    ->body(__('user::auth.password_reset.success.message'))
                    ->success()
                    ->duration(8000)
                    ->send();

                Assert::string($email = $data['email'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));
                /** @var UserContract $user */
                $user = XotData::make()->getUserByEmail($email);
                Assert::isInstanceOf($user, Authenticatable::class);
                Auth::guard()->login($user);

                $this->js('setTimeout(() => { window.location.href = "'.route('login').'"; }, 3000);');
            } else {
                $this->handleResetError(is_string($response) ? $response : 'passwords.generic_error');
            }
        } catch (\Exception $e) {
            $this->handleResetError('passwords.generic_error');
        }
    }

    public function resetForm(): void
    {
        $this->currentState = 'form';
        $this->errorMessage = null;
        $this->form->fill(['email' => $this->email ?? '']);
    }

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function shouldShowForm(): bool
    {
        return \in_array($this->currentState, ['form', 'loading'], strict: true);
    }

    public function isLoading(): bool
    {
        return 'loading' === $this->currentState;
    }

    public function isSuccess(): bool
    {
        return 'success' === $this->currentState;
    }

    public function hasError(): bool
    {
        return 'error' === $this->currentState;
    }

    protected function handleResetError(string $response): void
    {
        $this->currentState = 'error';

        $errorMessages = [
            Password::INVALID_TOKEN => __('user::auth.password_reset.errors.invalid_token'),
            Password::INVALID_USER => __('user::auth.password_reset.errors.invalid_user'),
            'passwords.generic_error' => __('user::auth.password_reset.errors.generic'),
        ];

        $this->errorMessage = $errorMessages[$response] ?? trans($response);

        Notification::make()
            ->title(__('user::auth.password_reset.errors.title'))
            ->body($this->errorMessage)
            ->danger()
            ->duration(10000)
            ->send();
    }
}
