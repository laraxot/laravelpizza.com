<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\LogFileData;
use Modules\Activity\Datas\LogTreeData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Trasforma l'elenco piatto dei file di log (vedi {@see ListLogFilesAction}) in un albero di cartelle,
 * come quello di un editor: prima le sottocartelle, poi i file.
 *
 * - le cartelle sono in ordine naturale e senza distinguere maiuscole/minuscole (252, 253, ..., 1000);
 * - i file di ogni cartella sono dal piu' recente al piu' vecchio (nei log conta l'ultimo);
 * - ogni cartella riporta quanti file contiene, sottocartelle comprese.
 */
class BuildLogFileTreeAction
{
    use QueueableAction;

    /**
     * @param  list<LogFileData>  $files
     */
    public function execute(array $files): LogTreeData
    {
        return $this->buildNode('', '', $files);
    }

    /**
     * @param  list<LogFileData>  $files  tutti i file contenuti in questa cartella, a qualunque profondita'
     */
    private function buildNode(string $name, string $path, array $files): LogTreeData
    {
        $direct = [];
        $childNames = [];

        foreach ($files as $file) {
            $relative = $path === '' ? $file->path : substr($file->path, strlen($path) + 1);
            $slash = strpos($relative, '/');

            if ($slash === false) {
                $direct[] = $file;

                continue;
            }

            $childNames[substr($relative, 0, $slash)] = true;
        }

        // Le chiavi numeriche ('252') diventano int in un array PHP: si riportano a stringa prima di ordinare.
        $names = array_map(strval(...), array_keys($childNames));
        usort($names, strnatcasecmp(...));

        $folders = [];
        foreach ($names as $childName) {
            $childPath = $path === '' ? $childName : $path.'/'.$childName;
            $prefix = $childPath.'/';
            $inChild = array_values(array_filter(
                $files,
                static fn (LogFileData $file): bool => str_starts_with($file->path, $prefix),
            ));

            $folders[] = $this->buildNode($childName, $childPath, $inChild);
        }

        usort(
            $direct,
            static fn (LogFileData $a, LogFileData $b): int => [$b->modifiedAt, $a->name] <=> [$a->modifiedAt, $b->name],
        );

        return new LogTreeData(
            name: $name,
            path: $path,
            count: count($files),
            folders: $folders,
            files: $direct,
        );
    }
}
