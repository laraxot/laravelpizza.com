<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\LogFileData;
use Modules\Activity\Exceptions\InvalidLogFileException;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Finder\Finder;

/**
 * Elenca, in modo RICORSIVO, i file `.log` sotto la cartella dei log (storage/logs), comprese le sottocartelle
 * (per esempio `reports/2026/`), dal piu' recente al piu' vecchio.
 *
 * I file il cui percorso reale (link simbolici risolti) esce dalla cartella base non vengono
 * elencati. Il numero di file restituiti e' limitato per non appesantire la pagina.
 */
class ListLogFilesAction
{
    use QueueableAction;

    // ponytail: tetto di 1000 file elencati, nessuna paginazione ne' ricerca per nome;
    // se non bastano, paginare l'albero o filtrare per nome/cartella.
    public const int DEFAULT_LIMIT = 1000;

    /**
     * @return list<LogFileData>
     */
    public function execute(?string $baseDirectory = null, int $limit = self::DEFAULT_LIMIT): array
    {
        try {
            $base = app(ResolveLogDirectoryAction::class)->execute($baseDirectory);
        } catch (InvalidLogFileException) {
            return [];
        }

        $files = [];
        $finder = Finder::create()->files()->in($base)->name('*.log')->ignoreDotFiles(true)->ignoreUnreadableDirs();

        foreach ($finder as $file) {
            $real = $file->getRealPath();
            if ($real === false || ! str_starts_with($real, $base.DIRECTORY_SEPARATOR)) {
                continue;
            }

            $relative = str_replace(DIRECTORY_SEPARATOR, '/', $file->getRelativePathname());
            $directory = dirname($relative);

            $files[] = new LogFileData(
                path: $relative,
                name: $file->getFilename(),
                directory: $directory === '.' ? '' : $directory,
                size: (int) $file->getSize(),
                modifiedAt: (int) $file->getMTime(),
            );
        }

        usort(
            $files,
            static fn (LogFileData $left, LogFileData $right): int => [$right->modifiedAt, $left->path] <=> [$left->modifiedAt, $right->path],
        );

        return array_slice($files, 0, max(1, $limit));
    }
}
