<?php

declare(strict_types=1);

namespace Modules\Activity\Exceptions;

use InvalidArgumentException;

/**
 * Lanciata quando un file di log richiesto non e' leggibile dalla pagina Log:
 * percorso non valido, fuori da storage/logs, non .log o inesistente.
 *
 * Il messaggio e' per i log/test, non va mostrato all'utente (contiene il percorso richiesto).
 */
class InvalidLogFileException extends InvalidArgumentException
{
    public static function invalidPath(): self
    {
        return new self('Percorso del file di log vuoto o non valido.');
    }

    public static function notALogFile(string $path): self
    {
        return new self(sprintf('Il file richiesto non e\' un file .log: %s', $path));
    }

    public static function notFound(string $path): self
    {
        return new self(sprintf('File di log non trovato: %s', $path));
    }

    public static function outsideLogDirectory(string $path): self
    {
        return new self(sprintf('Il file richiesto e\' fuori dalla cartella dei log: %s', $path));
    }

    public static function baseDirectoryMissing(): self
    {
        return new self('La cartella dei log non esiste.');
    }
}
