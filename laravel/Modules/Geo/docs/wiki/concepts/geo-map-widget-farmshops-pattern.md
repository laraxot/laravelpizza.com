---
type: concept
module: Geo
sources:
  - ../../../stories/geo-map-widget-farmshops-lod.md
  - ../../../farmshops-integration-analysis.md
  - ../../../LIT-MAP-IMPLEMENTATION.md
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/popupcontent.js
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/update_data.js
confidence: high
updated: 2026-04-17
---

# GeoMapWidget Farmshops Pattern

## Decisione

Per il `GeoMapWidget` del modulo `Geo` il pattern corretto è:

- dataset **GeoJSON statico** caricato una sola volta lato client;
- rendering **Leaflet** con `leaflet.markercluster`;
- stato UI e filtri mantenuti **interamente nel browser**;
- separazione netta tra:
  - trasformazione dati GeoJSON;
  - state management;
  - rendering Leaflet;
  - layer manager;
  - Web Component Lit come boundary UI.

Questo replica il principio prestazionale di `farmshops.eu` senza copiarne in modo cieco l’implementazione.

## Cosa è verificato in farmshops.eu

Dall’analisi di `direktvermarkter.js`, `popupcontent.js` e `update_data.js` risultano verificati questi principi:

- il dataset viene preparato offline e servito come file statico;
- la mappa evita roundtrip server durante pan/zoom/filter normali;
- i marker sono clusterizzati per ridurre il costo di rendering;
- popup e dettagli sono costruiti dai dati già presenti localmente;
- il sistema privilegia semplicità operativa e performance su dataset di poche migliaia di punti.

## Adattamento corretto nel modulo Geo

Nel contesto Laraxot/FixCity il pattern diventa:

- backend PHP: costruisce un payload `FeatureCollection` coerente dal dominio `Place`;
- frontend JS: riceve il payload già normalizzato e non richiama endpoint addizionali;
- `Lit` funge da boundary del widget, non da store globale;
- `Leaflet` resta il motore di rendering reale;
- il widget vive interamente nel modulo `Geo`, senza contaminare altri domini.

## Regole architetturali

- Il widget Filament espone solo il payload e la view.
- La logica mappa non va messa in Blade.
- Il Web Component non deve conoscere Eloquent o Livewire.
- Il renderer Leaflet non deve fare fetch o trasformazioni business-oriented.
- I layer devono essere attivabili/disattivabili tramite un manager dedicato.
- Per Leaflet è lecito usare light DOM quando serve compatibilità con CSS globali della libreria.

## Layer minimi

- `cluster`: default per zoom basso o medio
- `points`: dettaglio marker a zoom alto
- `heatmap`: densità opzionale
- `zones`: poligoni/aree GeoJSON, se presenti

L’attivazione dei layer deve essere combinabile e non deve forzare un reload dati.

## LOD consigliato

- zoom basso: cluster
- zoom intermedio: cluster con progressiva riduzione aggregazione
- zoom alto: marker puntuali e stato selezione più preciso

La logica LOD deve limitare re-render completi e riutilizzare i layer già materializzati quando possibile.

## Stato client-side minimo

- `center`
- `zoom`
- `selectedId`
- `activeLayers`
- `filters`

Questo stato è sufficiente per:

- sincronizzare UI interna;
- applicare filtri client-side;
- mantenere selezione e popup;
- evitare richieste ripetute al server.

## Anti-pattern

- fetch server a ogni movimento mappa;
- HTML popup costruito nella Blade del widget;
- logica Leaflet dentro classi PHP;
- uso di CDN fuori dalla pipeline npm/Vite del progetto;
- dataset spezzato in molte chiamate se il volume resta nell’ordine di ~3000 punti;
- coupling diretto tra Web Component e query backend.

## Implicazioni pratiche per il repo

- il modulo `Geo` può mantenere componenti Lit dedicati alle mappe;
- i payload mappa devono essere documentati come contratti stabili;
- i problemi di build Vite/Mix vanno distinti dai problemi architetturali del widget;
- la qualità del widget va verificata con test PHP sul payload e con build frontend funzionante.
