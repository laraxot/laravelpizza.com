<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Contracts;

/**
 * Interfaccia per modelli che supportano traduzioni.
 */
interface HasTranslationsContract
{
    /**
     * Ottiene la traduzione di un attributo in una specifica lingua.
     *
     * @return string|array<mixed>|int|null Il valore tradotto dell'attributo, o null se non disponibile
     */
    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): string|array|int|null;

    /**
     * Imposta la traduzione di un attributo in una specifica lingua.
     *
     * @return self L'istanza corrente del modello, per supportare method chaining
     */
    public function setTranslation(string $key, string $locale, int|array|string|null $value): self;
}
