# Lit + Leaflet: Light DOM Fix

> **PROBLEMA**: I componenti Lit che usano Leaflet non funzionano correttamente perché Leaflet manipola il DOM direttamente e non è compatibile con Shadow DOM.

> **SOLUZIONE**: Usare Light DOM con `createRenderRoot() { return this; }`

## Il Problema

Leaflet crea elementi DOM direttamente (non dentro il componente) e manipola CSS esterno. Con Shadow DOM:
- Gli elementi Leaflet vengono creati fuori dal Shadow DOM
- Gli stili CSS nel componente non si applicano agli elementi fuori
- I marker non sono visibili
- I controlli della mappa non funzionano

**Riferimento**: https://github.com/Leaflet/Leaflet/issues/6960

## La Soluzione

Aggiungere `createRenderRoot()` a tutti i componenti Lit che usano Leaflet:

```javascript
export class MyMapPicker extends LitElement {
    createRenderRoot() {
        return this;  // Usa Light DOM invece di Shadow DOM
    }
    
    // ... resto del codice
}
```

## Componenti Corretti

Tutti questi componenti nel Geo module usano Light DOM:

| Componente | File | Stato |
|-----------|------|--------|
| GeopointPicker | `geopicker-lit.js` | ✅ Fixato |
| LatitudeLongitudeInput | `geo-latlng-input.js` | ✅ Fixato |
| LeafletMarkerMapInput | `leaflet-marker-map-input-lit.js` | ✅ Fixato |
| MapLocationInput | `map-location-input-lit.js` | ✅ Fixato |
| MapPicker | `map-picker-lit.js` | ✅ Fixato |
| MapPositioner | `map-positioner-lit.js` | ✅ Fixato |
| PlacePicker | `place-picker-lit.js` | ✅ Fixato |

## Integrazione Theme

Ogni componente Lit del Geo module DEVE essere importato nel bundle JS del theme:

```javascript
// laravel/Themes/Sixteen/resources/js/app.js

import '@modules/Geo/resources/js/components/geopoint-picker-lit.js';
import '@modules/Geo/resources/js/components/geo-latlng-input.js';
import '@modules/Geo/resources/js/components/map-picker-lit.js';
import '@modules/Geo/resources/js/components/location-picker-lit.js';
import '@modules/Geo/resources/js/components/place-picker-lit.js';
import '@modules/Geo/resources/js/components/leaflet-marker-map-input-lit.js';
import '@modules/Geo/resources/js/components/map-location-input-lit.js';
import '@modules/Geo/resources/js/components/map-positioner-lit.js';
```

## CSS Esterno

Il file CSS principale per gli stili dei map picker:

```
laravel/Modules/Geo/resources/css/geopoint-picker.css
```

Questo file contiene:
- Stili per `.map-container`
- Stili per `.layer-controls-overlay` (bottoni di controllo)
- Stili per `.ctrl-btn` (bottoni singoli)
- Stili per marker personalizzati
- Fix per z-index e visibilità

## Checklist Nuovi Componenti

Quando si crea un nuovo componente Lit con Leaflet:

1. ✅ Aggiungere `createRenderRoot() { return this; }`
2. ✅ Importare il componente in `app.js` del theme
3. ✅ Verificare che gli stili CSS siano applicati
4. ✅ Testare marker e controlli su mobile

## Riferimenti

- [Leaflet Issue #6960](https://github.com/Leaflet/Leaflet/issues/6960)
- [Lit Documentation](https://lit.dev/docs/templates/shadow-dom/)
