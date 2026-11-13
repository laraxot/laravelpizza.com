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

- Update successivo: fullscreen spostato in `bottomright` come `L.Control` (stackato sotto "centra su di me", no overlap); rimosso il vecchio `<button data-fs-btn>` fixed risurgito da un secondo merge — era dead code (JS non lo wiring). Verificato: 1 solo bottone, fullscreen nativo ok, 0 errori.
- Errore produzione `resources/views/vendor/filament/components/icon-button.blade.php` mancante su `/techplanner/admin/clients`: file esiste in locale → causa probabile view cache stale o publish parziale su prod; fix lato server `php artisan view:clear && php artisan optimize:clear`.

- `GeoTrait::scopeWithDistance`: aggiunto `orderByRaw('distance IS NULL')` prima di `orderBy('distance')` — MySQL ordina gli NULL prima in ASC, quindi i record senza coordinate dominavano la lista "ordinata per distanza" e la colonna `distance` appariva vuota. Verificato: `withDistance` ora ritorna distance numeriche ascendenti; test `GeoTraitWithDistanceSqlTest` esteso con assert `distance IS NULL`.

## [2026-11-09] base-map-widget | fullscreen come L.Control nativo + fix asset git-ignored

- `base-map.blade.php`: fullscreen spostato da `<button>` absolute custom (sovrapposto ai pulsanti zoom, icona bruttta) a `L.Control` in `.leaflet-bar` — Leaflet lo impila nella corner senza overlap; icona SVG commuta expand/contract, label `fullscreen`/`fullscreen_exit` con `aria-pressed`.
- `getMapStrings()` (Base + ClientMapWidget): aggiunta chiave `fullscreen_exit` in geo::widgets.base_map e techplanner::client_map_widget (it/en/de/es).
- **Bug deploy**: `public/` in `.gitignore` escludeva `Modules/Geo/public/assets/{leaflet.markercluster.js,images/layers*.png}` → mai deployati → 404 in produzione. Fix: `git add -f` dei 3 file. Verificato `git ls-files --others --ignored` sugli altri moduli: nessun altro caso.
- Asset contract confermato: `public_html/assets/geo` → symlink `Modules/Geo/public` → URL `/assets/geo/assets/*`; `asset('modules/geo/assets')` NON esiste (public_html/modules è legacy).
- Verifica headless Chrome: fs-btn in `.leaflet-bar` topright, nessun overlap con zoom, `fullscreenElement=base-map-stage`, toggle icona/label ok, 0 errori console.

## [2026-11-19] test-infra + sushi data | fix bootstrap suite e bug production-ready

- `tests/TestCase.php`: `$connectionsToTransact` reimpostata a `['sqlite','geo']` — le voci `fixcity`/`mariadb`/`user` non esistono o puntano a mysql senza credenziali in `.env.testing` e facevano fallire OGNI test del modulo in `setUp`.
- `tests/Pest.php`: aggiunto helper `geo_mockery_expect()` (stessa tecnica di `mockeryExpect()` di Activity/User) per tipizzare le expectation Mockery 1.6 CompositeExpectation.
- `tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php`: nuovo test di regressione (3 casi: indirizzo vuoto, errori provider propagati, successo) — verificato il fix `$this->errors->merge()`.
- `Modules/Tenant/app/Models/Traits/SushiToJson.php`: `getSchema()` override tipizzato `@return array<string,string>` — il vendor Sushi non dichiara il tipo e PHPStan vedeva `mixed` (4 errori in `ComuneBusinessLogicTest`).
- `resources/json/comuni.json`: riga Bresso (id 4) normalizzata allo schema completo delle altre righe — le chiavi mancanti rompevano l'INSERT Sushi multi-riga (`all VALUES must have the same number of terms`) in OGNI query `Comune`, anche in produzione.
- Test modelli (`Comune`/`Location`/`Province`/`Region` BusinessLogic): assertion `HasFactory` → `HasXotFactory` (trait reale del modello).
- Stato suite `Modules/Geo/tests/Unit`: 552 passati; restano ~90 failure preesistenti non correlate (mock HTTP Bing/Google/Elevation, scritture file Sushi, schema assente in sqlite :memory:).

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
## 2026-11-19 — BaseMapWidget: mappa Leaflet condivisa per widget Filament

- **Nuovo** `app/Filament/Widgets/BaseMapWidget.php` (XotBaseWidget): contratto marker/origin/strings/assetBase + vista `geo::filament.widgets.base-map`.
- **Vista** `resources/views/filament/widgets/base-map.blade.php`: cluster adaptive, layer OSM+satellite Esri, scala, geolocate, permalink `#map=`, fullscreen, azioni Livewire via `data-map-method`/`data-map-arg` → `$wire` registry.
- **i18n**: `geo::map.widget.*` in it/en/de (es/fr/pl via fallback).
- **Asset contract**: `Modules/Geo/public/` canonica, servita da symlink `public_html/assets/geo`; script `copy` in package.json neutralizzato (ridondante col symlink); rimossa `geo.bak-*` stale.
- **Primeira figlia**: `ClientMapWidget` (TechPlanner) estende BaseMapWidget — popup server-side escaped, origine da sessione/cookie.
- **Trappola documentata**: widget custom senza `<x-filament-widgets::widget>` perde columnSpan → metà larghezza.
- Verificato headless Chrome: 1216px full width, cluster/controlli/popup/wire OK, 0 errori. PHPStan 0, Pint ok.
- 2026-11-09 — Log audit: fix GeoTrait::scopeWithDistance + Address::scopeNearby (no star duplicato con colonne preselezionate — syntax error MariaDB). Test: tests/Unit/Models/GeoTraitWithDistanceSqlTest.php. Rimossi dal log errori gia risolti (widget lazy, Livewire root tag, distance SQL, controls table, reminder_sent_at, xot:theme-link).
- 2026-11-09 — Convenzione i18n widget: chiavi spostate da `geo::map.widget.*` a `geo::widgets.base_map.*` (widgets.php it/en/de/es). Stessa migrazione in TechPlanner (`client_map_widget.php`) e User (`user_overview_widget.php`, da `user::user.widgets.overview.*`).
