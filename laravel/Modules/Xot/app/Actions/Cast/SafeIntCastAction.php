<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

/**
 * Action per convertire in modo sicuro un valore mixed in int.
 *
 * Questa action centralizza la logica di cast sicuro per evitare duplicazioni
 * di codice (principio DRY) e garantire comportamento consistente in tutto il codebase.
 *
 * Principi applicati:
 * - DRY: Evita duplicazione di logica di cast int in tutto il progetto
 * - KISS: Logica semplice e diretta, facile da comprendere e mantenere
 * - Robustezza: Gestisce tutti i casi edge e mantiene la type safety
 */
class SafeIntCastAction
{
    use QueueableAction;

    /**
     * Converte in modo sicuro un valore mixed in int.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int|null  $default  Valore di default se la conversione fallisce (default: 0)
     * @return int Il valore convertito in int
     */
    public function execute(mixed $value, ?int $default = 0): int
    {
        // Se è già un int, restituiscilo direttamente
        if (is_int($value)) {
            return $value;
        }

        // Se è un float, convertilo in int (troncamento)
        if (is_float($value)) {
            return is_finite($value) ? ((int) $value) : ($default ?? 0);
        }

        // Se è null, restituisci il default
        if (is_null($value)) {
            return $default ?? 0;
        }

        // Se è una stringa, prova a convertirla
        if (is_string($value)) {
            return $this->parseStringToInt($value, $default);
        }

        // Se è un booleano, convertilo (true = 1, false = 0)
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        // Se è un array e ha un solo elemento numerico
        if (is_array($value) && count($value) === 1) {
            return $this->execute(reset($value), $default);
        }

        // Se è un oggetto con metodo __toString, prova a convertirlo
        if (is_object($value) && method_exists($value, '__toString')) {
            return $this->parseStringToInt((string) $value, $default);
        }

        // Per tutti gli altri tipi, restituisci il default
        return $default ?? 0;
    }

    /**
     * Metodo statico di convenienza per chiamate dirette.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int|null  $default  Valore di default se la conversione fallisce (default: 0)
     * @return int Il valore convertito in int
     */
    public static function cast(mixed $value, ?int $default = 0): int
    {
        return app(self::class)->execute($value, $default);
    }

    /**
     * Converte un valore in int con validazione di range.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int  $min  Valore minimo consentito
     * @param  int  $max  Valore massimo consentito
     * @param  int|null  $default  Valore di default se la conversione fallisce
     * @return int Il valore convertito e validato
     */
    public function executeWithRange(mixed $value, int $min, int $max, ?int $default = null): int
    {
        $int = $this->execute($value, $default);

        // Clamp il valore tra min e max
        return max($min, min($max, $int));
    }

    /**
     * Metodo statico di convenienza per cast con range.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int  $min  Valore minimo consentito
     * @param  int  $max  Valore massimo consentito
     * @param  int|null  $default  Valore di default se la conversione fallisce
     * @return int Il valore convertito e validato
     */
    public static function castWithRange(mixed $value, int $min, int $max, ?int $default = null): int
    {
        return app(self::class)->executeWithRange($value, $min, $max, $default);
    }

    /**
     * Converte un valore in ID positivo (sempre >= 1).
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int|null  $default  Valore di default se la conversione fallisce (default: 1)
     * @return int Il valore convertito come ID positivo
     */
    public function executeAsId(mixed $value, ?int $default = 1): int
    {
        $int = $this->execute($value, $default);

        return max(1, $int);
    }

    /**
     * Metodo statico per cast come ID positivo.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  int|null  $default  Valore di default se la conversione fallisce (default: 1)
     * @return int Il valore convertito come ID positivo
     */
    public static function castAsId(mixed $value, ?int $default = 1): int
    {
        return app(self::class)->executeAsId($value, $default);
    }

    /**
     * Converte una stringa in int con gestione avanzata.
     *
     * @param  string  $value  La stringa da convertire
     * @param  int|null  $default  Valore di default
     * @return int Il valore convertito
     */
    private function parseStringToInt(string $value, ?int $default = 0): int
    {
        $trimmed = trim($value);

        // Stringa vuota o solo spazi
        if (empty($trimmed)) {
            return $default ?? 0;
        }

        // Rimuovi separatori di migliaia comuni
        $normalized = str_replace([',', ' ', '.'], '', $trimmed);

        // Verifica se è un numero valido
        if (is_numeric($normalized)) {
            return (int) $normalized;
        }

        // Prova a estrarre solo i numeri
        $matches = [];
        if (preg_match('/^[+-]?[0-9]+/', $normalized, $matches) === 1 && ! empty($matches[0])) {
            return (int) $matches[0];
        }

        return $default ?? 0;
    }
}
