---
title: "Geo Module Best Practices"
type: concept
sources: ["../../Modules/Geo/app/Filament/Forms/Components/"]
confidence: high
created: 2026-04-28
updated: 2026-04-28
tags: [geo, best-practices, leaflet, map-components, filament-5]
related:
  - concepts/coordinate-picker-best-practices.md
  - concepts/svg-asset-architecture.md
  - concepts/leaflet-class-selector-governance.md
---

# Geo Module Best Practices

## Overview

Best practices per lo sviluppo e manutenzione del modulo Geo.

## ✅ Best Practices

### 1. SVG Assets in `resources/svg/`
```bash
# ✅ SI
Modules/Geo/resources/svg/map-pin.svg
Modules/Geo/resources/svg/location-crosshairs.svg

# ❌ NO
public/img/icons/  # NON in public/
cdn.unpkg.com    # NON CDN esterni
```

### 2. Registrazione icone via XotBaseServiceProvider
```php
// ✅ SI - in XotBaseServiceProvider del modulo Xot
$this->publishes([
    __DIR__.'/../resources/svg' => public_path('svg/geo'),
], 'geo-svg');

// ❌ NO - in moduli figli o temi
```

### 3. Class selectors per Leaflet (NO IDs)
```javascript
// ✅ SI
document.querySelector('.map-container')

// ❌ NO
document.getElementById('map')  // collisioni con multiple mappe
```

### 4. Invalidare dimensioni mappa dopo mount
```javascript
// In Lit component
firstUpdated() {
    this.invalidateMapSize();
}
```

### 5. Usare `IntersectionObserver` per visibilità
```javascript
// ✅ SI - rileva quando il container diventa visibile
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        map.invalidateSize();
    }
});
```

## ❌ Bad Practices

### 1. CDN per Leaflet CSS/JS
```html
<!-- ❌ NO -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- ✅ SI -->
@vite('resources/js/leaflet-config.js')
```

### 2. ID globali per container mappe
```html
<!-- ❌ NO -->
<div id="map"></div>

<!-- ✅ SI -->
<div class="map-container" data-map-id="{{ $ticket->id }}"></div>
```

### 3. Hardcodare dimensioni mappa
```css
/* ❌ NO */
.leaflet-container { width: 600px; height: 400px; }

/* ✅ SI */
.leaflet-container { width: 100%; height: 100%; }
```

## 🔗 False Friends

### `MapPicker` vs `CoordinatePicker`
- **False Friend**: Pensare che siano interscambiabili
- **Realtà**: `MapPicker` è legacy (Lit + Leaflet), `CoordinatePicker` è Filament 5 custom field
- **Soluzione**: Usare `CoordinatePicker` per nuovi progetti Filament 5

### `resources/svg/` vs `public/svg/`
- **False Friend**: Pensare che `public/svg/` sia il percorso corretto
- **Realtà**: SVG moduli vivono in `Modules/Geo/resources/svg/`, copiati in `public/svg/` via publish
- **Soluzione**: Sviluppare in `resources/svg/`, deployare via `php artisan vendor:publish`

### `XotBaseField` vs `XotBaseComponent`
- **False Friend**: Pensare che per i form field si usi `XotBaseComponent`
- **Realtà**: I form field devono estendere `XotBaseField`, i componenti Blade `XotBaseComponent`
- **Soluzione**: Controllare namespace `Filament\Forms\Components\` vs `Illuminate\View\`

## Related

- [[coordinate-picker-best-practices]]
- [[svg-asset-architecture]]
- [[leaflet-class-selector-governance]]
- [[mappicker-xotbasefield-rule]]
