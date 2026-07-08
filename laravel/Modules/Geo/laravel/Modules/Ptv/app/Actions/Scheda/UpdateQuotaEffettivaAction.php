<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Support\EloquentModelResolver;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiorna la quota effettiva.
 */
class UpdateQuotaEffettivaAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $model = EloquentModelResolver::newInstance($class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        $where = 'ha_diritto>0 and anno="'.$year.'" and type = "'.$type.'"';

        $assenza = '(gg_assenza_dalal+round(hh_assenza_dalal/6.0,0))';
        $gg_presenza_eff = '(gg_presenza_dalal-'.$assenza.')';
        $decurtazione_perc = 1;
        $punteggio_perc = '(totale_punteggio/100)';

        $sql = 'update '.$tbl.' as A set quota_effettiva=quota_teorica/365*('.$punteggio_perc.'*'.$decurtazione_perc.'*'.$gg_presenza_eff.'*perc_parttimepond_dalal)
            where  '.$where;
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
