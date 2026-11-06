<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Modules\Xot\Datas\Concerns\HasYearsConfig;

/**
 * Configurazione di modulo che sa quali anni proporre nei filtri e nelle select.
 *
 * @see HasYearsConfig
 */
interface YearsConfigContract
{
    /**
     * @return array<int, string> anno => etichetta, dal piu' recente
     */
    public function getAnniOptions(): array;
}
