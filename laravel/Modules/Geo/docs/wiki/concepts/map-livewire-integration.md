# Map-Livewire Integration Guide

> How to properly integrate Leaflet maps with Filament v5 + Livewire v3

---

## The Golden Rule

```
wire:ignore = Required for all map containers
```

Livewire's DOM diffing and external map libraries (Leaflet, Mapbox, Google Maps) **do not mix** without explicit boundaries.

---

## The Problem Explained

### Livewire's Lifecycle

```
1. Initial Render
   └─> Blade renders HTML
   └─> Livewire hydrates component
   └─> Leaflet initializes on DOM node

2. State Change
   └─> User drags map marker
   └─> Leaflet updates position
   └─> @entangle triggers Livewire
   └─> Livewire detects "change"
   └─> Livewire re-renders component
   └─> Leaflet DOM destroyed! 💥
   └─> Map disappears
```

### The Infinite Loop

Without `wire:ignore`, this happens:

1. Map emits `coords-changed`
2. `@entangle($state)` updates
3. Livewire re-renders
4. Map DOM destroyed and recreated
5. Map re-initializes
6. Map emits another event
7. **LOOP FOREVER** 🔁

---

## The Solution: wire:ignore

`wire:ignore` tells Livewire: **"Don't touch this subtree. I'll manage it myself."**

```blade
<div wire:ignore>  <!-- 🛡️ Livewire shield -->
    <div class="map-container"></div>
</div>
```

### What wire:ignore Does

- Prevents Livewire from morphing (diffing) the element
- Preserves external library DOM
- Allows manual coordination via events

### What wire:ignore Does NOT Do

- Block Livewire from receiving events
- Prevent `$wire.*` method calls
- Stop Alpine.js from working

---

## Implementation Patterns

### Pattern A: Full Container Ignore (Recommended)

```blade
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div wire:ignore class="map-wrapper">
        <div class="map-container" style="height: 400px;"></div>
        
        <!-- Optional: Overlay controls -->
        <div class="map-controls">
            <button @click="$wire.centerOnUser()">My Location</button>
        </div>
    </div>
</x-dynamic-component>
```

### Pattern B: Self Ignore (Element only)

```blade
<div>
    <!-- Other Livewire-managed fields -->
    <input wire:model="name">
    
    <!-- Map ignored -->
    <div wire:ignore.self class="map-container" style="height: 400px;"></div>
</div>
```

### Pattern C: Targeted Ignore (Specific children)

```blade
<div wire:ignore="map-container">
    <div x-ref="mapContainer" class="map-container"></div>
</div>
```

---

## Communication Without @entangle

Since `@entangle` causes loops, use **explicit events**:

### Client → Server (User drags marker)

```blade
<coordinate-picker-lit
    @coords-changed="
        $wire.set('latitude', $event.detail.lat, false);
        $wire.set('longitude', $event.detail.lng, false);
    "
></coordinate-picker-lit>
```

### Server → Client (Programmatic update)

```php
#[Renderless]  // ⚡ No re-render!
public function flyToLocation(float $lat, float $lng): void
{
    $this->dispatch('fly-to', lat: $lat, lng: $lng);
}
```

```blade
<coordinate-picker-lit
    x-on:fly-to.window="
        $refs.picker.setCoordinates($event.detail.lat, $event.detail.lng);
    "
></coordinate-picker-lit>
```

---

## Complete Working Example

### Component Class

```php
<?php

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Attributes\Renderless;

class CoordinatePicker extends Field
{
    protected string $view = 'geo::filament.forms.components.coordinate-picker';
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->default([
            'latitude' => null,
            'longitude' => null,
        ]);
    }
    
    #[Renderless]
    public function updateCoordinates(float $lat, float $lng): void
    {
        $this->state = [
            'latitude' => $lat,
            'longitude' => $lng,
        ];
    }
    
    public function reverseGeocode(float $lat, float $lng): ?array
    {
        // Call geocoding service
        return app(GeocodingService::class)->reverse($lat, $lng);
    }
}
```

### Blade View

```blade
@php
$statePath = $field->getStatePath();
$id = $field->getId();

// Get current values (static, not reactive)
$currentLat = $field->getState()['latitude'] ?? 41.9028;
$currentLng = $field->getState()['longitude'] ?? 12.4964;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- 🛡️ wire:ignore prevents DOM destruction --}}
    <div wire:ignore class="coordinate-picker-wrapper">
        
        <coordinate-picker-lit
            x-ref="picker"
            :initial-lat="{{ $currentLat }}"
            :initial-lng="{{ $currentLng }}"
            :zoom="{{ $field->getZoom() }}"
            @coords-changed="
                $wire.updateCoordinates(
                    $event.detail.lat, 
                    $event.detail.lng
                )
            "
        ></coordinate-picker-lit>
        
        {{-- Readout summary (outside wire:ignore) --}}
        <div class="coordinates-display">
            Lat: {{ $currentLat }}
            Lng: {{ $currentLng }}
        </div>
    </div>
</x-dynamic-component>
```

### Lit Component

```javascript
// coordinate-picker-lit.js
import { LitElement, html, css } from 'lit';
import L from 'leaflet';

export class CoordinatePickerLit extends LitElement {
    static properties = {
        initialLat: { type: Number },
        initialLng: { type: Number },
        zoom: { type: Number },
    };
    
    firstUpdated() {
        const container = this.querySelector('.map-container');
        
        // Prevent double initialization
        if (container._leaflet_map) return;
        
        // Initialize map
        const map = L.map(container).setView(
            [this.initialLat, this.initialLng], 
            this.zoom
        );
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        
        // Add draggable marker
        const marker = L.marker([this.initialLat, this.initialLng], {
            draggable: true
        }).addTo(map);
        
        // Emit event on drag end
        marker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng();
            this._emitCoords(lat, lng, 'drag');
        });
        
        // Track for cleanup
        container._leaflet_map = map;
        container._leaflet_marker = marker;
    }
    
    // Called by parent to update programmatically
    setCoordinates(lat, lng) {
        const container = this.querySelector('.map-container');
        const map = container?._leaflet_map;
        const marker = container?._leaflet_marker;
        
        if (map && marker) {
            marker.setLatLng([lat, lng]);
            map.panTo([lat, lng]);
        }
    }
    
    _emitCoords(lat, lng, source) {
        this.dispatchEvent(new CustomEvent('coords-changed', {
            detail: { lat, lng, source },
            bubbles: true,
            composed: true,
        }));
    }
    
    disconnectedCallback() {
        super.disconnectedCallback();
        
        // Cleanup to prevent memory leaks
        const container = this.querySelector('.map-container');
        if (container?._leaflet_map) {
            container._leaflet_map.remove();
            container._leaflet_map = null;
            container._leaflet_marker = null;
        }
    }
    
    render() {
        return html`
            <div class="map-container" style="height: 340px;"></div>
        `;
    }
}

customElements.define('coordinate-picker-lit', CoordinatePickerLit);
```

---

## Common Pitfalls

### Pitfall 1: Forgetting Container Height

```blade
<!-- ❌ WRONG - No height -->
<div wire:ignore>
    <div class="map-container"></div>
</div>

<!-- ✅ CORRECT - Explicit height -->
<div wire:ignore>
    <div class="map-container" style="height: 400px;"></div>
</div>
```

**Symptom:** Map container is white/empty

### Pitfall 2: Using @entangle Anyway

```blade
<!-- ❌ WRONG - Infinite loop -->
<div x-data="{ coords: @entangle($statePath) }" wire:ignore>
    <div class="map-container"></div>
</div>
```

**Symptom:** Console errors, browser freeze, high CPU

### Pitfall 3: No Cleanup

```javascript
// ❌ WRONG - Memory leak
class MapComponent extends LitElement {
    firstUpdated() {
        this._map = L.map(this.renderRoot.querySelector('.map-container'));
    }
}

// ✅ CORRECT - Cleanup
class MapComponent extends LitElement {
    disconnectedCallback() {
        this._map?.remove();
    }
}
```

**Symptom:** Memory leaks, slow performance over time

### Pitfall 4: Using ID Selectors

```javascript
// ❌ WRONG - ID collision
const map = L.map('map');

// ✅ CORRECT - Class selector
const map = L.map(this.querySelector('.map-container'));
```

**Symptom:** Multiple maps show same data, random map updates

---

## Testing Your Implementation

### Checklist

- [ ] Map visible on initial load
- [ ] Map persists after marker drag
- [ ] No console errors (especially loops)
- [ ] Network tab shows no excessive requests
- [ ] Map works in wizard/step transitions
- [ ] No memory leaks (check Performance tab)

### Debug Commands

```javascript
// Check if wire:ignore is working
$0.closest('[wire\\:ignore]')  // Should return the wrapper

// Check for map instance
$0.querySelector('.map-container')._leaflet_map  // Should return L.Map

// Monitor Livewire updates
Livewire.hook('message.processed', () => {
    console.log('Livewire updated - map should still be there');
});
```

---

## Advanced Patterns

### Dynamic Height

```blade
<div wire:ignore class="map-wrapper" 
     style="height: {{ $isFullscreen ? '100vh' : '340px' }}">
    <div class="map-container" style="height: 100%;"></div>
</div>
```

### Multiple Maps

```blade
<div wire:ignore class="maps-container">
    @foreach($locations as $location)
        <div class="map-instance" 
             data-lat="{{ $location['lat'] }}"
             data-lng="{{ $location['lng'] }}"
             style="height: 200px;">
        </div>
    @endforeach
</div>
```

### Conditional Map

```blade
@if($showMap)
    <div wire:ignore class="map-wrapper">
        <div class="map-container" style="height: 400px;"></div>
    </div>
@endif
```

---

## References

### Internal
- **Rule**: `.windsurf/rules/map-livewire-ignore.mdc`
- **Rule**: `.windsurf/rules/leaflet-class-selector.mdc`
- **Story**: `.planning/stories/8-39-coordinate-picker-map-visibility-fix.story.md`

### External
- **Livewire wire:ignore**: https://livewire.laravel.com/docs/wire-ignore
- **Leaflet Docs**: https://leafletjs.com/reference.html
- **Filament Custom Fields**: https://filamentphp.com/docs/5.x/forms/custom-fields

---

## Summary

| Do | Don't |
|----|-------|
| ✅ `wire:ignore` on map container | ❌ `@entangle` with map state |
| ✅ Class selectors (`.map-container`) | ❌ ID selectors (`#map`) |
| ✅ Explicit events for communication | ❌ Reactive property binding |
| ✅ `#[Renderless]` for updates | ❌ Default Livewire re-renders |
| ✅ Cleanup in `disconnectedCallback` | ❌ Leave map instances hanging |
| ✅ Static initial values | ❌ Dynamic reactive props |

---

**Remember: `wire:ignore` draws the boundary between Livewire's world and the external library's world.**
