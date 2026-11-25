<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources;

use Illuminate\Support\Facades\Config; // Temporaneamente commentato per compatibilità Filament 4.x
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Modules\Lang\Actions\GetDefaultTranslatableLocaleAction;
use Modules\Lang\Actions\GetTranslatableLocalesAction;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class LangBaseResource extends XotBaseResource
{
    use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    // Temporaneamente commentato per compatibilità Filament 4.x
    public static function getDefaultTranslatableLocale(): string
    {
        return app(GetDefaultTranslatableLocaleAction::class)->execute(Config::string('app.locale', 'it'));
    }

    /**
     * @return array<int, string>
     */
    public static function getTranslatableLocales(): array
    {
        return app(GetTranslatableLocalesAction::class)->execute();
    }
}
