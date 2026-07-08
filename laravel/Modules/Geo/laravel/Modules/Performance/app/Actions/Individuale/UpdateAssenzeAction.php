<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Modules\Performance\Models\Individuale as Scheda;
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
        // Scheda::where('anno', $year)->update(['gg_assenza_dalal' => null,'hh_assenza_dalal' => null]);
        $rows = Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('gg_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            // dddx( [$row,$row->gg_assenza_dalal]);
            echo $row->gg_assenza_dalal;
        }

        $rows = Scheda::where('anno', $year)
            ->where('type', $type)
            ->where('hh_assenza_dalal', null)
            ->inRandomOrder()
            ->get();

        foreach ($rows as $row) {
            echo $row->hh_assenza_dalal;
        }
    }
}
