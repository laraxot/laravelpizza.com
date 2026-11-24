---
title: "ADR — Componenti mappa Lit in Light DOM con pane Leaflet protetto"
type: decision
status: accepted
module: Geo
tags: [adr, geo, lit, leaflet, light-dom, livewire, wizard]
created: 2026-04-22
updated: 2026-11-24
related:
  - ../../resources/js/components/coordinate-picker-lit.js
  - ../../resources/js/components/location-picker-lit.js
  - ../../resources/js/components/map-picker-lit.js
---

# ADR: componenti mappa Lit in Light DOM, con il pane Leaflet protetto da `guard`

## Contesto

- I campi mappa del modulo (picker di coordinate, luogo, geopoint, mappa) vivono dentro form Filament a più step (wizard)
  e tab, ridisegnati da Livewire a ogni aggiornamento di stato.
- Con lo Shadow DOM i componenti soffrivano di: mappa grigia quando nascono in uno step nascosto (Leaflet misura un
  contenitore di 0 px), istanza della mappa persa quando Lit ridisegna il template dopo un aggiornamento Livewire, CSS di
  Leaflet e icone non applicati dentro la shadow root.
- Il componente usato dal pannello è `coordinate-picker-lit` (`vite.config.js`, `app/Providers/Filament/AdminPanelProvider.php`,
  viste `resources/views/filament/forms/components/*.blade.php`).

Domanda: come rendere stabili le mappe Leaflet dentro componenti Lit montati e ridisegnati da Livewire?

## Decisione

- Light DOM: i componenti mappa definiscono `createRenderRoot() { return this; }`, così CSS di Leaflet e del tema si
  applicano e Livewire vede il markup.
- Il contenitore della mappa è avvolto in `guard([], () => html\`…\`)`: Lit non lo ridisegna mai, l'istanza Leaflet sopravvive.
- `ResizeObserver` + `map.invalidateSize()`: la mappa si ricalcola quando lo step o il tab diventa visibile.
- Le icone sono template `html`, non stringhe, per non essere escapate.
- Classi CSS specifiche (es. `.map-picker-leaflet-pane`) al posto di `:host`/`::part`, perché in Light DOM lo stile è globale.

## Alternative scartate

- Shadow DOM con `::part` e stili iniettati: era la situazione di partenza, con i difetti sopra.
- `wire:ignore` sul solo wrapper senza `guard`: Livewire smette di toccare il nodo ma Lit continua a ridisegnare il
  proprio template e a ricreare il contenitore della mappa.
- Ricreare la mappa a ogni `updated()`: perde zoom, posizione e marker trascinati dall'utente, e ricarica i tile.

## Conseguenze

- Pro: mappe stabili negli step e nei tab; lo stile si governa con CSS normale.
- Contro: in Light DOM il CSS è globale: nomi di classe specifici obbligatori.
- Debito misurato (2026-11-24, `grep` su `resources/js`): dei 22 file con `extends LitElement`, 17 usano Light DOM,
  9 usano `guard(` e 12 `ResizeObserver`; restano varianti storiche (`geo-map-lit-new.js`, `geo-map-lit-final.js`,
  `coordinate-picker-lit-stable.js`) da consolidare. Copiare il componente montato dal pannello (`coordinate-picker-lit.js`),
  non le varianti.

## Verifica

Solo revisione: nessun test JS né browser controlla la regola (l'unico spec in `tests/Browser` riguarda i cluster della
mappa di elenco). Controllo rapido su un componente nuovo o modificato: `grep -c "createRenderRoot\|guard(\|ResizeObserver"
resources/js/components/<file>.js` deve trovare tutti e tre; a mano, aprire un wizard con la mappa in uno step non
iniziale e verificare che non resti grigia.
