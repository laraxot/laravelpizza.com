# Map-Lit: Lessons Learned & Error Resolution

**Modulo:** Geo  
**Data:** 2026-06-03  
**Scope:** map-lit component, marker cluster, GPS integration  
**Status:** Completato (STORY-121…129)

**Ricostruzione da docs:** [wiki/concepts/geo-map-lit-reconstruction-guide.md](./wiki/concepts/geo-map-lit-reconstruction-guide.md)

---

## Problemi Risolti

### 1. Marker Cluster che "Scappano" al Hover (STORY-123)

**Sintomo:** Cluster tremano, si spostano, comportamento instabile al passaggio mouse.

**Root Cause:**
```javascript
// ❌ ERRATO — Causava instabilità
{
    showCoverageOnHover: true,
    removeOutsideVisibleBounds: false,
    animate: false,
    _scheduleClusterRefresh() // race condition
}
```

**Fix:**
```javascript
// ✅ CORRETTO — Allineato a direktvermarkter.js
{
    showCoverageOnHover: false,
    removeOutsideVisibleBounds: true,
    chunkedLoading: true,
    // NO _scheduleClusterRefresh() — rimosso completamente
}
```

**Lezione:** Non forzare `refreshClusters()` manualmente. Lascia il plugin gestire autonomamente i refresh.

---

### 2. Marker che Scompaiono durante Pan/Zoom (STORY-122)

**Sintomo:** Marker e cluster spariscono durante interazione mappa.

**Root Cause:** 
- Event listeners `zoomend` + `moveend` causavano doppio refresh
- Debounce troppo aggressivo (100ms)
- `_isRefreshing` flag insufficiente

**Fix:**
```javascript
// ❌ RIMOSSO
this._map.on('zoomend', () => this._scheduleClusterRefresh());
this._map.on('moveend', () => this._scheduleClusterRefresh());

// ✅ Sostituito con: nessun listener — lascia markercluster gestire
```

**Lezione:** Più event listeners ≠ più stabilità. Spesso è il contrario.

---

### 3. GPS Centering con Pattern Implicito (STORY-122)

**Sintomo:** Mappa non centrava su GPS, o richiedeva flag `center-on-gps` esplicito.

**Pattern Corretto (come `<input type="date">`):**
```javascript
// Assenza lat/lng → GPS default (creazione)
<map-lit data-url="/data/tickets.json"></map-lit>

// Presenza lat/lng → usa coordinate (modifica)
<map-lit data-url="/data/tickets.json" lat="44.5" lng="11.3"></map-lit>
```

**Implementazione:**
```javascript
_hasExplicitCenter() {
    return Number.isFinite(this.lat) && Number.isFinite(this.lng);
}

// Logica di inizializzazione
if (!this._hasExplicitCenter() && navigator.geolocation) {
    this._tryCenterOnGpsThenMarkers(features);
} else if (this._hasExplicitCenter()) {
    this._map.setView([this.lat, this.lng], 14, { animate: false });
} else {
    this._fitBoundsToMarkers(features);
}
```

**Lezione:** Non duplicare la semantica con flag booleani. L'assenza di un attributo dovrebbe già indicare il default.

---

### 4. Bundle Vite non Include Leaflet/MarkerCluster

**Sintomo:** Mappa bianca, console error `L is not defined` o `markerClusterGroup is not a function`.

**Fix:**
```javascript
// In map-lit.js — assicura plugin disponibili
async _ensureLeafletPlugins() {
    window.L = L;
    globalThis.L = L;
    // Vite bundler include già leaflet.markercluster via alias
}
```

**Vite Config:**
```javascript
// vite.config.js
resolve: {
    alias: {
        'leaflet': 'leaflet/dist/leaflet.js',
        'leaflet.markercluster': 'leaflet.markercluster/dist/leaflet.markercluster.js'
    }
}
```

**Lezione:** Controllare sempre che le dipendenze siano correttamente bundled, anche se import sembra corretto.

---

## Best Practices Emerge

### Cluster Configuration
```javascript
{
    maxClusterRadius: (z) => (z < 12 ? 80 : 45),  // farmshops.eu pattern
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,  // true = UX diversa, ma più stabile
    zoomToBoundsOnClick: true,
    removeOutsideVisibleBounds: true,  // performance
    chunkedLoading: true,
    iconCreateFunction: customIconFn
}
```

### Icon Anchor Fisso
```javascript
const clusterSize = L.point(80, 80);
const clusterAnchor = L.point(40, 40);  // Centro esatto

return L.divIcon({
    html: `<div class="geo-cluster-circle">...</div>`,
    className: 'geo-cluster-wrapper',
    iconSize: clusterSize,
    iconAnchor: clusterAnchor,  // CRITICO per stabilità
});
```

---

## Errori Comuni & Soluzioni

| Errore | Causa | Fix |
|--------|-------|-----|
| `refreshClusters is not a function` | Plugin non caricato | Controlla vite.config alias |
| `Cannot read property 'addLayer' of undefined` | `_markersLayer` null | Attendi `_initMap()` completo |
| Cluster tremano | `animate: false` + CSS transform | Rimuovi entrambi |
| Marker scompaiono | `removeOutsideVisibleBounds: false` + refresh manuale | `true` e no refresh |
| GPS non centra | Lat/lng non null ma invalidi | Ometti lat/lng per GPS automatico |

---

## Reference Implementation

**File:** `resources/js/components/map-lit.js`  
**Bundle:** `public_html/themes/Sixteen/assets/map-lit-*.js`  
**Data:** `public_html/data/tickets.json`

---

### 4. Popup — vuoto header → Tipologia (STORY-129)

**Sintomo:** fascia bianca ~30% altezza card sotto titolo/badge.

**Cause:** `header { min-height: 222px !important }` (parity Design Comuni) su `<header class="popup__header">`.

**Fix:** `<div class="popup__header">` + `min-height: 0 !important` in popup JS e `13-final-runtime-overrides.css`.

**Doc:** [map-popup-header-whitespace-fix.md](./wiki/troubleshooting/map-popup-header-whitespace-fix.md)

### 5. Marker pin stato + pad + punta (STORY-129/130 UX)

**Implementazione canonica (2026-06-03):** `__shell` → `__inner` 36px (stato) → `__glyph-pad` 28px (bianco) → `__point` 8px; `iconAnchor` `[20, 44]`.

**Doc:** [geo-map-marker-status-background.md](./wiki/concepts/geo-map-marker-status-background.md) · [geo-map-lit-reconstruction-guide.md](./wiki/concepts/geo-map-lit-reconstruction-guide.md)

---

## Collegamenti

- [geo-map-lit-reconstruction-guide.md](./wiki/concepts/geo-map-lit-reconstruction-guide.md)
- [map-lit-it-incidents-2026-06.md](./wiki/troubleshooting/map-lit-it-incidents-2026-06.md)
- [map-lit-lat-lng-gps-default-pattern.md](../../../docs/wiki/memories/map-lit-lat-lng-gps-default-pattern.md)
- [STORY-121](../../../docs/stories/STORY-121-map-lit-non-visibile-verifica-fix.md)
- [STORY-122](../../../docs/stories/STORY-122-map-lit-marker-scomparsa-gps-center.md)
- [STORY-123](../../../docs/stories/STORY-123-map-lit-cluster-hover-escape-fix.md)
- [STORY-129](../../../docs/stories/STORY-129-map-marker-icon-first-popup-ux.md)
