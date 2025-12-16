<?php

declare(strict_types=1);

namespace Modules\User\Enums\Enums;

use Filament\Support\Contracts\HasLabel;

enum LanguageEnum: string implements HasLabel
{
    case ITALIAN = 'it';
    case ENGLISH = 'en';
    case SPANISH = 'es';
    case FRENCH = 'fr';
    case GERMAN = 'de';

    public function getLabel(): string
    {
        return match ($this) {
            self::ITALIAN => 'Italiano',
            self::ENGLISH => 'English',
            self::SPANISH => 'Español',
            self::FRENCH => 'Français',
            self::GERMAN => 'Deutsch',
        };
    }
}
