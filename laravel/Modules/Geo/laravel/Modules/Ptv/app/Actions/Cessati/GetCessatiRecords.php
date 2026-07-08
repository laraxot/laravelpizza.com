<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Illuminate\Support\Collection;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Sigma\Models\Rep00f;

/**
 * Action to get records that exist in indennitaResponsabilita but not in rep00f for given year
 */
class GetCessatiRecords
{
    /**
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
        $rows = IndennitaResponsabilita::where('anno', $anno)
            ->whereNotIn('matr', $rep00fMatricole)
            ->get();

        return $rows;
    }
}
