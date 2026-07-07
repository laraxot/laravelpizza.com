---
title: "Map-Lit Cluster — i marker 'scappano' al hover (fix)"
type: troubleshooting
confidence: high
created: 2026-06-03
updated: 2026-06-03
tags: [map-lit, markercluster, leaflet, hover, transform, farmshops, STORY-123]
related:
  - troubleshooting/map-current-position-bug-fix.md
  - concepts/geo-map-lit-implementation.md
  - concepts/map-lit-canonical-name.md
  - ../../farmshops-integration.md
  - ../../research-farmshops-architecture.md
---

# Map-Lit Cluster — i marker "scappano" al hover

**Status**: ✅ RISOLTO 2026-06-03 (STORY-123) — verifica Playwright `movedPx {dx:0, dy:0}`

## Sintomo

Sulla mappa `/it` (componente `<map-lit>`), passando il mouse sopra un marker
cluster, il cerchio **salta via** dalla sua posizione ("scappa") e/o trema.
UX pessima, percepita come glitch.

## Root cause (il punto non-ovvio)

`.geo-cluster-wrapper` **È** il `.leaflet-marker-icon`: Leaflet posiziona ogni
marker-icon via `transform: translate3d(x, y, 0)`. Qualsiasi regola CSS che
imposti un **altro** `transform` sull'icona (es. `transform: scale(1.1)` al
hover) **sovrascrive** la traslazione di posizionamento → il marker salta
all'origine del pane. Se è presente `transition: transform`, il salto viene
**animato** → tremolio.

```css
/* ❌ rompe l'anchor Leaflet */
.geo-cluster-wrapper { transition: transform 0.2s ease, box-shadow 0.2s ease !important; }
.geo-cluster-wrapper:hover { transform: scale(1.1) !important; }
```

### Perché correggere `map/styles.js` (light DOM) NON bastava

`map-lit` è un web component a **light DOM**. Le sue regole in
`resources/js/components/map/styles.js` erano già pulite, ma **perdevano la
cascade** contro il CSS di **tema bundlato** che usava `!important`:
`laravel/Themes/Sixteen/resources/css/app/07-map-clusters-and-leaflet.css`.

> **Lezione cascade**: per i componenti Lit a light DOM, il CSS del tema bundlato
> con `!important` **vince** sul CSS interno del componente. La fonte della
> regressione va cercata nel tema, non solo nel componente. Doc CSS canonico lato
> tema: [`marker-cluster-hover-stability.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/marker-cluster-hover-stability.md);
> lezioni trasversali (cascade + git multi-repo):
> [`leaflet-no-transform-on-marker-icon.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/leaflet-no-transform-on-marker-icon.md).

## Fix

1. **Tema** `07-map-clusters-and-leaflet.css` (fix principale): rimosso
   `transform: scale(1.1)` dall'hover; `transition` ridotta a **solo**
   `box-shadow 0.2s ease !important` (mai `transform`); feedback hover via sola
   `box-shadow`.
2. **Light DOM** `map/styles.js`: confermato senza `transform` su hover; hover
   solo `box-shadow`; divIcon 80×80 fisso, `transform-origin: center center`.
3. **`map-lit.js`**: config cluster allineata a farmshops
   ([direktvermarkter.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js)):
   `showCoverageOnHover`, divIcon 80×80 con `iconAnchor: L.point(40, 40)`;
   rimosso il refresh manuale dei cluster (`_scheduleClusterRefresh()`) per
   evitare race con il plugin.

## Regola riusabile

**Mai** `transform` o `transition: transform` su `.leaflet-marker-icon` (incluse
`.geo-cluster-wrapper` / divIcon). Per ingrandire/rimpicciolire un'icona, agire
sulla dimensione del **contenitore interno** (figlio del marker-icon), non sul
marker-icon stesso. Il feedback hover si dà con `box-shadow`/`color`, come fa
farmshops.eu.

Questa regola vale anche per i bug "vicini": icona trash troppo grande nel
cluster (#13/#12) e scomparsa cluster su pan/zoom (#24, bug **diverso**, legato a
`removeOutsideVisibleBounds` + refresh manuale).

## Verifica

```bash
cd laravel/Themes/Sixteen && npm run build
npx playwright test --config=laravel/Modules/Geo/playwright.config.js \
  tests/Playwright/map-lit-cluster-hover-stability.spec.js \
  tests/Playwright/map-lit-gps-cluster-stability.spec.js
```

Esito atteso: `movedPx {dx:0, dy:0}`, `transform` resta `matrix(1,0,0,1,…,…)`
(solo translate, non scalato), `transition` esclude `transform`. Smoke test
rendering `/it`: 12 marker, 1 cluster, 12 tile, 0 asset 404.

## Tracciamento

Story: `docs/stories/STORY-123-map-lit-cluster-hover-escape-fix.md` (root repo).
GitHub: issue [#28](https://github.com/laraxot/module_geo_fila5/issues/28)
(chiusa), discussion [#5](https://github.com/laraxot/module_geo_fila5/discussions/5).
