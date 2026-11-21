<?php

declare(strict_types=1);

/*
 * Debito di architettura di Modules\Geo: classi che oggi violano una regola di Modules/Xot/tests/Arch/ArchitectureTest.php.
 * Misurato il 2026-11-18. Solo in discesa: chi corregge una classe la toglie, chi aggiunge una voce lo spiega nella PR.
 * Ogni voce deve stare nel namespace di questo pacchetto (lo verifica ArchitectureTest).

 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md
 */

return [
    // md5/sha1/uniqid/rand/extract nel codice di produzione: quasi sempre usi non crittografici (chiavi di cache, id), da rivedere uno per uno; factory e seeder sono esclusi a parte
    'security' => [
        'Modules\Geo\Actions\Address\FormatAddressAction',
        'Modules\Geo\Actions\GoogleMapsAction',
        'Modules\Geo\Actions\GoogleMaps\GoogleMapsHttpAction',
        'Modules\Geo\Actions\Osm\QueryNominatimAction',
        'Modules\Geo\Adapters\GeoHttpClientBase',
        'Modules\Geo\Models\ComuneJson',
        'Modules\Geo\Models\GeoJsonModel',
        'Modules\Geo\Models\Traits\SushiToJsons',
        'Modules\Geo\Services\BaseGeoService',
        'Modules\Geo\Services\GoogleMapsService',
        'Modules\Geo\View\Components\PointMap',
    ],
    // classi in un namespace Services (regola No Services, DCP-270); NoServicesTest le vede come cartelle
    'services' => [
        'Modules\Geo\Services\BaseGeoService',
        'Modules\Geo\Services\GeoDataService',
        'Modules\Geo\Services\GeoDataValidator',
        'Modules\Geo\Services\GeoService',
        'Modules\Geo\Services\GeocodingService',
        'Modules\Geo\Services\GoogleMapsService',
        'Modules\Geo\Services\HereService',
        'Modules\Geo\Services\MapService',
    ],
];
