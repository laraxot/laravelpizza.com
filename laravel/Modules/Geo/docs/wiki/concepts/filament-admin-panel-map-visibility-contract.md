# Filament admin panel map visibility contract

## Scopo

Definire un contratto esplicito per il rendering mappa nei form Filament admin (non frontoffice).

## Principio

Leaflet in wizard/tab/step nascosti richiede gestione esplicita di visibilita' container e resize.

## Regole

1. inizializzare la mappa solo quando il container e' realmente visibile, oppure gestire refresh robusto al cambio visibilita'
2. chiamare `invalidateSize()` dopo transizioni di step/tab/modal
3. usare redraw tile solo come recovery mirata (non loop aggressivi)
4. verificare CSS Leaflet nel contesto render effettivo del panel
5. testare sempre sulla route admin reale, non solo su pagine demo/frontoffice

## False friends

- "funziona su `tests/segnalazione-crea`, quindi funziona anche in admin"
- "HTTP 200 implica mappa corretta"
- "basta un `invalidateSize()` al mount"
- "asset registry e file deployati sono sempre allineati"

## Nota pratica su questo repository

Nel deploy corrente:

- `public_html/modules/geo/` contiene `map-picker.css` e `map-picker.js`
- `public_html/modules/geo/geo-map-widget.js` risulta assente
- `public_html/themes/Geo/js/geo.js` risulta presente su path diverso

Questa asimmetria va trattata come root-cause candidata primaria quando la mappa admin non appare.

## Esito check visuale corrente (admin tickets create)

- route admin raggiungibile
- map picker presente a layout
- richieste runtime mostrano fallback chain con asset mancanti su `/modules/geo/`:
  - `geo-map-widget.js` 404
  - `geo.js` 404 (HEAD)
  - fallback `themes/Geo/js/map-picker-component.js` 200

Conclusione: la mappa dipende ancora da catena fallback non pienamente allineata alla registry dichiarata del panel.

## Riferimenti

- [leaflet wizard step invalidate size](./leaflet-wizard-step-invalidate-size.md)
- [coordinate picker lit wizard fullscreen rule](./coordinate-picker-lit-wizard-fullscreen-rule.md)
- [fixcity admin ticket create map visual contract](../../../Fixcity/docs/wiki/concepts/admin-ticket-create-map-visual-contract.md)
