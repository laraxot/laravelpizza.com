<?php

declare(strict_types=1);

namespace Modules\UI\Contracts;

/**
 * Contratto geocoding UI — implementazione locale o bridge verso modulo Geo opzionale.
 */
interface GeocodingServiceContract
{
    /**
     * @return array<string, mixed>
     */
    public function geocodeAddress(string $address): array;

    /**
     * @return list<array<string, mixed>>
     */
    public function getSuggestions(string $query): array;
}
