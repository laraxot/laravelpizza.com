<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources;

use Illuminate\Support\Facades\Config; // Temporaneamente commentato per compatibilità Filament 4.x
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class LangBaseResource extends XotBaseResource
{
    use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    // Temporaneamente commentato per compatibilità Filament 4.x
    public static function getDefaultTranslatableLocale(): string
    {
        return Config::string('app.locale', 'it');
    }

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }
}
