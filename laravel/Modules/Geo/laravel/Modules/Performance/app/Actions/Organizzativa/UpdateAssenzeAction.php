<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateAssenzeAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type): void
    {
        $where = [
            'anno' => $year,
            'type' => $type,
        ];
        //Scheda::where($where)->update(['gg_assenza_dalal' => null,'hh_assenza_dalal' => null]);

        
        $rows = Scheda::where($where)
            ->where('gg_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            echo $row->gg_assenza_dalal;
        }

        $rows = Scheda::where($where)
            ->where('hh_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            echo $row->hh_assenza_dalal;
        }
    }
}
