<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

// https://www.geodatasource.com/world-cities-database/free
// https://mikepolatoglou.com/geospatial-mysql-laravel-53
// https://github.com/malhal/Laravel-Geographical
// https://www.scribd.com/presentation/2569355/Geo-Distance-Search-with-MySQL
// https://www.databasejournal.com/features/mysql/mysql-calculating-distance-based-on-latitude-and-longitude.html
// http://blog.canispater.com/2017/05/laravel-5-distance-spatial-query-part-2/
// https://scotch.io/tutorials/achieving-geo-search-with-laravel-scout-and-algolia
/**
 * Class GeoService.
 */
class GeoService
{
    public static string $latitude_field = 'latitude';

    public static string $longitude_field = 'longitude';

    private static ?self $_instance = null;

    /**
     * getInstance.
     *
     * this method will return instance of the class
     */
    public static function getInstance(): self
    {
        if (! self::$_instance instanceof GeoService) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public static function setLatitudeField(string $latitude_field): self
    {
        $geoService = self::getInstance();
        $geoService::$latitude_field = $latitude_field;

        return $geoService;
    }

    public static function setLongitudeField(string $longitude_field): self
    {
        $geoService = self::getInstance();
        $geoService::$longitude_field = $longitude_field;

        return $geoService;
    }

    public static function setLatitudeLongitudeField(string $latitude_field, string $longitude_field): self
    {
        $geoService = self::getInstance();
        $geoService::$latitude_field = $latitude_field;
        $geoService::$longitude_field = $longitude_field;

        return $geoService;
    }

    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
    /* ::                                                                         : */
    /* ::  This routine calculates the distance between two points (given the     : */
    /* ::  latitude/longitude of those points). It is being used to calculate     : */
    /* ::  the distance between two locations using GeoDataSource(TM) Products    : */
    /* ::                                                                         : */
    /* ::  Definitions:                                                           : */
    /* ::    South latitudes are negative, east longitudes are positive           : */
    /* ::                                                                         : */
    /* ::  Passed to function:                                                    : */
    /* ::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  : */
    /* ::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  : */
    /* ::    unit = the unit you desire for results                               : */
    /* ::           where: 'M' is statute miles (default)                         : */
    /* ::                  'K' is kilometers                                      : */
    /* ::                  'N' is nautical miles                                  : */
    /* ::  Worldwide cities and other features databases with latitude longitude  : */
    /* ::  are available at https://www.geodatasource.com                          : */
    /* ::                                                                         : */
    /* ::  For enquiries, please contact sales@geodatasource.com                  : */
    /* ::                                                                         : */
    /* ::  Official Web site: https://www.geodatasource.com                        : */
    /* ::                                                                         : */
    /* ::         GeoDataSource.com (C) All Rights Reserved 2018                  : */
    /* ::                                                                         : */
    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

    public static function distance(
        ?float $lat1,
        ?float $lon1,
        ?float $lat2,
        ?float $lon2,
        ?string $unit,
    ): ?float {
        if ($lat1 === $lat2 && $lon1 === $lon2) {
            return 0;
        }
        if ($lat1 === null) {
            return null;
        }
        if ($lon1 === null) {
            return null;
        }
        if ($lat2 === null) {
            return null;
        }
        if ($lon2 === null) {
            return null;
        }
        $theta = $lon1 - $lon2;
        $dist =
            (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) +
            (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        if ($unit === null) {
            $unit = 'K'; // default
        }
        $unit = strtoupper($unit);

        return match ($unit) {
            'K' => $miles * 1.609344,
            'N' => $miles * 0.8684,
            default => $miles,
        };
    }

    // echo GeoService::distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
    // echo GeoService::distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
    // echo GeoService::distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
    public static function haversine(float $latitude, float $longitude): string
    {
        return '(6371 * acos(cos(radians('.
            $latitude.
            '))
        * cos(radians(`'.
            self::$latitude_field.
            '`))
        * cos(radians(`'.
            self::$longitude_field.
            '`)
        - radians('.
            $longitude.
            '))
        + sin(radians('.
            $latitude.
            '))
        * sin(radians(`'.
            self::$latitude_field.
            '`)))) *1.1515';
    }

    /**
     * Undocumented function.
     */
    public static function is_in_polygon(float $latitude, float $longitude, array $polygon): bool
    {
        $i = $j = $c = 0;
        $points_polygon = \count($polygon) - 1;

        // dddx([$latitude, $longitude, $polygon]);

        for ($i = 0, $j = $points_polygon; $i < $points_polygon; $j = $i++) {
            if (! is_array($polygon[$i]) || ! is_array($polygon[$j])) {
                continue;
            }

            $pointI = (object) $polygon[$i];
            $pointJ = (object) $polygon[$j];

            if (! isset($pointI->lat, $pointI->lng, $pointJ->lat, $pointJ->lng)) {
                continue;
            }

            $latI = is_float($pointI->lat) || is_int($pointI->lat) ? (float) $pointI->lat : 0.0;
            $lngI = is_float($pointI->lng) || is_int($pointI->lng) ? (float) $pointI->lng : 0.0;
            $latJ = is_float($pointJ->lat) || is_int($pointJ->lat) ? (float) $pointJ->lat : 0.0;
            $lngJ = is_float($pointJ->lng) || is_int($pointJ->lng) ? (float) $pointJ->lng : 0.0;

            if (
                ($latI > $latitude) !== ($latJ > $latitude)
                    && $longitude <
                    (($lngJ - $lngI) * ($latitude - $latI) /
                                ($latJ - $latI)) +
                        $lngI
            ) {
                $c = ! $c;
            }
        }

        return (bool) $c;
    }

    public static function pointInPolygon(float $lat, float $lng, ?string $polygon): bool
    {
        if ($polygon === null || $polygon === '') {
            return false;
        }

        $original_data = json_decode($polygon, true, 512, JSON_THROW_ON_ERROR);
        if (! \is_array($original_data)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (self::is_in_polygon($lat, $lng, $original_data)) {
            return true;
        }

        return false;
    }
}
