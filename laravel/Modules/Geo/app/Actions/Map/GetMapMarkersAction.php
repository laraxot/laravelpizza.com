<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Marker mappa interattiva (stub — implementazione dominio futura).
 *
 * Sostituisce MapService::getMarkers().
 */
final class GetMapMarkersAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $filters
     *
     * @return list<array<string, mixed>>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
