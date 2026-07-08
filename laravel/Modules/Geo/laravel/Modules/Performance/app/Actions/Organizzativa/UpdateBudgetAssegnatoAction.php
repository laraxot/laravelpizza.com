<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateBudgetAssegnatoAction
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

        $sql = 'update '.$tbl.' as A set budget_assegnato=quota_teorica/365*(gg_presenza_dalal*perc_parttimepond_dalal)
        where '.$where;

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
