<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * Le voci di un log che corrispondono ai filtri, dalla piu' recente, limitate a un massimo.
 *
 * `total` sono le voci che corrispondono, prima del limite.
 */
final class FilteredLogEntriesData extends Data
{
    /**
     * @param  list<LogEntryData>  $entries
     */
    public function __construct(
        public readonly array $entries,
        public readonly int $total,
    ) {}
}
