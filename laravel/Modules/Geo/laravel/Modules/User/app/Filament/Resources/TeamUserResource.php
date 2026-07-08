<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\TeamUser;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * Class TeamUserResource.
 */
final class TeamUserResource extends XotBaseResource
{
    protected static ?string $model = TeamUser::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
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

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['team', 'user']);
    }
}
