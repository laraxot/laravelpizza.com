<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Statistiche mappa interattiva (stub).
 *
 * Sostituisce MapService::getMapStats().
 */
final class GetMapStatsAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
