# Geo Module - Testing Guidelines

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration:
```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=<nome progetto>_data_test
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. Address Model Tests

#### Core Address Management
```php
<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Province;

describe('Address Business Logic', function () {
    it('creates address with required fields', function () {
        $province = Province::factory()->create();
        $comune = Comune::factory()->create(['province_id' => $province->id]);
        
        $address = Address::create([
            'street' => 'Via Roma 123',
            'city' => 'Milano',
            'postal_code' => '20121',
            'province_id' => $province->id,
            'comune_id' => $comune->id,
            'country' => 'IT',
        ]);

        expect($address)
            ->toBeInstanceOf(Address::class)
            ->and($address->street)->toBe('Via Roma 123')
            ->and($address->city)->toBe('Milano')
            ->and($address->postal_code)->toBe('20121')
            ->and($address->country)->toBe('IT');
    });

    it('validates Italian postal codes', function () {
        $validCodes = ['20121', '00100', '10121', '80121'];
        $invalidCodes = ['1234', '123456', 'ABCDE'];
        
        foreach ($validCodes as $code) {
            $address = Address::factory()->make(['postal_code' => $code]);
            expect($address->isValidPostalCode())->toBeTrue();
        }
        
        foreach ($invalidCodes as $code) {
            $address = Address::factory()->make(['postal_code' => $code]);
            expect($address->isValidPostalCode())->toBeFalse();
        }
    });

    it('geocodes address coordinates', function () {
        $address = Address::factory()->create([
            'street' => 'Via del Corso 1',
            'city' => 'Roma',
            'postal_code' => '00187',
        ]);

        $address->geocode();

        expect($address->latitude)->not->toBeNull()
            ->and($address->longitude)->not->toBeNull()
            ->and($address->latitude)->toBeFloat()
            ->and($address->longitude)->toBeFloat();
    });

    it('formats address for display', function () {
        $address = Address::factory()->create([
            'street' => 'Via Roma 123',
            'city' => 'Milano',
            'postal_code' => '20121',
            'country' => 'IT',
        ]);

        $formatted = $address->getFormattedAddress();
        
        expect($formatted)->toContain('Via Roma 123')
            ->and($formatted)->toContain('Milano')
            ->and($formatted)->toContain('20121');
    });
});
```

### 2. Geographic Hierarchy Tests

```php
describe('Geographic Hierarchy Business Logic', function () {
    it('maintains region-province-comune relationships', function () {
        $region = Region::factory()->create(['name' => 'Lombardia']);
        $province = Province::factory()->create([
            'name' => 'Milano',
            'region_id' => $region->id,
        ]);
        $comune = Comune::factory()->create([
            'name' => 'Milano',
            'province_id' => $province->id,
        ]);

        expect($comune->province->id)->toBe($province->id)
            ->and($province->region->id)->toBe($region->id)
            ->and($region->provinces)->toContain($province)
            ->and($province->comuni)->toContain($comune);
    });

    it('validates postal code consistency with geographic area', function () {
        $milanProvince = Province::factory()->create(['name' => 'Milano']);
        $milanoComune = Comune::factory()->create([
            'name' => 'Milano',
            'province_id' => $milanProvince->id,
            'postal_codes' => ['20121', '20122', '20123'],
        ]);

        expect($milanoComune->hasPostalCode('20121'))->toBeTrue()
            ->and($milanoComune->hasPostalCode('00100'))->toBeFalse(); // Rome postal code
    });

    it('provides statistical data for healthcare planning', function () {
        $region = Region::factory()->create([
            'population' => 10000000,
            'area_km2' => 23844,
        ]);

        $density = $region->getPopulationDensity();
        
        expect($density)->toBeFloat()
            ->and($density)->toBeGreaterThan(0);
    });
});
```

### 3. Location Services Tests

```php
describe('Location Services Business Logic', function () {
    it('calculates distance between two addresses', function () {
        $address1 = Address::factory()->create([
            'latitude' => 45.4642, // Milano
            'longitude' => 9.1900,
        ]);
        
        $address2 = Address::factory()->create([
            'latitude' => 41.9028, // Roma
            'longitude' => 12.4964,
        ]);

        $distance = $address1->distanceTo($address2);
        
        expect($distance)->toBeFloat()
            ->and($distance)->toBeGreaterThan(400) // ~480km Milano-Roma
            ->and($distance)->toBeLessThan(600);
    });

    it('finds addresses within radius', function () {
        $centerAddress = Address::factory()->create([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);
        
        // Create addresses at various distances
        $nearAddress = Address::factory()->create([
            'latitude' => 45.4700, // ~1km away
            'longitude' => 9.1950,
        ]);
        
        $farAddress = Address::factory()->create([
            'latitude' => 41.9028, // ~480km away
            'longitude' => 12.4964,
        ]);

        $nearbyAddresses = Address::withinRadius($centerAddress, 5); // 5km radius
        
        expect($nearbyAddresses)->toContain($nearAddress)
            ->and($nearbyAddresses)->not->toContain($farAddress);
    });

    it('optimizes routes for multiple destinations', function () {
        $startAddress = Address::factory()->create();
        $destinations = Address::factory()->count(5)->create();

        $optimizer = new RouteOptimizer();
        $optimizedRoute = $optimizer->optimize($startAddress, $destinations);
        
        expect($optimizedRoute)->toBeArray()
            ->and($optimizedRoute)->toHaveCount(5)
            ->and($optimizedRoute['total_distance'])->toBeFloat();
    });
});
```

### 4. Geocoding Integration Tests

```php
describe('Geocoding Integration', function () {
    it('geocodes Italian addresses accurately', function () {
        $address = Address::factory()->create([
            'street' => 'Piazza del Duomo 1',
            'city' => 'Milano',
            'postal_code' => '20121',
        ]);

        $geocoded = GeocodingService::geocode($address);
        
        expect($geocoded['latitude'])->toBeFloat()
            ->and($geocoded['longitude'])->toBeFloat()
            ->and($geocoded['accuracy'])->toBeGreaterThan(0.8);
    });

    it('handles geocoding failures gracefully', function () {
        $invalidAddress = Address::factory()->create([
            'street' => 'Invalid Street 999999',
            'city' => 'NonExistentCity',
            'postal_code' => '99999',
        ]);

        $result = GeocodingService::geocode($invalidAddress);
        
        expect($result['success'])->toBeFalse()
            ->and($result['error'])->not->toBeNull();
    });

    it('reverse geocodes coordinates to addresses', function () {
        $latitude = 45.4642; // Milano coordinates
        $longitude = 9.1900;

        $address = GeocodingService::reverseGeocode($latitude, $longitude);
        
        expect($address)->toBeArray()
            ->and($address['city'])->toContain('Milano')
            ->and($address['country'])->toBe('IT');
    });
});
```

### 5. Healthcare Integration Tests

```php
describe('Healthcare Location Integration', function () {
    it('matches patients with nearest healthcare providers', function () {
        $patientAddress = Address::factory()->create([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);
        
        $nearProvider = HealthcareProvider::factory()->create([
            'address_id' => Address::factory()->create([
                'latitude' => 45.4700, // 1km away
                'longitude' => 9.1950,
            ])->id,
        ]);
        
        $farProvider = HealthcareProvider::factory()->create([
            'address_id' => Address::factory()->create([
                'latitude' => 41.9028, // 480km away
                'longitude' => 12.4964,
            ])->id,
        ]);

        $nearestProviders = HealthcareProvider::nearestTo($patientAddress, 10); // 10km radius
        
        expect($nearestProviders)->toContain($nearProvider)
            ->and($nearestProviders)->not->toContain($farProvider);
    });

    it('calculates travel time for appointments', function () {
        $patientAddress = Address::factory()->create();
        $providerAddress = Address::factory()->create();

        $travelTime = TravelTimeCalculator::calculate($patientAddress, $providerAddress);
        
        expect($travelTime)->toBeArray()
            ->and($travelTime['driving_minutes'])->toBeInt()
            ->and($travelTime['walking_minutes'])->toBeInt()
            ->and($travelTime['public_transport_minutes'])->toBeInt();
    });

    it('defines service coverage areas', function () {
        $providerAddress = Address::factory()->create();
        $coverageRadius = 15; // 15km radius

        $coverageArea = ServiceCoverageArea::create([
            'provider_id' => $provider->id,
            'center_address_id' => $providerAddress->id,
            'radius_km' => $coverageRadius,
        ]);

        $testAddress = Address::factory()->create();
        $isInCoverage = $coverageArea->covers($testAddress);
        
        expect($isInCoverage)->toBeBool();
    });
});
```

## Performance Tests

### Geographic Calculations
```php
describe('Geographic Performance', function () {
    it('performs distance calculations efficiently', function () {
        $addresses = Address::factory()->count(1000)->create();
        $centerAddress = $addresses->first();

        $startTime = microtime(true);
        
        $nearbyAddresses = Address::withinRadius($centerAddress, 10);
        
        $duration = microtime(true) - $startTime;
        
        expect($duration)->toBeLessThan(2.0) // 2 seconds max
            ->and($nearbyAddresses)->toBeInstanceOf(Collection::class);
    });

    it('handles large geocoding batches', function () {
        $addresses = Address::factory()->count(100)->create();

        $startTime = microtime(true);
        
        $geocoded = GeocodingService::batchGeocode($addresses);
        
        $duration = microtime(true) - $startTime;
        
        expect($duration)->toBeLessThan(30.0) // 30 seconds max
            ->and($geocoded)->toHaveCount(100);
    });
});
```

## Quality Standards

### Test Requirements
- All tests use `declare(strict_types=1);`
- Descriptive test names explaining geographic scenarios
- Complete setup and teardown
- Meaningful assertions covering location accuracy
- Performance benchmarks for geographic calculations

### Business Logic Focus
- Address validation and standardization
- Geographic relationship integrity
- Location-based service accuracy
- Healthcare facility mapping
- Emergency response coordination

---

**Last Updated**: 2025-08-28
**Testing Framework**: Pest
**Environment**: .env.testing
