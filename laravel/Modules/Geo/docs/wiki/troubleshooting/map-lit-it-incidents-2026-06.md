# map-lit su /it — incidenti e risoluzioni (2026-06)

## Scopo

Second brain operativo per STORY-121/122/123/124: mappa elenco segnalazioni, cluster, GPS, build Vite.

**Registro correzioni (tabella):** [geo-map-fixes-registry.md](../concepts/geo-map-fixes-registry.md) · **Ricostruzione:** [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md)

## Contratto runtime

| Pezzo | Valore |
|-------|--------|
| Pagina | `/it` / `/it/#` (`data-page=ticket-list`) |
| Componente | `<map-lit id="block-map" data-url="/data/tickets.json">` |
| SSoT JSON | `public_html/data/tickets.json` (mappa + facet filtri sidebar) |
| Filtri | `SegnalazioniFilterViewModel` ← stesso JSON; pin + `iconUrl` in sidebar (STORY-127) |
| GPS | Nessun `lat`/`lng` su `<map-lit>` → `_tryCenterOnGpsThenMarkers` al primo load |
| JS | `Modules/Geo/resources/js/components/map-lit.js` |
| Build | `Themes/Sixteen` → `public_html/themes/Sixteen/assets/map-lit-*.js` |
| GitHub owner | Issue [#38](https://github.com/laraxot/module_geo_fila5/issues/38) su `module_geo_fila5` |

---

## Incidente 1 — Mappa non visibile (STORY-121)

**Sintomo:** tab Mappa vuota, bundle 404.

**Cause:** manifest Blade obsoleto; alias Vite mancanti per Lit/Leaflet.

**Fix:** `npm run build` in Sixteen (+ `view:clear`); alias in `vite.config.js`.

**Verifica:** 12 feature GeoJSON, `customElements.get('map-lit')` definito.

Doc tema: [map-lit-vite-build-troubleshooting.md](../../../../../Themes/Sixteen/docs/wiki/concepts/map-lit-vite-build-troubleshooting.md)

---

## Incidente 2 — Marker spariscono dopo GPS / pan (STORY-122/124)

**Sintomo:** GPS centra correttamente ma cluster/marker scompaiono dal DOM.

**Cause:**

1. `removeOutsideVisibleBounds: true` + `setView(GPS)` → ticket fuori viewport rimossi dal layer
2. `refreshClusters()` manuale → race con plugin
3. `IntersectionObserver` che chiamava `fitBounds` dopo GPS

**Fix in `map-lit.js`:**

- `removeOutsideVisibleBounds: false`
- Rimosso `_scheduleClusterRefresh()` e listener moveend dedicati
- `refreshWhenVisible()` → solo `invalidateSize`
- GPS: assenza `lat`/`lng` → geoloc; presenza → `setView` esplicito (**no** flag `center-on-gps`)

**Pattern:** [map-lit-lat-lng-gps-default-pattern.md](../../../../../../docs/wiki/memories/map-lit-lat-lng-gps-default-pattern.md)

---

## Incidente 3 — Cluster "scappano" al hover (STORY-123)

**Sintomo:** cluster tremano o saltano al mouse.

**Cause (ordine di scoperta):**

1. **CSS tema** `07-map-clusters-and-leaflet.css`: `transform: scale(1.1) !important` su `.geo-cluster-wrapper` (= `.leaflet-marker-icon`)
2. `transition: transform` animava il salto
3. Correzione solo in `map/styles.js` insufficiente (cascade tema vince)

**Fix:**

- Tema: hover solo `box-shadow`, zero `transform` sul wrapper
- `listing-parity.css`: cluster 80×80 allineati a divIcon
- JS: no `refreshClusters()` manuale

Doc tema: [marker-cluster-hover-stability.md](../../../../../Themes/Sixteen/docs/wiki/concepts/marker-cluster-hover-stability.md)

**Test:** `tests/Playwright/map-lit-cluster-hover-stability.spec.js`

---

## Configurazione cluster attuale (farmshops parity)

```javascript
L.markerClusterGroup({
  maxClusterRadius: (z) => (z < 12 ? 80 : 45),
  spiderfyOnMaxZoom: true,
  showCoverageOnHover: true,
  zoomToBoundsOnClick: true,
  removeOutsideVisibleBounds: false,
  iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
});
```

Marker aggiunti **singolarmente** al cluster (no wrapper `L.geoJson`).

Riferimento: [farmshops-eu-applicability-fixcity.md](../concepts/farmshops-eu-applicability-fixcity.md)

---

## Checklist post-modifica map-lit

1. `cd laravel/Themes/Sixteen && npm run build`
2. Playwright cluster + GPS (2 spec)
3. Smoke `/it`: 12 marker, 0×404
4. Hard refresh browser
5. Commento su [module_geo_fila5 discussion #5](https://github.com/laraxot/module_geo_fila5/discussions/5)

---

## Collegamenti

- [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md) — SSoT ricostruzione marker + popup
- [geo-map-lit-farmshops-parity.md](../concepts/geo-map-lit-farmshops-parity.md)
- [map-lit-canonical-name.md](../concepts/map-lit-canonical-name.md)
- Wiki root: [map-lit-marker-cluster-farmshops-pattern.md](../../../../../../docs/wiki/memories/map-lit-marker-cluster-farmshops-pattern.md)
- Stories: STORY-121–124, STORY-129 (popup/marker UX), STORY-130 (sfondo stato)

---

## Incidente 4 — Icona trash enorme nel cluster (#12 / #13)

**Sintomo:** glifo trash (tipo waste) gigante dentro il cluster.

**Cause:** SVG tipo grezzo nel cluster + CSS tema che scala SVG senza width; confuso con glifo marker 14px nel pin.

**Fix:**

- `buildClusterTypeDotHtml()` — pallini colore 14px, mai Heroicon nel cluster
- CSS lock su `.geo-cluster-type-icons` in `styles.js` + `07-map-clusters-and-leaflet.css`

**Test:** `map-lit-cluster-icon-size.spec.js`

Doc: [map-lit-cluster-type-icons.md](../concepts/map-lit-cluster-type-icons.md)

---

## Incidente 5 — Legenda tipologie assente (STORY-094 / #14)

**Sintomo:** utente non capisce i colori pin senza cliccare marker.

**Fix:**

- `map/legend.js` — Leaflet control `bottomleft`
- `_syncMapLegend()` su load JSON + `filterByTypes`

**Test:** `map-lit-legend.spec.js`

Doc: [map-lit-legend-types.md](../concepts/map-lit-legend-types.md)

---

## Incidente 6 — Vuoto bianco popup (header → Tipologia) (STORY-129)

**Sintomo:** fascia bianca tra titolo/badge e riga TIPOLOGIA (UX area rossa).

**Cause:** `header { min-height: 222px !important }` da parity Design Comuni su tag `<header class="popup__header">`; in seguito anche flex `1 1 100%` sul titolo.

**Fix:**

- Markup: `<div class="popup__header">` (BEM invariato)
- Override `min-height: 0 !important` in popup JS + `07-map-clusters` + `13-final-runtime-overrides`
- `.dc-homepage-parity header` ristretto a `.it-header-wrapper`

**Doc:** [map-popup-header-whitespace-fix.md](./map-popup-header-whitespace-fix.md)

---

## Incidente 7 — Marker plate + pad + punta (STORY-129/130)

**Sintomo:** marker bianco piatto o senza punta; glifo illeggibile su fill stato; doc obsoleta citava `__body`/`__point` SVG.

**Fix (`marker-config.js`):**

- `__shell` + `__inner` 36px — gradiente **stato**, bordo bianco
- `__glyph-pad` bianco 28px — glifo tipologia **22px a colori**
- `__point` span — triangolo 8px; `iconAnchor` `[20, 44]`
- Tema `07-map-clusters`: `__glyph-pad`, `__point` (rimosso `__body` obsoleto)

**Doc:** [geo-map-marker-status-background.md](../concepts/geo-map-marker-status-background.md) · [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md)

---

## Checklist post-modifica (aggiornata)

1. `cd laravel/Themes/Sixteen && npm run build`
2. Playwright: hover, GPS, cluster-icon-size, legend
3. Smoke `/it`: 12 marker, popup compatto (no vuoto header), marker con punta
4. Hard refresh browser
5. Commento discussion #5 module_geo_fila5
6. `bash bashscripts/docs/llm-wiki-qmd.sh update` (ingest QMD)
