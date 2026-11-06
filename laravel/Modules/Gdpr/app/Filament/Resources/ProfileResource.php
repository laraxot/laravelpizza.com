<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\CreateProfile;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\EditProfile;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\ListProfiles;
use Modules\Gdpr\Models\Profile;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ProfileResource extends XotBaseResource
{
    protected static ?string $model = Profile::class;

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

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
