# Map Geolocation Fallback Rule (Golden Rule)

**Status**: active | **Applies to**: all map picker components in Geo module

## The Rule

```
if (latitude == null || longitude == null) {
    latitude  = getCurrentLatitude()   // via browser geolocation API
    longitude = getCurrentLongitude()
}
```

If either coordinate is missing/null when a map component initializes, it **must** auto-geolocate using the browser's Geolocation API.

## Implementation

### JavaScript (Lit components)

All map components implement this via a `_geolocRequested` guard (single-trigger):

```javascript
// In constructor:
this._geolocRequested = false;

// Called from initMap() / _initMap() when hasCompleteCoordinates() is false:
_autoGeolocate() {
    if (this._geolocRequested) return; // never trigger twice
    this._geolocRequested = true;
    if (!navigator.geolocation) return; // silent fallback — use default center
    navigator.geolocation.getCurrentPosition(
        (pos) => { this.updateState(pos.coords.latitude, pos.coords.longitude, 'geolocation-auto'); },
        () => {}, // denied — map stays on default center
        { enableHighAccuracy: true, timeout: 5000, maximumAge: 60000 }
    );
}
```

### Files that implement this rule

| File | Method |
|------|--------|
| `coordinate-picker-field.js` | `autolocateWhenCoordinatesMissing()` + `_autoGeolocate()` |
| `map-picker-lit.js` | `_autolocateWhenCoordinatesMissing()` |

## Fallback chain

1. `latitude` and `longitude` are finite numbers → use them
2. Browser geolocation available and granted → use GPS position
3. Geolocation denied or unavailable → use `defaultLatitude` / `defaultLongitude` (default: Rome 41.9028, 12.4964)

## Guard: `_geolocRequested`

- Set to `true` on first geolocation attempt
- Prevents double-trigger from re-renders, Livewire updates, or `applyExternalLocation(null)` calls
- Reset only on component disconnect/destroy

## Notes

- `applyExternalLocation(null)` must NOT re-trigger geolocation — it means "server has no coords yet"
- User-triggered geolocation (📍 button) uses `handleGeolocation()` / `_handleGeolocation()` which is separate and not guarded
