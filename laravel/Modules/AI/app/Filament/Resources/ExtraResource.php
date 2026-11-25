<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Xot\Filament\Resources\ExtraResource\Pages\CreateExtra;
use Modules\Xot\Filament\Resources\ExtraResource\Pages\EditExtra;
use Modules\Xot\Filament\Resources\ExtraResource\Pages\ListExtras;
use Modules\Xot\Models\Extra;

class ExtraResource extends XotBaseResource
{
    protected static ?string $model = Extra::class;

    /**
     * @return array<string, class-string<RelationManager>>
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListExtras::route('/'),
            'create' => CreateExtra::route('/create'),
            'edit' => EditExtra::route('/{record}/edit'),
        ];
    }
}
