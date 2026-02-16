<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits;

use Spatie\Translatable\HasTranslations;

/**
 * Trait che estende HasTranslations con tipi di ritorno più stretti.
 */
trait HasStrictTranslations
{
    use HasTranslations {
        getTranslation as protected spatieGetTranslation;
    }

    /**
     * Ottiene la traduzione di un attributo in una specifica lingua.
     *
     * @param  string  $key  Il nome dell'attributo da tradurre
     * @param  string  $locale  Il codice della lingua richiesta
     * @param  bool  $useFallbackLocale  Se utilizzare o meno la lingua di fallback
     * @return string|array|int|null Il valore tradotto dell'attributo
     */
    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): string|array|int|null
    {
        $value = $this->spatieGetTranslation($key, $locale, $useFallbackLocale);

        if (is_string($value) || is_array($value) || is_int($value) || $value === null) {
            return $value;
        }

        // Se il valore non è del tipo atteso, lo convertiamo
        if (is_bool($value)) {
            return (int) $value;
        }

        if (is_float($value)) {
            return (int) $value;
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        return null;
    }
}
