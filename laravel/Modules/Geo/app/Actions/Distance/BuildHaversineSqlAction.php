<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Distance;

use Modules\Geo\Actions\Math\GenerateHaversineSqlAction;
use Spatie\QueueableAction\QueueableAction;

/*
 * GateGuard: callers BuildHaversineSqlActionTest; SSoT formula resta GenerateHaversineSqlAction;
 * no second formula copy; reads lat/lng floats + field names, writes SQL string;
 * user: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
 */

/**
 * Espressione SQL haversine per scope Eloquent orderBy distance.
 *
 * Delega a {@see GenerateHaversineSqlAction} (SSoT formula). Sostituisce
 * GeoService::haversine() + setLatitudeLongitudeField().
 */
final class BuildHaversineSqlAction
{
    use QueueableAction;

    public function execute(
        float $latitude,
        float $longitude,
        string $latitudeField = 'latitude',
        string $longitudeField = 'longitude',
    ): string {
        return app(GenerateHaversineSqlAction::class)->execute(
            $latitude,
            $longitude,
            $latitudeField,
            $longitudeField,
        );
    }
}
