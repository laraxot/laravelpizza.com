<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Contracts;

interface AnprServiceInterface
{
    /**
     * Cerca per codice fiscale
     */
    public function cercaPerCodiceFiscale(string $cf): array;

    /**
     * Cerca per dati anagrafici
     */
    public function cercaPerDatiAnagrafici(array $datiPersona): array;
}
