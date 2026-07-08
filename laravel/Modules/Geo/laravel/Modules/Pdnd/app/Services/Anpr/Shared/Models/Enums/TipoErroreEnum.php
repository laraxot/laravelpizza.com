<?php

declare(strict_types=1);

// Modules/Pdnd/Services/Anpr/Shared/Enums/ServizioAnprEnum.php

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Enums;

enum TipoErroreEnum: string
{
    case ERRORE = 'ERRORE';
    case ANOMALIA = 'ANOMALIA';
    case WARNING = 'WARNING';

    public function getDescription(): string
    {
        return match ($this) {
            self::ERRORE => 'Errore bloccante che impedisce l\'elaborazione',
            self::ANOMALIA => 'Anomalia che non blocca l\'elaborazione',
            self::WARNING => 'Avviso informativo',
        };
    }

    public function getSeverity(): int
    {
        return match ($this) {
            self::ERRORE => 3,
            self::ANOMALIA => 2,
            self::WARNING => 1,
        };
    }

    public function isBlocking(): bool
    {
        return $this === self::ERRORE;
    }
}
