<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;

use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ViewRecord\Concerns\Translatable;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

abstract class LangBaseViewRecord extends XotBaseViewRecord
{
    use Translatable;

    protected static string $resource; // = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ...parent::getHeaderActions(),
            // ...
        ];
    }
}
