<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

// // use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable; // Temporaneamente commentato per compatibilità Filament 4.x
use Modules\User\Filament\Resources\BaseProfileResource\Pages\ListProfiles;
use Modules\User\Models\BaseProfile;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseProfileResource extends XotBaseResource
{
    // // use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x // Temporaneamente commentato per compatibilità Filament 4.x

    protected static ?string $model = BaseProfile::class;

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListProfiles::route('/'),
            // 'create' => Pages\CreateProfile::route('/create'),
            // 'edit' => Pages\EditProfile::route('/{record}/edit'),
            // 'getcredits' => Pages\GetCreditProfile::route('/{record}/getcredits'),
        ];
    }
}
