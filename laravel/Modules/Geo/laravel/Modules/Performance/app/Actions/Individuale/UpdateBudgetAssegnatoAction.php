<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Calcola e aggiorna il budget assegnato per la pipeline individuale.
 *
 * PROBLEMA IDENTIFICATO: Questa action attualmente include il fattore punteggio
 * (totale_punteggio/100) nel calcolo del budget assegnato. Questo causa una ponderazione
 * errata che altera la distribuzione finale perché il punteggio viene applicato in più punti.
 *
 * MODIFICA NECESSARIA: Il fattore punteggio (totale_punteggio/100) NON deve essere applicato
 * qui, ma solo nel calcolo della quota effettiva. Va rimosso dalla formula di budget_assegnato.
 *
 * FORMULA ATTUALE:
 * budget_assegnato = quota_teorica/365*(gg_presenza_dalal*perc_parttimepond_dalal*(totale_punteggio/100))
 *
 * FORMULA CORRETTA:
 * budget_assegnato = quota_teorica/365*(gg_presenza_dalal*perc_parttimepond_dalal)
 *
 * MOTIVAZIONE: Il budget assegnato deve essere calcolato senza considerare il punteggio
 * individuale, proprio come avviene nella pipeline Organizzativa. Il punteggio verrà applicato
 * solo nel calcolo della quota effettiva per garantire una distribuzione corretta.
 */
class UpdateBudgetAssegnatoAction
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
     * Esegue l'aggiornamento del budget assegnato per l'anno e tipo specificati.
     * Output diagnostico via echo (HTML/tabellare).
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        echo "<h3>Aggiornamento budget assegnato (individuale) per anno {$year} e tipo {$type}</h3>";

        $tbl = $this->model->getTable();
        $conn = $this->model->getConnection();
        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        // TODO: Assicurarsi che il calcolo del budget assegnato sia basato sulla quota teorica già ponderata per il punteggio individuale.
        // 1. La formula corretta è: budget_assegnato = quota_teorica / 365 * (gg_presenza_dalal * perc_parttimepond_dalal)
        // 2. quota_teorica deve essere già personalizzata per ogni dipendente in base al suo punteggio.
        // 3. Non moltiplicare di nuovo per (totale_punteggio / 100) se già applicato in quota_teorica.
        // 4. Se il punteggio è 0, il budget assegnato deve essere 0.
        // 5. Dopo la modifica, verificare che la somma dei budget assegnati sia coerente con la quota individuale del fondo.
        // 6. Aggiornare la documentazione e i test automatici dopo la modifica.

        // Calcolo budget assegnato con ponderazione punteggio individuale (totale_punteggio/100)
        /*
        PROBLEMA: La formula attuale include (totale_punteggio/100) nel calcolo del budget_assegnato.
        Questo porta a una seconda ponderazione per punteggio che non dovrebbe esserci a questo livello.

        MODIFICA NECESSARIA: Rimuovere il fattore (totale_punteggio/100) dalla formula.

        FORMULA CORRETTA:
        $sql = 'update '.$tbl.' as A set budget_assegnato=quota_teorica/365*(gg_presenza_dalal*perc_parttimepond_dalal)
        where '.$where;
        */

        $sql = 'update '.$tbl.' as A set budget_assegnato=quota_teorica/365*(gg_presenza_dalal*perc_parttimepond_dalal*(totale_punteggio/100))
        where '.$where;
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $this->stampaRiepilogoDiagnostico($year, $type);
    }

    /**
     * Stampa il riepilogo diagnostico del budget assegnato.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    private function stampaRiepilogoDiagnostico(string $year, string $type): void
    {
        // Assicuriamo che sia un float prima di passarlo a number_format
        $sumBudgetAssegnato = (float) $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('budget_assegnato');

        echo '<p>Somma budget_assegnato: '.$sumBudgetAssegnato.'</p>';

        // Verifica quota individuale per controllo finale
        $scheda = $this->model->where('anno', $year)
            ->where('type', $type)
            ->first();

        if ($scheda) {
            $annoVal = $scheda->anno;
            echo "<p>Anno di riferimento: {$annoVal}</p>";
        }

        // Mostra tabella di esempio (primi 10 record)
        $records = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->take(10)
            ->get(['id', 'matr', 'cognome', 'nome', 'quota_teorica', 'gg_presenza_dalal',
                'perc_parttimepond_dalal', 'totale_punteggio', 'budget_assegnato']);

        if ($records->isNotEmpty()) {
            echo "<table border='1'>";
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Matr</th>';
            echo '<th>Cognome</th>';
            echo '<th>Nome</th>';
            echo '<th>Quota teorica</th>';
            echo '<th>Giorni presenza</th>';
            echo '<th>% Part-time</th>';
            echo '<th>Punteggio</th>';
            echo '<th>Budget assegnato</th>';
            echo '</tr>';

            foreach ($records as $record) {
                // Garantiamo sempre che i valori siano convertiti in float prima di number_format
                $quotaTeorica = (float) ($record->quota_teorica ?? 0);
                $budgetAssegnato = (float) ($record->budget_assegnato ?? 0);

                echo '<tr>';
                echo "<td>{$record->id}</td>";
                echo "<td>{$record->matr}</td>";
                echo "<td>{$record->cognome}</td>";
                echo "<td>{$record->nome}</td>";
                echo '<td>['.((float) $quotaTeorica).']</td>';
                echo "<td>{$record->gg_presenza_dalal}</td>";
                echo "<td>{$record->perc_parttimepond_dalal}</td>";
                echo "<td>{$record->totale_punteggio}</td>";
                echo '<td>['.((float) $budgetAssegnato).']</td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }
}
