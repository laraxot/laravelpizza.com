<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Illuminate\Support\Collection;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Sigma\Models\Rep00f;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action to get records that exist in indennitaResponsabilita but not in rep00f for given year
 *
 * This action follows the cross-database pattern:
 * 1. First get matricole from rep00f (sigma database)
 * 2. Then filter indennitaResponsabilita records (indennita_responsabilita database)
 */
class GetCessatiRecordsAction
{
    use QueueableAction;

    /**
     * Execute the action to get cessati records
     *
     * @param  int  $anno  The year to search for
     * @return Collection<int, IndennitaResponsabilita>
     */
    public function execute(int $anno): Collection
    {
        // Get all matricole from rep00f for the given year
        $rep00fMatricole = Rep00f::where('ente', 90)
            ->where('repann', '')
            ->ofYear($anno)
            ->pluck('matr')
            ->unique()
            ->toArray();

        // Get indennita responsabilita records whose matricole are NOT in rep00f
        return IndennitaResponsabilita::where('anno', $anno)
            ->whereNotIn('matr', $rep00fMatricole)
            ->get();
    }
}
