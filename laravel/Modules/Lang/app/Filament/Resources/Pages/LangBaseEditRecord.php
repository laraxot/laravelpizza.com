<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;

use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

abstract class LangBaseEditRecord extends XotBaseEditRecord
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
