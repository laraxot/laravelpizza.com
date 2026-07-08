<?php

declare(strict_types=1);

// Modules/Pdnd/Services/Anpr/Shared/Enums/ServizioAnprEnum.php

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Enums;

enum ServizioAnprEnum: string
{
    case C030 = 'C030';
    case C003 = 'C003';
    case C007 = 'C007';
    case C015 = 'C015';

    public function getServicePath(): string
    {
        return match ($this) {
            self::C030 => 'C030-servizioAccertamentoIdUnicoNazionale/v1',
            self::C003 => 'C003-servizioVerificaDichGeneralita/v1',
            self::C007 => 'C007-servizioVerificaDichEsistenzaVita/v1',
            self::C015 => 'C015-servizioAccertamentoGeneralita/v1',
        };
    }

    public function getDisplayName(): string
    {
        return match ($this) {
            self::C030 => 'Accertamento ID Univoco Nazionale (approvazione_autom)',
            self::C003 => 'Verifica dichiarazione generalità  (approvazione_autom)',
            self::C007 => 'Verifica dichiarazione esistenza vita  (approvazione_autom)',
            self::C015 => 'Accertamento generalità (approvazione_autom)',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::C030 => 'Servizio per la consultazione dell\'id univoco nazionale ai fini di un accertamento (approvazione_autom)',
            self::C003 => 'Servizio di verifica dei dati di una dichiarazione di generalità di un cittadino (approvazione_autom)',
            self::C007 => 'Servizio di verifica dei dati di una dichiarazione di esistenza vita di un cittadino (approvazione_autom)',
            self::C015 => 'Servizio per la consultazione dei dati di generalità ai fini di un accertamento (approvazione_autom)',
        };
    }
}
