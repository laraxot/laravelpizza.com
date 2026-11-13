<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

<<<<<<< .merge_file_OCi5yr
=======
use Modules\Activity\Enums\LogLevelEnum;
>>>>>>> .merge_file_yJRfdq
use Spatie\LaravelData\Data;

/**
 * Tutto cio' che la pagina Log mostra in un render: elenco e albero dei file, opzioni dei filtri e,
 * per il file scelto, la coda letta con le voci filtrate.
 *
 * `tail` e `modifiedAt` sono null se nessun file e' scelto o se il file non e' leggibile (allora `error` e' valorizzato).
 */
final class LogViewerStateData extends Data
{
    /**
     * @param  list<LogFileData>  $files
<<<<<<< .merge_file_OCi5yr
     * @param  list<string>  $levels
=======
     * @param  list<LogLevelEnum>  $levels
>>>>>>> .merge_file_yJRfdq
     * @param  list<int>  $windows  finestre di lettura selezionabili, in KB
     * @param  list<LogEntryData>  $entries
     */
    public function __construct(
        public readonly array $files,
        public readonly LogTreeData $tree,
        public readonly array $levels,
        public readonly array $windows,
        public readonly array $entries,
        public readonly int $total,
        public readonly ?LogTailData $tail,
        public readonly ?int $modifiedAt,
        public readonly ?string $error,
    ) {}
}
