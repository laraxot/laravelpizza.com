<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources;

use Modules\Media\Filament\Resources\MediaConvertResource\Pages\CreateMediaConvert;
use Modules\Media\Filament\Resources\MediaConvertResource\Pages\EditMediaConvert;
use Modules\Media\Filament\Resources\MediaConvertResource\Pages\ListMediaConverts;
use Modules\Media\Models\MediaConvert;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MediaConvertResource extends XotBaseResource
{
    protected static ?string $model = MediaConvert::class;

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMediaConverts::route('/'),
            'create' => CreateMediaConvert::route('/create'),
            'edit' => EditMediaConvert::route('/{record}/edit'),
        ];
    }
}
