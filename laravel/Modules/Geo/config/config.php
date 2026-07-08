<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | API Keys
     * |--------------------------------------------------------------------------
     * |
     * | Chiavi API per i vari servizi di mappe utilizzati dal modulo.
     * |
     */
    'api_keys' => [
        'google_maps' => Illuminate\Support\Env::get('GOOGLE_MAPS_API_KEY'),
        'bing_maps' => Illuminate\Support\Env::get('BING_MAPS_API_KEY'),
        'mapbox' => Illuminate\Support\Env::get('MAPBOX_API_KEY'),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Geocoding Driver
     * |--------------------------------------------------------------------------
     * |
     * | Chiave del provider di geocoding preferito, usata da
     * | GetAddressDataFromFullAddressAction per anteporlo alla catena di
     * | fallback (google_maps, photon, nominatim, bing_maps, here, mapbox,
     * | opencage — stesso elenco e stesso ordine dell'array hardcoded
     * | preesistente). Il default "google_maps" non altera il comportamento
     * | a runtime; cambiare GEO_DRIVER nell'env permette di preferire un
     * | altro provider (es. "nominatim", l'unico senza bisogno di API key)
     * | senza toccare il codice.
     * |
     * | La mappa chiave→classe resta letterale dentro
     * | GetAddressDataFromFullAddressAction (non qui) perché Larastan
     * | tipizza `app($class)->execute()` solo se `$class` è un
     * | `class-string<T>` risolto come literal nello stesso scope del
     * | try/catch che lo consuma: passarlo per config() lo degrada a
     * | `mixed`. Se la lista provider cambia, va aggiornata in entrambi i
     * | posti (qui per documentare i driver disponibili, nell'Action per il dispatch).
     * |
     */
    'driver' => Illuminate\Support\Env::get('GEO_DRIVER', 'google_maps'),
    /*
     * |--------------------------------------------------------------------------
     * | Rate Limiting
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per il rate limiting delle chiamate API.
     * |
     */
    'rate_limits' => [
        'google_maps' => [
            'requests_per_second' => 50,
            'burst' => 100,
        ],
        'bing_maps' => [
            'requests_per_second' => 50,
            'burst' => 100,
        ],
        'mapbox' => [
            'requests_per_second' => 50,
            'burst' => 100,
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Cache
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per la cache dei risultati.
     * |
     */
    'cache' => [
        'enabled' => true,
        'ttl' => 86400, // 24 ore
        'prefix' => 'geo_',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Timeout & Retry
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per timeout e retry delle chiamate API.
     * |
     */
    'http_client' => [
        'timeout' => 5.0,
        'retry' => [
            'times' => 3,
            'sleep' => 100,
            'when' => [
                'ConnectionException',
                'RequestException',
            ],
        ],
    ],
];
