<?php

declare(strict_types=1);

namespace Modules\Geo\Exceptions;

/**
 * Eccezione lanciata quando si verificano errori durante il recupero dell'elevazione.
 */
class ElevationException extends \RuntimeException
{
    /**
     * Crea una nuova istanza per risposta non valida.
     */
    public static function invalidResponse(string $message = 'Risposta non valida dal servizio di elevazione'): self
    {
        return new self($message);
    }

    /**
     * Crea una nuova istanza per errore del servizio.
     */
    public static function serviceError(string $message, ?\Throwable $previous = null): self
    {
        return new self($message, 0, $previous);
    }
}
