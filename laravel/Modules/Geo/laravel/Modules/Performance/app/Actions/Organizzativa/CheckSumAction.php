<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * ---.
 */
class CheckSumAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type): void
    {
        Assert::notNull($imp = Scheda::selectRaw('sum(importo_totale) as tot')
            ->where('ha_diritto', '>', 0)
            ->where('anno', $year)
            ->where('type', $type)
            ->first());
        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quota = (float) $fondo->quota_organizzativa;
        // Trade-off: selectRaw() with 'as tot' creates a dynamic property that PHPStan cannot infer.
        // The property is documented in @property on Organizzativa model, but only exists on query results.
        /** @phpstan-ignore-next-line property.notFound */
        $totValue = (float) $imp->tot;
        echo '
		<table border="1">
			<tr><th>Quota :</th><th align="right">'.number_format($quota, 2).'</th></tr>
			<tr><th>Quota Distribuita :</th><th align="right">'.number_format($totValue, 2).'</th></tr>
			<tr><th>Diff : </th><th align="right">'.number_format($quota - $totValue, 2).'</th></tr>;
		</table>';
    }
}
