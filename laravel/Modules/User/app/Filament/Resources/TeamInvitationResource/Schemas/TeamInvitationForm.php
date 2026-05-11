<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamInvitationResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TeamInvitationForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'team_id' => Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->required(),
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'role' => Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'member' => 'Member',
                    'viewer' => 'Viewer',
                    // Add other roles as defined in your application
                ])
                ->searchable()
                ->required(),
        ];
    }
}
