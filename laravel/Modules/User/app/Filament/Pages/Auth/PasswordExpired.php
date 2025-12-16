<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema as DatabaseSchema;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Http\Response\PasswordResetResponse;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Traits\NavigationPageLabelTrait;
use Webmozart\Assert\Assert;

/**
 * @property \Filament\Schemas\Schema $form
 * @property \Filament\Schemas\Schema $editProfileForm
 * @property \Filament\Schemas\Schema $editPasswordForm
 */
class PasswordExpired extends Page implements HasForms
{
    use InteractsWithFormActions;
    use InteractsWithForms;
    use NavigationPageLabelTrait;

    public ?string $current_password = '';

    public ?string $password = '';

    public ?string $passwordConfirmation = '';

    /**
     * @var view-string
     */
    protected string $view = 'user::filament.auth.pages.password-expired';

    protected static bool $shouldRegisterNavigation = false;

    public function getFormSchema(): array
    {
        return [
            $this->getCurrentPasswordFormComponent(),
            ...PasswordData::make()->getPasswordFormComponents('password'),
        ];
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')->submit('resetPassword');
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        $pwd = PasswordData::make();
        $data = $this->form->getState();
        Assert::string($current_password = Arr::get($data, 'current_password'));
        Assert::string($password = Arr::get($data, 'password'));
        $user = Auth::user();
        if (null === $user) {
            return null;
        }

        // check if current password is correct
        if (null === $user->password || ! Hash::check($current_password, $user->password)) {
            Notification::make()
                ->title(__('user::otp.notifications.wrong_password.title'))
                ->body(__('user::otp.notifications.wrong_password.body'))
                ->danger()
                ->send();

            return null;
        }

        // check if new password is different from the current password
        if (null !== $user->password && Hash::check($password, $user->password)) {
            Notification::make()
                ->title(__('user::otp.notifications.same_password.title'))
                ->body(__('user::otp.notifications.same_password.body'))
                ->danger()
                ->send();

            return null;
        }

        // check if both required columns exist in the database
        if (! DatabaseSchema::hasColumn('users', 'password_expires_at')) {
            Notification::make()
                ->title(__('user::otp.notifications.column_not_found.title'))
                ->body(__('user::otp.notifications.column_not_found.body', [
                    'column_name' => 'password_expires_at',
                    'password_column_name' => 'password',
                    'table_name' => 'users',
                ]))
                ->danger()
                ->send();

            return null;
        }

        // get password expiry date and time
        $passwordExpiryDateTime = now()->addDays($pwd->expires_in);

        // Verificare che l'utente esistante e che sia un modello Eloquent
        if (! ($user instanceof Model)) {
            throw new \InvalidArgumentException('L\'utente deve essere un modello Eloquent con il metodo update');
        }

        // set password expiry date and time
        $user->update([
            'password_expires_at' => $passwordExpiryDateTime,
            'is_otp' => false,
            'password' => Hash::make($password),
        ]);

        // Verificare che l'utente implementi l'interfaccia UserContract prima di passarlo all'evento
        if (! ($user instanceof UserContract)) {
            throw new \InvalidArgumentException('L\'utente deve implementare l\'interfaccia UserContract');
        }

        event(new NewPasswordSet($user));

        Notification::make()
            ->title(__('user::otp.notifications.password_reset.success'))
            ->success()
            ->send();

        return new PasswordResetResponse();
    }

    protected function getCurrentPasswordFormComponent(): Component
    {
        return TextInput::make('current_password')
            ->password()
            ->revealable()
            ->required()
            ->validationAttribute(static::trans('fields.current_password.validation_attribute'));
    }

    /**
     * @return array<Action|ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getResetPasswordFormAction(),
        ];
    }
}
