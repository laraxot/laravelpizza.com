<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Illuminate\Support\Collection;
use Modules\Geo\Datas\Elevation\ElevationData;
use Modules\Geo\Datas\Elevation\ElevationResultDTO;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Datas\Geocoding\GeocodingData;
use Modules\Geo\Datas\Geocoding\PlaceData;
use Modules\Geo\Datas\GeoData;
use Modules\Geo\Datas\Location\CoordinatesData;
use Modules\Geo\Datas\Location\IPLocationData;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\LocationDTO;
use Modules\Geo\Datas\MapPlatforms\BingMapData;
use Modules\Geo\Datas\MapPlatforms\MapboxMapData;
use Modules\Geo\Datas\Routing\RouteData;
use Modules\Geo\Datas\Routing\TravelTimeData;
use Modules\Geo\Datas\TimeZoneData;
use Modules\Geo\Datas\UpdateCoordinatesResult;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('CoordinatesData can be instantiated', function () {
    Assert::assertTrue(class_exists(CoordinatesData::class));

    $coordinates = CoordinatesData::from(['latitude' => 41.9028, 'longitude' => 12.4964]);

    Assert::assertSame(41.9028, $coordinates->latitude);
    Assert::assertSame(12.4964, $coordinates->longitude);
});

test('AddressData can be instantiated', function () {
    Assert::assertTrue(class_exists(AddressData::class));

    // latitude/longitude are required constructor parameters
    $address = AddressData::from(['latitude' => 41.9028, 'longitude' => 12.4964, 'city' => 'Roma']);

    Assert::assertSame('Roma', $address->city);
    Assert::assertSame(41.9028, $address->latitude);
});

test('LocationData can be instantiated', function () {
    Assert::assertTrue(class_exists(LocationData::class));

    // from(array) is routed to the magic LocationData::fromArray(), which requires latitude/longitude
    $location = LocationData::from(['latitude' => 41.9028, 'longitude' => 12.4964, 'name' => 'Rome']);

    Assert::assertSame('Rome', $location->name);
    Assert::assertSame(41.9028, $location->latitude);
});

test('PlaceData can be instantiated', function () {
    Assert::assertTrue(class_exists(PlaceData::class));

    $place = new PlaceData(
        placeId: 1,
        displayName: 'Test Place',
        latitude: 41.9028,
        longitude: 12.4964,
        type: 'city',
    );

    Assert::assertSame('Test Place', $place->displayName);
});

test('GeoData can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoData::class));

    $geoData = GeoData::from([
        'latlng' => [41.9028, 12.4964],
        'route' => 'Via del Corso',
        'street_number' => '1',
        'postal_code' => '00186',
        'administrative_area_level_3' => 'Roma',
        'administrative_area_level_2_short' => 'RM',
        'value' => 'Via del Corso 1, Roma',
    ]);

    Assert::assertSame('Via del Corso', $geoData->route);
    Assert::assertSame('00186', $geoData->postal_code);
    Assert::assertSame([41.9028, 12.4964], $geoData->toArray()['latlng']);
});

test('ElevationData can be instantiated', function () {
    Assert::assertTrue(class_exists(ElevationData::class));

    $elevationData = ElevationData::from([
        'elevation' => 100.0,
        'latitude' => 41.9028,
        'longitude' => 12.4964,
        'resolution' => 30.0,
    ]);

    Assert::assertSame(100.0, $elevationData->elevation);
});

test('ElevationResultDTO can be instantiated', function () {
    Assert::assertTrue(class_exists(ElevationResultDTO::class));

    $elevationResult = new ElevationResultDTO(
        elevation: 100.0,
        latitude: 41.9028,
        longitude: 12.4964
    );

    Assert::assertSame(100.0, $elevationResult->elevation);
});

test('LocationDTO can be instantiated', function () {
    Assert::assertTrue(class_exists(LocationDTO::class));

    $locationDTO = new LocationDTO(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Test Address'
    );

    Assert::assertSame('Test Address', $locationDTO->address);
});

test('BingMapData can be instantiated', function () {
    Assert::assertTrue(class_exists(BingMapData::class));

    $bingMapData = new BingMapData([
        'point' => [
            'coordinates' => [12.4964, 41.9028],
        ],
        'address' => [
            'countryRegion' => 'Italy',
            'adminDistrict' => null,
            'adminDistrict2' => null,
            'locality' => 'Rome',
            'postalCode' => null,
            'addressLine' => null,
            'countryRegionIso2' => null,
            'neighborhood' => null,
            'houseNumber' => null,
        ],
    ]);

    Assert::assertSame('Rome', $bingMapData->toArray()['address']['locality']);
});

test('MapboxMapData can be instantiated', function () {
    Assert::assertTrue(class_exists(MapboxMapData::class));

    $mapboxMapData = new MapboxMapData([
        'center' => [12.4964, 41.9028],
        'text' => 'Rome',
        'address' => null,
        'context' => [
            'country' => 'Italy',
            'country_code' => null,
            'place' => 'Rome',
            'postcode' => null,
            'locality' => null,
            'region' => null,
            'neighborhood' => null,
        ],
    ]);

    Assert::assertSame('Rome', $mapboxMapData->toArray()['text']);
});

test('UpdateCoordinatesResult can be instantiated', function () {
    Assert::assertTrue(class_exists(UpdateCoordinatesResult::class));

    $updateResult = new UpdateCoordinatesResult(
        totalProcessed: 5,
        successCount: 5,
        failureCount: 0,
        errors: new Collection,
    );

    Assert::assertTrue($updateResult->isCompleteSuccess());
});

test('RouteData can be instantiated', function () {
    Assert::assertTrue(class_exists(RouteData::class));

    $routeData = new RouteData(
        waypoints: new Collection,
        originalWaypoints: new Collection,
        totalDistance: 1000,
        totalDuration: 600,
        steps: [],
    );

    Assert::assertSame(1000, $routeData->totalDistance);
});

test('TravelTimeData can be instantiated', function () {
    Assert::assertTrue(class_exists(TravelTimeData::class));

    $travelTimeData = new TravelTimeData(
        duration_seconds: 1800,
        duration_in_traffic_seconds: 1800,
        distance_meters: 10000,
        formatted_duration: '30 min',
        formatted_distance: '10 km',
    );

    Assert::assertSame(1800, $travelTimeData->duration_seconds);
});

test('IPLocationData can be instantiated', function () {
    Assert::assertTrue(class_exists(IPLocationData::class));

    $ipLocationData = IPLocationData::from([
        'ip' => '8.8.8.8',
        'latitude' => 37.751,
        'longitude' => -97.822,
    ]);

    Assert::assertSame('8.8.8.8', $ipLocationData->ip);
});

test('GeocodingData can be instantiated', function () {
    Assert::assertTrue(class_exists(GeocodingData::class));

    // from(array) is routed to the magic GeocodingData::fromGoogleResponse(): it expects a Google Geocoding payload
    $geocodingData = GeocodingData::from([
        'status' => 'OK',
        'results' => [[
            'geometry' => ['location' => ['lat' => 41.9028, 'lng' => 12.4964]],
            'formatted_address' => 'Rome, Italy',
            'address_components' => [
                ['long_name' => 'Roma', 'short_name' => 'Roma', 'types' => ['locality']],
                ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
            ],
        ]],
    ]);

    Assert::assertSame('Rome, Italy', $geocodingData->formatted_address);
    Assert::assertSame(41.9028, $geocodingData->latitude);
    Assert::assertSame('Roma', $geocodingData->locality);
    Assert::assertNull($geocodingData->error);
});

test('TimeZoneData can be instantiated', function () {
    Assert::assertTrue(class_exists(TimeZoneData::class));

    $timeZoneData = TimeZoneData::from([
        'timeZoneId' => 'Europe/Rome',
        'timeZoneName' => 'Central European Time',
        'rawOffset' => 3600,
        'dstOffset' => 3600,
        // required by the magic TimeZoneData::fromGoogleMaps() used by from(array)
        'countryCode' => 'IT',
    ]);

    Assert::assertSame('Europe/Rome', $timeZoneData->timeZoneId);
    Assert::assertSame(7200, $timeZoneData->getTotalOffset());
});
