<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum per i driver SMS supportati
 *
 * Questo enum centralizza la gestione dei driver SMS disponibili
 * e fornisce metodi helper per ottenere le opzioni e le etichette.
 */
enum SmsDriverEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case SMSFACTOR = 'smsfactor';

    /**
     * Restituisce il driver predefinito dal file di configurazione
     */
    public static function getDefault(): self
    {
        $default = config('sms.default', self::SMSFACTOR->value);

        return self::from(is_string($default) ? $default : self::SMSFACTOR->value);
    }
}
