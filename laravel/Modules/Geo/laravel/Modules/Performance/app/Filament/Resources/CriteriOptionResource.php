<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\CreateCriteriOption;
use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\EditCriteriOption;
use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\ListCriteriOptions;
use Modules\Performance\Models\CriteriOption;
use Modules\Ptv\Filament\Resources\BaseCriteriOptionResource;
use Override;

class CriteriOptionResource extends BaseCriteriOptionResource
{
    protected static ?string $model = CriteriOption::class;

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriOptions::route('/'),
            'create' => CreateCriteriOption::route('/create'),
            'edit' => EditCriteriOption::route('/{record}/edit'),
        ];
    }
}
