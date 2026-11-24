<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Modules\Xot\Traits\EnumTrait;

/**
 * Stub temporaneo per PdfEngineEnum. Da implementare secondo le esigenze reali.
<<<<<<< .merge_file_PjkTXE
 *
 * @see docs/contracts/pdf-engine-enum.md
 *
=======
 * @see docs/contracts/pdf-engine-enum.md
>>>>>>> .merge_file_4dluov
 * @contract docs/contracts/pdf-engine-enum.md
 */
enum PdfEngineEnum: string
{
    use EnumTrait;

    case SPIPU = 'spipu';

    // TODO: Aggiungere altri engine se necessario
}
