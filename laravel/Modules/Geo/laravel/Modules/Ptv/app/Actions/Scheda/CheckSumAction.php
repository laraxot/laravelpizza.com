<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Check delle somme.
 *
 * Nota: Questa action dipende da modelli specifici di Performance.
 */
class CheckSumAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $quota_field = 'quota_'.strtolower(class_basename($class));

        Assert::notNull($imp = $class::selectRaw('sum(importo_totale) as tot')
            ->where('ha_diritto', '>', 0)
            ->where('anno', $year)
            ->where('type', $type)
            ->first());
        Assert::isInstanceOf($imp, Model::class);

        $totAttribute = $imp->getAttribute('tot');
        $totDistribuita = is_numeric($totAttribute) ? (float) $totAttribute : 0.0;

        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quota = (float) $fondo->{$quota_field};

        echo '
        <table border="1">
            <tr><th>Quota :</th><th align="right">'.number_format($quota, 2).'</th></tr>
            <tr><th>Quota Distribuita :</th><th align="right">'.number_format($totDistribuita, 2).'</th></tr>
            <tr><th>Diff : </th><th align="right">'.number_format($quota - $totDistribuita, 2).'</th></tr>;
        </table>';
    }
}
