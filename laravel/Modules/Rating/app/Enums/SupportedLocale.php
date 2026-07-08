<?php

declare(strict_types=1);

namespace Modules\Rating\Enums;

use Modules\Xot\Traits\EnumTrait;

enum SupportedLocale: string
{
    use EnumTrait;

    case IT = 'it';
    case EN = 'en';

    /**
     * Create from string value.
     */
    public static function fromString(string $value): self
    {
        return match ($value) {
            'it' => self::IT,
            'en' => self::EN,
            default => self::IT,
        };
    }
}
