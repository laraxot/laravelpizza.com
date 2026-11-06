<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit;

use PHPUnit\Framework\Assert;
use Tests\TestCase;

uses(TestCase::class);

/**
 * Regole di dominio geocoding/meteo/luoghi (dati in-memory, senza DB).
 * Assert PHPUnit: evita crash pest-plugin-phpstan HigherOrderExpectationTypeExtension.
 */
describe('Geocoding Business Logic', function () {
    beforeEach(function () {
        $this->italianAddress = [
            'street' => 'Via Roma 123',
            'city' => 'Milano',
            'province' => 'MI',
            'region' => 'Lombardia',
            'postal_code' => '20100',
            'country' => 'Italy',
            'country_code' => 'IT',
        ];

        $this->geocodingResult = [
            'latitude' => 45.4642,
            'longitude' => 9.1900,
            'accuracy' => 'street_level',
            'provider' => 'nominatim',
            'confidence' => 0.95,
            'bounding_box' => [
                'north' => 45.4652,
                'south' => 45.4632,
                'east' => 9.1910,
                'west' => 9.1890,
            ],
        ];

        $this->weatherData = [
            'temperature' => 15.5,
            'humidity' => 65,
            'pressure' => 1013.25,
            'weather_condition' => 'partly_cloudy',
            'wind_speed' => 3.2,
            'wind_direction' => 180,
            'visibility' => 10,
            'uv_index' => 4,
        ];

        $this->place = [
            'id' => 'place-milano-001',
            'name' => 'Milano',
            'type' => 'city',
            'population' => 1366180,
            'area_km2' => 181.76,
            'elevation' => 120,
            'timezone' => 'Europe/Rome',
        ];
    });

    describe('Italian Address Validation', function () {
        it('validates Italian postal code format', function () {
            $address = $this->italianAddress;

            Assert::assertMatchesRegularExpression('/^\d{5}$/', $address['postal_code']);
            Assert::assertSame('20100', $address['postal_code']);
            Assert::assertSame(5, strlen($address['postal_code']));
        });

        it('validates Italian province codes', function () {
            $address = $this->italianAddress;

            Assert::assertMatchesRegularExpression('/^[A-Z]{2}$/', $address['province']);
            Assert::assertSame('MI', $address['province']);
            Assert::assertSame(2, strlen($address['province']));
        });

        it('validates Italian address structure', function () {
            $address = $this->italianAddress;

            Assert::assertArrayHasKey('street', $address);
            Assert::assertArrayHasKey('city', $address);
            Assert::assertArrayHasKey('province', $address);
            Assert::assertArrayHasKey('region', $address);
            Assert::assertArrayHasKey('postal_code', $address);
            Assert::assertArrayHasKey('country_code', $address);

            Assert::assertSame('IT', $address['country_code']);
            Assert::assertSame('Italy', $address['country']);
        });

        it('validates Italian street address format', function () {
            $address = $this->italianAddress;

            Assert::assertStringContainsString('Via', $address['street']);
            Assert::assertMatchesRegularExpression('/Via\s+\w+\s+\d+/', $address['street']);
            Assert::assertSame('Via Roma 123', $address['street']);
        });

        it('validates Italian regional hierarchy', function () {
            $address = $this->italianAddress;

            if ($address['city'] === 'Milano') {
                Assert::assertSame('Lombardia', $address['region']);
                Assert::assertSame('MI', $address['province']);
            }

            $lombardyProvinces = ['MI', 'BG', 'BS', 'CO', 'CR', 'MN', 'PV', 'SO', 'VA'];
            if ($address['region'] === 'Lombardia') {
                Assert::assertContains($address['province'], $lombardyProvinces);
            }
        });
    });

    describe('Geocoding Provider Logic', function () {
        it('validates geocoding coordinate precision', function () {
            $result = $this->geocodingResult;

            Assert::assertGreaterThan(35.0, $result['latitude']);
            Assert::assertLessThan(47.5, $result['latitude']);
            Assert::assertGreaterThan(6.0, $result['longitude']);
            Assert::assertLessThan(19.0, $result['longitude']);
        });

        it('ensures geocoding accuracy levels', function () {
            $result = $this->geocodingResult;
            $validAccuracyLevels = ['country', 'region', 'city', 'district', 'street_level', 'building'];

            Assert::assertContains($result['accuracy'], $validAccuracyLevels);
            Assert::assertGreaterThan(0.0, $result['confidence']);
            Assert::assertLessThanOrEqual(1.0, $result['confidence']);
        });

        it('validates provider response structure', function () {
            $result = $this->geocodingResult;

            Assert::assertArrayHasKey('latitude', $result);
            Assert::assertArrayHasKey('longitude', $result);
            Assert::assertArrayHasKey('accuracy', $result);
            Assert::assertArrayHasKey('provider', $result);
            Assert::assertArrayHasKey('confidence', $result);

            $validProviders = ['nominatim', 'bing', 'mapbox', 'here', 'google'];
            Assert::assertContains($result['provider'], $validProviders);
        });

        it('validates bounding box calculations', function () {
            $result = $this->geocodingResult;
            $bbox = $result['bounding_box'];

            Assert::assertGreaterThan($result['latitude'], $bbox['north']);
            Assert::assertLessThan($result['latitude'], $bbox['south']);
            Assert::assertGreaterThan($result['longitude'], $bbox['east']);
            Assert::assertLessThan($result['longitude'], $bbox['west']);

            $latDiff = $bbox['north'] - $bbox['south'];
            $lngDiff = $bbox['east'] - $bbox['west'];
            Assert::assertGreaterThan(0.0001, $latDiff);
            Assert::assertLessThan(1.0, $latDiff);
            Assert::assertGreaterThan(0.0001, $lngDiff);
            Assert::assertLessThan(1.0, $lngDiff);
        });

        it('handles provider failover logic', function () {
            $providers = ['nominatim', 'bing', 'mapbox', 'here'];
            $primaryProvider = 'nominatim';
            $fallbackProviders = ['bing', 'mapbox', 'here'];

            Assert::assertContains($primaryProvider, $providers);
            Assert::assertGreaterThan(0, count($fallbackProviders));

            foreach ($fallbackProviders as $fallback) {
                Assert::assertContains($fallback, $providers);
            }
        });
    });

    describe('Weather Data Integration', function () {
        it('validates weather data structure', function () {
            $weather = $this->weatherData;

            Assert::assertArrayHasKey('temperature', $weather);
            Assert::assertArrayHasKey('humidity', $weather);
            Assert::assertArrayHasKey('pressure', $weather);
            Assert::assertArrayHasKey('weather_condition', $weather);

            Assert::assertGreaterThan(-20, $weather['temperature']);
            Assert::assertLessThan(50, $weather['temperature']);
        });

        it('validates humidity and pressure ranges', function () {
            $weather = $this->weatherData;

            Assert::assertGreaterThanOrEqual(0, $weather['humidity']);
            Assert::assertLessThanOrEqual(100, $weather['humidity']);

            Assert::assertGreaterThan(950, $weather['pressure']);
            Assert::assertLessThan(1050, $weather['pressure']);
        });

        it('validates wind measurements', function () {
            $weather = $this->weatherData;

            Assert::assertGreaterThanOrEqual(0, $weather['wind_speed']);
            Assert::assertLessThan(100, $weather['wind_speed']);

            Assert::assertGreaterThanOrEqual(0, $weather['wind_direction']);
            Assert::assertLessThan(360, $weather['wind_direction']);
        });

        it('validates weather condition categories', function () {
            $weather = $this->weatherData;
            $validConditions = [
                'clear',
                'partly_cloudy',
                'cloudy',
                'overcast',
                'rain',
                'heavy_rain',
                'snow',
                'thunderstorm',
                'fog',
                'mist',
                'hail',
                'sleet',
            ];

            Assert::assertContains($weather['weather_condition'], $validConditions);
        });

        it('validates UV index ranges', function () {
            $weather = $this->weatherData;

            Assert::assertGreaterThanOrEqual(0, $weather['uv_index']);
            Assert::assertLessThanOrEqual(15, $weather['uv_index']);
        });
    });

    describe('Place Classification Logic', function () {
        it('validates place hierarchy and types', function () {
            $place = $this->place;
            $validTypes = [
                'country',
                'region',
                'province',
                'city',
                'town',
                'village',
                'district',
                'neighborhood',
                'landmark',
            ];

            Assert::assertContains($place['type'], $validTypes);
            Assert::assertIsString($place['name']);
            Assert::assertNotEmpty($place['name']);
        });

        it('validates population data for cities', function () {
            $place = $this->place;

            if ($place['type'] === 'city') {
                Assert::assertArrayHasKey('population', $place);
                Assert::assertIsInt($place['population']);
                Assert::assertGreaterThan(0, $place['population']);
            }

            if ($place['name'] === 'Milano') {
                Assert::assertGreaterThan(1000000, $place['population']);
                Assert::assertLessThan(2000000, $place['population']);
            }
        });

        it('validates geographic measurements', function () {
            $place = $this->place;

            if (isset($place['area_km2'])) {
                Assert::assertGreaterThan(0, $place['area_km2']);
                Assert::assertLessThan(100000, $place['area_km2']);
            }

            if (isset($place['elevation'])) {
                Assert::assertIsInt($place['elevation']);
                Assert::assertGreaterThanOrEqual(-100, $place['elevation']);
                Assert::assertLessThan(5000, $place['elevation']);
            }
        });

        it('validates timezone assignments', function () {
            $place = $this->place;
            $italianTimezones = ['Europe/Rome'];

            if (isset($place['timezone'])) {
                Assert::assertContains($place['timezone'], $italianTimezones);
            }
        });
    });

    describe('Distance and Route Calculations', function () {
        it('calculates distance between coordinates', function () {
            $point1 = ['lat' => 45.4642, 'lng' => 9.1900];
            $point2 = ['lat' => 41.9028, 'lng' => 12.4964];

            $earthRadius = 6371;
            $dLat = deg2rad($point2['lat'] - $point1['lat']);
            $dLng = deg2rad($point2['lng'] - $point1['lng']);

            $a =
                (sin($dLat / 2) * sin($dLat / 2)) +
                (cos(deg2rad($point1['lat'])) * cos(deg2rad($point2['lat'])) * sin($dLng / 2) * sin($dLng / 2));
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;

            Assert::assertGreaterThan(450, $distance);
            Assert::assertLessThan(520, $distance);
        });

        it('validates coordinate bounds checking', function () {
            $milanBounds = [
                'north' => 45.5311,
                'south' => 45.3975,
                'east' => 9.2844,
                'west' => 9.0944,
            ];

            $pointInMilan = ['lat' => 45.4642, 'lng' => 9.1900];
            $pointOutsideMilan = ['lat' => 41.9028, 'lng' => 12.4964];

            /**
             * @param  array{lat: float, lng: float}  $point
             * @param  array{north: float, south: float, east: float, west: float}  $bounds
             */
            $isInBounds = static function (array $point, array $bounds): bool {
                return $point['lat'] >= $bounds['south']
                    && $point['lat'] <= $bounds['north']
                    && $point['lng'] >= $bounds['west']
                    && $point['lng'] <= $bounds['east'];
            };

            Assert::assertTrue($isInBounds($pointInMilan, $milanBounds));
            Assert::assertFalse($isInBounds($pointOutsideMilan, $milanBounds));
        });

        it('validates proximity search radius', function () {
            $searchRadius = 10;
            $maxReasonableRadius = 100;
            $minReasonableRadius = 0.1;

            Assert::assertGreaterThan($minReasonableRadius, $searchRadius);
            Assert::assertLessThan($maxReasonableRadius, $searchRadius);
        });
    });

    describe('Data Quality and Validation', function () {
        it('ensures coordinate precision limits', function () {
            $coordinates = ['lat' => 45.4642035, 'lng' => 9.1899738];
            $maxPrecision = 6;

            $latFraction = strrchr((string) $coordinates['lat'], '.');
            $lngFraction = strrchr((string) $coordinates['lng'], '.');
            Assert::assertNotFalse($latFraction);
            Assert::assertNotFalse($lngFraction);
            $latPrecision = strlen(substr($latFraction, 1));
            $lngPrecision = strlen(substr($lngFraction, 1));

            Assert::assertLessThanOrEqual($maxPrecision, $latPrecision);
            Assert::assertLessThanOrEqual($maxPrecision, $lngPrecision);
        });

        it('validates address completeness scoring', function () {
            $address = $this->italianAddress;
            $requiredFields = ['street', 'city', 'postal_code'];
            $optionalFields = ['province', 'region', 'country'];

            $score = 0;
            foreach ($requiredFields as $field) {
                if (isset($address[$field]) && ! empty($address[$field])) {
                    $score += 40;
                }
            }
            foreach ($optionalFields as $field) {
                if (isset($address[$field]) && ! empty($address[$field])) {
                    $score += 20 / count($optionalFields);
                }
            }

            Assert::assertGreaterThan(80, $score);
            Assert::assertLessThanOrEqual(100, $score);
        });

        it('validates geocoding cache invalidation logic', function () {
            $cacheEntry = [
                'address' => $this->italianAddress,
                'result' => $this->geocodingResult,
                'cached_at' => time() - 86400,
                'expires_at' => time() + (86400 * 30),
            ];

            Assert::assertIsArray($cacheEntry['address']);
            Assert::assertIsArray($cacheEntry['result']);

            $isExpired = $cacheEntry['expires_at'] < time();
            $isRecentEnough = (time() - $cacheEntry['cached_at']) < (86400 * 90);

            Assert::assertFalse($isExpired);
            Assert::assertTrue($isRecentEnough);
        });
    });
});
