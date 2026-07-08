<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Models\OrganizzativaCatCoeff as CatCoeff;
use Modules\Performance\Models\PerformanceFondo;
use Modules\Ptv\Support\EloquentModelResolver;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Aggiorna la quota teorica.
 *
 * Nota: Questa action dipende da modelli specifici di Performance.
 */
class UpdateQuotaTeoricaAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $quota_field = 'quota_'.strtolower(class_basename($class));
        $tbl_categoria_coeff = app(CatCoeff::class)->getTable();
        $model = EloquentModelResolver::newInstance($class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        $rows = $class::where('anno', $year)
            ->where('type', $type)
            ->get();

        $fields = ['gg_presenza_dalal', 'perc_parttimepond_dalal'];
        $html = '';
        $html .= '<table border="1">';
        foreach ($rows as $k => $row) {
            Assert::isInstanceOf($row, Model::class);
            if ($k === 0) {
                $html .= '<tr>';
                foreach ($fields as $field) {
                    $html .= '<th>'.$field.'</th>';
                }
                $html .= '</tr>';
            }
            $html .= '<tr>';
            foreach ($fields as $field) {
                $attribute = $row->getAttribute($field);
                $html .= '<td>'.(is_scalar($attribute) ? (string) $attribute : '').'</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni = COALESCE((
            select sum(gg_presenza_dalal) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni_pt = COALESCE((
            select sum(gg_presenza_dalal*perc_parttimepond_dalal) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl_categoria_coeff.' as A set tot_giorni_pt_coeff = COALESCE((
            select sum(gg_presenza_dalal*perc_parttimepond_dalal*coeff) from '.$tbl.' as B where
            '.$where.' and find_in_set(B.propro,A.lista_propro)
            and A.anno=B.anno
            and ha_diritto>0
            ),0) where A.anno="'.$year.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        Assert::notNull($res = CatCoeff::selectRaw('sum(tot_giorni_pt_coeff) as tot')
            ->where('anno', $year)
            ->first());
        Assert::isInstanceOf($res, Model::class);
        $totGiorni = $res->getAttribute('tot');
        $totGiorniFloat = is_numeric($totGiorni) ? (float) $totGiorni : 0.0;
        echo '<h3>tot_giorni_pt_coeff :['.$totGiorniFloat.']</h3>';

        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quota = (float) $fondo->{$quota_field};
        echo '<h3>quota :'.number_format($quota, 2, ',', "'").'</h3>';

        $delta = $totGiorniFloat > 0 ? $quota * 365 / $totGiorniFloat + 0.0 : 0.0;
        echo '<h3> delta = quota * 365 / tot_giorni_pt_coeff </h3>';
        echo '<h3>Delta:['.$delta.'] </h3>';

        $sql = 'update '.$tbl_categoria_coeff.' as A set  quota_teorica = (
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
    }
}
