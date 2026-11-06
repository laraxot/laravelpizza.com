---
qmd: "coordinate picker design comuni runtime rule"
issues: []
discussions: []
title: CoordinatePicker Design Comuni Runtime Rule
type: concept
tags: [geo, coordinate-picker, leaflet, livewire, filament, design-comuni]
created: 2026-04-22
updated: 2026-10-14
sources:
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/coordinate-picker-design-comuni-parity-rule.md
  - ../../../../../../docs/wiki/concepts/filament5-schema-section-namespace-rule.md
status: draft
---

# CoordinatePicker Design Comuni Runtime Rule

## Regola Permanente

Quando `CoordinatePicker` e' renderizzato dentro un wizard Filament/Livewire:

- la mappa Leaflet deve essere opaca e leggibile;
- i controlli fullscreen, geolocalizzazione, layer, zoom in e zoom out devono essere sempre visibili e cliccabili;
- selezionare un risultato di ricerca indirizzo deve spostare la mappa e posizionare il marker sulle coordinate del risultato;
- il componente Geo deve esporre comportamento funzionale, mentre il tema owner applica la parity visuale.

## Contratto Implementativo

Il componente Lit `coordinate-picker-lit` espone `setCoordinates(lat, lng, source = 'programmatic')` per aggiornamenti programmatici. La ricerca indirizzo NON passa da questo metodo: `search.js` chiama `_handleSearchSelection()` (`coordinate-picker-lit.js`) e poi emette `address-selected`; `setCoordinates()` non ha chiamanti nel modulo Geo (verificato con `rg`, 2026-10-14).

`setCoordinates()`:

1. normalizza le coordinate (`normalizeCoordinatePair`), tramite `handleMapInteraction()`;
2. aggiorna stato e marker con lo stesso percorso di click, drag, ricerca e geolocalizzazione (`handleMapInteraction()` in `map/events.js` e l'unico punto di scrittura dello stato);
3. emette `coords-changed`;
4. centra la mappa con `setView([lat, lng], Math.max(zoomCorrente, this.zoom))`: lo zoom non e fisso e non ingrandisce a livello di strada se il campo ha `zoom` basso.

In sola lettura (`readonly`) `handleMapInteraction()` esce senza scrivere lo stato, ma `setCoordinates()` esegue comunque il `setView`.

Questo evita duplicazione tra Alpine, Livewire e Lit.

## Verifica

Verificato il 2026-10-14 su `resources/js/components/coordinate-picker-lit.js` e `resources/js/components/map/**`. Esistono nel picker i controlli fullscreen, geolocalizzazione, layer, zoom in e zoom out (import da `./map/controls.js`). Che la mappa risulti "opaca e leggibile" in ogni pagina ospite e comportamento CSS del tema: (non verificato) qui.

## Boundary DRY

- Geo: stato, marker, geocoding/reverse geocoding, metodo pubblico del web component.
- Sixteen: dimensioni, contrasto, opacita, spaziatura e stile controlli nel flusso Design Comuni.
