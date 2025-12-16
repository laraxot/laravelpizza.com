<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\String;

use function Safe\preg_replace;

/**
 * Action per normalizzare i nomi dei driver.
 *
 * Questa action centralizza la logica di normalizzazione dei nomi dei driver
 * per evitare duplicazione di codice e garantire consistenza in tutta l'applicazione.
 */
class NormalizeDriverNameAction
{
    /**
     * Normalizza il nome del driver eliminando caratteri non alfanumerici
     * e gestendo eventuali casi speciali/alias.
     *
     * @return string Nome normalizzato
     */
    public function execute(string $driver): string
    {
        // Gestione speciale per driver con caratteri non alfanumerici (es. 360dialog)
        $driver = preg_replace('/[^a-zA-Z0-9]/', '', $driver);

        return strtolower($driver);
    }
}
