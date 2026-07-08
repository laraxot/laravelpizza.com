<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Support\EloquentModelResolver;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Ridistribuisce i fondi residui (resti) in base al valutatore_id.
 *
 * Nota: Questa action dipende da modelli specifici di Performance.
 */
class UpdateRestiPondByValutatoreIdAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $totValutatoreIdClass = EloquentModelResolver::siblingClass($class, 'TotValutatoreId');
        Assert::classExists($totValutatoreIdClass);
        Assert::subclassOf($totValutatoreIdClass, Model::class);

        $count = $class::where('anno', $year)
            ->where('type', $type)
            ->update(['resti_pond' => 0]);
        echo "Resettati resti_pond per {$count} record, anno: {$year}, tipo: {$type}\n";

        /** @var class-string<Model> $totValutatoreIdClass */
        $valutatori = $totValutatoreIdClass::where('anno', $year)->get();
        $totalUpdated = 0;

        foreach ($valutatori as $valutatore) {
            Assert::isInstanceOf($valutatore, Model::class);
            $valutatoreId = $valutatore->getAttribute('valutatore_id');
            if (! is_numeric($valutatoreId)) {
                echo 'Valutatore senza ID trovato durante aggiornamento resti_pond';

                continue;
            }

            $deltaMinPunteggio = $valutatore->getAttribute('delta_min_punteggio');
            if (! is_numeric($deltaMinPunteggio)) {
                echo 'Valutatore ID '.$valutatoreId.' ha delta_min_punteggio NULL';

                continue;
            }

            $delta = (float) $deltaMinPunteggio + 0.00114;

            $class::query()
                ->where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->where('valutatore_id', (int) $valutatoreId)
                ->select(['id', 'quota_effettiva'])
                ->chunkById(200, function ($rows) use ($class, $delta, &$totalUpdated): void {
                    foreach ($rows as $row) {
                        $quotaEffettiva = $row->getAttribute('quota_effettiva');
                        if (! is_numeric($quotaEffettiva)) {
                            continue;
                        }

                        $class::whereKey($row->getKey())->update([
                            'resti_pond' => (float) $quotaEffettiva * $delta,
                        ]);
                        $totalUpdated++;
                    }
                });
            echo '<br/>Aggiornati resti_pond per dipendenti del valutatore '.$valutatoreId.', delta: '.$delta."\n";
        }

        echo "Aggiornati resti_pond per un totale di {$totalUpdated} dipendenti, anno: {$year}, tipo: {$type}\n";

        $totResti = (float) $class::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti');
        $totRestiPond = (float) $class::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti_pond');
        $difference = abs($totResti - $totRestiPond);

        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'>"
            .'<th>Anno</th>'
            .'<th>Tipo</th>'
            .'<th>Tot Resti</th>'
            .'<th>Tot Resti Pond</th>'
            .'<th>Differenza</th>'
            .'</tr>';
        echo '<tr>'
            .'<td>'.htmlspecialchars($year).'</td>'
            .'<td>'.htmlspecialchars($type).'</td>'
            ."<td style='text-align:right;'>".number_format($totResti, 4, ',', '.').'</td>'
            ."<td style='text-align:right;'>".number_format($totRestiPond, 4, ',', '.').'</td>'
            ."<td style='text-align:right;'>".number_format($difference, 4, ',', '.').'</td>'
            .'</tr>';
        echo "</table>\n";
    }
}
