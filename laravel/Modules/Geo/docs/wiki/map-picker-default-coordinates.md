# MapPicker Default Coordinates Rule

## Rule Summary
- If `latitude` or `longitude` is null, use `getCurrentCoordinates()`
- Fallback to `41.9028, 12.4964` if geo fails

## Implementation
```php
// MapPicker.php
if ($latitude === null || $longitude === null) {
    $this->center(self::getCurrentCoordinates());
}
```

## Impact
- Ensures valid center point on form load
- Prevents empty map UI

## References
- `laravel/Modules/Geo/docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- Story 8-27 fix