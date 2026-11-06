<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Modules\Media\Filament\Resources\MediaResource\Pages\ConvertMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\CreateMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\EditMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\ListMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\ViewMedia;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MediaResource extends XotBaseResource
{
    protected static ?string $model = Media::class;

    /**
     * @psalm-return array<never, never>
     */
    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * @return array{index: PageRegistration, create: PageRegistration, edit: PageRegistration, view: PageRegistration, convert: PageRegistration}
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMedia::route('/'),
            'create' => CreateMedia::route('/create'),
            'edit' => EditMedia::route('/{record}/edit'),
            'view' => ViewMedia::route('/{record}'),
            'convert' => ConvertMedia::route('/{record}/convert'),
        ];
    }
}
