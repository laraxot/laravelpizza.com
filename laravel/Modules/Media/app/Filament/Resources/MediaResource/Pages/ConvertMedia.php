<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Modules\Media\Filament\Resources\MediaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ConvertMedia extends XotBaseViewRecord
{
    protected static string $resource = MediaResource::class;

    #[Override]
    public function getInfolistSchema(): array
    {
        return [
            // Definire qui i componenti dell'infolist
        ];
    }
}
