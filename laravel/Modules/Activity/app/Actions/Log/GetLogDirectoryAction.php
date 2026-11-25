<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Exceptions\InvalidLogFileException;
use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;

/**
 * Percorso reale (link simbolici risolti) della cartella dei log, `storage/logs` salvo diversa indicazione.
 *
 * @see docs/contracts/resolve-log-directory-action.md
 *
 * @contract docs/contracts/resolve-log-directory-action.md
 */
class GetLogDirectoryAction
{
    use QueueableAction;

    /**
     * @throws InvalidLogFileException se la cartella non esiste
     */
    public function execute(?string $directory = null): string
    {
        try {
            $base = realpath($directory ?? storage_path('logs'));
        } catch (FilesystemException) {
            throw InvalidLogFileException::baseDirectoryMissing();
        }

        if (! is_dir($base)) {
            throw InvalidLogFileException::baseDirectoryMissing();
        }

        return $base;
    }
}
