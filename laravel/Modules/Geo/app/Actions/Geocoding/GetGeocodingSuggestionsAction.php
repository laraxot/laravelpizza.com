<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Geocoding;

use Spatie\QueueableAction\QueueableAction;

/**
 * Suggerimenti autocomplete indirizzo (stub).
 *
 * Sostituisce GeocodingService::getSuggestions().
 */
final class GetGeocodingSuggestionsAction
{
    use QueueableAction;

    /**
     * @return list<array<string, mixed>>
     */
    public function execute(string $query): array
    {
        return [];
    }
}
