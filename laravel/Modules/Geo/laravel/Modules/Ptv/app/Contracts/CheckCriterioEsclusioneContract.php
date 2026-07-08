<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;

interface CheckCriterioEsclusioneContract
{
    /**
     * @param  Collection<string, mixed>  $criteriOption
     */
    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string;
}
