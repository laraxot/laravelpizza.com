<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateQuotaEffettivaAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type): void
    {
        $model = app(Scheda::class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        $assenza = '(gg_assenza_dalal+round(hh_assenza_dalal/6.0,0))';
        // $assenza=0;
        $gg_presenza_eff = '(gg_presenza_dalal-'.$assenza.')';
        $decurtazione_perc = 1; // mi servira' per individuale
        $punteggio_perc = '(totale_punteggio/100)';

        $sql = 'update '.$tbl.' as A set quota_effettiva=quota_teorica/365*('.$punteggio_perc.'*'.$decurtazione_perc.'*'.$gg_presenza_eff.'*perc_parttimepond_dalal)
            where  '.$where;
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
