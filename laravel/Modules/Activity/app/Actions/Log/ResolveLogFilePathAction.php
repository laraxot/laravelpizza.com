<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\ResolvedLogFileData;
use Modules\Activity\Exceptions\InvalidLogFileException;
use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;

/**
 * Traduce il percorso relativo di un file di log scelto dall'utente nel percorso reale sul disco,
 * garantendo che il file stia DENTRO la cartella dei log (storage/logs) e abbia estensione .log.
 *
 * E' l'unico punto della pagina Log che trasforma input dell'utente in un percorso su disco:
 * lettura e download passano tutti da qui. Regole:
 * - niente percorsi vuoti o con byte nullo;
 * - solo estensione .log (controllata sia sull'input sia sul file risolto);
 * - `realpath()` risolve `..` e link simbolici: se il risultato non e' dentro la cartella base
 *   (per esempio un link simbolico verso /etc) il file e' rifiutato.
 */
class ResolveLogFilePathAction
{
    use QueueableAction;

    /**
     * @throws InvalidLogFileException
     */
    public function execute(string $relativePath, ?string $baseDirectory = null): ResolvedLogFileData
    {
        $base = app(ResolveLogDirectoryAction::class)->execute($baseDirectory);

        if ($relativePath === '' || str_contains($relativePath, "\0")) {
            throw InvalidLogFileException::invalidPath();
        }

        if (! $this->hasLogExtension($relativePath)) {
            throw InvalidLogFileException::notALogFile($relativePath);
        }

        $resolved = $this->realpathOrNull($base.DIRECTORY_SEPARATOR.$relativePath);
        if ($resolved === null || ! is_file($resolved)) {
            throw InvalidLogFileException::notFound($relativePath);
        }

        if (! str_starts_with($resolved, $base.DIRECTORY_SEPARATOR)) {
            throw InvalidLogFileException::outsideLogDirectory($relativePath);
        }

        if (! $this->hasLogExtension($resolved)) {
            throw InvalidLogFileException::notALogFile($relativePath);
        }

        return new ResolvedLogFileData(
            absolutePath: $resolved,
            relativePath: str_replace(DIRECTORY_SEPARATOR, '/', substr($resolved, strlen($base) + 1)),
        );
    }

    /**
     * `Safe\realpath()` lancia un'eccezione se il percorso non esiste: qui diventa `null`.
     */
    private function realpathOrNull(string $path): ?string
    {
        try {
            return realpath($path);
        } catch (FilesystemException) {
            return null;
        }
    }

    private function hasLogExtension(string $path): bool
    {
        return mb_strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'log';
    }
}
