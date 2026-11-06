<?php

declare(strict_types=1);

namespace Modules\Geo\Infrastructure\Config;

/**
 * Config condivisa dati geografici (JSON comuni + cache).
 * Non e' una QueueableAction: costanti infrastrutturali (ex app/Support).
 */
final class GeoDataConfig
{
    /** Percorso (relativo a base_path) del file JSON con regioni/province/comuni. */
    public const string JSON_PATH = 'Modules/Geo/resources/json/comuni.json';

    /** Durata cache in secondi (24 ore). */
    public const int CACHE_TTL = 86400;

    public const string CACHE_KEY_REGIONS = 'geo.regions';

    /** Pattern sprintf: codice regione. */
    public const string CACHE_KEY_PROVINCES = 'geo.provinces.%s';

    /** Pattern sprintf: codice provincia. */
    public const string CACHE_KEY_CITIES = 'geo.cities.%s';

    /** Pattern sprintf: codice provincia, codice citta'. */
    public const string CACHE_KEY_CAP = 'geo.cap.%s.%s';
}
