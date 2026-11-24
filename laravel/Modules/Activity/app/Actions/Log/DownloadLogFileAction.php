<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Exceptions\InvalidLogFileException;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Risposta di download per un file di log scelto dall'utente.
 *
 * Usa BinaryFileResponse, che legge il file a blocchi dal disco: niente file intero in memoria, a differenza
 * di un download Livewire (che lo legge tutto e lo codifica in base64). Il percorso passa da
 * {@see ResolveLogFilePathAction}, quindi non si puo' uscire da storage/logs.
 *
<<<<<<< .merge_file_K44dsa
<<<<<<< .merge_file_IxieXr
<<<<<<< .merge_file_apM7PN
<<<<<<< .merge_file_OFTYiy
 * @see docs/contracts/download-log-file-action.md
 *
=======
>>>>>>> .merge_file_IU3ysZ
=======
>>>>>>> .merge_file_GxBVV1
=======
>>>>>>> .merge_file_6gaIrL
=======
>>>>>>> .merge_file_H7Zyr0
 * @contract docs/contracts/download-log-file-action.md
 */
class DownloadLogFileAction
{
    use QueueableAction;

    /**
     * @throws InvalidLogFileException se il file non e' valido
     */
    public function execute(string $file): BinaryFileResponse
    {
        $resolved = app(ResolveLogFilePathAction::class)->execute($file);

        return response()->download(
            $resolved->absolutePath,
            str_replace('/', '_', $resolved->relativePath),
            ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }
}
