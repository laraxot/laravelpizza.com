<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Http\Response\PasswordResetResponse;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationPageLabelTrait;
use Webmozart\Assert\Assert;

class PasswordExpired extends XotBasePage
{
    use InteractsWithFormActions;
    use NavigationPageLabelTrait;

    protected string $view = 'user::filament.auth.pages.password-expired';
    protected static bool $shouldRegisterNavigation = false;

    public function getFormSchema(): array
    {
        return array_merge(
            $this->getCurrentPasswordFormComponent(),
            PasswordData::make()->getPasswordFormComponents('password')
        );
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')->submit('resetPassword');
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        $pwd = PasswordData::make();
        $data = $this->form->getState();
        Assert::string($currentPassword = Arr::get($data, 'current_password'));
        Assert::string($password = Arr::get($data, 'password'));
        $user = Auth::user();
        if (null === $user) {
            return null;
        }

        if (! Hash::check($currentPassword, $user->password)) {
            Notification::make()->title(__('user::otp.notifications.wrong_password.title'))->danger()->send();

            return null;
        }

        $user->update([
            'password_expires_at' => now()->addDays($pwd->expires_in),
            'is_otp' => false,
            'password' => Hash::make($password),
        ]);

        if ($user instanceof UserContract) {
            event(new NewPasswordSet($user));
        }

        Notification::make()->title(__('user::otp.notifications.password_reset.success'))->success()->send();

        return new PasswordResetResponse();
    }

    protected function getCurrentPasswordFormComponent(): array
    {
        return [
            TextInput::make('current_password')
                ->password()
                ->revealable()
                ->required(),
        ];
    }

    protected function getFormActions(): array
    {
        return [$this->getResetPasswordFormAction()];
    }
}
