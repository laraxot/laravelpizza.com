<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Illuminate\Support\Facades\DB;
use Modules\Performance\Models\Organizzativa as Scheda;
use Modules\Performance\Models\OrganizzativaTotValutatoreId as TotValutatoreId;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ridistribuisce i fondi residui (resti) in base al valutatore_id.
 *
 * Questa Action ridistribuisce i fondi residui proporzionalmente alla quota effettiva
 * di ogni dipendente, utilizzando i coefficienti delta calcolati a livello di valutatore
 * anziché di stabilimento. Ciò garantisce che i fondi rimangano all'interno dello stesso
 * gruppo di valutazione.
 */
class UpdateRestiPondByValutatoreIdAction
{
    use QueueableAction;

    /**
     * Il modello Scheda per le query.
     */
    protected Scheda $model;

    /**
     * Il modello TotValutatoreId per le query.
     */
    protected TotValutatoreId $totValutatoreIdModel;

    /**
     * Costruttore.
     *
     * @param  Scheda  $schedeModel  Il modello Scheda
     * @param  TotValutatoreId  $totValutatoreIdModel  Il modello TotValutatoreId
     */
    public function __construct(Scheda $schedeModel, TotValutatoreId $totValutatoreIdModel)
    {
        $this->model = $schedeModel;
        $this->totValutatoreIdModel = $totValutatoreIdModel;
    }

    /**
     * Esegue la ridistribuzione dei resti in base al valutatore_id.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance ('dip' per dipendenti)
     */
    public function execute(string $year, string $type): void
    {
        // Reset dei resti ponderati
        $this->resetRestiPond($year, $type);

        // Aggiornamento dei resti ponderati
        $this->updateRestiPond($year, $type);

        // Verifica della somma totale dei resti
        $this->verifyTotalResti($year, $type);
    }

    /**
     * Resetta i resti ponderati a zero.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    protected function resetRestiPond(string $year, string $type): void
    {
        $count = Scheda::where('anno', $year)
            ->where('type', $type)
            ->update(['resti_pond' => 0]);

        echo "Resettati resti_pond per {$count} record, anno: {$year}, tipo: {$type}\n";
    }

    /**
     * Aggiorna i resti ponderati in base al delta del valutatore.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    protected function updateRestiPond(string $year, string $type): void
    {
        // Recupera tutti i valutatori con i relativi delta
        $valutatori = TotValutatoreId::where('anno', $year)->get();

        $totalUpdated = 0;

        // Per ogni valutatore, aggiorna i resti_pond dei dipendenti associati
        foreach ($valutatori as $valutatore) {
            // Salta valutatori senza ID
            if (is_null($valutatore->valutatore_id)) {
                echo 'Valutatore senza ID trovato durante aggiornamento resti_pond';

                continue;
            }

            // Salta valutatori con delta nullo
            if (is_null($valutatore->delta_min_punteggio)) {
                echo "Valutatore ID {$valutatore->valutatore_id} ha delta_min_punteggio NULL";

                continue;
            }

            // Converti esplicitamente a float per sicurezza
            $delta = (float) $valutatore->delta_min_punteggio + 0.00114;

            // Aggiorna i resti_pond per i dipendenti di questo valutatore
            $updated = DB::update(
                'UPDATE '.(new Scheda)->getTable().' SET resti_pond = quota_effettiva * ? WHERE anno = ? AND type = ? AND ha_diritto > 0 AND valutatore_id = ?',
                [$delta, $year, $type, $valutatore->valutatore_id],
            );

            $totalUpdated += $updated;

            echo "<br/>Aggiornati resti_pond per {$updated} dipendenti del valutatore {$valutatore->valutatore_id}, delta: {$delta}\n";
        }

        echo "Aggiornati resti_pond per un totale di {$totalUpdated} dipendenti, anno: {$year}, tipo: {$type}\n";
    }

    /**
     * Verifica che la somma dei resti_pond corrisponda alla somma dei resti.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    /**
     * Verifica che la somma dei resti_pond corrisponda alla somma dei resti.
     * Mostra tutte le informazioni principali in formato tabellare dettagliato.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    protected function verifyTotalResti(string $year, string $type): void
    {
        // Calcola la somma totale dei resti
        $totResti = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti');
        // Calcola la somma totale dei resti_pond
        $totRestiPond = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti_pond');
        // Calcola la differenza
        $difference = abs($totResti - $totRestiPond);

        // Output HTML tabellare dettagliato
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
