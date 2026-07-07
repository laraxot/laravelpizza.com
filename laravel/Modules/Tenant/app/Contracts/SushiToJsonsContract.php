<?php

declare(strict_types=1);

namespace Modules\Tenant\Contracts;

use Modules\Tenant\Models\Traits\SushiToJsons;

/**
 * Contratto per modelli che usano il trait SushiToJsons.
 * Permette a PHPStan di risolvere i metodi del trait nelle closure di boot.
 *
 * @see SushiToJsons
 */
interface SushiToJsonsContract
{
    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     */
    public function getJsonFile(): string;
}
