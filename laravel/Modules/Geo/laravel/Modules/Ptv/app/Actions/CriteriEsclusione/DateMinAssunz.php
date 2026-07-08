<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class DateMinAssunz
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        $lastDataAssunz = $scheda->last_data_assunz;
        if ($lastDataAssunz !== null && (string) $lastDataAssunz > $value) {
            return 'no date min assunz [my:'.(string) $lastDataAssunz.'][min:'.$value.']';
        }

        return '';
    }
}
