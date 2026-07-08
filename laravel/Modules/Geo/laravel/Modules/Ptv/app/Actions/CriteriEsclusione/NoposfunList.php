<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class NoposfunList
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $posfun = $scheda->posfun;
        if (\in_array($posfun, explode(',', $value), true)) {
            return 'no posfun';
        }

        return '';
    }
}
