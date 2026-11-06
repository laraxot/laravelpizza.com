<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * Cartella dell'albero dei file di log mostrato nella pagina Log.
 *
 * La radice ha `name` e `path` vuoti e rappresenta la cartella dei log.
 */
final class LogTreeData extends Data
{
    /**
     * @param  int  $count  numero di file contenuti nella cartella, sottocartelle comprese
     * @param  list<LogTreeData>  $folders  sottocartelle, in ordine naturale (2 prima di 10)
     * @param  list<LogFileData>  $files  file direttamente in questa cartella, dal piu' recente
     */
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly int $count,
        public readonly array $folders,
        public readonly array $files,
    ) {}
}
