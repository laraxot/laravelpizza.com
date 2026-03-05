<?php

declare(strict_types=1);

use Modules\Geo\Datas\AddressData;
use Modules\Geo\Datas\BingMapData;
use Modules\Geo\Datas\CoordinatesData;
use Modules\Geo\Datas\ElevationData;
use Modules\Geo\Datas\ElevationResultDTO;
use Modules\Geo\Datas\GeocodingData;
use Modules\Geo\Datas\GeoData;
use Modules\Geo\Datas\IPLocationData;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\LocationDTO;
use Modules\Geo\Datas\MapboxMapData;
use Modules\Geo\Datas\PlaceData;
use Modules\Geo\Datas\RouteData;
use Modules\Geo\Datas\TimeZoneData;
use Modules\Geo\Datas\TravelTimeData;
use Modules\Geo\Datas\UpdateCoordinatesResult;

// ---------------------------------------------------------------------------
// CoordinatesData
// ---------------------------------------------------------------------------

describe('CoordinatesData', function () {
    test('can be instantiated via constructor', function () {
        $coordinates = new CoordinatesData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($coordinates)->toBeInstanceOf(CoordinatesData::class)
            ->and($coordinates->latitude)->toBe(41.9028)
            ->and($coordinates->longitude)->toBe(12.4964);
    });

    test('can be instantiated via constructor with named arguments', function () {
        $coordinates = new CoordinatesData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($coordinates->latitude)->toBe(41.9028)
            ->and($coordinates->longitude)->toBe(12.4964);
    });

    test('properties reflect constructor values', function () {
        $coordinates = new CoordinatesData(
            latitude: 45.4654,
            longitude: 9.1866,
        );

        expect($coordinates->latitude)->toBe(45.4654)
            ->and($coordinates->longitude)->toBe(9.1866);
    });

    test('json_encode on object produces valid json with correct values', function () {
        $coordinates = new CoordinatesData(latitude: 41.9028, longitude: 12.4964);
        $json = json_encode(['latitude' => $coordinates->latitude, 'longitude' => $coordinates->longitude]);

        expect($json)->toBeString();

        $decoded = json_decode((string) $json, true);
        expect($decoded['latitude'])->toBe(41.9028)
            ->and($decoded['longitude'])->toBe(12.4964);
    });

    test('properties are readonly', function () {
        $coordinates = new CoordinatesData(latitude: 41.9028, longitude: 12.4964);

        expect(fn () => $coordinates->latitude = 0.0)
            ->toThrow(Error::class);
    });
});

// ---------------------------------------------------------------------------
// AddressData
// ---------------------------------------------------------------------------

describe('AddressData', function () {
    test('can be instantiated with required fields only', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($address)->toBeInstanceOf(AddressData::class)
            ->and($address->latitude)->toBe(41.9028)
            ->and($address->longitude)->toBe(12.4964)
            ->and($address->country)->toBeNull()
            ->and($address->city)->toBeNull();
    });

    test('can be instantiated with all fields', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
            country: 'Italy',
            city: 'Rome',
            country_code: 'IT',
            postal_code: 100,
            locality: 'Centro',
            county: 'RM',
            street: 'Via Roma',
            street_number: '1',
            district: 'Prati',
            state: 'Lazio',
        );

        expect($address->country)->toBe('Italy')
            ->and($address->city)->toBe('Rome')
            ->and($address->country_code)->toBe('IT')
            ->and($address->postal_code)->toBe(100)
            ->and($address->street)->toBe('Via Roma')
            ->and($address->street_number)->toBe('1');
    });

    test('getFormattedAddress returns all parts when all fields set', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
            country: 'Italy',
            city: 'Rome',
            street: 'Via Roma',
            street_number: '10',
            state: 'Lazio',
            postal_code: 100,
        );

        $formatted = $address->getFormattedAddress();

        expect($formatted)->toContain('Via Roma, 10')
            ->and($formatted)->toContain('Rome')
            ->and($formatted)->toContain('Lazio')
            ->and($formatted)->toContain('Italy')
            ->and($formatted)->toContain('100');
    });

    test('getFormattedAddress handles street without street_number', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
            street: 'Via Nazionale',
        );

        $formatted = $address->getFormattedAddress();

        expect($formatted)->toBe('Via Nazionale');
    });

    test('getFormattedAddress returns empty string when no parts', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        $formatted = $address->getFormattedAddress();

        expect($formatted)->toBe('');
    });

    test('getFormattedAddress handles city only', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
            city: 'Milan',
        );

        $formatted = $address->getFormattedAddress();

        expect($formatted)->toBe('Milan');
    });

    test('properties contain correct values when city set', function () {
        $address = new AddressData(
            latitude: 41.9028,
            longitude: 12.4964,
            city: 'Rome',
        );

        expect($address->latitude)->toBe(41.9028)
            ->and($address->longitude)->toBe(12.4964)
            ->and($address->city)->toBe('Rome');
    });
});

// ---------------------------------------------------------------------------
// LocationData
// ---------------------------------------------------------------------------

describe('LocationData', function () {
    test('can be instantiated with required fields', function () {
        $location = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
        );

        expect($location)->toBeInstanceOf(LocationData::class)
            ->and($location->latitude)->toBe(45.4654)
            ->and($location->longitude)->toBe(9.1866)
            ->and($location->name)->toBeNull()
            ->and($location->address)->toBeNull();
    });

    test('can be instantiated with optional fields', function () {
        $location = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
            address: 'Via della Scala, Milan',
        );

        expect($location->name)->toBe('Milan')
            ->and($location->address)->toBe('Via della Scala, Milan');
    });

    test('toArray returns correct structure', function () {
        $location = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
            address: 'Via della Scala, Milan',
        );

        $array = $location->toArray();

        expect($array)->toBe([
            'latitude' => 45.4654,
            'longitude' => 9.1866,
            'name' => 'Milan',
            'address' => 'Via della Scala, Milan',
        ]);
    });

    test('toArray returns nulls for optional fields when not set', function () {
        $location = new LocationData(latitude: 45.0, longitude: 9.0);
        $array = $location->toArray();

        expect($array['name'])->toBeNull()
            ->and($array['address'])->toBeNull();
    });

    test('fromArray creates instance correctly', function () {
        $location = LocationData::fromArray([
            'latitude' => 45.4654,
            'longitude' => 9.1866,
            'name' => 'Milan',
            'address' => 'Via Roma',
        ]);

        expect($location->latitude)->toBe(45.4654)
            ->and($location->longitude)->toBe(9.1866)
            ->and($location->name)->toBe('Milan')
            ->and($location->address)->toBe('Via Roma');
    });

    test('fromArray handles missing optional keys', function () {
        $location = LocationData::fromArray([
            'latitude' => 45.4654,
            'longitude' => 9.1866,
        ]);

        expect($location->name)->toBeNull()
            ->and($location->address)->toBeNull();
    });

    test('fromArray casts floats from strings', function () {
        $location = LocationData::fromArray([
            'latitude' => '45.4654',
            'longitude' => '9.1866',
        ]);

        expect($location->latitude)->toBe(45.4654)
            ->and($location->longitude)->toBe(9.1866);
    });
});

// ---------------------------------------------------------------------------
// PlaceData
// ---------------------------------------------------------------------------

describe('PlaceData', function () {
    test('can be instantiated with required fields', function () {
        $place = new PlaceData(
            placeId: 42,
            displayName: 'Rome, Italy',
            latitude: 41.9028,
            longitude: 12.4964,
            type: 'city',
        );

        expect($place)->toBeInstanceOf(PlaceData::class)
            ->and($place->placeId)->toBe(42)
            ->and($place->displayName)->toBe('Rome, Italy')
            ->and($place->latitude)->toBe(41.9028)
            ->and($place->longitude)->toBe(12.4964)
            ->and($place->type)->toBe('city')
            ->and($place->address)->toBeNull()
            ->and($place->addressComponents)->toBe([])
            ->and($place->extraData)->toBe([]);
    });

    test('can be instantiated with all optional fields', function () {
        $place = new PlaceData(
            placeId: 1,
            displayName: 'Milan, Italy',
            latitude: 45.4654,
            longitude: 9.1866,
            type: 'city',
            address: 'Milan, Lombardy, Italy',
            addressComponents: ['city' => 'Milan', 'country' => 'Italy'],
            extraData: ['osm_id' => 12345],
        );

        expect($place->address)->toBe('Milan, Lombardy, Italy')
            ->and($place->addressComponents)->toBe(['city' => 'Milan', 'country' => 'Italy'])
            ->and($place->extraData)->toBe(['osm_id' => 12345]);
    });

    test('fromNominatim creates instance from raw API data', function () {
        $nominatimData = [
            'place_id' => 283702554,
            'display_name' => 'Rome, Lazio, Italy',
            'lat' => '41.9028',
            'lon' => '12.4964',
            'type' => 'city',
            'address' => [
                'city' => 'Rome',
                'country' => 'Italy',
                'country_code' => 'it',
            ],
        ];

        $place = PlaceData::fromNominatim($nominatimData);

        expect($place->placeId)->toBe(283702554)
            ->and($place->displayName)->toBe('Rome, Lazio, Italy')
            ->and($place->latitude)->toBe(41.9028)
            ->and($place->longitude)->toBe(12.4964)
            ->and($place->type)->toBe('city')
            ->and($place->address)->toBe('Rome, Lazio, Italy')
            ->and($place->addressComponents)->toBe([
                'city' => 'Rome',
                'country' => 'Italy',
                'country_code' => 'it',
            ]);
    });

    test('fromNominatim handles missing address field', function () {
        $nominatimData = [
            'place_id' => 1,
            'display_name' => 'Florence',
            'lat' => '43.7696',
            'lon' => '11.2558',
            'type' => 'city',
        ];

        $place = PlaceData::fromNominatim($nominatimData);

        expect($place->addressComponents)->toBe([]);
    });

    test('properties contain expected values', function () {
        $place = new PlaceData(
            placeId: 1,
            displayName: 'Florence',
            latitude: 43.7696,
            longitude: 11.2558,
            type: 'city',
        );

        expect($place->placeId)->toBe(1)
            ->and($place->displayName)->toBe('Florence')
            ->and($place->latitude)->toBe(43.7696)
            ->and($place->longitude)->toBe(11.2558)
            ->and($place->type)->toBe('city');
    });
});

// ---------------------------------------------------------------------------
// GeoData
// ---------------------------------------------------------------------------

describe('GeoData', function () {
    test('class exists and extends Data', function () {
        expect(class_exists(GeoData::class))->toBeTrue();
        expect(is_subclass_of(GeoData::class, Spatie\LaravelData\Data::class))->toBeTrue();
    });

    test('can be instantiated and properties set', function () {
        $geo = new GeoData();
        $geo->latlng = [41.9028, 12.4964];
        $geo->route = 'Via Roma';
        $geo->street_number = '10';
        $geo->postal_code = '00100';
        $geo->administrative_area_level_3 = 'Rome';
        $geo->administrative_area_level_2_short = 'RM';
        $geo->value = 'Via Roma 10, Rome';

        expect($geo->latlng)->toBe([41.9028, 12.4964])
            ->and($geo->route)->toBe('Via Roma')
            ->and($geo->street_number)->toBe('10')
            ->and($geo->postal_code)->toBe('00100')
            ->and($geo->value)->toBe('Via Roma 10, Rome');
    });
});

// ---------------------------------------------------------------------------
// ElevationData
// ---------------------------------------------------------------------------

describe('ElevationData', function () {
    test('can be instantiated with required fields', function () {
        $elevation = new ElevationData(
            elevation: 100.5,
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($elevation)->toBeInstanceOf(ElevationData::class)
            ->and($elevation->elevation)->toBe(100.5)
            ->and($elevation->latitude)->toBe(41.9028)
            ->and($elevation->longitude)->toBe(12.4964)
            ->and($elevation->resolution)->toBeNull();
    });

    test('can be instantiated with optional resolution', function () {
        $elevation = new ElevationData(
            elevation: 100.5,
            latitude: 41.9028,
            longitude: 12.4964,
            resolution: 30.0,
        );

        expect($elevation->resolution)->toBe(30.0);
    });

    test('can be instantiated via constructor with resolution', function () {
        $elevation = new ElevationData(
            elevation: 50.0,
            latitude: 45.0,
            longitude: 10.0,
            resolution: 15.0,
        );

        expect($elevation->elevation)->toBe(50.0)
            ->and($elevation->resolution)->toBe(15.0);
    });

    test('properties contain all expected values', function () {
        $elevation = new ElevationData(
            elevation: 100.5,
            latitude: 41.9028,
            longitude: 12.4964,
            resolution: 30.0,
        );

        expect($elevation->elevation)->toBe(100.5)
            ->and($elevation->latitude)->toBe(41.9028)
            ->and($elevation->longitude)->toBe(12.4964)
            ->and($elevation->resolution)->toBe(30.0);
    });
});

// ---------------------------------------------------------------------------
// ElevationResultDTO
// ---------------------------------------------------------------------------

describe('ElevationResultDTO', function () {
    test('can be instantiated', function () {
        $dto = new ElevationResultDTO(
            elevation: 200.0,
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($dto)->toBeInstanceOf(ElevationResultDTO::class)
            ->and($dto->elevation)->toBe(200.0)
            ->and($dto->latitude)->toBe(41.9028)
            ->and($dto->longitude)->toBe(12.4964);
    });

    test('properties are readonly via readonly class', function () {
        $dto = new ElevationResultDTO(
            elevation: 200.0,
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect(fn () => $dto->elevation = 0.0)
            ->toThrow(Error::class);
    });
});

// ---------------------------------------------------------------------------
// LocationDTO
// ---------------------------------------------------------------------------

describe('LocationDTO', function () {
    test('can be instantiated with required fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($dto)->toBeInstanceOf(LocationDTO::class)
            ->and($dto->latitude)->toBe(41.9028)
            ->and($dto->longitude)->toBe(12.4964)
            ->and($dto->address)->toBeNull()
            ->and($dto->city)->toBeNull()
            ->and($dto->country)->toBeNull();
    });

    test('can be instantiated with all optional fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            address: 'Via Roma 1',
            city: 'Rome',
            country: 'Italy',
        );

        expect($dto->address)->toBe('Via Roma 1')
            ->and($dto->city)->toBe('Rome')
            ->and($dto->country)->toBe('Italy');
    });

    test('toArray returns correct structure', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            address: 'Via Roma 1',
            city: 'Rome',
            country: 'Italy',
        );

        $array = $dto->toArray();

        expect($array)->toBe([
            'latitude' => 41.9028,
            'longitude' => 12.4964,
            'address' => 'Via Roma 1',
            'city' => 'Rome',
            'country' => 'Italy',
        ]);
    });

    test('toArray returns nulls for unset optional fields', function () {
        $dto = new LocationDTO(latitude: 0.0, longitude: 0.0);
        $array = $dto->toArray();

        expect($array['address'])->toBeNull()
            ->and($array['city'])->toBeNull()
            ->and($array['country'])->toBeNull();
    });

    test('properties are readonly via readonly class', function () {
        $dto = new LocationDTO(latitude: 41.9028, longitude: 12.4964);

        expect(fn () => $dto->latitude = 0.0)
            ->toThrow(Error::class);
    });
});

// ---------------------------------------------------------------------------
// BingMapData
// ---------------------------------------------------------------------------

describe('BingMapData', function () {
    test('can be instantiated with raw data array', function () {
        $rawData = [
            'point' => [
                'coordinates' => [12.4964, 41.9028],
            ],
            'address' => [
                'countryRegion' => 'Italy',
                'locality' => 'Rome',
            ],
        ];

        $bingData = new BingMapData($rawData);

        expect($bingData)->toBeInstanceOf(BingMapData::class);
    });

    test('toArray returns the raw data unchanged', function () {
        $rawData = [
            'point' => [
                'coordinates' => [12.4964, 41.9028],
            ],
            'address' => [
                'countryRegion' => 'Italy',
                'locality' => 'Rome',
                'adminDistrict' => 'Lazio',
            ],
        ];

        $bingData = new BingMapData($rawData);

        expect($bingData->toArray())->toBe($rawData);
    });

    test('class exists and extends Data', function () {
        expect(class_exists(BingMapData::class))->toBeTrue();
        expect(is_subclass_of(BingMapData::class, Spatie\LaravelData\Data::class))->toBeTrue();
    });
});

// ---------------------------------------------------------------------------
// MapboxMapData
// ---------------------------------------------------------------------------

describe('MapboxMapData', function () {
    test('can be instantiated with raw data array', function () {
        $rawData = [
            'center' => [12.4964, 41.9028],
            'text' => 'Rome',
            'address' => null,
            'context' => [
                'country' => 'Italy',
                'place' => 'Rome',
            ],
        ];

        $mapboxData = new MapboxMapData($rawData);

        expect($mapboxData)->toBeInstanceOf(MapboxMapData::class);
    });

    test('toArray returns the raw data unchanged', function () {
        $rawData = [
            'center' => [12.4964, 41.9028],
            'text' => 'Rome',
            'context' => ['country' => 'Italy'],
        ];

        $mapboxData = new MapboxMapData($rawData);

        expect($mapboxData->toArray())->toBe($rawData);
    });
});

// ---------------------------------------------------------------------------
// UpdateCoordinatesResult
// ---------------------------------------------------------------------------

describe('UpdateCoordinatesResult', function () {
    test('can be instantiated with basic data', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 10,
            successCount: 8,
            failureCount: 2,
            errors: collect([]),
        );

        expect($result)->toBeInstanceOf(UpdateCoordinatesResult::class)
            ->and($result->totalProcessed)->toBe(10)
            ->and($result->successCount)->toBe(8)
            ->and($result->failureCount)->toBe(2);
    });

    test('hasErrors returns true when failureCount > 0', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 10,
            successCount: 8,
            failureCount: 2,
            errors: collect([]),
        );

        expect($result->hasErrors())->toBeTrue();
    });

    test('hasErrors returns false when failureCount is 0', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 5,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->hasErrors())->toBeFalse();
    });

    test('isCompleteSuccess returns true when no failures and has successes', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 5,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->isCompleteSuccess())->toBeTrue();
    });

    test('isCompleteSuccess returns false when there are failures', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 4,
            failureCount: 1,
            errors: collect([]),
        );

        expect($result->isCompleteSuccess())->toBeFalse();
    });

    test('isCompleteSuccess returns false when successCount is 0', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 0,
            successCount: 0,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->isCompleteSuccess())->toBeFalse();
    });

    test('isCompleteFailure returns true when no successes and has processed records', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 3,
            successCount: 0,
            failureCount: 3,
            errors: collect([]),
        );

        expect($result->isCompleteFailure())->toBeTrue();
    });

    test('isCompleteFailure returns false when there are successes', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 2,
            failureCount: 3,
            errors: collect([]),
        );

        expect($result->isCompleteFailure())->toBeFalse();
    });

    test('getSuccessRate returns correct percentage', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 10,
            successCount: 8,
            failureCount: 2,
            errors: collect([]),
        );

        expect($result->getSuccessRate())->toBe(80.0);
    });

    test('getSuccessRate returns 0 when totalProcessed is 0', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 0,
            successCount: 0,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->getSuccessRate())->toBe(0.0);
    });

    test('getSuccessRate returns 100 when all succeeded', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 5,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->getSuccessRate())->toBe(100.0);
    });

    test('getErrorMessages formats error collection correctly', function () {
        $errors = collect([
            ['model' => 'User::1', 'error' => 'geocoding failed'],
            ['model' => 'User::2', 'error' => 'timeout'],
        ]);

        $result = new UpdateCoordinatesResult(
            totalProcessed: 10,
            successCount: 8,
            failureCount: 2,
            errors: $errors,
        );

        $messages = $result->getErrorMessages();

        expect($messages)->toHaveCount(2)
            ->and($messages[0])->toBe('User::1: geocoding failed')
            ->and($messages[1])->toBe('User::2: timeout');
    });

    test('getErrorMessages returns empty array when no errors', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 5,
            successCount: 5,
            failureCount: 0,
            errors: collect([]),
        );

        expect($result->getErrorMessages())->toBe([]);
    });

    test('getSummaryMessage contains processed and success counts', function () {
        $result = new UpdateCoordinatesResult(
            totalProcessed: 10,
            successCount: 8,
            failureCount: 2,
            errors: collect([]),
        );

        $message = $result->getSummaryMessage();

        expect($message)->toContain('10')
            ->and($message)->toContain('8')
            ->and($message)->toContain('80.0')
            ->and($message)->toContain('2');
    });
});

// ---------------------------------------------------------------------------
// RouteData
// ---------------------------------------------------------------------------

describe('RouteData', function () {
    test('can be instantiated with required fields', function () {
        $waypoints = collect([
            new LocationData(latitude: 41.9028, longitude: 12.4964),
            new LocationData(latitude: 45.4654, longitude: 9.1866),
        ]);

        $route = new RouteData(
            waypoints: $waypoints,
            originalWaypoints: $waypoints,
            totalDistance: 500000,
            totalDuration: 18000,
            steps: [],
        );

        expect($route)->toBeInstanceOf(RouteData::class)
            ->and($route->totalDistance)->toBe(500000)
            ->and($route->totalDuration)->toBe(18000)
            ->and($route->waypoints)->toHaveCount(2);
    });

    test('getFormattedDistance returns meters for < 1000 m', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 800,
            totalDuration: 600,
            steps: [],
        );

        expect($route->getFormattedDistance())->toBe('800 m');
    });

    test('getFormattedDistance returns km for >= 1000 m', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 5500,
            totalDuration: 1800,
            steps: [],
        );

        expect($route->getFormattedDistance())->toBe('5.5 km');
    });

    test('getFormattedDuration returns only minutes when < 1 hour', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 1000,
            totalDuration: 1800, // 30 minutes
            steps: [],
        );

        expect($route->getFormattedDuration())->toBe('30 min');
    });

    test('getFormattedDuration returns hours and minutes when >= 1 hour', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 100000,
            totalDuration: 5400, // 1h 30min
            steps: [],
        );

        expect($route->getFormattedDuration())->toBe('1 ore 30 min');
    });

    test('getSummary returns correct keys and values', function () {
        $route = new RouteData(
            waypoints: collect([
                new LocationData(latitude: 41.9028, longitude: 12.4964),
            ]),
            originalWaypoints: collect([]),
            totalDistance: 2500,
            totalDuration: 300,
            steps: [['instruction' => 'Turn left']],
        );

        $summary = $route->getSummary();

        expect($summary)->toHaveKey('distance')
            ->and($summary)->toHaveKey('duration')
            ->and($summary)->toHaveKey('steps', 1)
            ->and($summary)->toHaveKey('waypoints', 1);
    });

    test('validateRouteData returns true when all items have key', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 0,
            totalDuration: 0,
            steps: [],
        );

        $data = collect([
            ['key' => 'value1'],
            ['key' => 'value2'],
        ]);

        expect($route->validateRouteData($data))->toBeTrue();
    });

    test('validateRouteData returns false when an item is missing key', function () {
        $route = new RouteData(
            waypoints: collect([]),
            originalWaypoints: collect([]),
            totalDistance: 0,
            totalDuration: 0,
            steps: [],
        );

        $data = collect([
            ['key' => 'value1'],
            ['other' => 'value2'],
        ]);

        expect($route->validateRouteData($data))->toBeFalse();
    });
});

// ---------------------------------------------------------------------------
// TravelTimeData
// ---------------------------------------------------------------------------

describe('TravelTimeData', function () {
    test('can be instantiated with required fields', function () {
        $travelTime = new TravelTimeData(
            duration_seconds: 1800,
            duration_in_traffic_seconds: 2100,
            distance_meters: 30000,
            formatted_duration: '30 min',
            formatted_distance: '30 km',
        );

        expect($travelTime)->toBeInstanceOf(TravelTimeData::class)
            ->and($travelTime->duration_seconds)->toBe(1800)
            ->and($travelTime->distance_meters)->toBe(30000)
            ->and($travelTime->status)->toBe('OK');
    });

    test('error() factory creates error instance', function () {
        $travelTime = TravelTimeData::error();

        expect($travelTime->status)->toBe('ERROR')
            ->and($travelTime->duration_seconds)->toBe(0)
            ->and($travelTime->distance_meters)->toBe(0)
            ->and($travelTime->formatted_duration)->toBe('N/D')
            ->and($travelTime->formatted_distance)->toBe('N/D');
    });

    test('error() accepts custom status', function () {
        $travelTime = TravelTimeData::error('NOT_FOUND');

        expect($travelTime->status)->toBe('NOT_FOUND');
    });

    test('fromGoogleResponse creates instance from successful response', function () {
        $response = [
            'status' => 'OK',
            'rows' => [
                [
                    'elements' => [
                        [
                            'status' => 'OK',
                            'duration' => ['value' => 1800, 'text' => '30 mins'],
                            'duration_in_traffic' => ['value' => 2100, 'text' => '35 mins'],
                            'distance' => ['value' => 30000, 'text' => '30 km'],
                        ],
                    ],
                ],
            ],
        ];

        $travelTime = TravelTimeData::fromGoogleResponse($response);

        expect($travelTime->status)->toBe('OK')
            ->and($travelTime->duration_seconds)->toBe(1800)
            ->and($travelTime->duration_in_traffic_seconds)->toBe(2100)
            ->and($travelTime->distance_meters)->toBe(30000)
            ->and($travelTime->formatted_duration)->toBe('30 mins')
            ->and($travelTime->formatted_distance)->toBe('30 km');
    });

    test('fromGoogleResponse returns error when top-level status is not OK', function () {
        $response = [
            'status' => 'REQUEST_DENIED',
            'rows' => [],
        ];

        $travelTime = TravelTimeData::fromGoogleResponse($response);

        expect($travelTime->status)->toBe('REQUEST_DENIED')
            ->and($travelTime->duration_seconds)->toBe(0);
    });

    test('fromGoogleResponse uses duration when no traffic data', function () {
        $response = [
            'status' => 'OK',
            'rows' => [
                [
                    'elements' => [
                        [
                            'status' => 'OK',
                            'duration' => ['value' => 1800, 'text' => '30 mins'],
                            'distance' => ['value' => 30000, 'text' => '30 km'],
                        ],
                    ],
                ],
            ],
        ];

        $travelTime = TravelTimeData::fromGoogleResponse($response);

        expect($travelTime->duration_in_traffic_seconds)->toBe(1800);
    });

    test('fromGoogleResponse returns error when element status is not OK', function () {
        $response = [
            'status' => 'OK',
            'rows' => [
                [
                    'elements' => [
                        [
                            'status' => 'NOT_FOUND',
                        ],
                    ],
                ],
            ],
        ];

        $travelTime = TravelTimeData::fromGoogleResponse($response);

        expect($travelTime->status)->toBe('NOT_FOUND');
    });
});

// ---------------------------------------------------------------------------
// IPLocationData
// ---------------------------------------------------------------------------

describe('IPLocationData', function () {
    test('can be instantiated with required ip field', function () {
        $ipData = new IPLocationData(ip: '8.8.8.8');

        expect($ipData)->toBeInstanceOf(IPLocationData::class)
            ->and($ipData->ip)->toBe('8.8.8.8')
            ->and($ipData->city)->toBeNull()
            ->and($ipData->region)->toBeNull()
            ->and($ipData->country)->toBeNull()
            ->and($ipData->latitude)->toBeNull()
            ->and($ipData->longitude)->toBeNull();
    });

    test('can be instantiated with all optional fields', function () {
        $ipData = new IPLocationData(
            ip: '8.8.8.8',
            city: 'Mountain View',
            region: 'California',
            country: 'US',
            countryName: 'United States',
            latitude: 37.4056,
            longitude: -122.0775,
            timezone: 'America/Los_Angeles',
            isp: 'Google LLC',
        );

        expect($ipData->city)->toBe('Mountain View')
            ->and($ipData->country)->toBe('US')
            ->and($ipData->latitude)->toBe(37.4056)
            ->and($ipData->isp)->toBe('Google LLC');
    });

    test('can be instantiated via constructor with minimal fields', function () {
        $ipData = new IPLocationData(
            ip: '1.1.1.1',
            city: 'Brisbane',
            country: 'AU',
        );

        expect($ipData->ip)->toBe('1.1.1.1')
            ->and($ipData->city)->toBe('Brisbane');
    });

    test('properties contain ip and city values', function () {
        $ipData = new IPLocationData(
            ip: '8.8.8.8',
            city: 'Mountain View',
            country: 'US',
        );

        expect($ipData->ip)->toBe('8.8.8.8')
            ->and($ipData->city)->toBe('Mountain View');
    });
});

// ---------------------------------------------------------------------------
// GeocodingData
// ---------------------------------------------------------------------------

describe('GeocodingData', function () {
    test('can be instantiated with all nullable fields', function () {
        $geo = new GeocodingData(
            latitude: 41.9028,
            longitude: 12.4964,
            formatted_address: 'Rome, Italy',
            street_number: '1',
            route: 'Via Roma',
            locality: 'Rome',
            administrative_area: 'Lazio',
            country: 'Italy',
            postal_code: '00100',
        );

        expect($geo->latitude)->toBe(41.9028)
            ->and($geo->formatted_address)->toBe('Rome, Italy')
            ->and($geo->error)->toBeNull();
    });

    test('error() factory creates all-null instance with error message', function () {
        $geo = GeocodingData::error('API key invalid');

        expect($geo->error)->toBe('API key invalid')
            ->and($geo->latitude)->toBeNull()
            ->and($geo->longitude)->toBeNull()
            ->and($geo->formatted_address)->toBeNull()
            ->and($geo->street_number)->toBeNull()
            ->and($geo->route)->toBeNull()
            ->and($geo->locality)->toBeNull()
            ->and($geo->administrative_area)->toBeNull()
            ->and($geo->country)->toBeNull()
            ->and($geo->postal_code)->toBeNull();
    });

    test('fromGoogleResponse parses successful response', function () {
        $response = [
            'status' => 'OK',
            'results' => [
                [
                    'formatted_address' => 'Via Roma, 1, 00100 Rome, Italy',
                    'geometry' => [
                        'location' => [
                            'lat' => 41.9028,
                            'lng' => 12.4964,
                        ],
                    ],
                    'address_components' => [
                        [
                            'long_name' => '1',
                            'short_name' => '1',
                            'types' => ['street_number'],
                        ],
                        [
                            'long_name' => 'Via Roma',
                            'short_name' => 'Via Roma',
                            'types' => ['route'],
                        ],
                        [
                            'long_name' => 'Rome',
                            'short_name' => 'Rome',
                            'types' => ['locality', 'political'],
                        ],
                        [
                            'long_name' => 'Lazio',
                            'short_name' => 'LZ',
                            'types' => ['administrative_area_level_1', 'political'],
                        ],
                        [
                            'long_name' => 'Italy',
                            'short_name' => 'IT',
                            'types' => ['country', 'political'],
                        ],
                        [
                            'long_name' => '00100',
                            'short_name' => '00100',
                            'types' => ['postal_code'],
                        ],
                    ],
                ],
            ],
        ];

        $geo = GeocodingData::fromGoogleResponse($response);

        expect($geo->latitude)->toBe(41.9028)
            ->and($geo->longitude)->toBe(12.4964)
            ->and($geo->formatted_address)->toBe('Via Roma, 1, 00100 Rome, Italy')
            ->and($geo->street_number)->toBe('1')
            ->and($geo->route)->toBe('Via Roma')
            ->and($geo->locality)->toBe('Rome')
            ->and($geo->administrative_area)->toBe('Lazio')
            ->and($geo->country)->toBe('Italy')
            ->and($geo->postal_code)->toBe('00100')
            ->and($geo->error)->toBeNull();
    });

    test('properties are accessible after error() factory call', function () {
        $geo = GeocodingData::error('Test error');

        expect($geo->latitude)->toBeNull()
            ->and($geo->longitude)->toBeNull()
            ->and($geo->formatted_address)->toBeNull()
            ->and($geo->error)->toBe('Test error');
    });
});

// ---------------------------------------------------------------------------
// TimeZoneData
// ---------------------------------------------------------------------------

describe('TimeZoneData', function () {
    test('can be instantiated with required fields', function () {
        $tz = new TimeZoneData(
            timeZoneId: 'Europe/Rome',
            timeZoneName: 'Central European Time',
            rawOffset: 3600,
            dstOffset: 3600,
            countryCode: 'IT',
        );

        expect($tz)->toBeInstanceOf(TimeZoneData::class)
            ->and($tz->timeZoneId)->toBe('Europe/Rome')
            ->and($tz->timeZoneName)->toBe('Central European Time')
            ->and($tz->rawOffset)->toBe(3600)
            ->and($tz->dstOffset)->toBe(3600)
            ->and($tz->countryCode)->toBe('IT');
    });

    test('getTotalOffset sums rawOffset and dstOffset', function () {
        $tz = new TimeZoneData(
            timeZoneId: 'Europe/Rome',
            timeZoneName: 'Central European Summer Time',
            rawOffset: 3600,
            dstOffset: 3600,
            countryCode: 'IT',
        );

        expect($tz->getTotalOffset())->toBe(7200);
    });

    test('getTotalOffset with zero dstOffset equals rawOffset', function () {
        $tz = new TimeZoneData(
            timeZoneId: 'UTC',
            timeZoneName: 'Coordinated Universal Time',
            rawOffset: 0,
            dstOffset: 0,
            countryCode: 'XX',
        );

        expect($tz->getTotalOffset())->toBe(0);
    });

    test('fromGoogleMaps creates instance from API array', function () {
        $data = [
            'timeZoneId' => 'Europe/Rome',
            'timeZoneName' => 'Central European Time',
            'rawOffset' => 3600,
            'dstOffset' => 0,
            'countryCode' => 'IT',
        ];

        $tz = TimeZoneData::fromGoogleMaps($data);

        expect($tz->timeZoneId)->toBe('Europe/Rome')
            ->and($tz->rawOffset)->toBe(3600)
            ->and($tz->dstOffset)->toBe(0)
            ->and($tz->countryCode)->toBe('IT');
    });

    test('properties contain expected values on construction', function () {
        $tz = new TimeZoneData(
            timeZoneId: 'Europe/Rome',
            timeZoneName: 'CET',
            rawOffset: 3600,
            dstOffset: 0,
            countryCode: 'IT',
        );

        expect($tz->timeZoneId)->toBe('Europe/Rome')
            ->and($tz->rawOffset)->toBe(3600)
            ->and($tz->countryCode)->toBe('IT');
    });
});
