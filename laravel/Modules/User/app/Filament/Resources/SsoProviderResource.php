<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationManager;
use Modules\User\Filament\Resources\SsoProviderResource\Pages;
use Modules\User\Filament\Resources\SsoProviderResource\RelationManagers\UsersRelationManager;
use Modules\User\Models\SsoProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

class SsoProviderResource extends XotBaseResource
{
    protected static ?string $model = SsoProvider::class;

    /**
     * @return array<string, class-string<RelationManager>>
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [
            'users' => UsersRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSsoProviders::route('/'),
            'create' => Pages\CreateSsoProvider::route('/create'),
            'view' => Pages\ViewSsoProvider::route('/{record}'),
            'edit' => Pages\EditSsoProvider::route('/{record}/edit'),
        ];
    }
}
