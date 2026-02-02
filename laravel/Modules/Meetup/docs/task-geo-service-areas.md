# Task: Implement GeoCircle for Service Areas

**Priority**: LOW
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org GeoCircle](https://schema.org/GeoCircle)

---

## Objective

Implement `GeoCircle` support for defining circular geographic areas used for:
- Delivery zones for food establishments
- Event catchment areas
- Service coverage areas

---

## Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `geoMidpoint` | GeoCoordinates | Center of circle |
| `geoRadius` | Distance/Number | Radius in meters |

---

## Implementation

```php
// Trait: HasGeoCircle
trait HasGeoCircle
{
    public function toGeoCircleSchema(): array
    {
        return [
            '@type' => 'GeoCircle',
            'geoMidpoint' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'geoRadius' => [
                '@type' => 'Distance',
                'value' => $this->radius_km,
                'unitCode' => 'KM',
            ],
        ];
    }
}
```

---

## Use Cases

1. **Delivery Zones**: Food delivery radius
2. **Event Discovery**: "Events near me" feature
3. **Venue Service Area**: Geographic coverage

---

## Implementation Steps

- [ ] Create `HasGeoCircle` trait
- [ ] Add radius fields to relevant models
- [ ] Implement `toGeoCircleSchema()` method
- [ ] Update Geo module Place model
- [ ] Write Pest tests

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
