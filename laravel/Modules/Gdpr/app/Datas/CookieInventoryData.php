<?php

declare(strict_types=1);

namespace Modules\Gdpr\Datas;

use Modules\Gdpr\Enums\CookieCategory;
use Spatie\LaravelData\Data;

/**
 * Inventario dei cookie impostati dal sito: l'unica fonte del banner e della pagina cookie policy.
 * Il banner chiede il consenso solo se l'inventario contiene almeno un cookie non tecnico.
 */
final class CookieInventoryData extends Data
{
    /**
     * @param  list<CookieData>  $cookies
     */
    public function __construct(
        public readonly array $cookies,
    ) {}

    /**
     * @return list<CookieCategory> categorie non tecniche presenti nell'inventario
     */
    public function optionalCategories(): array
    {
        $found = [];
        foreach ($this->cookies as $cookie) {
            if ($cookie->category->requiresConsent()) {
                $found[$cookie->category->value] = $cookie->category;
            }
        }

        return array_values($found);
    }

    public function requiresConsent(): bool
    {
        return $this->optionalCategories() !== [];
    }

    public function has(CookieCategory $category): bool
    {
        return in_array($category, $this->optionalCategories(), true);
    }
}
