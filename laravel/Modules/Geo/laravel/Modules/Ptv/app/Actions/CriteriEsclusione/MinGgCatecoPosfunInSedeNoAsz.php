<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class MinGgCatecoPosfunInSedeNoAsz
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $value = intval($value);
        $gg_cateco_posfun_in_sede_no_asz = isset($scheda->gg_cateco_posfun_in_sede_no_asz) ? $scheda->gg_cateco_posfun_in_sede_no_asz : 0;
        $gg_cateco_posfun_in_sede_no_asz = is_numeric($gg_cateco_posfun_in_sede_no_asz) ? (int) $gg_cateco_posfun_in_sede_no_asz : 0;
        if ($gg_cateco_posfun_in_sede_no_asz < $value) {
            return ' no min_gg_cateco_posfun_in_sede_no_asz [my:'.(string) $gg_cateco_posfun_in_sede_no_asz.'][min:'.(string) $value.']';
        }

        return '';
    }
}
