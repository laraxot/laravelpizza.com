# geo-map-lit — guida ricostruzione da documentazione

## scopo

Se il codice JS/CSS della mappa su `/it` andasse perso, questa pagina è il **contratto unico** per ricostruire comportamento, file, misure e fix già validati (STORY-121 → STORY-130, UX 2026-06).

**Perché esiste:** la mappa è cross-modulo (Geo + Fixcity JSON + tema Sixteen Vite). La bussiness logic è «cittadino vede segnalazioni, filtra per tipo/stato, clicca per dettaglio» — non «un plugin Leaflet generico».

**Registro correzioni (tabella):** [geo-map-fixes-registry.md](./geo-map-fixes-registry.md) · **Hub root:** [map-lit-reconstruction-hub.md](../../../../../docs/wiki/memories/map-lit-reconstruction-hub.md)

---

## contratto runtime (non negoziabile)

| Pezzo | Valore |
|-------|--------|
| Pagina | `/it`, `body[data-page="ticket-list"]` |
| Componente | `<map-lit id="block-map" data-url="/data/tickets.json">` |
| SSoT dati | `public_html/data/tickets.json` ← `GenerateTicketsJsonAction` (Fixcity) |
| Filtri sidebar | `SegnalazioniFilterViewModel` + evento `filters-changed` |
| JS entry | `Modules/Geo/resources/js/components/map-lit.js` |
| Build | `cd laravel/Themes/Sixteen && npm run build` → `public_html/themes/Sixteen/assets/map-lit-*.js` |
| Manifest | `public_html/themes/Sixteen/manifest.json` (Blade legge hash bundle) |

**Semantica pin:** colore = `TicketStatusEnum`; icona = `TicketTypeEnum` (`iconUrl` in properties). Vedi [ticket-type-vs-status-map-semantics.md](./ticket-type-vs-status-map-semantics.md).

---

## mappa file (ricostruzione minima)

```
Modules/Geo/resources/js/components/
  map-lit.js                    # orchestrazione Leaflet + Lit
  map/
    marker-config.js            # divIcon marker + markerCardStylesText
    popup-ticket.js             # HTML popup + popupTicketStylesText
    icon-glyph.js               # buildMarkerGlyphHtml, cluster dot SVG
    legend.js                   # control tipologie (se abilitato)
    styles.js                   # controlli mappa (no transform su marker-icon)

Themes/Sixteen/resources/css/app/
  07-map-clusters-and-leaflet.css   # cluster, marker, popup override tema
  13-final-runtime-overrides.css    # popup header min-height fix (ultimo cascade)

Themes/Sixteen/resources/views/...   # layout elenco + <map-lit>
public_html/data/tickets.json
```

---

## marker — plate stato + pad bianco + punta (implementazione 2026-06)

**Riferimenti UX:** [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu); contrasto su basemap (alone bianco + glow); punta = coordinate GPS.

### dimensioni (SSoT `marker-config.js`)

| Costante | px |
|----------|-----|
| `MARKER_WIDTH` | 40 |
| `MARKER_BODY_SIZE` | 36 |
| `MARKER_POINTER_HEIGHT` | 8 |
| `MARKER_TOTAL_HEIGHT` | 44 |
| `MARKER_GLYPH_PAD` | 28 |
| `MARKER_GLYPH_SIZE` | 22 |
| `iconAnchor` | `[20, 44]` |
| `popupAnchor` | `[0, -42]` |

### DOM (divIcon html)

```html
<div class="geo-map-marker-card" style="--status-color:#…;--status-fill:rgba(…);--status-glow:rgba(…)">
  <div class="geo-map-marker-card__shell">
    <div class="geo-map-marker-card__inner">
      <div class="geo-map-marker-card__glyph-pad">
        <img class="geo-map-marker-glyph--img" width="22" height="22" … />
      </div>
    </div>
    <span class="geo-map-marker-card__point"></span>
  </div>
</div>
```

Punta: elemento `<span class="geo-map-marker-card__point">` (triangolo CSS), non `::before`/`::after` sul card.

### CSS (`markerCardStylesText` + tema)

- `__inner`: squircle 11px, gradiente stato, bordo bianco 2.5px
- `__glyph-pad`: `#fff` 28×28, glifo a colori 22px
- `__point`: `border-top` = `--status-color`, halo `drop-shadow`
- **Hover:** `transform` su `__shell` (`transform-origin: 50% 100%`) — **vietato** `transform` su `.leaflet-marker-icon` (STORY-123)

**Deprecato:** `__body`, punta solo `::after` sul card senza `__shell`, dimensioni 44×52 da doc vecchi.

Dettaglio: [geo-map-marker-status-background.md](./geo-map-marker-status-background.md) · tema: [geo-map-marker-civic-pin-theme-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/geo-map-marker-civic-pin-theme-boundary.md)

---

## popup — block `popup` (BEM)

**Perché block corto:** modulo Geo già namespaced; `geo-popup-segnalazione` era ridondante e favoriva hack CSS.

| Classe | Ruolo |
|--------|--------|
| `popup` | `<article>` card |
| `popup--loading` | skeleton; **senza** `popup__footer` nel DOM |
| `popup__header` | **`<div>`** (non `<header>` — vedi incidente sotto) |
| `popup__header-bar` | griglia `1fr auto`: titolo \| badge stato |
| `popup__body` | righe Tipologia, Indirizzo, mappe, descrizione, gallery |
| `popup__footer` | solo stato loaded: scheda + chiudi |
| `popup-wrapper` | `className` su `L.popup` |

### flusso

1. Click → `buildTicketPopupLoadingHtml` se `properties.id`
2. `GET /api/ticket-details/{id}` → `buildTicketPopupHtml`
3. Chiusura popup: fetch completato **non** deve riaprire

### stili

- SSoT stringa: `popupTicketStylesText` in `popup-ticket.js`
- Iniettati da `map-lit.js`: `<style>` nel component + `#popup-styles` in `document.head`

Regola BEM: [bem-modifier-dom-contract.md](../rules/bem-modifier-dom-contract.md) — vietato `.popup--loading .popup__footer { display: none }`.

Dettaglio: [geo-map-popup-bem.md](./geo-map-popup-bem.md)

---

## incidenti documentati (non ripetere errori)

| # | Sintomo | Doc |
|---|---------|-----|
| 1 | Mappa vuota / 404 bundle | [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md) §1 |
| 2 | Marker spariscono dopo GPS | idem §2 |
| 3 | Cluster scappano hover | [marker-cluster-hover-stability.md](../../../../../Themes/Sixteen/docs/wiki/concepts/marker-cluster-hover-stability.md) |
| 4 | Icona trash gigante in cluster | [map-lit-cluster-type-icons.md](./map-lit-cluster-type-icons.md) |
| 5 | Legenda assente | [map-lit-legend-types.md](./map-lit-legend-types.md) |
| 6 | Vuoto bianco popup header→Tipologia | [map-popup-header-whitespace-fix.md](../troubleshooting/map-popup-header-whitespace-fix.md) |
| 7 | Marker quadrato piatto / poco leggibile | [geo-map-marker-status-background.md](./geo-map-marker-status-background.md) |

---

## cluster (farmshops parity)

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

Marker aggiunti **uno a uno** al cluster (no `L.geoJson` wrapper che perde riferimenti).

---

## checklist ricostruzione

1. Ripristinare `marker-config.js` + `popup-ticket.js` da questa spec (misure tabella sopra).
2. `map-lit.js`: import popup + marker styles; `_bindFeaturePopup`; `className: 'popup-wrapper'`.
3. Tema: `07-map-clusters-and-leaflet.css` + `13-final-runtime-overrides.css` (popup header).
4. `npm run build` in Sixteen; verificare `manifest.json` punta a `map-lit-*.js` esistente.
5. Hard refresh `/it`; 12 marker demo; popup compatto; cluster stabili al hover.
6. Playwright: `map-lit-cluster-hover-stability`, legend, cluster-icon-size (se presenti).

---

## stories e github

| Story | Argomento |
|-------|-----------|
| [STORY-129](../../../../../docs/stories/STORY-129-map-marker-icon-first-popup-ux.md) | Marker + popup UX |
| STORY-121–124 | Visibilità, GPS, cluster hover |
| STORY-128 | Filtri stato sidebar |
| STORY-130 | Sfondo stato marker (se file story esiste) |

Issue modulo: [module_geo_fila5#4](https://github.com/laraxot/module_geo_fila5/issues/4) · base [#227](https://github.com/laraxot/base_fixcity_fila5/issues/227)

---

## collegamenti

- [geo-map-lit-farmshops-parity.md](./geo-map-lit-farmshops-parity.md)
- [geo-map-popup-leaflet-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/geo-map-popup-leaflet-boundary.md)
- [ticket-list-map-integration.md](../../../../../Themes/Sixteen/docs/wiki/concepts/ticket-list-map-integration.md)
- [map-lit-vite-build-troubleshooting.md](../../../../../Themes/Sixteen/docs/wiki/concepts/map-lit-vite-build-troubleshooting.md)
- Wiki root memoria: [map-lit-marker-cluster-farmshops-pattern.md](../../../../../../docs/wiki/memories/map-lit-marker-cluster-farmshops-pattern.md)
