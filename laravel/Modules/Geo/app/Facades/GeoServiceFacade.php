<?php

declare(strict_types=1);

namespace Modules\Geo\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;

/**
 * Facade for Geo module services.
 * Establishes clear boundary for geographic operations across modules.
 *
 * @method static array<string, mixed> getAddressFromCoordinates(float $lat, float $lon)
 * @method static array<string, mixed> getCoordinatesFromAddress(string $address)
 * @method static float                calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2)
 * @method static string               getCountryCode(float $lat, float $lon)
 *
 * @see CalculateGeoDistanceAction
 */
class GeoServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'geo.service';
    }
}
