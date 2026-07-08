<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\IndividualeCatCoeff as CatCoeff;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Calcola la quota teorica per ciascuna scheda di performance individuale.
 *
 * Questa action calcola la quota teorica spettante per ogni dipendente nella pipeline individuale,
 * ponderando i risultati per il punteggio individuale (totale_punteggio/100).
 * Segue il pattern di Organizzativa ma con aggiustamenti per la pipeline Individuale.
 */
class UpdateQuotaTeoricaAction
{
    use QueueableAction;

    /**
     * Esegue il calcolo della quota teorica per la performance individuale.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance (es: 'ind')
     */
    public function execute(string $year, string $type): void
    {
        $tbl_categoria_coeff = app(CatCoeff::class)->getTable();
        $model = app(Scheda::class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        $rows = Scheda::where('anno', $year)
            ->where('type', $type)
            ->get();

        $fields = ['gg_presenza_dalal', 'perc_parttimepond_dalal'];
        $html = '<table border="1">';
        foreach ($rows as $k => $row) {
            if ($k === 0) {
                $html .= '<tr>';
                foreach ($fields as $field) {
                    $html .= '<th>'.$field.'</th>';
                }

                $html .= '</tr>';
            }

            $html .= '<tr>';
            foreach ($fields as $field) {
                $tmp = $row->{$field}; // forzo mutator
                $html .= '<td>'.$tmp.'</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</table>';
        \Illuminate\Support\Facades\Log::debug('UpdateQuotaTeoricaAction debug table', ['html' => $html]);

        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni = COALESCE((
            select sum(gg_presenza_dalal) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $res = $conn->statement($sql);

        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni_pt = COALESCE((
            select sum(gg_presenza_dalal*perc_parttimepond_dalal) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $res = $conn->statement($sql);

        // TODO: Applicare la ponderazione per il punteggio individuale in ogni step della pipeline.
        // 1. Quando si calcola la quota teorica per ogni dipendente, bisogna moltiplicare la quota teorica di categoria per (totale_punteggio / 100).
        // 2. La quota teorica che viene assegnata a ciascun dipendente deve essere personalizzata in base al suo punteggio.
        // 3. Se il punteggio è 0, la quota teorica deve essere 0. Se è 100, riceve la quota massima di categoria.
        // 4. Attenzione a non applicare la ponderazione due volte se già inclusa nei giorni ponderati.
        // 5. Dopo la modifica, verificare che la somma delle quote teoriche sia coerente con il fondo individuale.
        // 6. Esempio di formula da applicare:
        //    quota_teorica_individuale = quota_teorica_categoria * (totale_punteggio / 100);
        // 7. Aggiornare la documentazione e i test automatici dopo la modifica.

        // MODIFICA NECESSARIA: Calcolo giorni ponderati per punteggio
        // L'attuale calcolo moltiplica per (totale_punteggio/100) ma potrebbe non garantire
        // la corretta distribuzione quando i punteggi sono molto bassi o molto alti
        //
        // Vecchia formula (da rivedere):
        // sum(gg_presenza_dalal*perc_parttimepond_dalal*coeff*(B.totale_punteggio/100))
        //
        // Nuova formula proposta:
        // 1. Normalizzare i punteggi in modo che la loro somma sia 100
        // 2. Applicare una soglia minima per evitare valori nulli
        // 3. Usare una media ponderata per il calcolo
        //
        // Esempio:
        // $sql = '... SUM(gg_presenza_dalal * perc_parttimepond_dalal * coeff *
        //   CASE
        //     WHEN (SELECT SUM(totale_punteggio) FROM '.$tbl.' WHERE '.$where.') > 0
        //     THEN (totale_punteggio / (SELECT SUM(totale_punteggio) FROM '.$tbl.' WHERE '.$where.') * 100) / 100
        //     ELSE 1 / (SELECT COUNT(*) FROM '.$tbl.' WHERE '.$where.' AND totale_punteggio IS NOT NULL)
        //   END) ...';

        // Per Individuale includiamo la ponderazione per punteggio (totale_punteggio/100)
        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni_pt_coeff = COALESCE((
            select sum(gg_presenza_dalal*perc_parttimepond_dalal*coeff*(B.totale_punteggio/100)) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $res = $conn->statement($sql);

        Assert::notNull($res = CatCoeff::selectRaw('sum(tot_giorni_pt_coeff) as tot')
            ->where('anno', $year)
            ->first());
        echo '<h3>tot_giorni_pt_coeff :['.(string) $res->tot.']</h3>';

        // Per Individuale usiamo quota_individuale invece di quota_organizzativa
        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quota = (float) $fondo->quota_individuale;
        echo '<h3>quota :'.$quota.'</h3>';

        // Preveniamo divisione per zero
        $tot = (float) $res->tot;
        $delta = ($tot > 0) ? ($quota * 365 / $tot) : 0;
        echo '<h3>Delta * 365 (quota*365/tot_giorni_pt_coeff): '.$delta.'</h3>';

        $sql = 'update '.$tbl_categoria_coeff.' as A set quota_teorica = (
            '.$delta.'*coeff
            ) where A.anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl.' as A
		set quota_teorica=(
		select quota_teorica from '.$tbl_categoria_coeff.' as B
		where find_in_set(A.propro,B.lista_propro)
		and A.anno=B.anno
		) where A.anno="'.$year.'" and type = "'.$type.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        // Verifica finale con output delle somme
        $sumQuotaTeorica = (float) Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('quota_teorica');

        echo '<h3>Somma quota_teorica: '.$sumQuotaTeorica.'</h3>';
    }
}
