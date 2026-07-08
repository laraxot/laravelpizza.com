<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits;

use Spatie\Translatable\HasTranslations;

/**
 * Trait che estende HasTranslations con tipi di ritorno più stretti.
<<<<<<< HEAD
 *
 * @phpstan-ignore trait.unused
=======
>>>>>>> 11c7c7d (.)
 */
trait HasStrictTranslations
{
    use HasTranslations {
        getTranslation as protected spatieGetTranslation;
    }

    /**
     * @param string $key               Il nome dell'attributo da tradurre
     * @param string $locale            Il codice della lingua richiesta
     * @param bool   $useFallbackLocale Se utilizzare o meno la lingua di fallback
     *
     * @return string|array<string, mixed>|int|null Il valore tradotto dell'attributo
     */
    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): string|array|int|null
    {
        $value = $this->spatieGetTranslation($key, $locale, $useFallbackLocale);

        if (is_string($value) || is_int($value) || null === $value) {
            return $value;
        }

        if (is_array($value)) {
            return self::normalizeTranslationArray($value);
        }

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

    /**
     * @param array<mixed, mixed> $value
     *
     * @return array<string, mixed>
     */
    private static function normalizeTranslationArray(array $value): array
    {
        $normalized = [];

        foreach ($value as $k => $v) {
            if (! is_string($k)) {
                continue;
            }

            $normalized[$k] = $v;
        }

        return $normalized;
    }
}
