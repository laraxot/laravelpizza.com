# MapPicker/LocationPicker Architecture (Unified State)

**Data aggiornamento:** 2026-04-20  
**Status:** Produzione (Laravel 12 / Filament v5 / Livewire v4 / Lit 3.x / Leaflet 1.9.x)  
**Modulo:** Geo  
**Story:** [1-7-mappicker-locationpicker-consolidation](../../../.planning/stories/1-7-mappicker-locationpicker-consolidation.story.md)

---

## Obiettivo Architetturale

Eliminare la fragilità della sincronizzazione bidirezionale e il coupling tra Blade view e schema database, consolidando MapPicker/LocationPicker come componente **"Unified State"** robusto, testabile e documentato.

### Principi Chiave

1. **Unified State Object**: Stato del field = singolo oggetto `{ latitude, longitude }`
2. **Thin Alpine Adapter**: Alpine = bridge puro (NO stato ridondante, NO logica business)
3. **Lit Stateless**: Web component = UI-only (props in, events out)
4. **Shadow DOM Enforcement**: Leaflet + CSS isolati in Shadow DOM
5. **Visibility Awareness**: ResizeObserver per init su container nascosti (Wizard steps)
6. **LLM Wiki Documentation**: Conoscenza accumulata, cross-linkata, sempre aggiornata

---

## Contratto Dati (API)

### Stato del Field (Filament)

```json
{
  "latitude": 41.9028,
  "longitude": 12.4964
}
```

**Path**: `$wire.$get('location')` o `$wire.$get('map_reference')`

### Evento Custom Lit → Livewire

```javascript
// Evento dispatchato da map-picker-lit
new CustomEvent('location-changed', {
  detail: {
    latitude: 41.9028,
    longitude: 12.4964,
    source: 'click' | 'drag' | 'geolocation' | 'search' | 'external'
  },
  bubbles: true,
  composed: true  // attraversa Shadow DOM
})
```

### Public API (Web Component)

```javascript
// Chiamato da Alpine quando Livewire state cambia
picker.applyExternalLocation({ latitude: 41.9028, longitude: 12.4964 })

// Chiamato per forzare resize Leaflet (es. post-fullscreen)
picker.invalidateSize()
```

---

## Architettura a Strati

```
┌─────────────────────────────────────────────────────────────┐
│ Livewire (Server-Side)                                      │
│ State: { latitude: float|null, longitude: float|null }     │
│ Geocoding: geocodeAddress(string) → { lat, lng, name }     │
└────────────────────┬────────────────────────────────────────┘
                     │
                     │ $wire.$set(statePath, value, false)
                     │ $wire.$watch(statePath, callback)
                     │
┌────────────────────▼────────────────────────────────────────┐
│ Alpine Adapter (x-data nel Blade)                          │
│ - statePath: @js($getStatePath())                          │
│ - onLocationChanged(e): $wire.$set(path, { lat, lng })    │
│ - init(): $watch(path, val → picker.applyExternalLocation)│
└────────────────────┬────────────────────────────────────────┘
                     │
                     │ location-changed event (bubbles, composed)
                     │ applyExternalLocation(loc)
                     │
┌────────────────────▼────────────────────────────────────────┐
│ Lit Web Component (<map-picker-lit>)                        │
│ Props: latitude, longitude, zoom, height, showSearch       │
│ Events: location-changed                                   │
│ API: applyExternalLocation(), invalidateSize()             │
│ Styles: Shadow DOM (map-picker-styles.js)                  │
└────────────────────┬────────────────────────────────────────┘
                     │
                     │ L.map(), L.marker(), L.tileLayer()
                     │
┌────────────────────▼────────────────────────────────────────┐
│ Leaflet 1.9.x (UI Rendering)                                │
│ - Map container: .map-picker-leaflet-pane                  │
│ - Marker: draggable, custom SVG icon (red pin)             │
│ - Layers: OSM street, Esri satellite                       │
│ - Controls: zoom, scale, locate, fullscreen, layer switch  │
└─────────────────────────────────────────────────────────────┘
```

---

## Flusso di Sincronizzazione

### Scenario 1: Utente clicca sulla mappa

```
1. Utente clicca → Leaflet: map.on('click', callback)
2. Callback: _updateInternal(lat, lng, emit=true, source='click')
3. _updateInternal:
   - Aggiorna marker: marker.setLatLng([lat, lng])
   - Muove vista: map.setView([lat, lng])
   - Se emit=true: dispatchEvent('location-changed')
4. Alpine: onLocationChanged(e) riceve evento
5. Alpine: $wire.$set(statePath, { latitude, longitude }, false)
6. Livewire: aggiorna stato server-side
7. Livewire: $watch triggera callback
8. Alpine: callback → picker.applyExternalLocation(value)
9. Lit: applyExternalLocation aggiorna marker SENZA emit (previene loop)
```

**Loop prevention**: `applyExternalLocation()` → `_updateInternal(emit=false)`

### Scenario 2: Geocoding server-side

```
1. Utente digita indirizzo → input search in Lit component
2. Lit: _handleSearch() → fetch Nominatim API
3. Nominatim: response { lat, lon, display_name }
4. Lit: _updateInternal(lat, lng, emit=true, source='search')
5. Lit: dispatchEvent('location-changed')
6. Alpine → Livewire: come Scenario 1
```

### Scenario 3: Wizard resetta form

```
1. Livewire: reset form → state = { latitude: null, longitude: null }
2. Livewire: $watch triggera callback
3. Alpine: callback → picker.applyExternalLocation(null)
4. Lit: applyExternalLocation → _removeMarker()
5. Mappa: marker rimosso, vista su defaultLocation
```

---

## Decisioni Architetturali

### 1. Unified State vs 2 Colonne DB

**Problema**: Database ha 2 colonne separate (`latitude`, `longitude`), ma UI lavora con coordinata singola.

**Opzioni valutate**:

| Opzione | Pro | Contro | Scelta |
|---------|-----|--------|--------|
| **A**: Field state = 2 sibling paths (`location.latitude`, `location.longitude`) | Mapping diretto a DB | Coupling Blade→DB, sincronizzazione complessa, testing difficile | ❌ |
| **B**: Field state = oggetto unico `{ latitude, longitude }` | UI agnostica da schema DB, testing semplice, meno coupling | Richiede trasformazione esplicita nel consumer | ✅ |
| **C**: Campo JSON nel DB | Mapping 1:1 UI→DB | Query SQL complesse, indici separati difficili, migrazione costosa | ❌ |

**Scelta finale**: **Opzione B**

**Motivazione**:
- Field Filament lavora su stato strutturato (pattern ufficiale Filament v5)
- Consumer (es. `CreateTicketWizardWidget`) gestisce trasformazione in `dehydrateStateUsing` / `afterStateHydrated`
- Testing: mock state = array semplice, non serve mockare struttura DB
- Estensibilità: aggiungere `altitude`, `accuracy` futuro = change in un solo punto

**Implementazione consumer**:

```php
// In CreateTicketWizardWidget o Model
protected function afterStateHydrated(): void
{
    // DB (2 colonne) → UI (oggetto unico)
    $this->location = [
        'latitude' => $this->latitude,
        'longitude' => $this->longitude,
    ];
}

public function saving(): void
{
    // UI (oggetto unico) → DB (2 colonne)
    $this->latitude = $this->location['latitude'] ?? null;
    $this->longitude = $this->location['longitude'] ?? null;
}
```

### 2. NO `@entangle` - Uso Esplicito di `$wire.$set` e `$wire.$watch`

**Problema**: `@entangle` crea sincronizzazione bidirezionale automatica che può causare loop con componenti Lit.

**Opzioni valutate**:

| Opzione | Pro | Contro | Scelta |
|---------|-----|--------|--------|
| **A**: `@entangle('statePath')` | Sintassi concisa, meno boilerplate | Loop reattivi, controllo granulare nullo, debugging difficile | ❌ |
| **B**: `$wire.$set(value, false)` + `$wire.$watch()` | Controllo totale, previene loop, debugging facile | Leggermente più verboso | ✅ |

**Scelta finale**: **Opzione B**

**Motivazione**:
- `$wire.$set(value, false)`: secondo parametro `false` = NON emettere update a chain (previene loop)
- `$wire.$watch()`: reattività controllata, callback esplicita
- Documentazione ufficiale Livewire v4: https://livewire.laravel.com/docs/4.x/wire-model
- Pattern osservato in farmshops.eu (fullscreen map component)

**Implementazione**:

```javascript
// Alpine x-data
x-data="{
  onLocationChanged(e) {
    // Aggiorna Livewire SENZA emettere update (previene loop)
    this.$wire.$set(this.statePath, { 
      latitude: e.detail.latitude, 
      longitude: e.detail.longitude 
    }, false);
  },
  init() {
    // Watch per cambiamenti esterni (geocoding, reset form)
    this.$wire.$watch(this.statePath, (value) => {
      this.$refs.picker?.applyExternalLocation(value);
    });
  }
}"
```

### 3. Shadow DOM Enforcement per Leaflet

**Problema**: Leaflet inietta stili globali che possono confliggere con Filament/Tailwind.

**Opzioni valutate**:

| Opzione | Pro | Contro | Scelta |
|---------|-----|--------|--------|
| **A**: NO Shadow DOM (`createRenderRoot() { return this; }`) | Stili globali, facile override | Conflitti CSS, leakage, testing difficile | ❌ |
| **B**: Shadow DOM con CSS in file separato | Isolamento totale, zero conflitti, testing facile | Leggermente più complesso setup | ✅ |

**Scelta finale**: **Opzione B**

**Motivazione**:
- Lit official docs: https://lit.dev/docs/components/styles/
- Shadow DOM previene leakage CSS da/to Filament global styles
- CSS in file separato (`map-picker-styles.js`) = tree-shaking, riuso, manutenzione
- `static styles = mapPickerStyles` pattern ufficiale Lit

**Implementazione**:

```javascript
// map-picker-styles.js
import { css } from '@theme-lit';

export const mapPickerStyles = css`
  :host { display: block; }
  .map-container { position: relative; height: var(--map-height); }
  .map-picker-leaflet-pane { width: 100%; height: 100%; }
  /* ... */
`;

// map-picker-lit.js
import { mapPickerStyles } from './map-picker-styles.js';

export class MapPickerLit extends LitElement {
  static styles = mapPickerStyles;
  // ...
}
```

### 4. ResizeObserver per Visibility Detection

**Problema**: Filament Wizard nasconde step non attivi (container height=0); Leaflet init su container invisibile causa render grigio/rotto.

**Opzioni valutate**:

| Opzione | Pro | Contro | Scelta |
|---------|-----|--------|--------|
| **A**: Init immediato in `firstUpdated()` | Semplice | Mappa grigia se container nascosto | ❌ |
| **B**: ResizeObserver + check visibilità | Init solo quando visibile, zero bug | Leggermente più complesso | ✅ |
| **C**: MutationObserver su style changes | Detecta cambiamenti espliciti | Overkill, performance peggiori | ❌ |

**Scelta finale**: **Opzione B**

**Motivazione**:
- Pattern osservato in farmshops.eu fullscreen implementation
- ResizeObserver = standard moderno, performance ottime
- Check `rect.width > 0 && rect.height > 0` = visibilità reale
- `requestAnimationFrame` fallback per init immediato se già visibile

**Implementazione**:

```javascript
firstUpdated() {
  // Setup ResizeObserver
  if (typeof ResizeObserver !== 'undefined') {
    this._resizeObserver = new ResizeObserver(() => this._handleResize());
    this._resizeObserver.observe(this);
  }
  
  // Fallback/Initial trigger
  requestAnimationFrame(() => this._handleResize());
}

_handleResize() {
  const rect = this.getBoundingClientRect();
  const isVisible = rect.width > 0 && rect.height > 0;
  
  if (!isVisible) return;
  
  if (!this._map) {
    // Posticipa init a visibilità
    if (this._initRaf) cancelAnimationFrame(this._initRaf);
    this._initRaf = requestAnimationFrame(() => {
      this._initRaf = null;
      this._initMap();
    });
  } else {
    // Map già init, solo resize
    this._map.invalidateSize({ animate: false });
  }
}
```

---

## Troubleshooting

| Problema | Causa Probabile | Soluzione |
|----------|-----------------|-----------|
| **Mappa grigia all'avvio** | Init su container invisibile (Wizard step nascosto) | ResizeObserver già implementato; verificare che `_handleResize()` sia chiamato in `firstUpdated()` |
| **Loop di aggiornamento** | Evento UI → Livewire → Prop Lit → Evento UI | Verificare: `applyExternalLocation()` → `_updateInternal(emit=false)`; `$wire.$set(value, false)` |
| **Marker non visibile** | Icon 404 o SVG inline rotto | Controllare `map-picker-marker-config.js`; verificare build Vite include SVG |
| **Fullscreen break controls** | Toolbar outside map container | Spostare toolbar DENTRO `.map-container`; CSS `position: absolute` |
| **Memory leak dopo navigazione** | Listener non rimossi | Verificare `disconnectedCallback()`: `map.remove()`, `observer.disconnect()`, `removeEventListener()` |
| **Geocoding non funziona** | Nominatim API rate limit o CORS | Controllare browser console; aggiungere User-Agent header; implementare debounce |
| **Coordinate non salvate** | Field `dehydrated(false)` o consumer transformation mancante | Verificare `MapPicker.php`: `$this->dehydrated(true)`; controllare Wizard widget `saving()` hook |

---

## File di Riferimento

| File | Percorso | Descrizione |
|------|----------|-------------|
| **MapPicker.php** | `Modules/Geo/app/Filament/Forms/Components/MapPicker.php` | Field PHP (extends XotBaseField) |
| **LocationPicker.php** | `Modules/Geo/app/Filament/Forms/Components/LocationPicker.php` | Alias (classe vuota, stesso view) |
| **map-picker.blade.php** | `Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php` | Blade view con Alpine adapter |
| **map-picker-lit.js** | `Modules/Geo/resources/js/components/map-picker-lit.js` | Lit Web Component (400 righe) |
| **map-picker-styles.js** | `Modules/Geo/resources/js/components/map-picker-styles.js` | CSS in Shadow DOM |
| **map-picker-marker-config.js** | `Modules/Geo/resources/js/components/map-picker-marker-config.js` | Configurazione marker SVG |
| **MapPickerTest.php** | `Modules/Geo/tests/Unit/Filament/Forms/Components/MapPickerTest.php` | Pest test suite |

---

## Backlink

- **Modulo Geo**: [[geo-module]](../overviews/geo-module.md)
- **Lit Web Components**: [[lit-web-components]](./lit-web-components.md)
- **Location Picker Entity**: [[location-picker]](../../../../docs/wiki/entities/location-picker.md)
- **Story Implementazione**: [1-7-mappicker-locationpicker-consolidation](../../../.planning/stories/1-7-mappicker-locationpicker-consolidation.story.md)

---

## Asset Visivi (Screenshot)

### Wizard Segnalazione Crea

| Screenshot | Descrizione | Stato |
|------------|-------------|-------|
| ![Wizard Initial](../../../../docs/wiki/assets/screenshots/segnalazione-crea-wizard-initial.png) | Mappa in stato iniziale (step 1 wizard) | ✅ Catturato |
| ![Fullscreen](../../../../docs/wiki/assets/screenshots/segnalazione-crea-wizard-fullscreen.png) | Mappa in fullscreen (controls dentro container) | ✅ Catturato |
| ![Layer Switch](../../../../docs/wiki/assets/screenshots/segnalazione-crea-wizard-layer-switch.png) | Switch layer satellite/street | ✅ Catturato |
| ![Geolocation](../../../../docs/wiki/assets/screenshots/segnalazione-crea-wizard-geolocation.png) | Geolocation button click | ✅ Catturato |
| ![Drag Marker](../../../../docs/wiki/assets/screenshots/segnalazione-crea-wizard-drag-marker.png) | Marker draggable | ⏳ Da catturare (interazione manuale) |

**Nota**: Gli screenshot di fullscreen, layer switch e geolocation mostrano lo stato post-interazione. Per il drag marker, è richiesto test manuale poiché Playwright screenshot cattura solo lo stato iniziale della pagina.

**Percorso asset**: `docs/wiki/assets/screenshots/segnalazione-crea-*.png`

---

*Documento creato con pattern LLM Wiki (Karpathy). Aggiornare dopo ogni modifica architetturale. Backlink bidirezionali obbligatori.*
