<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class NoproproList
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $propro = $scheda->propro;
        if (\in_array($propro, explode(',', $value), true)) {
            return 'no propro';
        }

        return '';
    }
}
