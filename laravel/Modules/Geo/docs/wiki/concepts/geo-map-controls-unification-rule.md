---
title: "Geo Map Controls Unification Rule"
type: concept
module: Geo
confidence: high
created: 2026-04-29
tags: [geo-map-lit, coordinate-picker-lit, controls, DRY, UX]
related:
  - ../entities/geo-map-lit.md
  - coordinate-picker-purpose.md
  - map-picker-family-architecture.md
  - geo-component-family-philosophy.md
sources:
  - story 8-79
---

# Regola: Unificazione Controlli Mappa

## Principio

**Le due mappe pubbliche del progetto devono avere controlli visivamente e funzionalmente identici.**

Non è accettabile che `geo-map-lit` (elenco segnalazioni) e `coordinate-picker-lit` (form creazione) mostrino pulsanti di controllo con aspetto diverso.

## Famiglia componenti mappa

```
Modules/Geo/resources/js/components/
├── coordinate-picker-lit.js      ← picker input (form admin + wizard)
│   └── import map-picker-controls.js
├── geo-map-lit.js                ← viewer read-only (pagina pubblica elenco)
│   └── deve usare STESSO sistema controlli
└── map-picker-controls.js        ← SOURCE OF TRUTH per logica controlli
```

## Design token dei controlli (canonical)

Definiti in `map-picker-lit-styles.js`:

| Token | Valore |
|-------|--------|
| Dimensione bottone | `2.75rem × 2.75rem` |
| Background | `#ffffff` |
| Border radius | `0.5rem` |
| Shadow | `0 2px 8px rgba(0,0,0,0.15)` |
| Shadow hover | `0 6px 16px rgba(0,0,0,0.2)` |
| Dimensione icona SVG | `1.25rem × 1.25rem` |
| Layout overlay | Colonna verticale (`flex-direction: column`) |
| Posizione overlay | `top:10px; right:10px` |

## Controlli obbligatori in entrambe le mappe

| Controllo | Icona Heroicons | Azione |
|-----------|----------------|--------|
| Fullscreen toggle | `arrows-pointing-out` / `arrows-pointing-in` | `_toggleFullscreen()` |
| Zoom In | `plus` | `_map.zoomIn()` |
| Zoom Out | `minus` | `_map.zoomOut()` |
| Layer toggle | `squares-2x2` | Switch OSM ↔ Esri |

## Controlli opzionali per geo-map-lit

| Controllo | Icona | Condizione |
|-----------|-------|-----------|
| Geolocalizzazione (view) | `map-pin` | Solo centra mappa, non salva |

## Regola: nessun controllo Leaflet nativo duplicato

`geo-map-lit` NON deve usare `L.control.zoom()` perché i pulsanti custom nel `render()` gestiscono già lo zoom. Avere entrambi crea confusione visiva.

```js
// ❌ VIETATO in geo-map-lit (duplica i pulsanti custom):
L.control.zoom({ position: 'bottomright' }).addTo(this._map);

// ✅ CORRETTO:
// zoomControl: false in L.map() options (già impostato)
// Pulsanti custom nel render() con @click cablati
```

## Regola: tutti i pulsanti devono avere @click

Nel template Lit, ogni `<button>` dei controlli deve avere `@click` collegato al metodo corrispondente.

```js
// ❌ VIETATO (pulsante morto):
<button class="geo-map-btn geo-map-btn-zoom-in" title="Zoom in">${geoIcon('plus')}</button>

// ✅ CORRETTO:
<button class="geo-map-btn geo-map-btn-zoom-in" title="Zoom in" @click=${() => this._zoomIn()}>${geoIcon('plus')}</button>
```

## Origine del problema

`geo-map-lit.js` è stato sviluppato separatamente da `coordinate-picker-lit.js`. I controlli nel `render()` di `geo-map-lit` sono stati aggiunti graficamente ma:

1. `_wireControls()` è chiamata in `_initMap()` ma il metodo **non è mai stato definito** → `TypeError` silenzioso
2. I pulsanti zoom/layer nel template **non hanno `@click`**
3. `L.control.zoom()` è ancora presente → doppio controllo zoom
4. Il CSS usa stile inline invece di classi condivise

## Fix canonico (story 8-79)

Vedere `@/var/www/_bases/base_fixcity_fila5/.planning/stories/8-79-geo-map-controls-unification.story.md`

## Link correlati

- [geo-map-lit entity](../entities/geo-map-lit.md)
- [coordinate-picker-purpose](./coordinate-picker-purpose.md)
- [map-picker-family-architecture](./map-picker-family-architecture.md)
- [geo-component-family-philosophy](./geo-component-family-philosophy.md)
