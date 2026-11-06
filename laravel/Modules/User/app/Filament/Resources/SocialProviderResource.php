<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\User\Filament\Resources\SocialProviderResource\Pages\CreateSocialProvider;
use Modules\User\Filament\Resources\SocialProviderResource\Pages\EditSocialProvider;
use Modules\User\Filament\Resources\SocialProviderResource\Pages\ListSocialProviders;
use Modules\User\Filament\Resources\SocialProviderResource\Pages\ViewSocialProvider;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property SocialProvider $record
 *                                  -------
 */
class SocialProviderResource extends XotBaseResource
{
    protected static ?string $model = SocialProvider::class;

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSocialProviders::route('/'),
            'create' => CreateSocialProvider::route('/create'),
            'view' => ViewSocialProvider::route('/{record}'),
            'edit' => EditSocialProvider::route('/{record}/edit'),
        ];
    }
}
