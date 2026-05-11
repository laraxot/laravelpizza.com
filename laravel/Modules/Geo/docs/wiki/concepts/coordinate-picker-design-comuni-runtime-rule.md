---
title: CoordinatePicker Design Comuni Runtime Rule
type: concept
tags: [geo, coordinate-picker, leaflet, livewire, filament, design-comuni]
created: 2026-04-22
updated: 2026-04-22
sources:
  - ../../../../Themes/Sixteen/docs/wiki/concepts/coordinate-picker-design-comuni-parity-rule.md
  - ../../../../../../docs/wiki/concepts/filament5-schema-section-namespace-rule.md
---

# CoordinatePicker Design Comuni Runtime Rule

## Regola Permanente

Quando `CoordinatePicker` e' renderizzato dentro un wizard Filament/Livewire:

- la mappa Leaflet deve essere opaca e leggibile;
- i controlli fullscreen, geolocalizzazione, layer, zoom in e zoom out devono essere sempre visibili e cliccabili;
- selezionare un risultato di ricerca indirizzo deve spostare la mappa e posizionare il marker sulle coordinate del risultato;
- il componente Geo deve esporre comportamento funzionale, mentre il tema owner applica la parity visuale.

## Contratto Implementativo

Il componente Lit `coordinate-picker-lit` espone `setCoordinates(lat, lng, source)` per aggiornamenti programmatici provenienti dalla ricerca indirizzo.

`setCoordinates()` deve:

1. normalizzare le coordinate;
2. aggiornare lo stato/marker con lo stesso percorso di click e drag;
3. emettere `coords-changed`;
4. centrare la mappa con zoom utile per indirizzo puntuale.

Questo evita duplicazione tra Alpine, Livewire e Lit.

## Boundary DRY

- Geo: stato, marker, geocoding/reverse geocoding, metodo pubblico del web component.
- Sixteen: dimensioni, contrasto, opacita, spaziatura e stile controlli nel flusso Design Comuni.
