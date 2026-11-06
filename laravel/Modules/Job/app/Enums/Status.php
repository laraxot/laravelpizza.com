<?php

declare(strict_types=1);

namespace Modules\Job\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Stato di uno Schedule (colonna `status`, cast in Schedule::casts()).
 *
 * `One` e' il valore legacy '1' della colonna booleana (default della migration create_schedule_table):
 * per lo scheduler equivale a `Active`.
 */
enum Status: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case Active = 'active';
    case Inactive = 'inactive';
    case Trashed = 'trashed';
    case One = '1';

    /** Lo Schedule viene eseguito dallo scheduler. */
    public function isActive(): bool
    {
        return in_array($this, self::activeCases(), true);
    }

    /**
     * Stati che rendono uno Schedule eseguibile (usati da Schedule::scopeActive()).
     *
     * @return list<self>
     */
    public static function activeCases(): array
    {
        return [self::Active, self::One];
    }
}
