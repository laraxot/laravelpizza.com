<?php

declare(strict_types=1);

namespace Modules\Geo\Exceptions\GoogleMaps;

/**
 * Eccezione lanciata quando si verificano errori con l'API di Google Maps.
 */
class GoogleMapsApiException extends \RuntimeException
{
    /**
     * Crea una nuova istanza per API key mancante.
     */
    public static function missingApiKey(): self
    {
        return new self('API key di Google Maps non configurata');
    }

    /**
     * Crea una nuova istanza per richiesta fallita.
     */
    public static function requestFailed(string $message = 'Richiesta a Google Maps fallita'): self
    {
        return new self($message);
    }

    /**
     * Crea una nuova istanza per nessun risultato trovato.
     */
    public static function noResultsFound(): self
    {
        return new self('Nessun risultato trovato');
    }

    /**
     * Crea una nuova istanza per dati di posizione non validi.
     */
    public static function invalidLocationData(): self
    {
        return new self('Dati della posizione non validi');
    }
}
