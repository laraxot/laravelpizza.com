<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Support\EloquentModelResolver;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiorna i resti.
 */
class UpdateRestiAction
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

        $sql = 'update '.$tbl.' as A set resti=budget_assegnato-quota_effettiva
        where '.$where;

        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
