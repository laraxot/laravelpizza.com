<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class MinGgAnno
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $value = intval($value);
        // Use isset check which works with Eloquent models
        $gg_presenza_anno = isset($scheda->gg_presenza_anno) ? $scheda->gg_presenza_anno : 0;
        $gg_assenza_anno = isset($scheda->gg_assenza_anno) ? $scheda->gg_assenza_anno : 0;

        $gg_presenza_anno = is_numeric($gg_presenza_anno) ? (int) $gg_presenza_anno : 0;
        $gg_assenza_anno = is_numeric($gg_assenza_anno) ? (int) $gg_assenza_anno : 0;

        $eff = $gg_presenza_anno - $gg_assenza_anno;

        if ($eff < $value) {
            return 'no min gg_anno [my:'.$eff.'][min:'.$value.']';
        }

        return '';
    }
}
