# Map Default Coordinates in Wizard Steps

## Problem
When latitude/longitude are null in wizard steps, MapPicker fails to center on current location, causing flickering and blank areas.

## Root Cause
1. Initial state has null coordinates
2. Map initializes with default (41.9028, 12.4964) but doesn't update when coordinates become available
3. Livewire updates trigger re-renders that reset map state

## Implementation
### Auto-geolocate on null coordinates
```javascript
_initMap() {
    const el = this.renderRoot.querySelector('.map-picker-leaflet-pane');
    if (!el || this._map) return;

    // Critical: Use current coordinates when available, otherwise geolocate
    const centerLat = this._lat ?? await this._getCurrentLatitude();
    const centerLng = this._lng ?? await this._getCurrentLongitude();

    this._map = L.map(el, {
        center: [centerLat, centerLng],
        zoom: this.zoom,
        zoomControl: false,
        attributionControl: false
    });
}
```

### Geolocation fallback methods
```javascript
async _getCurrentLatitude() {
    if (navigator.geolocation) {
        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => resolve(pos.coords.latitude),
                () => resolve(41.9028) // Rome fallback
            );
        });
    }
    return 41.9028;
}

async _getCurrentLongitude() {
    if (navigator.geolocation) {
        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => resolve(pos.coords.longitude),
                () => resolve(12.4964) // Rome fallback
            );
        });
    }
    return 12.4964;
}
```

## Verification
- [ ] Map centers on user location when lat/lng=null
- [ ] No flickering during coordinate updates
- [ ] Smooth transition from geolocate to user-provided coords
- [ ] Fallback to Rome coordinates when geolocation unavailable