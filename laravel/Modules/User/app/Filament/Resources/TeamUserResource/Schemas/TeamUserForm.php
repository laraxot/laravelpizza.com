<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TeamUserForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public function getFormSchema(): array
    {
        return [
            'team_user' => Section::make('Team User Information')
                ->schema([
                    'team_id' => Select::make('team_id')
                        ->label('Team')
                        ->relationship('team', 'name')
                        ->required()
                        ->searchable(),
                    'user_id' => Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                    'role' => Select::make('role')
                        ->label('Role')
                        ->options([
                            'admin' => 'Admin',
                            'member' => 'Member',
                            'viewer' => 'Viewer',
                        ])
                        ->required()
                        ->searchable()
                        ->helperText('Role of the user in the team'),
                ])
                ->columns(2),
        ];
    }
}
