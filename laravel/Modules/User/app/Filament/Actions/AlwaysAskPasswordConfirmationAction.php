<?php

declare(strict_types=1);

namespace Modules\User\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

final class AlwaysAskPasswordConfirmationAction extends Action
{
    protected function setUp(): void
    {
        $this->requiresConfirmation()
            ->modalHeading(__('filament-jet::jet.password_confirmation_modal.heading'))
            ->modalSubheading(__('filament-jet::jet.password_confirmation_modal.description'))
            ->schema([
                TextInput::make('current_password')
                    ->required()
                    ->password()
                    ->rule('current_password'),
            ]);
    }
}
