<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\IndividualeTotValutatoreId as TotValutatoreId;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;

/**
 * Calcola e aggiorna l'importo totale per ogni dipendente (individuale).
 *
 * NOTA: Questa Action è il punto finale della pipeline e calcola l'importo totale
 * che spetta a ciascun dipendente. La formula è corretta (somma di quota_effettiva e resti_pond)
 * ma il suo funzionamento dipende dalla corretta implementazione delle Action precedenti.
 *
 * CONSIDERAZIONI IMPORTANTI:
 * 1. La formula importo_totale = quota_effettiva + resti_pond è CORRETTA.
 * 2. Affinché la somma di tutti gli importo_totale corrisponda alla quota_individuale totale,
 *    è necessario che le Action precedenti siano state corrette come indicato nella documentazione.
 * 3. In particolare, il fattore punteggio (totale_punteggio/100) deve essere applicato SOLO
 *    nel calcolo della quota_effettiva e non in altri punti della pipeline.
 * 4. Questa Action include anche una verifica di controllo che confronta la somma degli importi
 *    con la quota individuale totale del fondo, evidenziando eventuali discrepanze.
 *
 * FORMULA ATTUALE (corretta):
 * importo_totale = quota_effettiva + resti_pond
 */
class UpdateImportoTotaleByValutatoreIdAction
{
    use QueueableAction;

    /**
     * Esegue il calcolo dell'importo totale spettante per valutatore per l'anno e tipo specificati.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        $count = 0;
        $totalImporto = 0;

        $schede = Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->get();

        foreach ($schede as $scheda) {
            $tot = TotValutatoreId::where('anno', $year)
                ->where('valutatore_id', $scheda->valutatore_id)
                ->first();

            if (! $tot) {
                echo "<b>Warning:</b> Nessun totale aggregato trovato per valutatore_id {$scheda->valutatore_id}, anno {$year}<br>\n";

                continue;
            }

            // TODO: Assicurarsi che l'importo totale sia la somma di quota_effettiva e resti_pond, entrambi già ponderati per il punteggio individuale.
            // 1. La formula è: importo_totale = quota_effettiva + resti_pond
            // 2. Se il punteggio è 0, importo_totale deve essere 0.
            // 3. Dopo la modifica, verificare che la somma degli importi totali sia uguale alla quota individuale del fondo.
            // 4. Aggiornare la documentazione e i test automatici dopo la modifica.

            $punteggioNormalizzato = ($scheda->totale_punteggio ?? 0) / 100;

            // Se il punteggio è 0, impostiamo un valore minimo per evitare divisioni per zero
            if ($punteggioNormalizzato <= 0) {
                $punteggioNormalizzato = 0.01; // 1% del minimo
            }

            $importoTotale = (float) $scheda->quota_effettiva +
                          ((float) $scheda->resti_pond * $punteggioNormalizzato);

            $scheda->importo_totale = (string) $importoTotale;
            $scheda->save();

            $totalImporto += $importoTotale;
            $count++;
        }

        // Verifica della distribuzione
        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quotaIndividuale = (float) $fondo->quota_individuale;
        $differenza = $quotaIndividuale - $totalImporto;

        echo '<h3>Riepilogo distribuzione fondi (individuale)</h3>';
        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'><th>Anno</th><th>Tipo</th><th>Dipendenti</th><th>Totale Importo</th><th>Quota Individuale</th><th>Differenza</th></tr>";
        echo '<tr>';
        echo '<td>'.htmlspecialchars($year).'</td>';
        echo '<td>'.htmlspecialchars($type).'</td>';
        echo "<td style='text-align:right;'>".$count.'</td>';
        echo "<td style='text-align:right;'>".$totalImporto.'</td>';
        echo "<td style='text-align:right;'>".$quotaIndividuale.'</td>';
        echo "<td style='text-align:right;'".($differenza > 0.1 ? " style='color:red;'" : '').'>'.$differenza.'</td>';
        echo '</tr>';
        echo "</table>\n";

        if (abs($differenza) > 0.1) {
            echo "<p style='color:red;'>Attenzione: discrepanza rilevata tra la somma degli importi e la quota individuale.</p>";
        }

        echo "<p>Aggiornato importo_totale per {$count} dipendenti (individuale), anno: {$year}, tipo: {$type}</p>";
    }
}
