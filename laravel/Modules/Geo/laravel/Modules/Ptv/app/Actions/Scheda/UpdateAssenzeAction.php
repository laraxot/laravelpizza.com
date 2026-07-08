<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza i dati delle assenze sulle schede.
 */
class UpdateAssenzeAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        $where = [
            'anno' => $year,
            'type' => $type,
        ];

        $rows = $class::where($where)
            ->where('gg_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            // @phpstan-ignore-next-line
            echo $row->gg_assenza_dalal;
        }

        $rows = $class::where($where)
            ->where('hh_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            // @phpstan-ignore-next-line
            echo $row->hh_assenza_dalal;
        }
    }
}
