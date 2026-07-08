<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Sigma\Models\Rep00f;

/**
 * Action to get count of records that exist in indennitaResponsabilita but not in rep00f for given year
 */
class GetCessatiRecordsCount
{
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
        $a = IndennitaResponsabilita::where('anno', $anno)
            ->whereNotIn('matr', $rep00fMatricole)
            ->count();

        return $a;
    }
}
