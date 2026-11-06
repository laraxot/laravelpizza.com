<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

use function Safe\preg_replace;

/**
 * Action per convertire in modo sicuro un valore mixed in float.
 *
 * Questa action centralizza la logica di cast sicuro per evitare duplicazioni
 * di codice (principio DRY) e garantire comportamento consistente in tutto il codebase.
 *
 * Principi applicati:
 * - DRY: Evita duplicazione di logica di cast float in tutto il progetto
 * - KISS: Logica semplice e diretta, facile da comprendere e mantenere
 * - Sicurezza: Gestisce tutti i casi edge e previene errori di cast
 *
 * Casi d'uso tipici:
 * - Conversione di valori da API esterne
 * - Parsing di dati da file CSV/JSON
 * - Gestione di input utente
 * - Risoluzione errori PHPStan "Cannot cast mixed to float"
 *
 * @example
 * // Uso base
 * $value = SafeFloatCastAction::cast($mixedValue);
 *
 * // Con default personalizzato
 * $value = SafeFloatCastAction::cast($mixedValue, 10.5);
 *
 * // Con validazione di range
 * $percentage = SafeFloatCastAction::castWithRange($mixedValue, 0.0, 100.0);
 */
class SafeFloatCastAction
{
    /**
     * Converte in modo sicuro un valore mixed in float.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce (default: 0.0)
     * @return float Il valore convertito
     */
    public function execute(mixed $value, ?float $default = 0.0): float
    {
        // Se è già un float, verifica che sia valido
        if (is_float($value)) {
            return is_finite($value) ? $value : ($default ?? 0.0);
        }

        // Se è un intero, convertilo in float
        if (is_int($value)) {
            return (float) $value;
        }

        // Se è null, restituisci il default
        if (is_null($value)) {
            return $default ?? 0.0;
        }

        // Se è una stringa, prova a convertirla
        if (is_string($value)) {
            return $this->parseStringToFloat($value, $default);
        }

        // Se è un booleano, convertilo (true = 1.0, false = 0.0)
        if (is_bool($value)) {
            return $value ? 1.0 : 0.0;
        }

        // Se è un array e ha un solo elemento numerico
        if (is_array($value) && count($value) === 1) {
            return $this->execute(reset($value), $default);
        }

        // Se è un oggetto con metodo __toString, prova a convertirlo
        if (is_object($value) && method_exists($value, '__toString')) {
            return $this->parseStringToFloat((string) $value, $default);
        }

        // Per tutti gli altri tipi, restituisci il default
        return $default ?? 0.0;
    }

    /**
     * Metodo statico di convenienza per chiamate dirette.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce (default: 0.0)
     * @return float Il valore convertito in float
     */
    public static function cast(mixed $value, ?float $default = 0.0): float
    {
        return app(self::class)->execute($value, $default);
    }

    /**
     * Converte un valore in float con validazione di range.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float  $min  Valore minimo consentito
     * @param  float  $max  Valore massimo consentito
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito e validato
     */
    public function executeWithRange(mixed $value, float $min, float $max, ?float $default = null): float
    {
        $float = $this->execute($value, $default);

        // Clamp il valore tra min e max
        return max($min, min($max, $float));
    }

    /**
     * Metodo statico di convenienza per cast con range.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float  $min  Valore minimo consentito
     * @param  float  $max  Valore massimo consentito
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito e validato
     */
    public static function castWithRange(mixed $value, float $min, float $max, ?float $default = null): float
    {
        return app(self::class)->executeWithRange($value, $min, $max, $default);
    }

    /**
     * Converte un valore in float con controllo di precisione.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int  $precision  Numero di decimali (default: 2)
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito con precisione specificata
     */
    public function executeWithPrecision(mixed $value, int $precision = 2, ?float $default = 0.0): float
    {
        $float = $this->execute($value, $default);

        return round($float, max(0, $precision));
    }

    /**
     * Metodo statico per cast con precisione.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int  $precision  Numero di decimali (default: 2)
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito con precisione specificata
     */
    public static function castWithPrecision(mixed $value, int $precision = 2, ?float $default = 0.0): float
    {
        return app(self::class)->executeWithPrecision($value, $precision, $default);
    }

    /**
     * Converte un valore in percentuale (0-100).
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito come percentuale (0-100)
     */
    public function executeAsPercentage(mixed $value, ?float $default = 0.0): float
    {
        return $this->executeWithRange($value, 0.0, 100.0, $default);
    }

    /**
     * Metodo statico per cast come percentuale.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito come percentuale (0-100)
     */
    public static function castAsPercentage(mixed $value, ?float $default = 0.0): float
    {
        return app(self::class)->executeAsPercentage($value, $default);
    }

    /**
     * Converte un valore in formato monetario (sempre positivo, 2 decimali).
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito come importo monetario
     */
    public function executeAsCurrency(mixed $value, ?float $default = 0.0): float
    {
        $float = $this->execute($value, $default);

        return round(abs($float), 2);
    }

    /**
     * Metodo statico per cast come importo monetario.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  float|null  $default  Valore di default se la conversione fallisce
     * @return float Il valore convertito come importo monetario
     */
    public static function castAsCurrency(mixed $value, ?float $default = 0.0): float
    {
        return app(self::class)->executeAsCurrency($value, $default);
    }

    /**
     * Converte una stringa in float con gestione avanzata.
     *
     * @param  string  $value  La stringa da convertire
     * @param  float|null  $default  Valore di default
     * @return float Il valore convertito
     */
    private function parseStringToFloat(string $value, ?float $default = 0.0): float
    {
        $trimmed = trim($value);

        // Stringa vuota o solo spazi
        if (empty($trimmed)) {
            return $default ?? 0.0;
        }

        // Gestisci separatori decimali comuni (virgola europea)
        $normalized = str_replace(',', '.', $trimmed);

        // Rimuovi caratteri non numerici eccetto punto, segno meno, plus e notazione scientifica
        $cleaned = preg_replace('/[^0-9.\-+eE]/', '', $normalized);

        // Verifica se è un numero valido dopo la pulizia
        if (is_numeric($cleaned) && ! empty($cleaned)) {
            $float = (float) $cleaned;

            // Verifica che non sia infinito o NaN
            if (is_finite($float)) {
                return $float;
            }
        }

        return $default ?? 0.0;
    }
}
