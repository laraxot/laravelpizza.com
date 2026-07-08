<?php

declare(strict_types=1);

// Modules/Pdnd/Services/Anpr/Shared/Enums/ServizioAnprEnum.php

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Enums;

enum SessoEnum: string
{
    case MASCHIO = 'M';
    case FEMMINA = 'F';

    public function getDescription(): string
    {
        return match ($this) {
            self::MASCHIO => 'Maschio',
            self::FEMMINA => 'Femmina',
        };
    }

    public static function fromString(string $sesso): ?self
    {
        return match (strtoupper($sesso)) {
            'M', 'MASCHIO', 'MALE' => self::MASCHIO,
            'F', 'FEMMINA', 'FEMALE' => self::FEMMINA,
            default => null,
        };
    }
}
