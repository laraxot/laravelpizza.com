<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * Un file di log sotto la cartella dei log (storage/logs).
 *
 * `path` e' relativo alla cartella dei log, con `/` come separatore (es. `reports/2026/app.log`).
 */
final class LogFileData extends Data
{
    public function __construct(
        public readonly string $path,
        public readonly string $name,
        public readonly string $directory,
        public readonly int $size,
        public readonly int $modifiedAt,
    ) {}

    /**
     * Percorsi delle cartelle che contengono il file, dalla piu' esterna: `a/b/c.log` => `['a', 'a/b']`.
     *
     * @return list<string>
     */
    public function ancestorFolders(): array
    {
        if ($this->directory === '') {
            return [];
        }

        $ancestors = [];
        $current = '';

        foreach (explode('/', $this->directory) as $segment) {
            $current = $current === '' ? $segment : $current.'/'.$segment;
            $ancestors[] = $current;
        }

        return $ancestors;
    }
}
