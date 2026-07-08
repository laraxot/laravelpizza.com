<?php

declare(strict_types=1);

namespace Modules\Progressioni\View\Composers;

use Modules\Progressioni\Models\Scheda;

class ProgressioniComposer
{
    /**
     * Undocumented function.
     */
    public function schedeCount(int $year): int
    {
        return Scheda::where('anno', $year)
            // ->where('ha_diritto', '>', 0)
            // ->get()
            ->count();
    }
}
