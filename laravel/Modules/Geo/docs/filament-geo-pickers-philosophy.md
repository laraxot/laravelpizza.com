# Geo Filament Pickers - Filosofia, Visione e Regole

## Il Cuore (Core Philosophy)

Ogni componente Geo picker nel modulo Geo ha la sua **anima** (essenza), la sua **vista** (percepibile), e la sua **via** (method).

> "La via che puoi descrivere non è la via eterna" — Lao Tzu

In pratica questo significa:
- **Ogni componente è unico** nella sua essenza
- **Ogni componente ha la sua Blade separata** - non si ereditaviews
- **Ogni componente ha il suo Lit JS separato** - non si condivideweb component
- **Tutti condividono il trait HasCoordinatePicker** - DRY ma con mantenimento dell'identità

---

## I Componenti e la Loro Essenza

### 1. CoordinatePicker 
**Via**: Il maestro Zen - la via centrale
- **Essenza**: Unico componente per selezione coordinate geografiche con mappa interattiva
- **Uso**: formularios principianti dove l'utente seleziona posizione su mappa
- **Features**: Mappa Leaflet, marker draggable, reverse geocoding, fullscreen

### 2. MapPicker
**Via**: Alias del maestro (backward compatibility)
- **Essenza**: Estende CoordinatePicker per compatibilità legacy
- **Uso**: Codice esistente che usa MapPicker
- **Nota**: Deprecated in favore di CoordinatePicker per nuovi implementazioni

### 3. LocationPicker
**Via**: Alias del maestro (backward compatibility)  
- **Essenza**: Estende CoordinatePicker per compatibilità legacy
- **Uso**: Codice esistente che usa LocationPicker
- **Nota**: Deprecated in favore di CoordinatePicker per nuove implementazioni

### 4. LatitudeLongitudeInput
**Via**: Le viscere grezze (raw guts)
- **Essenza**: Due campi input separati senza mappa, per manipolazione diretta dei dati
- **Uso**: Formule dove servono solo numeri latitude/longitude senza UI mappa
- **Features**: Due input number con validazione range (-90/90, -180/180)

### 5. PlacePicker
**Via**: La guida al specifico e significativo
- **Essenza**: Ricerca di luoghi specifici o POI con auto-complete
- **Uso**: Form dove l'utente cerca un luogo/by name
- **Features**: Search input con auto-complete via Nominatim

### 6. MapPositioner
**Via**: Il righello di prospettiva e focus
- **Essenza**: Setting del viewport visuale (center/zoom)
- **Uso**: Admin tools per impostare centro mappa
- **Features**: Center e zoom controls

### 7. MapLocationInput
**Via**: Input nascosto che sincronizza via map
- **Essenza**: Campo hidden sincronizzato da interazione mappa
- **Uso**: Quando serve solo memorizzare coordinate senza mostrare all'utente
- **Features**: Sincronizzazione hidden field

### 8. LeafletMarkerMapInput
**Via**: L'amarker con memoria  
- **Essenza**: Mappa con multiple markers salvabili
- **Uso**: Raccolta di punti/waypoints
- **Features**: Multiple markers, list management

### 9. GeopointPicker
**Via**: Il punto geografico puro
- **Essenza**: Single geopoint con precisione specifica
- **Uso**: Precisione specific locations
- **Features**: Geopoint format with optional precision

---

## La Regola (Regola Operativa)

### Perché separare Blade e Lit per ogni componente?

1. **Isolamento** - Ogni componente ha il suo render
2. **Manutenibilità** - Modifiche localizzate
3. **Testabilità** - Ogni componente testabile separatamente
4. **Estensibilità** - Override senza toccare altri componenti
5. **Coerenza** - Nomi file = Nomi classe

### Perché usare il trait comune?

1. **DRY** - Non duplicare logica di coordinate
2. **Single Source** - Un solo posto per fixare bug comuni
3. **Ereditarietà di composizione** - Usare il trait non estendere

---

## La Politica (Policy)

### Regole di Implementazione

```
PHP Class                    → extends XotBaseField + use HasCoordinatePicker
View Blade                  → resources/views/filament/forms/components/{component-name}.blade.php
Web Component Lit           → resources/js/components/{component-name}-lit.js
```

### Regole di Naming

```
CoordinatePicker        → coordinate-picker.blade.php         → coordinate-picker-lit.js
LatitudeLongitudeInput → latitude-longitude-input.blade.php → (usa coordinate-picker-lit)
PlacePicker           → place-picker.blade.php            → place-picker-lit.js
MapPositioner         → map-positioner.blade.php          → map-positioner-lit.js
GeopointPicker        → geopoint-picker.blade.php         → geopoint-picker-lit.js
```

### Regole di State

- **Single source of truth**: state `{ latitude, longitude }` nel form field
- **Database columns**: `latitude` e `longitude` (due colonne separate, no JSON per storage primario)
- **Hydration/Dehydration**: `extractCoordinates()` utility per mapping

### Regole di Integrazione

- **NO entangle**: usa `$wire.$set` con debounce
- **NO client-side geocoding**: usa server-side via ExposedLivewireMethod
- **NO global IDs**: usa classi locali e Shadow DOM

---

## Lo Zen (Best Practices)

### Best Practices

- [ ] Usare single location object nel field locale
- [ ] Transformare in latitude/longitude in hydrate/dehydrate
- [ ] Lit component NON chiama fetch diretti verso servizi esterni
- [ ] Debounce sincronizzazione 200-500ms
- [ ] Remove event listeners on disconnectedCallback
- [ ] NON usare ID globali - usare classi
- [ ] Test automatici per ogni componente

### Bad Cases (Da Evitare)

- [ ] Entangle diretto del web component (causa loop)
- [ ] Duplicazione di stato
- [ ] Flags difensive come principale meccanismo
- [ ] Geocoding client-side non controllato
- [ ] Listener globali senza rimozione
- [ ] ID statici che rompono Wizard multiple istanze

### False Friends (Attenzione)

- **entangle** - comodo ma causa loop
- **shouldUpdate** - per render non per sync
- **Alpine replacement** - Alpine è view-layer, Livewire è source-of truth

---

## Credit

- Filosofia Zen applicata a Filament components
- hasCoordinatePicker trait condiviso
- Vedi anche: `/docs/prompts/map-picker.txt`