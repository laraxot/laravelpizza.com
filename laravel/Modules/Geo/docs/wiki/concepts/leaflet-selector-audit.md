# Leaflet Selector Audit

## Scope audit

Ricerca eseguita su modulo Geo e tema Sixteen per pattern id-based nei componenti mappa.

## Esito sintetico

- **Picker family Geo (target principale):** governance formalizzata e pattern class-based confermato come standard.
- **Residui id-based presenti:** soprattutto in file legacy/demo, asset compilati, librerie vendorizzate e docs storiche.

## Priorita operative

1. **Alta**: componenti runtime attivi della picker family (`CoordinatePicker`, `MapPicker`, `PlacePicker`, `LatitudeLongitudeInput`).
2. **Media**: blade legacy non core (`leaflet-marker-map-input`) da riallineare quando entra nel perimetro di refactor.
3. **Bassa**: file vendorizzati/minificati/docs storiche/demo (`leaflet-src.js`, asset build, pagine farmshops legacy), non da toccare in massa senza task dedicato.

## Decisione

La policy “class selectors only” resta **obbligatoria** per tutti i nuovi interventi e per ogni refactor dei picker runtime.

## Riferimenti

- [leaflet-class-selector-governance](./leaflet-class-selector-governance.md)
- [map-picker-family-architecture](./map-picker-family-architecture.md)
