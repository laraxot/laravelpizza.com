<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPageContent extends XotBaseEditRecord
{
    // use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    protected static string $resource = PageContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
