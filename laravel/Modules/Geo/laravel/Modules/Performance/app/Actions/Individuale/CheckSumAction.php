<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;

/**
 * Verifica la coerenza tra la somma degli importi individuali e la quota individuale del fondo performance.
 */
class CheckSumAction
{
    use QueueableAction;

    /**
     * Esegue il riepilogo finale dei dati individuali per verifica amministrativa.
     * Output diagnostico via echo (HTML/tabellare).
     */
    public function execute(string $year, string $type): void
    {
        // TODO: Usare questa action come validazione finale della pipeline.
        // 1. Dopo aver eseguito tutte le action, la somma di importo_totale deve essere uguale alla quota individuale del fondo.
        // 2. Se il delta non è zero, controllare che tutte le action precedenti applichino la ponderazione per punteggio.
        // 3. Edge case: arrotondamenti, piccoli delta trascurabili sono accettabili, ma grandi differenze indicano errore di logica.
        // 4. Aggiornare la documentazione e i test automatici dopo la modifica.

        // [MODIFICA] Questa azione verifica che la somma degli importo_totale sia uguale alla quota individuale del fondo.
        // Se il delta è significativo, c'è un errore in uno degli step della pipeline (manca la ponderazione per punteggio o altro bug).
        $sumImportoTotale = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('importo_totale');
        // Utilizziamo il modello PerformanceFondo invece della query diretta DB::table
        // per garantire la corretta connessione e rispettare gli standard Laraxot PTVX
        $sumQuotaIndividuale = (float) PerformanceFondo::where('anno', $year)
            ->value('quota_individuale');
        $delta = abs($sumImportoTotale - $sumQuotaIndividuale);
        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'><th>Anno</th><th>Tipo</th><th>Somma Importo Totale</th><th>Quota Individuale</th><th>Delta</th></tr>";
        echo '<tr><td>'.htmlspecialchars($year).'</td><td>'.htmlspecialchars($type)."</td><td style='text-align:right;'>".$sumImportoTotale."</td><td style='text-align:right;'>".$sumQuotaIndividuale."</td><td style='text-align:right;'>".$delta.'</td></tr>';
        echo "</table>\n";
        if ($delta > 0.1) {
            echo "<b style='color:red;'>Warning:</b> Discrepanza nella redistribuzione individuale: delta = ".$delta."<br>\n";
        } else {
            echo "Verifica OK: la somma degli importi individuali corrisponde alla quota individuale.<br>\n";
        }
    }
}
