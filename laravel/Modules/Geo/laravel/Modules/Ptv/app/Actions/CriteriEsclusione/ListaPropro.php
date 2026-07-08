<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class ListaPropro
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value): string
    {
        // PHPStan Level 10: isset() invece di property_exists() per Eloquent magic properties
        $propro = isset($scheda->propro) ? $scheda->propro : null;
        if (\in_array($propro, explode(',', $value), true)) {
            return 'no propro';
        }

        return '';
    }
}
