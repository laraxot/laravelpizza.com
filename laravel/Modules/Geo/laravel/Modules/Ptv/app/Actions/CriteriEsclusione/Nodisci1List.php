<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class Nodisci1List
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        if (\in_array($scheda->disci1, explode(',', $value), false)) {
            return 'no disci';
        }

        return '';
    }
}
