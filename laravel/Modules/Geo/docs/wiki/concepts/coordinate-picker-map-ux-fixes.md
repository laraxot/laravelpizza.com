---
title: "Coordinate Picker Map UX Fixes"
description: "Fixes for map centering, search UX, wizard stepper, form fields, and geolocation on segnalazione-crea page"
type: concept
sources: []
confidence: high
created: 2026-05-13
updated: 2026-05-15
tags: [geo, coordinate-picker, map, geolocation, search, fixcity, wizard, stepper, form-fields]
related:
  - ../concepts/location-capture-map-wizard.md
  - ../concepts/map-controls-visibility-issue.md
  - ../../../Themes/Sixteen/resources/css/components/filament-wizard-parity.css
---

# Coordinate Picker Map UX Fixes (2026-05-13 / Updated 2026-05-15)

## Problemi Risolti

### Search: pannello indirizzo non visibile dopo click sul magnifier (2026-05-15)

**Causa**: `.map-container` applica `overflow: hidden` (bordi arrotondati + tile); il pannello `.search-box` viveva nello stesso contenitore del Leaflet pane pieno schermo ed era ritagliato o coperto dallo stacking dei livelli mappa.

**Soluzione**:

- Wrapper `.map-picker-viewport { position:absolute; inset:0; overflow:hidden; border-radius:inherit }` che contiene **solo** `.map-picker-leaflet-pane`; ricerca e toolbar restano **sibling** di `.map-container`, non dentro il viewport ritagliato.
- `.search-box` con `z-index: 3200 !important` (sopra overlay controlli 3001 e loading 2000).
- Condizione di render allineata al toggle: `showSearch !== false && _searchOpen` (stessa semantica di `renderToggleButton`).
- Click sul toggle: `stopPropagation()` per evitare effetti collaterali con handler sulla mappa.

**File**: `coordinate-picker-lit.js`, `map/styles.js`, `map/controls/search.js` (`renderToggleButton`).

### 1. Mappa Non Centrata sulla Posizione Corrente

**Problema**: La mappa mostrava sempre Roma come centro predefinito anche quando l'utente non aveva ancora selezionato coordinate.

**Soluzione**: Il componente `coordinate-picker-lit` ora ha `geolocateWhenEmpty=true` che:
- Avvia automaticamente la geolocalizzazione del browser quando non ci sono coordinate
- Centra la mappa sulla posizione corrente dell'utente
- Fallback: Roma (41.9028, 12.4964) se la geolocalizzazione fallisce

**File modificato**: `laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php`

```blade
<coordinate-picker-lit
    :state="state"
    zoom="{{ $field->getZoom() }}"
    geolocate-when-empty
    show-search
    labels='@json($labels)'
></coordinate-picker-lit>
```

**Aggiornamento 2026-05-14**: L'attributo `geolocate-when-empty` viene ora passato dinamicamente dal PHP in base al valore di `getGeolocateWhenEmpty()`:

```blade
<coordinate-picker-lit
    :state="state"
    zoom="{{ $field->getZoom() }}"
    height="{{ $field->getHeight() }}"
    show-search
    geolocate-when-empty="{{ $field->getGeolocateWhenEmpty() ? 'true' : 'false' }}"
    labels='@json($labels)'
></coordinate-picker-lit>
```

### 5. Mappa Spostata a Destra / Non Full-Width (Updated 2026-05-14)

**Problema**: La mappa appariva spostata a destra perché il contenitore del wizard aveva `col-lg-10` (83% width) e aveva padding interno dalle colonne.

**Soluzione**:
1. Il contenitore del wizard usa lo scope generico Design Comuni del tema (`.cmp-wizard-widget`, `.wizard-dc-form-shell`, `.fi-sc-wizard`).
2. CSS in `filament-wizard-parity.css`/`app.css` forza la mappa a usare tutta la larghezza disponibile del form senza hook di dominio:

```css
.cmp-wizard-widget .wizard-dc-form-shell coordinate-picker-lit,
.cmp-wizard-widget .wizard-dc-form-shell coordinate-picker-lit .map-container {
    width: 100% !important;
    max-width: 100% !important;
}
```

3. I contenitori della mappa sono stati configurati per utilizzare il 100% della larghezza:

```css
.cmp-wizard-widget .wizard-dc-form-shell .map-container-wrapper,
.cmp-wizard-widget .wizard-dc-form-shell .coordinate-picker-field-wrapper {
    width: 100% !important;
    max-width: 100% !important;
}

.cmp-wizard-widget .wizard-dc-form-shell .map-container-wrapper .map-container,
.cmp-wizard-widget .wizard-dc-form-shell .map-container-wrapper .map-picker-leaflet-pane {
    width: 100% !important;
    border-radius: 0 !important;
}
```

Regola: il modulo Geo espone il componente riusabile; il tema Sixteen decide la resa visuale con selettori generici. Non usare classi `fixcity-wizard-*` per layout della mappa.

### 3. Campi Form Trasparenti

**Problema**: I campi input e select apparivano trasparenti, rendendo impossibile distinguere un input text da un select.

**Soluzione**: CSS con selettori specifici per Filament v5:

```css
/* Force opaque white background and visible borders on all form fields */
.fi-sc-wizard input[type="text"],
.fi-sc-wizard input[type="email"],
.fi-sc-wizard input[type="tel"],
.fi-sc-wizard select,
.fi-sc-wizard textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 16px;
    border: 1px solid #5c6f82;
    border-radius: 4px;
    background-color: #ffffff;
    color: #191919;
    line-height: 1.5;
}

.fi-sc-wizard input:focus,
.fi-sc-wizard select:focus,
.fi-sc-wizard textarea:focus {
    border-color: #007a52;
    outline: none;
    box-shadow: 0 0 0 4px rgba(0, 122, 82, 0.1);
}

/* Additional specificity for various Filament field types */
.fi-sc-wizard .fi-input,
.fi-sc-wizard .fi-fo-text-input,
.fi-sc-wizard .fi-fo-select-input,
.fi-sc-wizard .fi-fo-textarea-input,
.fi-sc-wizard .fi-fo-input,
.fi-sc-wizard input.fi-input,
.fi-sc-wizard select.fi-input,
.fi-sc-wizard textarea.fi-input,
.fi-sc-wizard input[type="text"],
.fi-sc-wizard input[type="email"],
.fi-sc-wizard input[type="tel"],
.fi-sc-wizard input[type="number"],
.fi-sc-wizard input[type="search"],
.fi-sc-wizard select,
.fi-sc-wizard textarea {
    background-color: #ffffff !important;
    border: 1px solid #5c6f82 !important;
    color: #17324d !important;
    box-shadow: 0 1px 2px rgba(23, 50, 77, 0.04);
}

/* Make select elements clearly visible with visible dropdown arrow */
.fi-sc-wizard select {
    appearance: auto !important;
    -webkit-appearance: auto !important;
    padding-right: 2rem !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%235c6f82' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.5rem center !important;
    background-size: 16px 12px !important;
}

.fi-sc-wizard input::placeholder,
.fi-sc-wizard textarea::placeholder {
    color: #5c6f82 !important;
    opacity: 1 !important;
}
```

**File modificato**: `laravel/Themes/Sixteen/resources/css/components/filament-wizard-parity.css`

### 4. Wizard Stepper Visivamente Scadente

**Problema**: Lo stepper aveva poco contrasto, i cerchietti erano poco visibili.

**Soluzione**: CSS migliorato con ombre, bordi più definiti e migliori colori per stato attivo/inattivo:

```css
/* Stepper container */
.fi-sc-wizard .steppers {
    background-color: #ffffff !important;
    border-bottom: 2px solid #d9e1e8 !important;
    padding: 1.5rem 0 !important;
    margin-bottom: 2rem !important;
}

/* Step items */
.fi-sc-wizard .step-item {
    display: flex;
    align-items: center;
    flex: 1;
}

/* Step icons */
.fi-sc-wizard .step-item:not(.active):not(.confirmed):not(.completed) .step-icon {
    background-color: #f5f6f7 !important;
    color: #5c6f82 !important;
    border: 2px solid #c1c9d1 !important;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.fi-sc-wizard .step-item.active .step-icon {
    background-color: #007a52 !important;
    color: #ffffff !important;
    border: 2px solid #007a52 !important;
    box-shadow: 0 2px 4px rgba(0, 122, 82, 0.3) !important;
}

.fi-sc-wizard .step-item.confirmed .step-icon,
.fi-sc-wizard .step-item.completed .step-icon {
    background-color: #008c45 !important;
    color: #ffffff !important;
}

/* Step titles */
.fi-sc-wizard .step-title {
    font-size: 14px;
    font-weight: 600 !important;
    color: #5c6f82 !important;
    margin-left: 0.75rem;
}

.fi-sc-wizard .step-item.active .step-title {
    color: #007a52 !important;
    font-weight: 700 !important;
}

/* Step dividers */
.fi-sc-wizard .step-divider {
    flex: 1;
    height: 2px !important;
    background-color: #d9e1e8 !important;
}

.fi-sc-wizard .step-item.confirmed + .step-item .step-divider,
.fi-sc-wizard .step-item.active + .step-item .step-divider {
    background-color: #007a52 !important;
}

/* Step index pill */
.fi-sc-wizard .steppers-index {
    font-size: 14px;
    color: #17324d !important;
    font-weight: 600 !important;
    background-color: #f5f6f7 !important;
    padding: 0.25rem 0.75rem !important;
    border-radius: 12px !important;
    text-align: right;
    margin-top: 0.5rem;
}
```

### 5. Doppio Controllo Ricerca ("cerca un luogo" + "cerca indirizzo")

**Problema**: UI confusa con due controlli di ricerca visibili.

**Soluzione**: Un solo campo di ricerca che appare **solo** quando l'utente clicca sulla lente di ingrandimento.

**Comportamento UX**:
1. All'apertura della mappa, solo i controlli standard sono visibili (fullscreen, posizione, layer, zoom)
2. L'utente clicca sulla lente di ingrandimento
3. Appare il campo di ricerca "Cerca indirizzo..."
4. L'utente può cercare o chiudere la ricerca

**Implementazione in `coordinate-picker-lit.js`**:
- `_searchOpen` inizia a `false`
- `_toggleSearch()` mostra/nasconde il campo di ricerca
- `renderControls()` include la lente di ingrandimento solo se `showSearch && typeof ctx._toggleSearch === 'function'`

### 3. Posizionamento Controlli

I controlli sono posizionati nell'angolo in alto a sinistra della mappa per non interferire con il campo di ricerca (che sta in alto a destra).

## File Modificati

| File | Modifica |
|------|----------|
| `Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php` | Aggiunto `geolocate-when-empty` al componente Lit |
| `Modules/Geo/resources/js/components/coordinate-picker-lit.js` | Commento documentativo sul pattern UX |
| `Modules/Geo/resources/js/components/map-picker-controls.js` | Logica di ricerca on-demand tramite `_toggleSearch()` |

## Pattern UX

### Geolocalizzazione Automatica

```
User apre wizard step "data"
    ↓
CoordinatePicker renderizza mappa
    ↓
coordinate-picker-lit: state = null, geolocateWhenEmpty = true
    ↓
initMap() rileva lat/lng null
    ↓
requestGeolocation() → navigator.geolocation.getCurrentPosition()
    ↓
Mappa centratata su posizione utente
    ↓
Marker piazzato + coords-changed event → Livewire
```

### Ricerca On-Demand

```
Mappa aperta → _searchOpen = false
    ↓
Controlli standard visibili (no search box)
    ↓
Utente clicca 🔍 (lente ingrandimento)
    ↓
_toggleSearch() → _searchOpen = true
    ↓
renderSearch() mostra campo input + risultati
    ↓
Utente cerca / preme ESC / seleziona risultato
    ↓
closeSearch() → _searchOpen = false
```

## Testing

```bash
# Verifica geolocalizzazione automatica
# 1. Apri http://127.0.0.1:8000/it/tests/segnalazione-crea
# 2. Vai allo step "data"
# 3. Verifica che la mappa centri sulla tua posizione (o Roma se negato)

# Verifica search UX
# 1. Apri mappa → vedi solo controlli standard
# 2. Clicca lente 🔍 → vedi campo ricerca
# 3. Cerca indirizzo → risultati → seleziona
# 4. Mappa centratata sull'indirizzo selezionato
```

## Riferimenti

- [[location-capture-map-wizard]] - Workflow business della mappa
- [[segnalazione-crea-geolocate-when-empty]] - Contract Fixcity
- [[ticket-list-map-architecture]] - Architettura map-lit per ticket-list
