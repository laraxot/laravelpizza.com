<?php

declare(strict_types=1);

namespace Modules\User\Filament\Actions;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Actions\XotBaseAction;

final class AlwaysAskPasswordConfirmationAction extends XotBaseAction
{
    protected function setUp(): void
    {
        $this->requiresConfirmation()
            ->modalHeading(__('user::always_ask_password_confirmation.modal.heading'))
            ->modalDescription(__('user::always_ask_password_confirmation.modal.description'))
            ->schema([
                TextInput::make('current_password')
                    ->required()
                    ->password()
                    ->rule('current_password'),
            ]);
    }
}
