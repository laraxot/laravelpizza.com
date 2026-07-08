<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Sigma\Models\Rep00f;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action to get count of records that exist in indennitaResponsabilita but not in rep00f for given year
 *
 * This action follows the cross-database pattern:
 * 1. First get matricole from rep00f (sigma database)
 * 2. Then count indennitaResponsabilita records (indennita_responsabilita database)
 */
class GetCessatiRecordsCountAction
{
    use QueueableAction;

    /**
     * Execute the action to get cessati records count
     *
     * @param  int  $anno  The year to search for
     * @return int Number of records found
     */
    public function execute(int $anno): int
    {
        // Get all matricole from rep00f for the given year
        $rep00fMatricole = Rep00f::where('ente', 90)
            ->where('repann', '')
            ->ofYear($anno)
            ->pluck('matr')
            ->unique()
            ->toArray();

        // Count indennita responsabilita records whose matricole are NOT in rep00f
        return IndennitaResponsabilita::where('anno', $anno)
            ->whereNotIn('matr', $rep00fMatricole)
            ->count();
    }
}
