<?php

declare(strict_types=1);

namespace Modules\Geo\Exceptions;

/**
 * Eccezione lanciata quando i dati di una posizione non sono validi.
 */
class InvalidLocationException extends \RuntimeException
{
    /**
     * Crea una nuova istanza per dati non validi.
     */
    public static function invalidData(string $message = 'Dati della posizione non validi'): self
    {
        return new self($message);
    }

    /**
     * Crea una nuova istanza per coordinate non valide.
     */
    public static function invalidCoordinates(float $latitude, float $longitude): self
    {
        return new self(sprintf('Coordinate non valide: latitudine %f, longitudine %f', $latitude, $longitude));
    }

    /**
     * Crea una nuova istanza per indirizzo non valido.
     */
    public static function invalidAddress(): self
    {
        return new self('Indirizzo non valido');
    }

    /**
     * Crea una nuova istanza per tipo non valido.
     */
    public static function invalidType(string $expectedType): self
    {
        return new self(sprintf('Tipo di posizione non valido, atteso %s', $expectedType));
    }
}
