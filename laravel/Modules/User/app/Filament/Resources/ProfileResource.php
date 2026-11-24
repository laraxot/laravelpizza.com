<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\User\Filament\Resources\ProfileResource\Pages\CreateProfile;
use Modules\User\Filament\Resources\ProfileResource\Pages\EditProfile;
use Modules\User\Filament\Resources\ProfileResource\Pages\ListProfiles;
use Modules\User\Models\Profile;

class ProfileResource extends BaseProfileResource
{
    protected static ?string $model = Profile::class;

    /**
     * Pagine di questa risorsa. Senza questo metodo valevano quelle di BaseProfileResource, la cui lista
     * risolve la risorsa dal proprio namespace (BaseProfileResource, astratta): /user/admin/profiles dava 500
     * "Target [...BaseProfileResource] is not instantiable".
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListProfiles::route('/'),
            'create' => CreateProfile::route('/create'),
            'edit' => EditProfile::route('/{record}/edit'),
        ];
    }
}
