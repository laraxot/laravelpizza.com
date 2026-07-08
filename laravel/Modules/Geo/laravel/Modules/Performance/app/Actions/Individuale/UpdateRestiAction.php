<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Calcola i resti per la performance individuale.
 *
 * NOTA: La formula in questa Action (resti = budget_assegnato - quota_effettiva) è CORRETTA
 * e non necessita modifiche. Tuttavia, per funzionare correttamente, deve operare su valori
 * calcolati in modo appropriato dalle Action precedenti.
 *
 * CONSIDERAZIONI IMPORTANTI:
 * 1. Affinché questa formula funzioni correttamente, sia budget_assegnato che quota_effettiva
 *    devono essere calcolati secondo le correzioni proposte nelle rispettive Action.
 * 2. budget_assegnato deve essere calcolato SENZA applicare il fattore punteggio (totale_punteggio/100).
 * 3. quota_effettiva deve essere l'UNICO punto in cui viene applicato il fattore punteggio.
 *
 * FORMULA ATTUALE (corretta):
 * resti = budget_assegnato - quota_effettiva
 *
 * Vedere la documentazione in:
 * - ../../docs/correzioni-pipeline-individuale.md
 * - ../../docs/verifica-matematica-pipeline-individuale.md
 */
class UpdateRestiAction
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
     * Esegue il calcolo dei resti per l'anno e tipo specificati.
     * Output diagnostico via echo (HTML/tabellare).
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        // TODO: Verificare che il calcolo dei resti sia coerente con la pipeline ponderata per il punteggio.
        // 1. La formula resta: resti = budget_assegnato - quota_effettiva
        // 2. Sia budget_assegnato che quota_effettiva devono essere già ponderati per il punteggio individuale.
        // 3. Se il punteggio è 0, i resti devono essere 0.
        // 4. Edge case: budget_assegnato < quota_effettiva, il resto può essere negativo (da gestire secondo policy).
        // 5. Dopo la modifica, verificare che la somma dei resti sia coerente con la quota individuale del fondo.
        // 6. Aggiornare la documentazione e i test automatici dopo la modifica.

        echo "<h3>Aggiornamento resti (individuale) per anno {$year} e tipo {$type}</h3>";

        $tbl = $this->model->getTable();
        $conn = $this->model->getConnection();
        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        // Calcolo resti: budget_assegnato - quota_effettiva
        // Entrambi i valori sono già ponderati per punteggio in azioni precedenti
        $sql = 'update '.$tbl.' as A set resti=budget_assegnato-quota_effettiva where '.$where;

        echo '<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        // Output diagnostico tabellare
        $this->stampaRiepilogoDiagnostico($year, $type);
    }

    /**
     * Stampa il riepilogo diagnostico dei resti calcolati.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    private function stampaRiepilogoDiagnostico(string $year, string $type): void
    {
        $sumResti = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti');

        echo '<p>Somma resti: ['.$sumResti.']</p>';

        $sumBudget = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('budget_assegnato');

        $sumQuota = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('quota_effettiva');

        echo '<p>Verifica: budget_assegnato totale = '.$sumBudget.', quota_effettiva totale = '.$sumQuota.', differenza = '.($sumBudget - $sumQuota).' (dovrebbe essere uguale ai resti totali)</p>';        // Mostra tabella di esempio (primi 10 record)
        $records = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->take(10)
            ->get(['id', 'matr', 'cognome', 'nome', 'budget_assegnato', 'quota_effettiva', 'resti']);

        if ($records->isNotEmpty()) {
            echo "<table border='1'>";
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Matr</th>';
            echo '<th>Cognome</th>';
            echo '<th>Nome</th>';
            echo '<th>Budget assegnato</th>';
            echo '<th>Quota effettiva</th>';
            echo '<th>Resti</th>';
            echo '</tr>';

            foreach ($records as $record) {
                echo '<tr>';
                echo "<td>{$record->id}</td>";
                echo "<td>{$record->matr}</td>";
                echo "<td>{$record->cognome}</td>";
                echo "<td>{$record->nome}</td>";
                echo '<td>'.$record->budget_assegnato.'</td>';
                echo '<td>'.$record->quota_effettiva.'</td>';
                echo '<td>'.$record->resti.'</td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }
}
