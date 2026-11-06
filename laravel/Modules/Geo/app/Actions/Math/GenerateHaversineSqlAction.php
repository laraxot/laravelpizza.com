<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Math;

use Spatie\QueueableAction\QueueableAction;

class GenerateHaversineSqlAction
{
    use QueueableAction;

    public function execute(
        float $latitude,
        float $longitude,
        string $latitudeField = 'latitude',
        string $longitudeField = 'longitude',
    ): string {
        return '(6371 * acos(cos(radians('.
            $latitude.
            '))
        * cos(radians(`'.
            $latitudeField.
            '`))
        * cos(radians(`'.
            $longitudeField.
            '`)
        - radians('.
            $longitude.
            '))
        + sin(radians('.
            $latitude.
            '))
        * sin(radians(`'.
            $latitudeField.
            '`)))) *1.1515';
    }
}
