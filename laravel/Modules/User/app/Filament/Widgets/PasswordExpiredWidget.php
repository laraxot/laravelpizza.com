<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class PasswordExpiredWidget extends XotBaseWidget
{
    public ?string $current_password = '';
    public ?string $password = '';
    public ?string $passwordConfirmation = '';

    protected string $view = 'user::filament.widgets.password-expired';

    public function getFormSchema(): array
    {
        return array_merge(
            [$this->getCurrentPasswordFormComponent()],
            PasswordData::make()->getPasswordFormComponents('password')
        );
    }

    protected function getCurrentPasswordFormComponent(): TextInput
    {
        return TextInput::make('current_password')
            ->password()
            ->required();
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')->submit('resetPassword');
    }

    protected function getFormActions(): array
    {
        return [$this->getResetPasswordFormAction()];
    }
}
