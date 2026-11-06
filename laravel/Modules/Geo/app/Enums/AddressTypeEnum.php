<?php

declare(strict_types=1);

namespace Modules\Geo\Enums;

use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum for address types.
 *
 * Uses EnumTrait for getLabel().
 * Configure values in: Modules/Geo/lang/{locale}/enums.php
 */
enum AddressTypeEnum: string implements HasLabel
{
    use EnumTrait;

    case HOME = 'home';
    case WORK = 'work';
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
    case LEGAL = 'legal';
    case OTHER = 'other';

    /**
     * Get all the options as key-value pairs.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::HOME->value => self::HOME->getLabel(),
            self::WORK->value => self::WORK->getLabel(),
            self::BILLING->value => self::BILLING->getLabel(),
            self::SHIPPING->value => self::SHIPPING->getLabel(),
            self::LEGAL->value => self::LEGAL->getLabel(),
            self::OTHER->value => self::OTHER->getLabel(),
        ];
    }
}
