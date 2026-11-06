<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\SocialiteUserResource\Pages\EditSocialiteUser;
use Modules\User\Filament\Resources\SocialiteUserResource\Pages\ListSocialiteUsers;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class SocialiteUserResource.
 */
class SocialiteUserResource extends XotBaseResource
{
    protected static ?string $model = SocialiteUser::class;

    /**
     * Get the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSocialiteUsers::route('/'),
            'edit' => EditSocialiteUser::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
