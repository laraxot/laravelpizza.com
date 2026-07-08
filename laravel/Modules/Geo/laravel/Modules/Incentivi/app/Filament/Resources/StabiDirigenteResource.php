<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Pages\CreateStabiDirigente;
use Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Pages\EditStabiDirigente;
use Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Pages\ListStabiDirigentes;
use Modules\Incentivi\Models\StabiDirigente;
use Modules\Ptv\Filament\Resources\BaseStabiDirigenteResource;
use Override;

class StabiDirigenteResource extends BaseStabiDirigenteResource
{
    protected static ?string $model = StabiDirigente::class;

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListStabiDirigentes::route('/'),
            'create' => CreateStabiDirigente::route('/create'),
            'edit' => EditStabiDirigente::route('/{record}/edit'),
        ];
    }
}
