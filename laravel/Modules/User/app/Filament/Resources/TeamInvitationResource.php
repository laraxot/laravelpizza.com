<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
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
