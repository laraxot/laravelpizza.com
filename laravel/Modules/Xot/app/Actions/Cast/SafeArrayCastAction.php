<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action per convertire in modo sicuro un valore mixed in array.
 *
 * Questa action centralizza la logica di cast sicuro per evitare duplicazioni
 * di codice (principio DRY) e garantire comportamento consistente in tutto il codebase.
 *
 * Principi applicati:
 * - DRY: Evita duplicazione di logica di cast array in tutto il progetto
 * - KISS: Logica semplice e diretta, facile da comprendere e mantenere
 * - Sicurezza: Gestisce tutti i casi edge e previene errori di cast
 *
 * Casi d'uso tipici:
 * - Conversione di valori da API esterne
 * - Parsing di dati da file CSV/JSON
 * - Gestione di input utente
 * - Risoluzione errori PHPStan "Cannot cast mixed to array"
 *
 * @example
 * // Uso base
 * $array = SafeArrayCastAction::cast($mixedValue);
 *
 * // Con default personalizzato
 * $array = SafeArrayCastAction::cast($mixedValue, ['default']);
 *
 * // Con validazione di struttura
 * $array = SafeArrayCastAction::castWithKeys($mixedValue, ['required_key']);
 */
class SafeArrayCastAction
{
    use QueueableAction;

    /**
     * Converte in modo sicuro un valore mixed in array.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array|null  $default  Valore di default se la conversione fallisce (default: [])
     * @return array Il valore convertito
     */
    public function execute(mixed $value, ?array $default = []): array
    {
        // Se è già un array, restituiscilo direttamente
        if (is_array($value)) {
            return $value;
        }

        // Se è null, restituisci il default
        if (is_null($value)) {
            return $default ?? [];
        }

        // Se è una Collection Laravel, convertila in array
        if (is_object($value) && method_exists($value, 'toArray')) {
            $result = $value->toArray();

            return is_array($result) ? $result : ($default ?? []);
        }

        // Se è un oggetto stdClass, convertilo in array
        if (is_object($value) && $value::class === 'stdClass') {
            return (array) $value;
        }

        // Se è un oggetto con metodo __toArray, usalo
        if (is_object($value) && method_exists($value, '__toArray')) {
            $result = $value->__toArray();

            return is_array($result) ? $result : ($default ?? []);
        }

        // Se è un oggetto con proprietà pubbliche, convertilo in array
        if (is_object($value)) {
            return get_object_vars($value);
        }

        // Se è uno scalare, avvolgilo in un array
        if (is_scalar($value)) {
            return [$value];
        }

        // Per tutti gli altri tipi, restituisci il default
        return $default ?? [];
    }

    /**
     * Converte un valore in array con validazione di chiavi richieste.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array  $requiredKeys  Chiavi che devono essere presenti
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con chiavi validate
     */
    public function executeWithKeys(mixed $value, array $requiredKeys, ?array $default = []): array
    {
        $array = $this->execute($value, $default);

        // Verifica che tutte le chiavi richieste siano presenti
        foreach ($requiredKeys as $key) {
            if (! is_string($key) && ! is_int($key)) {
                continue;
            }
            if (! array_key_exists($key, $array)) {
                return $default ?? [];
            }
        }

        return $array;
    }

    /**
     * Converte un valore in array con filtro di chiavi.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array  $allowedKeys  Solo queste chiavi saranno mantenute
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con solo le chiavi permesse
     */
    public function executeWithFilter(mixed $value, array $allowedKeys, ?array $default = []): array
    {
        $array = $this->execute($value, $default);

        // Filtra solo le chiavi permesse
        $flippedKeys = array_flip(array_filter($allowedKeys, fn ($key) => is_string($key) || is_int($key)));

        return array_intersect_key($array, $flippedKeys);
    }

    /**
     * Converte un valore in array con validazione di tipo per i valori.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  string  $valueType  Tipo richiesto per i valori ('string', 'int', 'float', 'bool')
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con valori del tipo richiesto
     */
    public function executeWithValueType(mixed $value, string $valueType, ?array $default = []): array
    {
        $array = $this->execute($value, $default);

        // Converte i valori al tipo richiesto
        switch ($valueType) {
            case 'string':
                return array_map(SafeStringCastAction::cast(...), $array);
            case 'int':
                return array_map(SafeIntCastAction::cast(...), $array);
            case 'float':
                return array_map(SafeFloatCastAction::cast(...), $array);
            case 'bool':
                return array_map(SafeBooleanCastAction::cast(...), $array);
            default:
                return $array;
        }
    }

    /**
     * Verifica se un valore può essere convertito in array.
     *
     * @param  mixed  $value  Il valore da verificare
     * @return bool True se il valore può essere convertito in array
     */
    public function canCast(mixed $value): bool
    {
        return is_array($value) || is_null($value) || is_object($value) || is_scalar($value);
    }

    /**
     * Metodo statico di convenienza per chiamate dirette.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array|null  $default  Valore di default se la conversione fallisce (default: [])
     * @return array Il valore convertito in array
     */
    public static function cast(mixed $value, ?array $default = []): array
    {
        return app(self::class)->execute($value, $default);
    }

    /**
     * Metodo statico per cast con chiavi richieste.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array  $requiredKeys  Chiavi che devono essere presenti
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con chiavi validate
     */
    public static function castWithKeys(mixed $value, array $requiredKeys, ?array $default = []): array
    {
        return app(self::class)->executeWithKeys($value, $requiredKeys, $default);
    }

    /**
     * Metodo statico per cast con filtro di chiavi.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  array  $allowedKeys  Solo queste chiavi saranno mantenute
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con solo le chiavi permesse
     */
    public static function castWithFilter(mixed $value, array $allowedKeys, ?array $default = []): array
    {
        return app(self::class)->executeWithFilter($value, $allowedKeys, $default);
    }

    /**
     * Metodo statico per cast con tipo di valore specifico.
     *
     * @param  mixed  $value  Il valore da convertire
     * @param  string  $valueType  Tipo richiesto per i valori
     * @param  array|null  $default  Valore di default se la conversione fallisce
     * @return array Il valore convertito con valori del tipo richiesto
     */
    public static function castWithValueType(mixed $value, string $valueType, ?array $default = []): array
    {
        return app(self::class)->executeWithValueType($value, $valueType, $default);
    }
}
