---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
status: draft
---

## [2026-10-26] git + second-brain | collisioni frontoffice risolte con soluzione 3 (non current/incoming)

- Studio entrambi i lati (current `0ffbcc9a` pulito ma con difetto `uses()` mancante; incoming `41c00823` con marker ma senza variabili `$schema`/`$rows`).
- **Decisione 3 applicata:** rimuovere marker prendendo il primo lato per le variabili; aggiungere `uses(Tests\TestCase::class);` ai 5 test modelli (`Comune`, `Province`, `Region`, `Address`, `Location` BusinessLogic) — il difetto era nascostto dai marker e avrebbe rotto i test anche dopo la pulizia.
- File modificati: `tests/Unit/Models/*BusinessLogicTest.php` (5).
- Documentazione creata: `docs/wiki/collisioni-git-fo-decision.md` (SSoT della decisione).
- Verifica sintassi PHP: passata (`php -l`).
- Prossimo: PHPStan L10 + Pest sui test modificati; aggiornare `docs/wiki/index.md` con riferimento al nuovo doc.

## [2026-10-20] git | marker di conflitto in quattro test, rimessi da un merge

Il merge `41c00823` ha rimesso marker di conflitto (`<<<<<<<`) in `GeocodingBusinessLogicTest`, `ComuneBusinessLogicTest`, `ProvinceBusinessLogicTest`, `RegionBusinessLogicTest`, gia' tolti da `0ffbcc9a` il 2026-09-24: PHPStan non leggeva i file. Risolti in avanti con il primo lato in tutti e sei i blocchi, l'unico che definisce le variabili usate dopo (`$schema`, `$rows`). Trappola: un merge dal remoto puo' rimettere marker gia' tolti; dopo ogni pull lanciare `bash bashscripts/tools/check-conflict-markers.sh`. I test ora partono e mostrano un difetto che i marker nascondevano: i tre test dei modelli non dichiarano `uses(TestCase::class)` e girano senza applicazione (`Container::storagePath()` non esiste). Story: [conflict-markers-business-logic-tests](../stories/conflict-markers-business-logic-tests.story.md).

## [2026-10-14] docs | studio degli ingressi di Geo confrontati con il codice

`README.md` descriveva classi e metodi inesistenti (`app/Services/GeocodingService.php`, `provider()`, `storeCoordinates()`, `GetCoordinatesAction::execute([...])` statico, config in `laravel/config/local/geo/`): corretto con le firme vere. Fatti durevoli, tutti verificati: `routes/` e `resources/views/pages` assenti (nessuna rotta del modulo), pannello Filament su `/geo/admin`, `config/config.php` si carica sotto `geo.config`, quindi `config('geo.driver')`, `geo.api_keys`, `geo.cache`, `geo.rate_limits`, `geo.http_client` letti in `GetAddressDataFromFullAddressAction`, `GoogleMapsAction` e `GoogleMaps/GoogleMapsHttpAction` valgono `null` (solo `geo.config.map.default_view` e' letta giusta); `tests/TestCase.php` forza `xra.pub_theme = Meetup` e `Themes/Meetup` non ha `resources/views/pages`, per cui i test PHP di Geo non partono; PHPStan 0 errori; `node --test tests/js/default-view.test.mjs` 3 passati. `index.md`, `wiki/ProjectHome.md`, `wiki/projecthome.md`, `wiki/reflective.md`, `wiki/method-name-homonym-census.md` sono contenuti di altri progetti o moduli, segnati `stale`. Conflitto aperto: contratto (`00-INDEX.md` canonico) contro decisione del 2026-10-14 (`INDEX.md` ingresso unico). Story: [studio-docs-geo-ingressi-verificati](../stories/studio-docs-geo-ingressi-verificati.story.md). Memoria: `bashscripts/ai/wiki/memories/docs-fixcity-geo-studio.md`.

## [2026-06-30] ponytail-audit | Phase 3 Finding 2 — BaseGeoService inlined into GoogleMapsService

- **BaseGeoService eliminated** ✅
  - Abstract class (143 lines) + single implementation (GoogleMapsService)
  - Methods inlined into GoogleMapsService as private: getApiKey, makeRequest, buildHttpClient, getCacheKey, getServiceName
  - File marked `.bak` (not deleted, per Ponytail methodology)
  - PHPStan Level 10: ✅ PASS (0 errors)
  - Pest: Tests failed due to DB infrastructure (not code-related)
  - Net: -143 lines, -1 file dependency

- Linked GitHub Issue: #237 — Ponytail Audit Phase 3 Architectural Review

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), llm-wiki.txt _(target mancante, verificato 2026-10-14: `bashscripts/tools/prompts/llm-wiki.txt` non esiste)_
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
module: "Geo"
---

# Geo - Wiki Activity Log

## [2026-06-03] bmad | STORY-132 — filename JS solo inglese

- [js-file-english-naming-rule.md](rules/js-file-english-naming-rule.md) · [js-file-english-naming-standing-rule.md](memories/js-file-english-naming-standing-rule.md)
- Rename pianificato: `popup-segnalazione.js` → `popup-ticket.js` ([STORY-132](../../../../../docs/stories/STORY-132-rename-popup-ticket-js-english.md), file rinominato rispetto al link originale `...popup-segnalazione-js-english.md`)

## [2026-06-03] docs | map-lit ricostruzione + registro correzioni

- [geo-map-lit-reconstruction-guide.md](concepts/geo-map-lit-reconstruction-guide.md) — SSoT `marker-config.js` (`__shell`, `__inner`, `__point`, 40×44).
- [geo-map-fixes-registry.md](concepts/geo-map-fixes-registry.md) — INC-1…8, mermaid rebuild, deprecazioni.
- Hub root: [map-lit-reconstruction-hub.md](../../../../../docs/wiki/memories/map-lit-reconstruction-hub.md).
- Aggiornati: marker/popup runbook, tema leak header, indici Geo/Sixteen, ingest root.

## [2026-05-15] Toolbar: registry in `render-controls.js`

- `OVERLAY_PARTS` elenca solo `(ctx) => …` importate dai moduli; zoom raggruppato con `renderZoomGroup` in `zoom-in-out.js`.
- Regola descritta in [concepts/geo-map-controls-unification-rule.md](concepts/geo-map-controls-unification-rule.md).

## [2026-05-15] Ricerca indirizzo in `map/controls/search.js`

- Implementazione unica: logica Nominatim + `renderSearch`, `renderToggleButton`, `searchUiHandlers`.
- `map/search.js` resta shim di compatibilità; `renderSearchPanel` è alias deprecato di `renderSearch` (secondo argomento: `searchUiHandlers`).
- `toggleSearch` mette a fuoco l’input all’apertura; `showSearch === false` disabilita, valore assente = mappa pubblica con ricerca attiva.
- Wiki regola: [concepts/map-js-module-naming-rule.md](concepts/map-js-module-naming-rule.md).

## [2026-05-15] map/styles.js

- `resources/js/components/map/styles.js` è il modulo canonico per `mapStyles` e `mapStylesText`.
- `coordinate-picker-lit.js` importa `mapStylesText` da `./map/styles.js`, non `mapStylesText` da root.
- `map/styles.js` resta solo re-export deprecato per compatibilità con componenti legacy.
- Mirror Sixteen: `resources/js/components/modules/Geo/map/styles.js` re-export verso il modulo Geo.

## [2026-05-15] map/controls split

- `map/controls.js` è barrel; implementazione in `map/controls/{render-controls,fullscreen,zoom-in-out,geolocation,switch-layer}.js`.
- `map/resize-after-action.js` condiviso per invalidate dopo zoom/fullscreen/layer.

## [2026-05-15] map/heroicons.js

- Spostata implementazione icone da `geo-heroicons.js` a `map/heroicons.js`; root `geo-heroicons.js` è solo re-export deprecato.
- Mirror Sixteen: `map/heroicons.js` re-export da `@modules/Geo/...`.

## [2026-05-15] Map JS modules in `components/map/`

- Spostata logica condivisa in `resources/js/components/map/`: `controls.js`, `events.js`, `search.js`, `resize.js`, `utils.js`, `layers.js`.
- Import Lit: `./map/controls.js` (non più `map-picker-controls` in root).
- Regola aggiornata: [concepts/map-js-module-naming-rule.md](concepts/map-js-module-naming-rule.md).
- Mirror Sixteen: `resources/js/components/modules/Geo/map/`.

## [2026-05-13] Full Geocoding Payload contract

- Aggiunto `concepts/full-geocoding-payload.md` con il contratto del payload
  `location` (search + reverse-geocode salvano `raw`, `address_details`,
  `place_id`, `boundingbox`).
- `map-picker-search.js → buildLocationPayload()` flatten + raw.
- `coordinate-picker-lit.js _handleSearchSelection` accetta payload completo.
- `coordinate-picker.blade.php` spread payload e reverseGeocode senza
  perdere `raw`.
- `HasCoordinatePicker::reverseGeocode()` ora ritorna `address`,
  `provider`, `place_id`, `osm_*`, `licence`, `importance`, `type`,
  `class`, `boundingbox`, `address_details`, `raw`.
- `map-controls.js` (`requestGeolocation`) usa lo zoom configurato del
  picker (min 14) invece di hard-code 12.

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-10-14] DCP-152 marker e pulsanti del picker

- `coordinate-picker-lit` include `markerCardStylesText` e accetta `marker-icon-url`, `marker-color`, `marker-label` (dettaglio ticket: tipo e stato noti).
- Pulsanti `.ctrl-btn` protetti dal reset `button` delle pagine `data-dc` (`.map-container .ctrl-btn.ctrl-btn`).
- Concept: `concepts/picker-marker-and-controls-on-host-pages.md`; story `stories/2026-10-14-dcp-152-...story.md`.
## [2026-10-14] docs | confine dati geografici e mappe

- Aggiunta `concepts/geo-data-and-map-boundary.md`.
- Documentati ordine GeoJSON, ownership geocoding e separazione da Fixcity/Sixteen.

## 2026-10-26: test di modello allineati al TestCase del modulo

- I 5 `*BusinessLogicTest.php` in `tests/Unit/Models` non avevano `uses(...)`; ora `uses(TestCase::class)` con `Modules\Geo\Tests\TestCase` (convenzione di 42 test del modulo).
- Marker di merge: 0 (la prima versione di `collisioni-git-fo-decision.md` ne descriveva e citava un file `Geocoding*` che non esiste: pagina riscritta con le misure).
- Esito identico col `Tests\TestCase` radice; restano 13 test rossi per contratto test/modello non coincidente (Address 4, Comune 6, Location 1, Province 1, Region 1), da decidere uno per uno.