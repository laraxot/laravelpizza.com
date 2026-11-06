<?php

declare(strict_types=1);

namespace Modules\Geo\Infrastructure\Config;

/**
 * Endpoint dei provider di geocoding/routing usati da piu' Actions/Adapters.
 *
 * Unica fonte per gli URL condivisi. Non e' una QueueableAction:
 * costanti infrastrutturali (ex app/Support).
 */
final class GeoApiEndpoints
{
    public const string GOOGLE_GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json';

    public const string GOOGLE_DISTANCE_MATRIX = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    public const string GOOGLE_ELEVATION = 'https://maps.googleapis.com/maps/api/elevation/json';

    public const string GOOGLE_DIRECTIONS = 'https://maps.googleapis.com/maps/api/directions/json';

    public const string GOOGLE_TIMEZONE = 'https://maps.googleapis.com/maps/api/timezone/json';

    public const string NOMINATIM_BASE = 'https://nominatim.openstreetmap.org';

    public const string NOMINATIM_SEARCH = self::NOMINATIM_BASE.'/search';

    public const string NOMINATIM_REVERSE = self::NOMINATIM_BASE.'/reverse';

    public const string NOMINATIM_LOOKUP = self::NOMINATIM_BASE.'/lookup';

    public const string MAPBOX_PLACES = 'https://api.mapbox.com/geocoding/v5/mapbox.places';

    public const string BING_LOCATIONS = 'http://dev.virtualearth.net/REST/v1/Locations';
}
