<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

class ValidateCoordinatesAction
{
    public function execute(float $latitude, float $longitude): bool
    {
        return $this->isValidLatitude($latitude) && $this->isValidLongitude($longitude);
    }

    private function isValidLatitude(float $latitude): bool
    {
        return $latitude >= -90 && $latitude <= 90;
    }

    private function isValidLongitude(float $longitude): bool
    {
        return $longitude >= -180 && $longitude <= 180;
    }
}
