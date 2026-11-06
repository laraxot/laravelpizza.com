<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * Un file di log verificato: dentro la cartella dei log, con estensione `.log`, esistente.
 */
final class ResolvedLogFileData extends Data
{
    public function __construct(
        public readonly string $absolutePath,
        public readonly string $relativePath,
    ) {}
}
