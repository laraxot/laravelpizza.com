<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class NoposizList
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $posiz = $scheda->posiz;
        if (\in_array($posiz, explode(',', $value), true)) {
            return 'no posiz';
        }

        return '';
    }
}
