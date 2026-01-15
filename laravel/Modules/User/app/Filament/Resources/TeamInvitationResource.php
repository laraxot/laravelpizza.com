<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Support\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\TeamInvitationResource\Pages\EditTeamInvitations;
use Modules\User\Filament\Resources\TeamInvitationResource\Pages\ListTeamInvitations;
use Modules\User\Models\TeamInvitation;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TeamInvitationResource.
 */
class TeamInvitationResource extends XotBaseResource
{
    protected static ?string $model = TeamInvitation::class;

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[\Override]
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

    /**
     * Get the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListTeamInvitations::route('/'),
            'edit' => EditTeamInvitations::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['team']);
    }
}
