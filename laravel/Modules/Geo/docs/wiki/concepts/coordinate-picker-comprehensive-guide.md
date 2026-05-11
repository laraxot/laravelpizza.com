---
name: Coordinate Picker Comprehensive Guide
description: Complete guide for Geo module coordinate pickers with best practices, bad practices, and false friends.
type: concept
---

# Coordinate Picker Comprehensive Guide

## Overview
The Geo module provides multiple coordinate picker components for Filament v5 forms. All components extend `XotBaseField` and use the `HasCoordinatePicker` trait.

## Component Family (Siblings, NOT Hierarchy)

| Component | Purpose | DB Columns |
|-----------|---------|-------------|
| `CoordinatePicker` | Full-featured picker with search, layers, fullscreen | `latitude`, `longitude` |
| `GeopointPicker` | Database-centric point extraction | `latitude`, `longitude` |
| `LatitudeLongitudeInput` | Simple lat/lng inputs | `latitude`, `longitude` |
| `LeafletMarkerMapInput` | Marker-focused with Leaflet | `latitude`, `longitude` |
| `LocationPicker` | Location with address details | `location` (JSON) |
| `MapLocationInput` | Map-based location picker | `location` (JSON) |
| `MapPicker` | Basic map picker | `latitude`, `longitude` |
| `MapPositioner` | Position marker on map | `latitude`, `longitude` |
| `PlacePicker` | Place search with autocomplete | `location` (JSON) |

## Best Practices ✅

### 1. Always Extend XotBaseField
```php
// CORRECT
class CoordinatePicker extends XotBaseField
{
    use HasCoordinatePicker;
}

// WRONG
class CoordinatePicker extends Field  // Breaks XotBaseField features
```

### 2. No Static $view Property
```php
// WRONG - Do NOT do this
class CoordinatePicker extends XotBaseField
{
    protected string $view = 'geo::components.coordinate-picker';
}

// CORRECT - Let XotBaseField resolve view dynamically
class CoordinatePicker extends XotBaseField
{
    use HasCoordinatePicker;
    // View resolved via Spatie Queryable actions
}
```

### 3. Use Light DOM for Lit Components
```javascript
// CORRECT - Light DOM for Leaflet compatibility
createRenderRoot() {
    return this;  // Light DOM
}

// WRONG - Shadow DOM breaks Leaflet CSS
// Shadow DOM is default in Lit
```

### 4. Proper MutationObserver Depth (≥12)
```javascript
// CORRECT - Depth 12+ for Filament 5 wizard steps
this._mutationObserver = new MutationObserver(() => {
    if (this.offsetParent !== null) {
        this._refreshMapSize();
    }
});
let parent = this.parentElement;
for (let i = 0; i < 12 && parent; i++) {  // NOT 6!
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}
```

### 5. Debounce Map Interactions
```javascript
// CORRECT
const debounce = (fn, delay) => {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), delay);
  };
};

_handleMapInteraction(lat, lng) {
    this._debounceMapUpdate(() => {
        this.state = { latitude: lat, longitude: lng };
        this.dispatchEvent(new CustomEvent('coords-changed', {
            detail: { latitude: lat, longitude: lng }
        }));
    });
}
```

### 6. Use Class Selectors, NOT IDs
```javascript
// CORRECT
const el = this.querySelector('.map-picker-leaflet-pane');

// WRONG - Causes conflicts with multiple maps
const el = document.getElementById('map');
```

### 7. Always Clean Up in disconnectedCallback
```javascript
disconnectedCallback() {
    super.disconnectedCallback();
    if (this._map) {
        this._map.remove();
        this._map = null;
    }
    this._resizeObserver?.disconnect();
    this._mutationObserver?.disconnect();
    clearTimeout(this._debounceTimeout);
}
```

### 8. Provide Fallback Center
```php
// In setUp() or setUpCoordinatePicker()
$centerLat = $this->getCenterLatitude() ?? 41.9028;  // Rome
$centerLng = $this->getCenterLongitude() ?? 12.4964;
```

### 9. Server-Side Geocoding Only
```php
// CORRECT - Via Livewire
async searchAddress(query) {
    const results = await this.$wire.callSchemaComponentMethod(
        '{{ $id }}',
        'searchAddress',
        { query }
    );
}

// WRONG - Client-side exposes IP, no rate limiting
fetch('https://nominatim.openstreetmap.org/search?...')
```

### 10. Respect Nominatim Usage Policy
```php
$response = Http::withHeaders([
    'User-Agent' => config('app.name', 'Laraxot') . '/1.0',
])->get('https://nominatim.openstreetmap.org/search', [
    'q' => $query,
    'format' => 'json',
    'limit' => 5,
    'countrycodes' => 'it',
]);
```

## Bad Practices ❌

| Bad Practice | Why Wrong | Correct Alternative |
|-------------|-----------|-------------------|
| `LatitudeLongitudeInput extends CoordinatePicker` | Tight coupling | Sibling pattern - both use `HasCoordinatePicker` |
| `id="map"` or `document.getElementById()` | ID conflicts with multiple maps | Class selector `.coordinate-picker-map` |
| `wire:entangle` on Lit component | Creates event loops | `$wire.$set` + `$wire.$watch` with `_suppressUpdate` |
| Separate `lat`/`lng` Alpine vars | Breaks SoT (Single Source of Truth) | Single state object |
| Calling Nominatim directly from JS | Exposes IP, no cache | Route through Livewire |
| `navigator.geolocation` on mount | Invasive privacy prompt | Explicit button only |
| Livewire on every `mousemove`/`drag` | Performance thrashing | `dragend`, `click`, `geolocation success` only |
| Hardcoding Italian strings in JS | Breaks i18n | Pass via `labels` JSON attribute |
| `shouldUpdate()` for state sync | Misuse of Lit hook | `updated()` with `_isProgrammaticUpdate` guard |
| No `invalidateSize()` after resize | Blank tiles | ResizeObserver + setTimeout |
| `protected string $view = '...'` | Static view breaks dynamic resolution | Remove `$view`, use Spatie Queryable actions |

## False Friends 🚫

| False Belief | Reality |
|--------------|---------|
| Shadow DOM better for encapsulation | Leaflet breaks in Shadow DOM. Use **Light DOM**. |
| Automatic geolocation on mount | Invasive. Make it **explicit** (button click). |
| `shouldUpdate()` for state sync | Only for re-render optimization, not data sync. |
| `marker.setLatLng()` immediate after init | Wait for `invalidateSize()` + debounce. |
| `entangle` simpler than `$wire.$set` | Creates feedback loops. Use explicit sync. |
| Store lat/lng in Alpine for speed | Breaks SoT. **Livewire is the truth**. |
| Geocoding client-only | Must go **server-side** for rate-limiting. |
| One Leaflet zoom control enough | Custom controls + `zoomControl: false`. |
| Layer control optional | **4 layers REQUIRED** (street, humanitarian, satellite, topographic). |
| GPS coordinates always floats | Nominatim returns strings. Use `parseFloat()`. |
| `IntersectionObserver` detects `class="hidden"` | **FALSE** - use `MutationObserver` with depth ≥12. |
| Single `invalidateSize()` enough | **FALSE** - Need `layer.redraw()` + multiple delays. |

## Map Visibility Fix Checklist

When map doesn't appear in wizard step:

- [ ] **Check `showSearch()` method exists** on picker class
- [ ] **Container has explicit height**: `h-[340px]` or `style="--map-height: 400px;"`
- [ ] **z-index high enough**: `z-[1050]` on map container
- [ ] **`overflow: visible`** on map wrapper
- [ ] **MutationObserver depth ≥12** in Lit component
- [ ] **No `class="hidden"`** on parent wrapper at render time
- [ ] **Leaflet CSS imported**: `import 'leaflet/dist/leaflet.css'` in JS
- [ ] **No CDN URLs**: Don't use `unpkg.com/leaflet` (breaks without internet)
- [ ] **Clean up commented components**: Remove `/* GeopointPicker::make(...) */` blocks

## File References

```
laravel/Modules/Geo/
├── app/Filament/Forms/Components/
│   ├── CoordinatePicker.php
│   ├── GeopointPicker.php
│   ├── LatitudeLongitudeInput.php
│   ├── LeafletMarkerMapInput.php
│   ├── LocationPicker.php
│   ├── MapLocationInput.php
│   ├── MapPicker.php
│   ├── MapPositioner.php
│   ├── PlacePicker.php
│   └── Traits/
│       └── HasCoordinatePicker.php
├── resources/
│   ├── js/components/
│   │   ├── coordinate-picker-lit.js
│   │   ├── geopoint-picker-lit.js
│   │   └── map-picker-marker-config.js
│   └── views/filament/forms/components/
│       ├── coordinate-picker.blade.php
│       ├── geopoint-picker.blade.php
│       └── map-picker.blade.php
└── lang/
    ├── it/coordinate-picker.php
    └── en/coordinate-picker.php
```

## Testing Checklist

### Functional
- [ ] Zoom + increases zoom
- [ ] Zoom − decreases zoom
- [ ] Fullscreen toggle opens/closes correctly
- [ ] "Usa la mia posizione" triggers permission prompt
- [ ] Geolocation updates marker and coordinates
- [ ] Layer switcher shows 4 layers
- [ ] Clicking on map places/moves marker
- [ ] Dragging marker updates on dragend
- [ ] Search with ≥3 chars shows dropdown
- [ ] Search result click: marker moves, address fields populated
- [ ] Reverse geocode: all address fields populated

### Performance
- [ ] No Livewire request during drag
- [ ] Search debounced at 500ms
- [ ] `invalidateSize()` on container resize
- [ ] Fullscreen `invalidateSize()` after 300ms

### Accessibility
- [ ] All buttons have `aria-label`
- [ ] Screen reader live region updates
- [ ] Search input has `aria-autocomplete`, `aria-controls`, `aria-expanded`
- [ ] ESC closes dropdown and fullscreen
- [ ] Tab order logical

---

*Last updated: 2026-04-23*
