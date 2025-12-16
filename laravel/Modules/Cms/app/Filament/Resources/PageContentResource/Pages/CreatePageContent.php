<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePageContent extends XotBaseCreateRecord
{
    // use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    protected static string $resource = PageContentResource::class;
}
