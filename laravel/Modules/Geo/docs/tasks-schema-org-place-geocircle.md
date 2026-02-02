# Task: Implement Schema.org GeoCircle and Place Enhancement

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 1-2 days
**Reference**: [Schema.org GeoCircle](https://schema.org/GeoCircle), [Place](https://schema.org/Place)

---

## Objective

Enhance the Geo module with Schema.org compliant GeoCircle support for service areas and improve Place model with full Schema.org structured data.

---

## GeoCircle Implementation

### Key Properties

| Property      | Type            | Description      |
|--------------|-----------------|------------------|
| `geoMidpoint` | GeoCoordinates  | Center of circle |
| `geoRadius`   | Distance/Number | Radius in meters |

### Trait: HasGeoCircle

```php
// Traits/HasGeoCircle.php
namespace Modules\Geo\Traits;

trait HasGeoCircle
{
    public function toGeoCircleSchema(): ?array
    {
        if (!$this->latitude || !$this->longitude || !$this->radius_m) {
            return null;
        }
        
        return [
            '@type' => 'GeoCircle',
            'geoMidpoint' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'geoRadius' => $this->radius_m,
        ];
    }
    
    public function isWithinRadius(float $lat, float $lng): bool
    {
        $distanceM = $this->calculateDistanceMeters($lat, $lng);

        return $distanceM <= $this->radius_m;
    }
    
    protected function calculateDistanceMeters(float $lat, float $lng): float
    {
        $earthRadius = 6371000; // m
        $dLat = deg2rad($lat - $this->latitude);
        $dLon = deg2rad($lng - $this->longitude);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($this->latitude)) * cos(deg2rad($lat)) *
            sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }
}
```

### Use Cases

1. **Delivery Zones**: Food delivery radius for restaurants
2. **Service Areas**: Geographic coverage for businesses
3. **Event Discovery**: "Events near me" feature
4. **Venue Catchment**: Target audience geographic area

---

## Place Model Enhancement

### Current State (already has toSchemaOrg)

Update to include full Schema.org Place properties:

```php
// Place.php enhanced toSchemaOrg()
public function toSchemaOrg(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Place',
        'name' => $this->name,
        'description' => $this->description,
        'address' => $this->getAddressSchemaOrg(),
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ],
        'telephone' => $this->telephone,
        'url' => $this->url,
        'photo' => $this->photo ? asset($this->photo) : null,
        'openingHoursSpecification' => $this->getOpeningHoursSchema(),
        'amenityFeature' => $this->getAmenitiesSchema(),
        'maximumAttendeeCapacity' => $this->max_capacity,
    ];
}

protected function getAddressSchemaOrg(): ?array
{
    if (!$this->address) {
        return null;
    }
    
    return [
        '@type' => 'PostalAddress',
        'streetAddress' => $this->address->street_address,
        'addressLocality' => $this->address->city,
        'addressRegion' => $this->address->region,
        'postalCode' => $this->address->postal_code,
        'addressCountry' => $this->address->country_code ?? 'IT',
    ];
}
```

---

## Italian Administrative Levels

When processing Google Maps API responses:

| Level                        | Italian Name | Example   |
|-----------------------------|--------------|-----------|
| administrative_area_level_1  | Regione      | Lombardia |
| administrative_area_level_2  | Provincia    | Milano    |
| administrative_area_level_3  | Comune       | Milano    |

---

## Database Changes

```php
// Nota: per regole Laraxot, evitare "migration di update" separate.
// Copiare la migrazione di creazione della tabella, aggiornare il timestamp,
// e aggiungere i campi in modo idempotente.
$table->unsignedInteger('service_radius_m')->nullable();
$table->json('service_area_polygon')->nullable();
$table->json('amenities')->nullable();
$table->unsignedInteger('max_capacity')->nullable();
```

---

## Implementation Steps

- [ ] Create `HasGeoCircle` trait
- [ ] Add service area fields to places table
- [ ] Update Place model with trait
- [ ] Enhance `toSchemaOrg()` with full properties
- [ ] Create action for "places within radius" query
- [ ] Update Filament PlaceResource
- [ ] Write Pest tests for distance calculation
- [ ] Update documentation

---

## Related Files

- `Modules/Geo/app/Models/Place.php`
- `Modules/Geo/app/Traits/HasGeoCircle.php` (new)
- `Modules/Geo/database/migrations/xxxx_add_service_area.php` (new)

---

## Acceptance Criteria

1. Places can have a service radius
2. GeoCircle Schema.org output is correct
3. Distance calculation is accurate
4. "Places within radius" query works
5. PHPStan Level 10 passes
6. Pest tests cover all scenarios

---

**Created**: 2026-02-10
**Reference**: [Schema.org GeoCircle](https://schema.org/GeoCircle)
