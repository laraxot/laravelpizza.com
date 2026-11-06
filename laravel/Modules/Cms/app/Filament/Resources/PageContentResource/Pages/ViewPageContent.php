<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Actions\EditAction;
// use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPageContent extends XotBaseViewRecord
{
    // use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    protected static string $resource = PageContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            // 'locale-switcher' => LocaleSwitcher::make(), // Temporarily disabled until lara-zeus package is working
        ];
    }
}
