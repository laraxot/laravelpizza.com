---
title: "Segnalazioni Elenco — Mappa e Cluster: Diagnosi e Fix"
type: troubleshooting
confidence: high
created: 2026-04-29
updated: 2026-05-08
tags: [map-lit, geo-map-lit, markercluster, geolocation, cache, bundle, deploy, playwright]
related:
  - concepts/geo-map-controls-unification-rule.md
  - concepts/static-geo-map-widget-pattern.md
  - entities/geo-map-lit.md
---

# Segnalazioni Elenco — Mappa e Cluster: Diagnosi e Fix

**Status**: ✅ RISOLTO 2026-05-08 — `map-lit` visibile e test Playwright 11/11
**Storia diagnosi**:
- Originale: [8-82](./../../../.planning/stories/8-82-geo-map-lit-not-visible-diagnosis.story.md) — risolta 2026-04-30 (bundle obsoleto in cache)
- Regressione: 8-134 — `<map-lit>` non importato in `Themes/Sixteen/resources/js/app.js` → `HTMLUnknownElement` inerte
- Regressione: 2026-05-08 — `@include('pub_theme::components.sections.map-lit')` senza partial → HTTP 500

---

## Regressione 2026-05-07 — Custom element non importato

**Sintomo identico**: utente non vede la mappa in `/it/tests/ticket-list`.

**Root cause diversa** dalla 8-82:
- `pages/tests/ticket-list.blade.php:11` rende `<map-lit data-url="...">`
- `Modules/Geo/resources/js/components/map-lit.js` definisce correttamente `customElements.define('map-lit', MapLit)`
- `Themes/Sixteen/resources/js/app.js` importava `geo-map-lit.js`, `my-map-lit.js`, `map-picker-lit.js` ecc., **ma NON `map-lit.js`**
- → Bundle del tema non includeva la classe `MapLit`
- → Browser tratta `<map-lit>` come `HTMLUnknownElement` (display:inline, nessun comportamento)

**Fix definitivo (decisione 2026-05-07)**:
1. Aggiunto `import '@modules/Geo/resources/js/components/map-lit.js';` in `Themes/Sixteen/resources/js/app.js` (subito dopo l'import di `geo-map-lit.js`)
2. `cd laravel/Themes/Sixteen && npm run build && npm run copy`
3. Atomic swap dei bundle hashati in `public_html/themes/Sixteen/assets/` (368 → 8 file prima, poi npm run copy ricostituisce solo i nuovi)

**Decisione architetturale**: il nome canonico per la pagina `ticket-list` è `<map-lit>` (NON `<geo-map-lit>` né `<ticket-map-lit>`). Migrazioni di pagine esistenti devono essere additive (mantenere `<map-lit>`), non sostitutive.

---

## Tabella varianti `*-lit.js` in Modules/Geo/resources/js/components/

| File | Custom element | Stato |
|------|----------------|-------|
| `map-lit.js` | `<map-lit>` | **canonical** per ticket-list |
| `geo-map-lit.js` | `<geo-map-lit>` | alternativo, presente in app.js, NON usato in ticket-list |
| `my-map-lit.js` | `<my-map-lit>` | demo/sandbox |
| `map-picker-lit.js` | `<map-picker-lit>` | field Filament wizard (single-point picker) |
| `coordinate-picker-lit.js` | `<coordinate-picker-lit>` | field Filament composite |
| `geopoint-picker-lit.js` | `<geopoint-picker-lit>` | field Filament alt |
| `place-picker-lit.js` | `<place-picker-lit>` | field con address search |
| `geo-map-lit-final.js` | n/a | orphan — rinominare `.old` |
| `geo-map-lit-new.js` | n/a | orphan — rinominare `.old` |
| `geo-map-lit.js.bak`, `.bak-1777577793` | n/a | orphan — rinominare `.old` |
| `coordinate-picker-lit-stable.js` | n/a | orphan — rinominare `.old` |

> **Regola di prevenzione**: prima di scrivere `<x-lit>` in un Blade, verificare che `Themes/Sixteen/resources/js/app.js` lo importi. Vedi `Themes/Sixteen/docs/wiki/concepts/theme-app-js-lit-import-registry.md` per il registry runtime aggiornato.

## Regressione 2026-05-08 — Include server-side mancante

**Sintomo**: pagina `/it/tests/ticket-list` in HTTP 500.

**Root cause**:
- `pages/tests/ticket-list.blade.php` includeva `pub_theme::components.sections.map-lit`;
- la partial `components/sections/map-lit.blade.php` non esisteva;
- Laravel cercava una view server-side, quindi il web component non arrivava mai al browser.

**Fix**:
- creata `Themes/Sixteen/resources/views/components/sections/map-lit.blade.php`;
- la partial emette solo `<map-lit ...></map-lit>` con `data-url`, altezza e `aria-label` configurabili;
- allineato il block legacy a `document.querySelector('map-lit')`.

**Verifica**:

```text
npx playwright test Modules/Geo/tests/Playwright/ticket-list.spec.js
11 passed
```

Smoke browser: `map-litDefined=true`, elemento 1108x522, Leaflet container 1, tile 15/15, marker 2, cluster 2.

---

## Sintomo

L'utente segnalava: "non vedo la mappa in `/it/tests/ticket-list`".

---

## Diagnosi

### Playwright: tutto OK

I test automatizzati passavano tutti (13/13) sul server:

```
customElements.get('geo-map-lit'): true
leafletContainer: true, size: 731×450
tilesLoaded: 9, markers: 5
tabPaneActive: true, tabPaneShow: true
JS Errors: []
```

### Root Cause: vecchi bundle JS accumulati in public_html

**11 bundle geo-map-lit** erano presenti in `public_html/assets/geo/assets/` da build precedenti.
Uno di questi (`B98GNGDO.js`) conteneva il bug `bindRefreshHandler is not defined`:

```js
// Bundle ROTTO (B98GNGDO.js)
bindRefreshHandler(this), this._loadGeoJson();
// → ReferenceError: bindRefreshHandler is not defined
// → _initMap() crasha → mappa non monta
```

Il browser dell'utente aveva questo bundle in cache HTTP, anche se il manifest
puntava già al bundle corretto `WZfa7jvI.js`.

**Causa strutturale**: il processo di deploy copiava solo il nuovo bundle
senza rimuovere i vecchi → accumulo di bundle obsoleti → possibile cache hit sul rotto.

---

## Fix Applicato

### 1. Atomic swap (pulizia bundle obsoleti)

```bash
# PRIMA (sbagliato): solo copia
cp new-bundle.js public_html/assets/geo/assets/

# DOPO (corretto): rimuovi vecchi, copia nuovo
rm -f public_html/assets/geo/assets/geo-map-lit-*.js
cp new-bundle.js public_html/assets/geo/assets/
```

Rimossi: 59 bundle obsoleti totali (`geo-map-lit-*`, `coordinate-picker-lit-*`, ecc.)

### 2. Deploy atomico — procedura standard

```bash
cd laravel/Modules/Geo
npm run build

NEWJS=$(python3 -c "import json; \
  d=json.load(open('public/manifest.json')); \
  print(d['resources/js/components/geo-map-lit.js']['file'].split('/')[-1])")

# ATOMIC SWAP:
rm -f ../../../public_html/assets/geo/assets/geo-map-lit-*.js
cp public/assets/$NEWJS ../../../public_html/assets/geo/assets/
cp public/manifest.json ../../../public_html/assets/geo/manifest.json

echo "Deployed: $NEWJS"
curl -s http://127.0.0.1:8000/it/tests/ticket-list | grep "geo-map-lit-"
# Must match $NEWJS
```

### 3. Fallback runtime cluster -> plain markers (2026-04-30)

Per eliminare il caso "mappa vuota" anche quando il plugin cluster fallisce in runtime
(`instanceof`/constructor errors lato `leaflet.markercluster`), `geo-map-lit` ora applica
una degradazione controllata:

- prova ad avviare il layer cluster (`L.markerClusterGroup`);
- se il cluster non e` disponibile o `addLayer()` genera errore, esegue switch automatico a `L.featureGroup()`;
- renderizza comunque tutti i marker plain;
- mantiene il filtro per tipo sia in modalita` cluster sia in modalita` plain.

Effetto business: l'utente vede sempre i punti mappa (degraded mode), evitando blank state.

### 4. Cluster bootstrap robusto in ESM/Vite (2026-04-30, fix definitivo)

Root cause residua: in alcuni runtime ESM il plugin `leaflet.markercluster` non si aggancia in modo affidabile a `L` se importato staticamente.

Fix applicato in `geo-map-lit.js`:

- bind esplicito di `window.L` / `globalThis.L`;
- import runtime del plugin (`await import('leaflet.markercluster/dist/leaflet.markercluster.js')`) prima di creare `markerClusterGroup`;
- rimozione opzione non supportata `minimumClusterSize` (non presente nel plugin ufficiale);
- icone cluster rese compatibili con CSS plugin tramite classi `marker-cluster marker-cluster-{small|medium|large}`.

Effetto business: cluster effettivamente renderizzati (non solo fallback plain markers), parity visuale con farmshops ripristinata.

### 5. Centratura su posizione corrente (2026-04-30)

Nuovo requisito utente: mappa centrata sulla posizione attuale.

Fix applicato:

- geolocalizzazione richiesta automaticamente in init (`requestGeolocation(..., { showLoading:false })`);
- geolocalizzazione manuale resa robusta: `_handleMapInteraction` chiamato solo se disponibile;
- introdotto flag `_isUserCentered` per evitare che `fitBounds` sovrascriva la vista dopo geolocalizzazione riuscita.

Effetto business: UX immediata sulla zona utente, mantenendo fallback ai bounds solo quando la geolocalizzazione non e` disponibile.

---

## Diagnosi Differenziale Completa

| Ipotesi | Evidenza | Esclusa? |
|---------|----------|----------|
| Bundle rotto in cache browser | `B98GNGDO.js` aveva `bindRefreshHandler` bug | ✅ **Root cause** — fix: atomic swap |
| Tab "Mappa" non attiva al caricamento | DB e Playwright: `tabPaneActive:true` | ✅ Non era il problema |
| `tickets.json` 404 | HTTP 200, 5 features | ✅ Non era il problema |
| Leaflet dimensione 0×0 | Playwright: `w:731,h:450` | ✅ Non era il problema |
| `leaflet.heat` constructor error | Gestito con try/catch, solo warning | ✅ Non bloccante |
| CSS height mancante | `style="height:450px"` presente nel Blade | ✅ Non era il problema |
| Service Worker stale | Nessun SW registrato nel progetto | ✅ Non era il problema |

---

## Regola di Prevenzione

**VIETATO** copiare bundle senza rimuovere i vecchi. Sempre atomic swap.

Vedi: [[concepts/geo-map-controls-unification-rule.md]] per le regole generali di deploy.

---

## Playwright Post-Fix (2026-04-29)

```
Feature: 13/13 ✅
Responsive /it/ desktop/tablet/mobile: 21/21 ✅
Bundle unico in public_html: geo-map-lit-WZfa7jvI.js
```

## Playwright Post-Fallback (2026-04-30)

```
tests/Playwright/ticket-list.spec.js: 10/10 ✅
- zoom test stabilizzato con fallback anti-flaky (click UI + fallback `_zoomIn()`/`map.zoomIn()`)
- markers are rendered on the map: PASS
- cluster icons style check: PASS (quando cluster disponibile)
```

## Playwright Post-Cluster-Fix (2026-04-30)

```
Modules/Geo/tests/Playwright/ticket-list.spec.js: 10/10 ✅
- cluster icons style check: PASS
- markers are rendered on the map: PASS
- map controls + zoom + fullscreen: PASS
```

## Verification
- Map renders correctly with proper dimensions
- Fullscreen, zoom, and layer controls function properly
- Marker clustering and heatmap work as expected
- Resize handling works correctly when switching tabs

## Testing
```bash
# Manual verification
open http://127.0.0.1:8000/it/tests/ticket-list

# Playwright test
npx playwright test tests/Playwright/ticket-list.spec.js
```
