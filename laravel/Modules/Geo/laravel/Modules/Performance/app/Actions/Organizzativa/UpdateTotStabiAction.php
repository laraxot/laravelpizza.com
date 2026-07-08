<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Modules\Performance\Models\OrganizzativaTotStabi as TotStabi;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateTotStabiAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type = 'dip'): void
    {
        $model = app(Scheda::class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        TotStabi::where('anno', $year)->delete();
        $tbl_tot_stabi = app(TotStabi::class)->getTable();
        $sql = 'insert into '.$tbl_tot_stabi.'(stabi,anno)
        (select distinct stabi,'.$year.' from '.$tbl.' where anno='.$year.')';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $fields = ['budget_assegnato', 'quota_effettiva', 'resti'];

        foreach ($fields as $field) {
            $sql = 'update '.$tbl_tot_stabi.' as A
			set tot_'.$field.' = COALESCE((
			select sum('.$field.') from '.$tbl.' as B
			where A.stabi=B.stabi and A.anno=B.anno
			and B.ha_diritto>0
			),0) where A.anno="'.$year.'"';
            echo '['.__LINE__.']<pre>'.$sql.'</pre>';
            $conn->statement($sql);

            $sql = 'update '.$tbl_tot_stabi.' as A
			set tot_'.$field.'_min_punteggio = COALESCE((
			select sum('.$field.') from '.$tbl.' as B
			where A.stabi=B.stabi and A.anno=B.anno
			and B.ha_diritto>0
			),0) where anno="'.$year.'"';

            echo '['.__LINE__.']<pre>'.$sql.'</pre>';
            $conn->statement($sql);
        }

        $sql = 'update '.$tbl_tot_stabi.'
			set delta=tot_resti/tot_quota_effettiva
            where anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl_tot_stabi.'
			set delta_min_punteggio=tot_resti/tot_quota_effettiva_min_punteggio
            where anno="'.$year.'"';

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
