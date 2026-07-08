<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Modules\Xot\Traits\EnumTrait;

/**
 * Stub temporaneo per PdfEngineEnum. Da implementare secondo le esigenze reali.
 */
enum PdfEngineEnum: string
{
    use EnumTrait;

    case SPIPU = 'spipu';

    // TODO: Aggiungere altri engine se necessario
}
