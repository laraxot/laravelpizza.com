<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Illuminate\Support\Facades\DB;
use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\IndividualeTotValutatoreId as TotValutatoreId;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ridistribuisce i fondi residui (resti) in base al valutatore_id e al punteggio individuale.
 *
 * NOTA: Questa Action opera sui resti calcolati per redistribuirli proporzionalmente tra i dipendenti
 * dello stesso valutatore. La formula è corretta ma il suo funzionamento dipende dalla corretta
 * implementazione delle Action precedenti.
 *
 * CONSIDERAZIONI IMPORTANTI:
 * 1. La formula resti_pond = quota_effettiva * delta_min_punteggio è CORRETTA.
 * 2. Il delta_min_punteggio è calcolato come rapporto tra la somma dei resti e la somma delle quote effettive
 *    per ciascun valutatore, garantendo una redistribuzione proporzionale.
 * 3. Poiché quota_effettiva è l'unico punto in cui il punteggio individuale (totale_punteggio/100) deve
 *    essere applicato, questa formula preserva la correlazione tra merito e importo ridistribuito.
 *
 * FORMULA ATTUALE (corretta):
 * delta_min = somma_resti_valutatore / somma_quote_effettive_valutatore
 * resti_pond = quota_effettiva * delta_min
 *
 * Vedere la documentazione in:
 * - ../../docs/correzioni-pipeline-individuale.md
 * - ../../docs/verifica-matematica-pipeline-individuale.md
 */
class UpdateRestiPondByValutatoreIdAction
{
    use QueueableAction;

    /**
     * Esegue la ridistribuzione dei resti ponderati per valutatore per l'anno e tipo specificati.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        $this->resetRestiPond($year, $type);
        $this->updateRestiPond($year, $type);
        $this->verifyTotalResti($year, $type);
        $this->verifyPunteggioDistribution($year, $type);
    }

    /**
     * Resetta i resti ponderati a zero per l'anno e tipo specificati.
     */
    protected function resetRestiPond(string $year, string $type): void
    {
        $count = Scheda::where('anno', $year)
            ->where('type', $type)
            ->update(['resti_pond' => 0]);
        echo "<p>Resettati resti_pond per {$count} record, anno: {$year}, tipo: {$type}</p>\n";
    }

    /**
     * Aggiorna i resti ponderati considerando il punteggio individuale.
     */
    protected function updateRestiPond(string $year, string $type): void
    {
        // TODO: Assicurarsi che la redistribuzione dei resti ponderati per valutatore sia proporzionale al punteggio individuale.
        // 1. La formula è: resti_pond = quota_effettiva * delta_min_punteggio
        // 2. quota_effettiva deve essere già ponderata per il punteggio.
        // 3. Se il punteggio è 0, resti_pond deve essere 0.
        // 4. Edge case: delta_min_punteggio nullo o divisione per zero, fallback a 0.
        // 5. Dopo la modifica, verificare che la somma dei resti_pond sia coerente con la quota individuale del fondo.
        // 6. Aggiornare la documentazione e i test automatici dopo la modifica.

        $valutatori = TotValutatoreId::where('anno', $year)->get();
        $totalUpdated = 0;
        $totalePonderato = 0;

        // Calcola il totale del punteggio per la normalizzazione
        $totalePunteggio = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('totale_punteggio');

        echo '<h3>Ridistribuzione resti per valutatore con punteggio individuale</h3>';
        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'><th>Valutatore ID</th><th>Delta</th><th>Dipendenti</th><th>Totale Ponderato</th></tr>";

        foreach ($valutatori as $valutatore) {
            if (is_null($valutatore->valutatore_id)) {
                echo '<p style="color:orange;">Attenzione: trovato valutatore senza ID durante l\'aggiornamento dei resti_pond individuali</p>';

                continue;
            }

            if (is_null($valutatore->delta_min_punteggio)) {
                echo "<p style='color:orange;'>Valutatore ID {$valutatore->valutatore_id} ha delta_min_punteggio NULL (individuale)</p>";

                continue;
            }

            $delta = (float) $valutatore->delta_min_punteggio;

            // MODIFICA NECESSARIA: Aggiornamento resti ponderati
            // L'attuale calcolo moltiplica la quota_effettiva per il delta e il punteggio normalizzato
            // ma potrebbe non garantire che la somma dei resti_pond corrisponda al totale dei resti
            //
            // Vecchia formula (da rivedere):
            // 'resti_pond' => DB::raw("quota_effettiva * {$delta} * (CASE WHEN totale_punteggio > 0 THEN totale_punteggio/100 ELSE 0.01 END)")
            //
            // Nuova formula proposta:
            // 1. Calcola il peso del punteggio rispetto al totale
            // 2. Moltiplica per il delta del valutatore
            // 3. Normalizza per garantire che la somma sia corretta
            //
            // Esempio:
            // $pesoPunteggio = "CASE
            //   WHEN totale_punteggio > 0 THEN totale_punteggio / {$totalePunteggio} * COUNT(*) OVER()
            //   ELSE 0.01 / {$totalePunteggio} * COUNT(*) OVER()
            // END";
            // 'resti_pond' => DB::raw("quota_effettiva * {$delta} * {$pesoPunteggio}")

            $updated = DB::update(
                'UPDATE '.(new Scheda)->getTable().' SET resti_pond = quota_effettiva * ? * (CASE WHEN totale_punteggio > 0 THEN totale_punteggio/100 ELSE 0.01 END) WHERE anno = ? AND type = ? AND ha_diritto > 0 AND valutatore_id = ?',
                [$delta, $year, $type, $valutatore->valutatore_id],
            );

            // Calcola il totale ponderato per questo valutatore
            $totaleValutatore = Scheda::where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->where('valutatore_id', $valutatore->valutatore_id)
                ->sum('resti_pond');

            $totalUpdated += $updated;
            $totalePonderato += $totaleValutatore;

            // Stampa il riepilogo per questo valutatore
            echo '<tr>';
            echo '<td>['.$valutatore->valutatore_id.']</td>';
            echo '<td>'.$delta.'</td>';
            echo '<td>'.$updated.'</td>';
            echo '<td>'.$totaleValutatore.'</td>';
            echo '</tr>';
        }

        echo "<tr style='font-weight:bold;'>";
        echo "<td colspan='2'>TOTALE</td>";
        echo "<td style='text-align:right;'>".$totalUpdated.'</td>';
        echo "<td style='text-align:right;'>".$totalePonderato.'</td>';
        echo '</tr>';
        echo '</table>';

        echo "<p>Aggiornati resti_pond per un totale di {$totalUpdated} dipendenti, anno: {$year}, tipo: {$type} (individuale)</p>";
    }

    /**
     * Verifica la correttezza della distribuzione dei resti.
     */
    protected function verifyTotalResti(string $year, string $type): void
    {
        $totResti = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti');

        $totRestiPond = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti_pond');

        $difference = abs($totResti - $totRestiPond);
        $percentDiff = $totResti > 0 ? ($difference / $totResti) * 100 : 0;

        echo '<h3>Verifica distribuzione resti</h3>';
        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'><th>Anno</th><th>Tipo</th><th>Tot Resti</th><th>Tot Resti Pond</th><th>Differenza</th><th>% Diff</th></tr>";

        $rowStyle = $percentDiff > 1 ? "style='color:red;'" : '';

        echo "<tr $rowStyle>";
        echo '<td>'.htmlspecialchars($year).'</td>';
        echo '<td>'.htmlspecialchars($type).'</td>';
        echo '<td>'.$totResti.'</td>';
        echo '<td>'.$totRestiPond.'</td>';
        echo '<td>'.$difference.'</td>';
        echo '<td>'.$percentDiff.'%</td>';
        echo '</tr>';
        echo "</table>\n";

        if ($percentDiff > 1) {
            echo "<p style='color:red;'>Attenzione: discrepanza superiore all'1% tra i resti e i resti ponderati.</p>";
        }
    }

    /**
     * Verifica la distribuzione in base al punteggio.
     */
    protected function verifyPunteggioDistribution(string $year, string $type): void
    {
        $distribuzione = Scheda::selectRaw('FLOOR(totale_punteggio/10)*10 as fascia_punteggio, COUNT(*) as num_dipendenti, SUM(resti_pond) as tot_resti_pond')
            ->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->groupBy('fascia_punteggio')
            ->orderBy('fascia_punteggio')
            ->get();

        if ($distribuzione->isEmpty()) {
            echo '<p>Nessun dato disponibile per la distribuzione del punteggio.</p>';

            return;
        }

        $totaleResti = $distribuzione->sum('tot_resti_pond');

        echo '<h3>Distribuzione dei resti per fascia di punteggio</h3>';
        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'>";
        echo '<th>Fascia Punteggio</th>';
        echo '<th>N° Dipendenti</th>';
        echo '<th>% Dipendenti</th>';
        echo '<th>Totale Resti</th>';
        echo '<th>% Resti</th>';
        echo '<th>Media per Dipendente</th>';
        echo '</tr>';

        foreach ($distribuzione as $riga) {
            // Trade-off: selectRaw() creates dynamic properties (num_dipendenti, tot_resti_pond, fascia_punteggio)
            // via SQL aliases. These are documented in @property on Individuale model but PHPStan cannot
            // statically infer them since they only exist on query result objects, not database rows.
            /** @phpstan-ignore-next-line property.notFound */
            $numDipendenti = (int) $riga->num_dipendenti;
            /** @phpstan-ignore-next-line property.notFound */
            $totRestiPond = (float) $riga->tot_resti_pond;
            /** @phpstan-ignore-next-line property.notFound */
            $fasciaPunteggio = (int) $riga->fascia_punteggio;

            $percentDipendenti = ($numDipendenti / (int) $distribuzione->sum('num_dipendenti')) * 100;
            $percentResti = $totaleResti > 0 ? ($totRestiPond / (float) $totaleResti) * 100 : 0;
            $mediaPerDipendente = $numDipendenti > 0 ? $totRestiPond / $numDipendenti : 0;

            echo '<tr>';
            /** @phpstan-ignore-next-line property.notFound */
            echo '<td>'.($riga->fascia_punteggio === null ? 'N/A' : $fasciaPunteggio.'-'.($fasciaPunteggio + 9)).'</td>';
            echo '<td>['.$numDipendenti.']</td>';
            echo '<td>['.((float) $percentDipendenti).']%</td>';
            echo '<td>['.$totRestiPond.']</td>';
            echo '<td>['.((float) $percentResti).']%</td>';
            echo '<td>['.((float) $mediaPerDipendente).']</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}
