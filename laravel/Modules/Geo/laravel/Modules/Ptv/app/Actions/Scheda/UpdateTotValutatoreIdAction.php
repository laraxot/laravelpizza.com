<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ptv\Support\EloquentModelResolver;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Aggrega i totali per ogni valutatore per i calcoli di performance.
 *
 * Nota: Questa action dipende da modelli specifici di Performance (OrganizzativaTotValutatoreId).
 */
class UpdateTotValutatoreIdAction
{
    use QueueableAction;

    /**
     * @var array<int, string>
     */
    protected array $fields = ['budget_assegnato', 'quota_effettiva', 'resti'];

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $totValutatoreIdClass = EloquentModelResolver::siblingClass($class, 'TotValutatoreId');
        Assert::classExists($totValutatoreIdClass);
        Assert::subclassOf($totValutatoreIdClass, Model::class);

        /** @var class-string<Model> $totValutatoreIdClass */
        $totValutatoreIdClass::where('anno', $year)->delete();
        echo "Cancellati record esistenti per anno: {$year}\n";

        $valutatoriIds = $class::where('anno', $year)
            ->where('type', $type)
            ->whereNotNull('valutatore_id')
            ->distinct()
            ->pluck('valutatore_id');

        foreach ($valutatoriIds as $valutatoreId) {
            $totValutatoreIdClass::create([
                'valutatore_id' => $valutatoreId,
                'anno' => $year,
            ]);
        }

        foreach ($this->fields as $field) {
            $sumExpression = match ($field) {
                'budget_assegnato' => 'SUM(budget_assegnato) as total',
                'quota_effettiva' => 'SUM(quota_effettiva) as total',
                'resti' => 'SUM(resti) as total',
                default => throw new \InvalidArgumentException('Unsupported aggregate field: '.$field),
            };

            $totals = $class::where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->whereNotNull('valutatore_id')
                ->select('valutatore_id')
                ->selectRaw($sumExpression)
                ->groupBy('valutatore_id')
                ->get();

            foreach ($totals as $total) {
                Assert::isInstanceOf($total, Model::class);
                $valutatoreId = $total->getAttribute('valutatore_id');
                if (! is_numeric($valutatoreId)) {
                    echo 'Valutatore ID null trovato durante aggiornamento totali';

                    continue;
                }

                $totalValue = $total->getAttribute('total');
                $normalizedTotal = is_numeric($totalValue) ? $totalValue : 0;

                $totValutatoreIdClass::where('valutatore_id', (int) $valutatoreId)
                    ->where('anno', $year)
                    ->update([
                        "tot_{$field}" => $normalizedTotal,
                        "tot_{$field}_min_punteggio" => $normalizedTotal,
                    ]);
            }

            echo "Aggiornati totali per campo {$field}, anno: {$year}\n";
        }

        $updated = $totValutatoreIdClass::where('anno', $year)
            ->update([
                'delta' => DB::raw('tot_resti / NULLIF(tot_quota_effettiva, 0)'),
                'delta_min_punteggio' => DB::raw('tot_resti_min_punteggio / NULLIF(tot_quota_effettiva_min_punteggio, 0)'),
            ]);

        $totValutatoreIdClass::where('anno', $year)
            ->whereNull('delta')
            ->update(['delta' => 0]);

        $totValutatoreIdClass::where('anno', $year)
            ->whereNull('delta_min_punteggio')
            ->update(['delta_min_punteggio' => 0]);

        echo 'Calcolati coefficienti delta per '.(int) $updated." valutatori, anno: {$year}\n";
    }
}
