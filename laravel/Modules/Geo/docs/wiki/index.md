# Geo Module LLM Wiki

Indice operativo del wiki Geo.

## Struttura canonica (sacra)

- `concepts/`
- `entities/`
- `sources/`
- `comparisons/`
- `decisions/`
- `troubleshooting/`
- `_archive/`
- `_templates/`

## Regole collegate

- [no-docs-archive-rule](./concepts/no-docs-archive-rule.md)
- [wiki-sacred-structure-rule](../../../../../docs/wiki/concepts/wiki-sacred-structure-rule.md)
- [phpmd-standalone-phar-rule](../../../../../docs/wiki/concepts/phpmd-standalone-phar-rule.md) — PHPMD del progetto/BMAD va tenuto standalone `.phar`, non via Composer
- [filament custom field state binding modifiers](./concepts/filament-custom-field-state-binding-modifiers-rule.md) — nei custom field usare `applyStateBindingModifiers()` attorno a `wire:model` / `$entangle()` per rispettare `live()` e `defer()`
- [second brain discipline for geo](./concepts/second-brain-geo-module-discipline.md) — nel modulo Geo il second brain accumula contratti field/runtime e falsi amici gia' risolti

## Scopo Mappa in Admin Ticket Create

- [coordinate-picker-purpose](./concepts/coordinate-picker-purpose.md) — scopo mappa in `/fixcity/admin/tickets/create`: selezione precisa luogo, geolocalizzazione, search indirizzo, layer switching
- [map-purpose](./concepts/map-purpose.md) — finalità mappa in wizard admin: lat/lng ticket, fallback geolocazione, UI controls
- [map-picker-location-json-contract](./concepts/map-picker-location-json-contract.md) — `location` come payload JSON canonico con `lat/lng`, bridge legacy per `latitude/longitude`

## Regola Leaflet + Wizard

- [leaflet-wizard-step-invalidate-size](./concepts/leaflet-wizard-step-invalidate-size.md) — MutationObserver per rilevare cambio step wizard; invalidateSize() quando container diventa visibile
- [coordinate-picker-fullscreen-wizard-contract](./concepts/coordinate-picker-fullscreen-wizard-contract.md) — contratto fullscreen wizard; story 8-74 richiede Fullscreen API + fallback CSS + sync `fullscreenchange`
- [filament-admin-panel-map-visibility-contract](./concepts/filament-admin-panel-map-visibility-contract.md) — contratto mappa in panel Filament admin (non frontoffice)
- [geo-vite-build-contract](./concepts/geo-vite-build-contract.md) — contratto build Vite modulo Geo (entry reali, buildDirectory, verifica)
- [lit-light-dom-map-controls-and-sync](./concepts/lit-light-dom-map-controls-and-sync.md) — fix controlli mappa Lit + sync lat/lng in Light DOM
- [admin-map-magnifier-and-controls-visibility](./concepts/admin-map-magnifier-and-controls-visibility.md) — fix lente enorme e visibilità controlli mappa in admin
- [admin-map-runtime-500-encryption-key-blocker](./concepts/admin-map-runtime-500-encryption-key-blocker.md) — visual check bloccato da errore bootstrap Laravel (cipher/key), non da rendering mappa
- [reusable-search-ui-component-rule](./concepts/reusable-search-ui-component-rule.md) — il blocco search dei picker va estratto in componente Blade riutilizzabile

## SVG Assets (Filament Way)

- [lit-icons-filament-way](./concepts/lit-icons-filament-way.md) — icone Lit via `geoIcon()` da file SVG in `resources/svg/`, non hardcoded
- [svg-asset-architecture](./concepts/svg-asset-architecture.md) — SVG sempre in `Modules/Geo/resources/svg/`, mai CDN/unpkg
- [blade-icons-registration-rule](./concepts/blade-icons-registration-rule.md) — Blade Icons registrati SOLO da XotBaseServiceProvider, mai nei moduli (evita collisioni prefix)

## Story 8-56 — map-picker-lit.js admin fix

- [map-picker-lit-admin-fix-8-56](./concepts/map-picker-lit-admin-fix-8-56.md) — 5 bug risolti: vite input mancante, CDN CSS, IntersectionObserver falso amico, SVG senza dimensioni

## Troubleshooting recente

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [geo-module](./overviews/geo-module.md) | overview | Gerarchia geografica italiana, Address, Comune, geocoding, LeafletMarkerMapInput |
| [lit-raw-svg-rendered-as-text](./troubleshooting/lit-raw-svg-rendered-as-text.md) | troubleshooting | SVG importati con `?raw` nei picker Lit appaiono come testo grezzo sopra la mappa |

## Nuovi documenti 2026-04-27

- [svg-asset-architecture](./concepts/svg-asset-architecture.md) — aggiornato con nuovi file SVG (magnifying-glass, arrows-pointing-out/in, map-pin, squares-2x2, plus, minus)
- [blade-icons-registration-rule](./concepts/blade-icons-registration-rule.md) — collisioni prefix `geo` evitate: auto-registrazione XotBaseServiceProvider gestisce tutto

## Nuovi documenti 2026-04-30

- [geo-map-lit-data-url-property](./concepts/geo-map-lit-data-url-property.md) — **NUOVO**: proprietà `dataUrl` per caricamento dinamico GeoJSON da URL configurabile
- [geo-map-controls-shared-implementation](./concepts/geo-map-controls-shared-implementation.md) — documentazione completa pattern condivisione moduli condivisi
- [playwright-test-location-policy](./concepts/playwright-test-location-policy.md) — **NUOVO**: test Playwright appartengono ai moduli/temi, non nella root
- [claude-code-geo-rules-path-scoping](./concepts/claude-code-geo-rules-path-scoping.md) — **NUOVO**: rules Claude Code Geo path-scoped, docs owner nel modulo, niente caricamento globale `.claude/rules`
- [geo-map-lit-search-is-default](./concepts/geo-map-lit-search-is-default.md) — **NUOVO**: ricerca indirizzo inclusa nel componente ma collassata di default (`_searchOpen = false`), senza attributo Blade `show-search`

## Story 8-65 — CoordinatePicker Filament 5 state binding + save fix

- [coordinate-picker-filament5-save-pattern](./concepts/coordinate-picker-filament5-save-pattern.md) — root cause: `dehydrated(false)` blocca salvataggio; fix con `dehydrateStateUsing()` + Eloquent mutator
- [filament5-custom-field-entangle-contract](./concepts/filament5-custom-field-entangle-contract.md) — perché `$applyStateBindingModifiers("\$entangle('{$statePath}')")` è OBBLIGATORIO — prova dal codice vendor Filament 5
- [coordinate-picker-state-binding-rule](./concepts/coordinate-picker-state-binding-rule.md) — **NUOVO**: documentazione completa state binding Filament 5.x: differenza `$applyStateBindingModifiers()` vs `$wire.$entangle()` diretto, gestione modificatori `live()`/`defer()`
- [geojson-map-lit-component](./concepts/geojson-map-lit-component.md) — `<geojson-map-lit>` Web Component riutilizzabile: fetch GeoJSON, Leaflet + MarkerCluster, filterByType() API (pattern farmshops.eu)

## Story 8-78/8-79 — geo-map-lit segnalazioni-elenco + controlli unificati (2026-04-29)

### Componente `geo-map-lit`

- [geo-map-lit](./entities/geo-map-lit.md) — **NUOVA entità**: documentazione completa `<geo-map-lit>`, props, metodi pubblici/interni, bug noti, integrazione Blade, pattern GeoJSON fetch
- [static-geo-map-widget-pattern](./concepts/static-geo-map-widget-pattern.md) — aggiornato: aggiunta sezione pattern `geo-map-lit` per pagine pubbliche, path corretto `../public_html/data/tickets.json`, fix bug `GenerateTicketsJsonAction`

### Regola unificazione controlli

- [geo-map-controls-unification-rule](./concepts/geo-map-controls-unification-rule.md) — **NUOVO**: le due mappe del progetto (`geo-map-lit` + `coordinate-picker-lit`) DEVONO avere controlli visivamente e funzionalmente identici; design token `.ctrl-btn`; lista bug `geo-map-lit` da fixare (story 8-79)
- [geo-map-controls-shared-implementation](./concepts/geo-map-controls-shared-implementation.md) — **NUOVO**: condivisione moduli (`map-picker-controls.js`, `map-picker-search.js`, `map-picker-layers.js`, `map-picker-styles.js`) per garantire parity visiva e funzionale tra `geo-map-lit` e `coordinate-picker-lit`

### Bug documentati (story 8-78, fix applicati 2026-04-29)

| Bug | File | Fix |
|-----|------|-----|
| `$t->title` null | `GenerateTicketsJsonAction.php` | → `$t->name` |
| `$t->type->value` su stringa | `GenerateTicketsJsonAction.php` | → `getAttribute('type')` + BackedEnum check |
| Output path errato `../../public/` | `GenerateTicketsJsonAction.php` | → `../public_html/data/tickets.json` |
| `/data/tickets.json` 404 | — | File generato e servito |

### Story 8-80 — geo-map-lit riuso moduli condivisi (2026-04-29)

- [8-80 story](./../../../.planning/stories/8-80-geo-map-lit-shared-modules.story.md) — spec completa per importare `map-picker-controls`, `map-picker-search`, `map-picker-layers`, `map-picker-styles` in `geo-map-lit` senza duplicare codice

**Moduli già pronti per riuso (ctx-based):**

| Modulo | API esportata | Compat. geo-map-lit |
|--------|--------------|---------------------|
| `map-picker-controls.js` | `renderControls(ctx)`, `toggleFullscreen`, `zoomIn`, `zoomOut`, `switchLayer` | ✅ drop-in |
| `map-picker-search.js` | `renderSearch(ctx)`, branching su `_handleSearchSelection` vs `_handleMapInteraction` vs `setView` | ✅ solo aggiungere `_handleSearchSelection` |
| `map-picker-layers.js` | `buildMapLayers(L)` | ✅ drop-in → `this._layers = buildMapLayers(L)` |
| `map-picker-styles.js` | `mapPickerStyles` CSS template literal | ✅ drop-in |

**Search: `map-picker-search.js` è superiore alla versione custom in `geo-map-lit`:**
- Debounce 350ms ✅ vs ❌
- Dropdown 5 risultati ✅ vs solo setView ❌
- Keyboard nav completo ✅ vs solo Enter ❌
- Loading spinner ✅ vs ❌

### Story 8-81 — geo-map-lit: farmshops.eu parity (2026-04-29) ✅ COMPLETED

- [8-81 story](./../../../.planning/stories/8-81-geo-map-lit-farmshops-parity.story.md)
- **Playwright**: 13/13 test pass — mappa, tile, marker SVG, popup badge, controls, search

**Feature implementate ispirate a direktvermarkter.js:**

| Feature | Prima | Dopo |
|---------|-------|------|
| Marker rendering | `L.circleMarker` plain | `L.geoJson` + `pointToLayer` + SVG pin colorato per tipo |
| Popup | HTML plain | Bootstrap Italia badge colorato + titolo + indirizzo |
| Cluster LOD zoom≥8 | solo count | count + colored dots breakdown per categoria |
| `showCoverageOnHover` | false | true |
| `popupopen` resize | assente | maxHeight 40% mappa, maxWidth 90% |
| MutationObserver delays | solo 150ms | multi-delay [0, 80, 180, 350, 700, 1200] |
| Heatmap | layer vuoto | riempito da `_allFeatures` post-load |
| `filterByType` | re-crea markers | usa `_allMarkers` array, `addLayers(filtered)` |
| `fitBounds` | assente | su `_geojsonLayer.getBounds()` post-load |
| `geo-map-loaded` event | assente | dispatched con count + types |

**Bug risolti (da story 8-79/8-80):**

| Bug | Fix |
|-----|-----|
| `_wireControls()` non definita | Rimossa — `renderControls()` usa `@click` Lit |
| `L.control.zoom()` duplicato | Rimosso — `zoomControl: false` |
| `bindRefreshHandler`/`cleanupObservers` non importati | Rimossi dal sorgente |
| `L.HeatLayer is not a constructor` | try/catch graceful fallback |
| `fitBounds: Bounds are not valid` | try/catch + `bounds.isValid()` check |

### Story 8-82 — Mappa non visibile: diagnosi & fix deploy atomico (2026-04-29) ✅ RESOLVED

- [8-82 story](./../../../.planning/stories/8-82-geo-map-lit-not-visible-diagnosis.story.md)
- [Wiki concept: segnalazioni-elenco-map-visibility-issue](./concepts/segnalazioni-elenco-map-visibility-issue.md)

**Root cause**: 11 vecchi bundle `geo-map-lit-*.js` in `public_html/assets/geo/assets/` da build precedenti.
Il bundle `B98GNGDO.js` (ancora in cache HTTP del browser) aveva `bindRefreshHandler is not defined` → `_initMap()` crashava → mappa non montava.

**Fix**: atomic swap — `rm -f geo-map-lit-*.js` prima di `cp` nuovo bundle.

**Pulizia applicata**: 59 bundle obsoleti rimossi da `public_html/assets/geo/assets/`.

**Regola da seguire sempre**:
```bash
rm -f public_html/assets/geo/assets/geo-map-lit-*.js   # prima
cp public/assets/$NEWJS public_html/assets/geo/assets/  # poi
```

## Story 8-83 — Nuovi documenti 2026-04-30

- [geo-map-lit-data-url-property](./concepts/geo-map-lit-data-url-property.md) — **NUOVO**: proprietà `dataUrl` per caricamento dinamico GeoJSON da URL configurabile
- [geo-map-controls-shared-implementation](./concepts/geo-map-controls-shared-implementation.md) — documentazione completa pattern condivisione moduli condivisi

## Story 8-84 — Nuovi documenti 2026-04-30 (continuazione)

- [geo-map-lit-search-default](./concepts/geo-map-lit-search-default.md) — **NUOVO**: ricerca indirizzo nascosta di default, visibile solo dopo click lente
- [geo-map-lit-dynamic-popup](./concepts/geo-map-lit-dynamic-popup.md) — **NUOVO**: pattern popup dinamico ispirato a farmshops.eu con caricamento AJAX dettagli

## Story 8-87 — cluster behavior parity (2026-04-30)
 
- [geo-map-lit](./entities/geo-map-lit.md) — updated contract: search toggle, outside close, and marker clustering fix
- [geo-map-lit-marker-clustering](./concepts/geo-map-lit-marker-clustering.md) — implementation details of marker clustering, including inlining rationale and parity with farmshops.eu
- [geo-map-lit-marker-clusters](./concepts/geo-map-lit-marker-clusters.md) — configuration settings for clusters: `showCoverageOnHover: false`, dynamic sizing, and zoom thresholds
- [document-root-isolation-pattern](../../../../../docs/wiki/concepts/document-root-isolation-pattern.md) — why we use `public_html` instead of `laravel/public`

## Visual Testing (2026-05-04)

- [visual-testing-playwright-puppeteer](./concepts/visual-testing-playwright-puppeteer.md) — **NUOVO**: guida completa Playwright vs Puppeteer, installazione Laravel, esempi Pest v4, visual regression testing per MapPicker

## Story 8-88 — marker/cluster visibility + data loading parity (2026-04-30)

- [story artifact 8-88](../../../../../_bmad-output/implementation-artifacts/8-88-segnalazioni-elenco-marker-cluster-data-loading-farmshops-parity.story.md) — hardening end-to-end su marker/cluster non visibili, dataset numeroso e fallback runtime.

## Nuovi documenti 2026-05-01

- [map-lit-component](./concepts/map-lit-component.md) — **NUOVO**: componente `map-lit` conversione fedele di `direktvermarkter.js` da farmshops.eu in Lit.dev, risolve bug validazione marcatori e clustering
- [git-forward-only-policy](./governance/git-forward-only-policy.md) — **NUOVO**: disciplina operativa Git "Sempre in Avanti" per preservazione contesto AI e audit trail
- [document-root-security](./architecture/document-root-security.md) — **NUOVO**: razionale architetturale per l'uso di `public_html` come web root per sicurezza e conformità
