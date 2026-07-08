<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Contracts;

interface AnprRequestInterface
{
    /**
     * Converte la richiesta in array per l'API
     */
    public function toArray(): array;

    /**
     * Valida i dati della richiesta
     */
    public function validate(): bool;

    /**
     * Ottiene l'ID operazione della richiesta
     */
    public function getIdOperazione(): string;
}
