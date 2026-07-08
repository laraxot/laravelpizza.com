<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Calcola la quota effettiva per la performance individuale.
 *
 * NOTA: In questa Action il fattore punteggio (totale_punteggio/100) è CORRETTAMENTE applicato,
 * poiché è qui che deve essere considerato. La formula è matematicamente corretta.
 *
 * La ponderazione per punteggio (totale_punteggio/100) deve avvenire SOLO in questa Action e
 * non dev'essere applicata nelle Action precedenti (UpdateQuotaTeoricaAction e UpdateBudgetAssegnatoAction).
 *
 * FORMULA CORRETTA (già implementata):
 * quota_effettiva = quota_teorica/365*((totale_punteggio/100) * gg_presenza_eff * perc_parttimepond_dalal)
 *
 * MOTIVAZIONE: È qui che si applica il punteggio individuale alla quota effettiva, riflettendo
 * così la valutazione della performance. Questo è l'unico punto in cui deve essere presente questa ponderazione.
 */
class UpdateQuotaEffettivaAction
{
    use QueueableAction;

    /**
     * Il modello Scheda per le query.
     */
    protected Scheda $model;

    /**
     * Costruttore.
     *
     * @param  Scheda  $schedeModel  Il modello Scheda
     */
    public function __construct(Scheda $schedeModel)
    {
        $this->model = $schedeModel;
    }

    /**
     * Esegue il calcolo della quota effettiva per l'anno e tipo specificati.
     * Output diagnostico via echo (HTML/tabellare).
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        echo "<h3>Aggiornamento quota effettiva (individuale) per anno {$year} e tipo {$type}</h3>";

        $tbl = $this->model->getTable();
        $conn = $this->model->getConnection();
        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        // Calcolo gg_presenza_eff (giorni di presenza effettivi, sottratte le assenze)
        $assenza = '(gg_assenza_dalal+round(hh_assenza_dalal/6.0,0))';
        $gg_presenza_eff = '(gg_presenza_dalal-'.$assenza.')';

        // Decurtazione percentuale (default 1, può essere personalizzato da tabella peso_assenze)
        $decurtazione_perc = 1;

        // Punteggio percentuale (normalizzato su 100)
        $punteggio_perc = '(totale_punteggio/100)';

        // TODO: Assicurarsi che la quota effettiva sia calcolata sulla quota teorica già ponderata per il punteggio individuale.
        // 1. La formula corretta è: quota_effettiva = quota_teorica / 365 * (gg_presenza_eff * perc_parttimepond_dalal)
        // 2. quota_teorica deve essere già personalizzata per ogni dipendente in base al suo punteggio.
        // 3. Non moltiplicare di nuovo per (totale_punteggio / 100) se già applicato in quota_teorica.
        // 4. Se il punteggio è 0, la quota effettiva deve essere 0.
        // 5. Edge case: gg_presenza_eff può essere negativo se le assenze superano le presenze, gestire con max(0, gg_presenza_eff).
        // 6. Dopo la modifica, verificare che la somma delle quote effettive sia coerente con la quota individuale del fondo.
        // 7. Aggiornare la documentazione e i test automatici dopo la modifica.

        // MODIFICA NECESSARIA: Calcolo della quota effettiva
        // L'attuale formula moltiplica per (totale_punteggio/100) ma questo potrebbe non essere corretto
        // se la quota_teorica è già stata ponderata per il punteggio
        //
        // Vecchia formula (da rivedere):
        // quota_effettiva = quota_teorica/365 * (totale_punteggio/100) * decurtazione_perc * gg_presenza_eff * perc_parttimepond_dalal
        //
        // Nuova formula proposta:
        // 1. Se quota_teorica è già ponderata per il punteggio, rimuovere la moltiplicazione per punteggio_perc
        // 2. Aggiungere controlli per evitare valori negativi (max(0, gg_presenza_eff))
        // 3. Gestire il caso in cui il punteggio sia 0 o NULL
        //
        // Esempio:
        // $sql = 'update '.$tbl.' as A
        //   set quota_effettiva =
        //   CASE
        //     WHEN totale_punteggio IS NULL OR totale_punteggio <= 0 THEN 0
        //     ELSE quota_teorica / 365 * '.$decurtazione_perc.' *
        //          GREATEST(0, '.$gg_presenza_eff.') * perc_parttimepond_dalal
        //   END';

        // Formula quota effettiva con ponderazione per punteggio
        $sql = 'update '.$tbl.' as A set quota_effettiva=quota_teorica/365*('
              .$punteggio_perc.'*'.$decurtazione_perc.'*'.$gg_presenza_eff.'*perc_parttimepond_dalal)'
              .' where '.$where;

        echo '<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        // Output diagnostico tabellare
        $this->stampaRiepilogoDiagnostico($year, $type);
    }

    /**
     * Stampa il riepilogo diagnostico delle quote effettive calcolate.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    private function stampaRiepilogoDiagnostico(string $year, string $type): void
    {
        $sumQuotaEffettiva = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('quota_effettiva');

        echo '<p>Somma quota_effettiva: ['.$sumQuotaEffettiva.']</p>';

        // Mostra tabella di esempio (primi 10 record)
        $records = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->take(10)
            ->get(['id', 'matr', 'cognome', 'nome', 'quota_teorica', 'budget_assegnato',
                'gg_presenza_dalal', 'gg_assenza_dalal', 'totale_punteggio', 'quota_effettiva']);

        if ($records->isNotEmpty()) {
            echo "<table border='1'>";
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Matr</th>';
            echo '<th>Cognome</th>';
            echo '<th>Nome</th>';
            echo '<th>Quota teorica</th>';
            echo '<th>Budget</th>';
            echo '<th>Giorni presenze</th>';
            echo '<th>Giorni assenza</th>';
            echo '<th>Punteggio</th>';
            echo '<th>Quota effettiva</th>';
            echo '</tr>';

            foreach ($records as $record) {
                echo '<tr>';
                echo "<td>{$record->id}</td>";
                echo "<td>{$record->matr}</td>";
                echo "<td>{$record->cognome}</td>";
                echo "<td>{$record->nome}</td>";
                echo '<td>'.$record->quota_teorica.'</td>';
                echo '<td>'.$record->budget_assegnato.'</td>';
                echo "<td>{$record->gg_presenza_dalal}</td>";
                echo "<td>{$record->gg_assenza_dalal}</td>";
                echo "<td>{$record->totale_punteggio}</td>";
                echo '<td>'.$record->quota_effettiva.'</td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }
}
