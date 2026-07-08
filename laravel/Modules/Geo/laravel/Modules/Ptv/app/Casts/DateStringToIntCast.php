<?php

declare(strict_types=1);

namespace Modules\Ptv\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

/**
 * Cast personalizzato per convertire stringhe di date nel formato YYYY-MM-DD
 * in interi nel formato YYYYMMDD.
 *
 * Gestisce anche:
 * - Valori già interi (li restituisce così come sono)
 * - Valori null (restituisce null)
 * - Stringhe vuote (restituisce null)
 */
class DateStringToIntCast implements Cast
{
    /**
     * Converte il valore in un intero nel formato YYYYMMDD.
     *
     * @param  mixed  $value  Valore da convertire (stringa data, intero, o null)
     * @param  array<string, mixed>  $properties
     * @param  CreationContext<\Spatie\LaravelData\Data>  $context
     * @return int|null|Uncastable Intero nel formato YYYYMMDD, null, o Uncastable se non può essere convertito
     */
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        // Se il valore è null, restituisce null
        if ($value === null) {
            return null;
        }

        // Se il valore è già un intero, lo restituisce così come è
        if (is_int($value)) {
            return $value;
        }

        // Se il valore è una stringa vuota, restituisce null
        if (is_string($value) && trim($value) === '') {
            return null;
        }

        // Se il valore è una stringa, prova a convertirla
        if (is_string($value)) {
            // Prova a parsare come data nel formato YYYY-MM-DD
            try {
                $date = Carbon::parse($value);

                // Converte in formato YYYYMMDD
                return (int) $date->format('Ymd');
            } catch (\Exception $e) {
                // Se il parsing fallisce, prova a vedere se è già un numero
                if (is_numeric($value)) {
                    return (int) $value;
                }

                // Se non può essere convertito, restituisce Uncastable
                return Uncastable::create();
            }
        }

        // Per qualsiasi altro tipo, restituisce Uncastable
        return Uncastable::create();
    }
}
