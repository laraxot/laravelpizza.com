<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enum per i driver SMS supportati
 *
 * Questo enum centralizza la gestione dei driver SMS disponibili
 * e fornisce metodi helper per ottenere le opzioni e le etichette.
 */
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;

    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value . '.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value . '.description');
    }

    /**
     * Restituisce il driver predefinito dal file di configurazione
     *
     * @return self
     */
    public static function getDefault(): self
    {
        $default = config('sms.default', self::SMSFACTOR->value);

        return self::from(is_string($default) ? $default : self::SMSFACTOR->value);
    }
}
