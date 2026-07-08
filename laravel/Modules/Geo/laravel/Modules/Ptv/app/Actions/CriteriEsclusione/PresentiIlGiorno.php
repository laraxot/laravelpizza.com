<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class PresentiIlGiorno
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        /**
         * -- WIP WIP
         */

        return '';
    }
}
