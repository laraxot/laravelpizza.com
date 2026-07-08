<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Contracts\CheckCriterioEsclusioneContract;
use Spatie\QueueableAction\QueueableAction;

abstract class BaseCriterioEsclusione implements CheckCriterioEsclusioneContract
{
    use QueueableAction;
}
