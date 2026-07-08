<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\CreateCriteriEsclusione;
use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\EditCriteriEsclusione;
use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\ListCriteriEsclusiones;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Ptv\Filament\Resources\BaseCriteriEsclusioneResource;
use Override;

class CriteriEsclusioneResource extends BaseCriteriEsclusioneResource
{
    protected static ?string $model = CriteriEsclusione::class;

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriEsclusiones::route('/'),
            'create' => CreateCriteriEsclusione::route('/create'),
            'edit' => EditCriteriEsclusione::route('/{record}/edit'),
        ];
    }
}
