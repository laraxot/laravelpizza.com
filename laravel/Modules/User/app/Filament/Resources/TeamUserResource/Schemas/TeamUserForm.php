<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Schemas;

use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class TeamUserForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'team_user' => XotBaseSection::make('Team User Information')
                ->schema([
                    'team_id' => XotBaseSelect::make('team_id')
                        ->label('Team')
                        ->relationship('team', 'name')
                        ->required()
                        ->searchable(),
                    'user_id' => XotBaseSelect::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                    'role' => XotBaseSelect::make('role')
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
