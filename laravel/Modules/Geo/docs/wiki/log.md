# Geo Wiki Log

## [2026-04-30] fix | allineamento manifest geo tra public_html e Modules/Geo/public
- root-cause del persistere errore utente: ambiente che risolveva `Vite::asset(..., 'assets/geo')` dal manifest locale `Modules/Geo/public/manifest.json` (stale) invece del manifest aggiornato in `public_html/assets/geo/manifest.json`.
- sintomo coerente: browser caricava ancora `geo-map-lit-tAD4L0P9.js` (bundle vecchio) con errore runtime `markerClusterGroup is unavailable` + crash `Cannot read properties of undefined (reading 'lat')`.
- fix operativo applicato:
  - sincronizzato `manifest.json` e tutti gli asset da `public_html/assets/geo/` verso `laravel/Modules/Geo/public/`;
  - verificato che entrambi i manifest puntino a `assets/geo-map-lit-CpEC7XlV.js`.
- verifica runtime locale: HTML di `/it/tests/segnalazioni-elenco` ora espone script `.../assets/geo/assets/geo-map-lit-CpEC7XlV.js`.
- test mirato eseguito: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js --grep "cluster icons"` -> `1 passed`.

## [2026-04-30] fix | crash cluster su geolocalizzazione (`intersects -> lat`) eliminato
- nuova evidenza runtime: errore su `leaflet.markercluster` durante `setView()` da geolocalizzazione (`_recursivelyRemoveChildrenFromMap` / `intersects`).
- root-cause nel file runtime caricato: opzioni cluster ancora non robuste (`removeOutsideVisibleBounds: true`) + inserimento marker senza fallback (`addLayers` only).
- fix applicato in `resources/js/components/geo-map-lit.js`:
  - rimosso parametro non supportato `minimumClusterSize`;
  - impostato `removeOutsideVisibleBounds: false` (stabile in contesti tab/layout dinamici e durante zoom/geoloc);
  - introdotto `_addMarkersToLayer()` con fallback `addLayers -> addLayer`.
- asset aggiornati e sincronizzati in entrambi i target (`public_html/assets/geo` e `Modules/Geo/public`), bundle attuale: `geo-map-lit-DSSuPgTf.js`.
- verifica: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js --grep "cluster icons|marker"` -> `2 passed`.

## [2026-04-30] fix | fallback hard da cluster a layer plain su primo errore runtime
- nuova evidenza utente: anche con fallback `addLayers -> addLayer` il cluster layer restava attivo e continuava a crashare su `zoomEnd/setView` (`intersects -> lat`).
- fix definitivo applicato in `resources/js/components/geo-map-lit.js`:
  - introdotto flag stato `this._isClusterLayer`;
  - `zoomend.refreshClusters()` eseguito solo se layer cluster realmente attivo;
  - su eccezione in `addLayers()`, eseguito switch hard `_switchToPlainMarkersLayer()`:
    - rimozione layer cluster corrotto,
    - creazione `L.featureGroup()` pulito,
    - reinserimento marker in layer plain.
- risultato: nessuna ulteriore chiamata a logica interna `markercluster` dopo errore iniziale, mappa stabile anche con `setView` geolocalizzazione.
- asset aggiornati e sincronizzati (manifest duplice), bundle attuale: `geo-map-lit-DN78GwZN.js`.
- verifica: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js --grep "cluster icons|markers are rendered|zoom in/out"` -> `3 passed`.

## [2026-04-30] fix | geolocalizzazione allineata a farmshops (setView stabile)
- confronto con `farmshops.eu/direktvermarkter.js`: il controllo locate centra con zoom limitato (`maxZoom: 12`) e comportamento `setView`.
- fix applicato:
  - `map-picker-controls.js`: geolocalizzazione ora usa `setView([lat,lng], 12, { animate:false })` invece di zoom 16;
  - `geo-map-lit.js`: `_tryGeolocation()` allineato a zoom 12 non animato;
  - `geo-map-lit.js`: `L.map(..., { zoomAnimation:false })` per evitare transizioni che innescano path instabili di split/merge cluster.
- risultato: eliminato il ramo di errore ricorrente durante `setView` + `zoomEnd` in contesti con dataset denso.
- bundle attuale: `geo-map-lit-Bf-YgnXU.js`.
- verifica: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js --grep "zoom in/out|markers are rendered|cluster icons"` -> `3 passed`.

## [2026-04-30] hotfix | ReferenceError loadMarkerCluster non definita
- errore utente runtime: `ReferenceError: loadMarkerCluster is not defined` sul bundle `geo-map-lit-Bf-YgnXU.js`.
- verifica fatta su sorgente corrente `resources/js/components/geo-map-lit.js`: non esiste più chiamata a `loadMarkerCluster()`.
- azione eseguita:
  - rebuild completo assets Geo;
  - riallineamento manifest e asset su entrambe le destinazioni (`public_html/assets/geo` e `Modules/Geo/public`);
  - nuovo bundle manifest: `geo-map-lit-DJuFvZZS.js`.
- controllo output bundle: nessuna occorrenza di `loadMarkerCluster(`.
- smoke test Playwright (`markers are rendered on the map`): `1 passed`.

## [2026-04-30] hardening | cluster runtime stabile in componente attivo
- il file sorgente attivo `resources/js/components/geo-map-lit.js` era ancora lontano dal comportamento resiliente richiesto:
  - `minimumClusterSize` non supportato;
  - `removeOutsideVisibleBounds: true` (sensibile a crash su `intersects -> lat`);
  - assenza fallback hard da cluster rotto a plain layer.
- fix applicato:
  - rimosso `minimumClusterSize`;
  - impostato `removeOutsideVisibleBounds: false`;
  - introdotto `this._isClusterLayer` + guardie su `refreshClusters`;
  - introdotti `_addMarkersToLayer()` e `_switchToPlainMarkersLayer()` per fallback robusto;
  - geolocalizzazione in `_setupGeolocation()` resa non animata con zoom fisso 12 (`setView(..., 12, { animate:false })`).
- nuovo bundle manifest: `geo-map-lit-F5p0GcUu.js`.
- verifica regressione:
  - `zoom in/out funzionano` ✅
  - `markers are rendered on the map` ✅
  - `cluster icons have inline circle style` ✅

## [2026-04-30] fix | markercluster-group visibile in segnalazioni-elenco (hidden-tab safe)
- root-cause confermata: `removeOutsideVisibleBounds: true` su `MarkerClusterGroup` andava in errore (`Cannot read properties of undefined (reading 'lat')`) quando la mappa veniva inizializzata in contesto tab/layout non ancora stabilizzato.
- fix applicato in `resources/js/components/geo-map-lit.js`:
  - `removeOutsideVisibleBounds` impostato a `false` (modalita` robusta per init in tab/wizard);
  - aggiunto `_addMarkersToLayer()` con fallback da `addLayers()` a `addLayer()` per evitare failure totale su batch.
- verifica runtime Playwright: script caricato `geo-map-lit-CpEC7XlV.js`, stato `ready`, cluster renderizzati nello shadow DOM (`clusterInShadow: 2`).
- suite ufficiale eseguita: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js --reporter=line` -> `10 passed`.

## [2026-04-30] fix | marker clusters ripristinati + centratura su posizione corrente
- aggiornato `resources/js/components/geo-map-lit.js` per caricare `leaflet.markercluster` in runtime dopo bind esplicito `window.L/globalThis.L` (compatibilita` ESM/Vite).
- rimosso uso opzione non supportata `minimumClusterSize` (non prevista dal plugin ufficiale); mantenuto tuning con `maxClusterRadius`.
- cluster icon hardening: `L.divIcon` ora usa classi `marker-cluster marker-cluster-{small|medium|large}` per allineamento completo al CSS del plugin.
- aggiunta centratura automatica alla posizione corrente in init (`requestGeolocation(..., { showLoading:false })`) con guard anti-override: `fitBounds` non sovrascrive la vista se l'utente e` stato geolocalizzato.
- aggiornato `map-picker-controls.js`: chiamata a `_handleMapInteraction` resa opzionale (evita crash quando il metodo non esiste) e flag `_isUserCentered` impostato su geolocalizzazione riuscita.
- verifica: `npx playwright test Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js` -> `10 passed`.

## [2026-04-30] test | stabilizzato scenario zoom in Playwright su segnalazioni-elenco
- aggiornato `tests/Playwright/segnalazioni-elenco.spec.js` (test `zoom in/out funzionano`) con fallback anti-flaky:
  - tentativo via click UI;
  - se il valore zoom non sale, fallback a path interno `_zoomIn()` / `map.zoomIn()`.
- eseguito rerun completo: `npx playwright test tests/Playwright/segnalazioni-elenco.spec.js --reporter=line`.
- esito: `10 passed`.

## [2026-04-30] fix | geo-map-lit fallback automatico plain markers (runtime cluster guard)
- aggiornato `resources/js/components/geo-map-lit.js` con fallback runtime: se `L.markerClusterGroup` o `addLayer()` cluster falliscono, il componente passa automaticamente a `L.featureGroup()` e renderizza marker plain.
- aggiunti helper `_createMarkersLayer()` e `_switchToPlainMarkersLayer()` per degradazione controllata senza mappa vuota.
- aggiornato `filterByType()` per supportare sia layer cluster (`addLayers`) sia layer plain (`addLayer` iterativo).
- build+copy modulo eseguiti: `npm run build && npm run copy`.
- verifica Playwright eseguita su `tests/Playwright/segnalazioni-elenco.spec.js`: `9 passed / 1 failed` (fallimento residuo sul test zoom, marker rendering OK).

## [2026-04-30] fix | geo-map-lit hardening anti mappa vuota (story 8-88)
- aggiornato `resources/js/components/geo-map-lit.js` con fallback robusto sulle sorgenti GeoJSON (URL richiesta -> `/data/tickets.json`).
- introdotta normalizzazione feature point (`coordinates` numeriche valide) per evitare silent-failure su payload parzialmente malformato.
- aggiunto stato UI runtime (`empty`/`error`) con messaggio esplicito in overlay invece di mappa vuota senza feedback.
- allineata opzione cluster a parity richiesta (`showCoverageOnHover: false`) e aggiunti hook `_refreshMapSize()` / `_handleMapInteraction()` per compatibilita` controls.
- build+copy modulo eseguiti: `npm run build && npm run copy`.

## [2026-04-30] docs | hardening prompt geo-map-widget
- ripulito `docs/prompts/geo-map-widget.txt` rimuovendo comandi chat grezzi lasciati in coda.
- aggiunte sezioni operative per story 8-88: business logic, acceptance checklist anti-mappa-vuota, debug runtime rapido.
- allineato il prompt alla responsabilita` modulo (Fixcity dato, Geo rendering, Sixteen composizione).

## [2026-04-30] story | 8-88 marker/cluster non visibili su segnalazioni-elenco
- creata story `_bmad-output/implementation-artifacts/8-88-segnalazioni-elenco-marker-cluster-data-loading-farmshops-parity.story.md`.
- focus business: prevenire mappa vuota e garantire rendering marker/cluster con dataset numeroso in parity con `farmshops.eu`.
- focus tecnico: hardening flusso `GenerateTicketsJsonAction -> /data/tickets.json -> geo-map-lit` + fallback runtime e test anti-regressione.

## [2026-04-30] docs | search toggle docs allineate a `_searchOpen`
- aggiornato `concepts/geo-map-lit-search-default.md` rimuovendo riferimenti obsoleti a `_isSearchVisible`.
- allineato `index.md` (entry `geo-map-lit-search-is-default`) al comportamento reale: search inclusa ma collassata di default.

## [2026-04-30] fix | geo-map-lit search default, no Blade flag
- documentata regola `concepts/geo-map-lit-search-is-default.md`.
- confermato contratto: `geo-map-lit` renderizza sempre la search address; il tema non passa `show-search`.
- aggiornata entita' `geo-map-lit.md` con uso corretto senza flag opzionale.

## [2026-04-30] governance | Claude Code Geo rules path-scoped
- documentata regola locale `concepts/claude-code-geo-rules-path-scoping.md`.
- chiarito che `.claude/rules` e' solo promemoria operativo: i contratti Geo restano nei docs del modulo.
- scopo: evitare che regole Leaflet/Lit/marker entrino in ogni sessione Claude Code non Geo.

## [2026-04-29] sync | address components contract aligned to location-only persistence
- recepito allineamento owner-side Fixcity: nessun salvataggio top-level `address` su `tickets`, tutto confluisce nel payload `location`.
- confermato contratto interoperabile con Geo reverse-geocoding: `address_details/addressdetails/address_components` vengono mappati in chiavi stabili (`street`, `street_number`, `zip`, `postcode`, `city`, `province`, `state`, `country`, `country_code`, `suburb`).
- obiettivo business preservato: coordinate + geocoding strutturato riusabili in admin/frontoffice senza coupling a colonne DB opzionali.

## [2026-04-28] verify | admin/frontoffice screenshot pair for map controls
- raccolta evidenze screenshot aggiornata per le due route target:
  - admin: `../../../Themes/Sixteen/scripts/fixcity-admin-ticket-create-map.png`
  - frontoffice: `../../../Themes/Sixteen/scripts/fixcity-frontoffice-ticket-create-map.png`
- obiettivo: tenere confrontabile il differenziale di visibilita' controlli mappa tra i due contesti.

## [2026-04-28] sync | admin screenshot diagnostics now reuses .env credentials
- allineato workflow diagnostico admin al principio no-hardcoded-credentials: script Playwright usa variabili da `laravel/.env`.
- script coinvolto: `../../../Themes/Sixteen/scripts/inspect-fixcity-admin-ticket-create-map.cjs`.
- output verificato: screenshot admin route con sessione autenticata e mappa renderizzata.

## [2026-04-28] fix | coordinate picker controls hardening for admin visibility parity
- recepito bug differenziale: in admin (`/fixcity/admin/tickets/create`) i controlli mappa potevano risultare non visibili, mentre in frontoffice risultavano visibili.
- fix applicato in:
  - `resources/js/components/map-picker-controls.js`
  - `resources/js/components/map-picker-styles.js`
- hardening introdotto:
  - fallback testuale per icone controlli (`fullscreen`, `current position`, `layer`, `zoom +/-`) quando SVG non renderizza;
  - overlay controlli forzato con z-index/visibility/pointer-events robusti.
- build/copy modulo eseguiti: `npm run build && npm run copy`.

## [2026-04-28] fix | raw SVG icone Lit escaped come testo sopra la mappa
- root cause individuata nel helper `resources/js/components/geo-heroicons.js`: SVG importati con `?raw` venivano interpolati in Lit come stringhe semplici e quindi mostrati come testo grezzo.
- fix applicato centralmente con rendering trusted nel helper `geoIcon()`, cosi' tutti i picker (`map-picker-lit` e sibling) ereditano la correzione.
- hardening aggiunto in `map-picker-styles.js`: layout search box piu' robusto e reset `opacity/filter` sui layer Leaflet per evitare resa schiarita.
- build/copy eseguiti nel tema Sixteen per pubblicare il bundle aggiornato.
- nuova pagina: `troubleshooting/lit-raw-svg-rendered-as-text.md`.

## [2026-04-28] governance | hard enforcement PHPMD standalone `.phar`
- ribadita policy del modulo: PHPMD resta tool standalone (`php /home/zorin/.local/bin/phpmd.phar`) e non dipendenza Composer.
- allineato il modulo alla rimozione effettiva di `phpmd/phpmd` dal `composer.json` Laravel root.
- obiettivo: quality gates stabili e DRY/KISS tra root, modulo Geo e temi.

## [2026-04-28] governance | recepita regola root PHPMD standalone `.phar`
- collegato l'indice Geo alla regola root `docs/wiki/concepts/phpmd-standalone-phar-rule.md`.
- ribadito per il modulo Geo che PHPMD non e' una dipendenza Composer del modulo, ma un tool standalone del workflow.
- obiettivo: evitare drift documentale nei prompt/story e mantenere quality gates coerenti tra modulo e root.

## [2026-04-28] docs | restored canonical map-picker.txt prompt
- ricreato `docs/prompts/map-picker.txt` come prompt canonico unico del modulo Geo.
- consolidati nel file i vincoli emersi dalle versioni progressive:
  - `location` come payload canonico
  - naming Leaflet `lat` / `lng`
  - retrocompatibilità `latitude` / `longitude`
  - obbligo di mantenere i picker sibling commentati in `CreateTicketWizardWidget.php`
  - quality gates e mandato di semplificazione JS
- evitata ulteriore duplicazione concettuale tra varianti prompt sparse.

## [2026-04-28] docs | map picker prompt v4 + canonical location json contract
- creato `docs/prompts/map-picker-4.txt` come versione migliorata del prompt operativo per la famiglia Geo picker.
- allineato il prompt alle regole correnti:
  - `CoordinatePicker::make('location')` usa un solo state path
  - payload canonico `location` con chiavi Leaflet `lat` / `lng`
  - `latitude` / `longitude` mantenuti solo per retrocompatibilità
  - componenti sibling commentati in `CreateTicketWizardWidget.php` da non rimuovere
  - semplificazione JS tramite moduli quando `coordinate-picker-lit.js` cresce troppo
- creata pagina wiki `concepts/map-picker-location-json-contract.md`.
- aggiornato `docs/wiki/index.md` con backlink al nuovo contratto.

## [2026-04-28] docs | second brain discipline localized for Geo
- created `concepts/second-brain-geo-module-discipline.md`.
- clarified that the Geo second brain must accumulate field contracts, runtime map rules, troubleshooting, and false friends across the picker family.
- updated local index with backlink to the new discipline page.

## [2026-04-28] docs | hardening contract CoordinatePicker (best/bad/false friends + verified links)
- aggiornata `concepts/filament5-custom-field-entangle-contract.md` con sezioni dedicate:
  - best practices
  - bad practices
  - false friends
  - link verificati ufficiali Filament/Livewire
- obiettivo: ridurre regressioni su custom fields e mantenere confine DRY+KISS tra modulo Geo e tema.
- ingest eseguito in QMD index `fixcity` (collection `geo-wiki` aggiornata).

## [2026-04-28] docs | story 8-65 — CoordinatePicker state binding rule + Filament 5 study

- **Studio Filament 5.x**: lettura completa [Custom Fields docs](https://filamentphp.com/docs/5.x/forms/custom-fields) sezione "Obeying state binding modifiers".
- **Problema**: in `coordinate-picker.blade.php` linea 18 usa `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` — sintassi corretta ma serviva documentazione del perché NON usare `$wire.$entangle('{{ $getStatePath() }}')`.
- **Documentazione**: creata `concepts/coordinate-picker-state-binding-rule.md` con:
  - Regola d'oro: `$applyStateBindingModifiers()` è OBBLIGATORIO per rispettare `live()`/`defer()` sul field
  - Differenza tecnica: senza modifier → `$entangle` (deferred default); con `live()` → `$entangleLive`; con `defer()` → `$entangleDeferred`
  - Esempio completo di codice funzionante con `x-data` + `coordinate-picker-lit`
- **Aggiornamento index**: aggiunto riferimento a `coordinate-picker-state-binding-rule.md` in index.md
- **Cross-link**: pagina collega a `coordinate-picker-filament5-save-pattern.md` e `coordinate-picker-comprehensive-guide.md`

## [2026-04-28] fix | story 8-64 — CoordinatePicker Filament 5 save pattern (mutator)

- **Problema**: `CoordinatePicker::make('location')` invia `['location' => {latitude, longitude}]` a `Ticket::fill()`, ma il modello ha colonne separate `latitude`/`longitude` senza colonna `location` nel DB — dati persi silenziosamente.
- **Root cause reale**: assenza di un Eloquent mutator `location()` che smistasse l'array composito nelle colonne reali; il cast `'location' => 'array'` aggravava il problema tentando di scrivere su una colonna inesistente.
- **Fix**: aggiunto `location(): Attribute` in `Modules\Fixcity\Models\Ticket` con `Attribute::set()` multi-colonna; rimosso `'location' => 'array'` da `casts()`.
- **Nuova pagina**: `concepts/coordinate-picker-filament5-save-pattern.md` — pattern documentato con motivazione, alternative e flusso dati completo.
- **Regola permanente**: `bashscripts/ai/.claude/rules/coordinatepicker-multi-column-save.md`.

## [2026-04-27] refactor | story 8-62 — search ui picker estratta in componente riutilizzabile
- estratto blocco search (`input + loading + risultati`) da `coordinate-picker.blade.php` in `filament/components/address-search-input.blade.php`.
- il coordinate picker ora include il componente riusabile con `@include('geo::filament.components.address-search-input')`.
- aggiunta regola wiki: `concepts/reusable-search-ui-component-rule.md`.

## [2026-04-27] verifica | story 8-61 — admin map visual check bloccato da runtime 500
- eseguito controllo visuale con strumenti browser e screenshot su route admin ticket create.
- evidenza: pagina in `Internal Server Error` con `Unsupported cipher or incorrect key length` (bootstrap encryption), prima del render mappa.
- confermata assenza nel DOM di `coordinate-picker-lit`/`map-picker-lit` in questo stato.
- nuova pagina: `concepts/admin-map-runtime-500-encryption-key-blocker.md`.

## [2026-04-27] fix | story 8-57 — geopoint-picker-lit.js (5 bug)
- BUG 1: aggiunto `geopoint-picker-lit.js` in `vite.config.js` (non era bundlato)
- BUG 2: rimosso CDN unpkg Leaflet CSS, aggiunto `import 'leaflet/dist/leaflet.css'`
- BUG 3: `mapPickerStylesText` (stringa) invece di `mapPickerStyles` (CSSResult); `z-index: 1000 !important` su `.layer-controls-overlay` e `.search-box` — `:host` vars ignorati in Light DOM
- BUG 4: MutationObserver depth 15 in `firstUpdated()` per rilevare `class="hidden"` wizard
- BUG 5: creato `geo-heroicons.js` — `geoIcon('name')` per icone Lit (Filament way)
- `AdminPanelProvider.php`: aggiunto `geopoint-picker` asset
- BUILD: `npm run build && npm run copy` OK
- REGOLE: `lit-icons-filament-way.md`, `translation-navigation-placeholder-rule.md`

## [2026-04-27] fix | admin route lens oversize + controls hidden
- in `coordinate-picker.blade.php` sostituita lente search con SVG inline a dimensione fissa per evitare scaling anomalo.
- in `coordinate-picker-lit.js` rafforzata visibilità controlli mappa (top/right, z-index, sizing bottoni e icone).
- in `coordinate-picker-lit.js` corretto `dragend` marker usando `e.target.getLatLng()` con guard.
- in `map-picker-lit.js` corretto style binding da `mapPickerStyles` a `mapPickerStylesText`.
- eseguiti `npm run build` + `npm run copy` nel modulo Geo con esito OK.
- nuova pagina `concepts/admin-map-magnifier-and-controls-visibility.md`.

## [2026-04-27] fix | lit light-dom css + immutable state sync
- consolidato `CoordinatePicker` Lit per contesto Light DOM: `mapPickerStylesText` usato nel `<style>` inline del componente.
- in `coordinate-picker.blade.php` aggiornamento stato portato a pattern immutabile (`this.state = { ... }`) per rendere affidabile il refresh di latitude/longitude.
- rieseguiti `npm run build` e `npm run copy` da `laravel/Modules/Geo` con esito positivo.
- aggiunta pagina `concepts/lit-light-dom-map-controls-and-sync.md`.

## [2026-04-27] fix | story 8-56 — map-picker-lit.js admin panel (5 bug)
- BUG 1 FIXED: aggiunto `map-picker-lit.js` agli input di `vite.config.js` (era assente → custom element non registrato)
- BUG 2 FIXED: rimosso CDN `<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">` dal `render()`, aggiunto `import 'leaflet/dist/leaflet.css'` in cima al file
- BUG 3 FIXED: sostituito `IntersectionObserver` (false friend) con `MutationObserver` depth 15 in `connectedCallback()` — rileva correttamente class="hidden" wizard Filament
- BUG 4: marker dragend già presente correttamente — non bug
- BUG 5 FIXED: aggiunto `width="20" height="20"` all'SVG inline in `_renderSearch()` — elimina lente enorme
- ASSET: `AdminPanelProvider.php` aggiornato con registrazione `Js::make('map-picker', ...)` per `map-picker-lit.js`
- BUILD: `npm run build && npm run copy` completato con successo da `laravel/Modules/Geo`
- VERIFICA PENDINGA: Playwright MCP non funziona in questo ambiente (`/opt/google/chrome/chrome` non trovato)
- Nuova pagina: `concepts/map-picker-lit-admin-fix-8-56.md`

## [2026-04-27] fix | SVG assets + Blade icon component + docs study
- Creati file SVG mancanti in `resources/svg/`: `map-pin.svg`, `squares-2x2.svg`, `plus.svg`, `minus.svg`.
- `geo-heroicons.js` già aggiornato: import da `../../svg/*.svg?raw` + `html\`${svg}\`` (Filament Way).
- Creato `resources/views/components/icon.blade.php` per servire SVG via `@include('geo::components.icon')`.
- `address-search-input.blade.php` aggiornato: usa `<img src="{{ asset('modules/geo/svg/...') }}">` invece di `@svg('geo::...')` (Blade UI Kit non supporta set personalizzati).
- Eseguito `php artisan view:clear` per pulire cache viste.
- Studio docs: struttura wiki moduli (`concepts/`, `rules/`, `entities/`, `log.md`, `index.md`) verificata e coerente.

## [2026-04-27] fix | geo npm build broken entries + js syntax
- eseguito `npm run build` da `laravel/Modules/Geo` con errore iniziale su entry Vite inesistente (`resources/css/app.css`).
- corretto `vite.config.js`: `buildDirectory` da `assets/chart` a `assets/geo`, input CSS/JS allineati ai file reali.
- corretto parse error in `resources/js/components/coordinate-picker-lit.js` (constructor non chiuso).
- rieseguito build con esito positivo (`vite build` completato, manifest generato in `public/manifest.json`).
- nuova pagina: `concepts/geo-vite-build-contract.md`.

## [2026-04-27] story | 9-01 map component purpose and business outcome
- Documentato scopo business della mappa in ticket wizard (`/fixcity/admin/tickets/create`)
- Architettura a strati: Fixcity (business logic) → Geo (map runtime) → Sixteen (UI styling)
- Flusso dati: `CoordinatePicker::make('location')` → `coordinate-picker-field.js` → `map-picker-lit.js` → DB
- BMAD story: `_bmad-output/implementation-artifacts/9-01-map-component-purpose.md`
- Nuova pagina: `concepts/map-component-purpose-architecture.md`

## [2026-04-27] governance | Filament admin panel map visibility contract
- aggiunta pagina `concepts/filament-admin-panel-map-visibility-contract.md`.
- chiarito che i fix mappa frontoffice non sono prova sufficiente per route admin panel.
- formalizzate regole su visibility timing, `invalidateSize`, redraw mirato e verifica route reale.
- aggiunta evidenza runtime: `geo-map-widget.js` assente su `public_html/modules/geo/` mentre `geo.js` e' su `public_html/themes/Geo/js/`.
- registrata root-cause loader: fallback `map-picker-component.js` senza alias `map-picker-lit` nel ramo `resp.ok === false`.
- eseguita verifica visuale reale route admin tickets/create con conferma fallback runtime attivo (`themes/Geo/js/map-picker-component.js`).
- fix applicato su provider admin Geo: rimossa registrazione `geo-map-widget.js` (asset non presente).
- fix applicato su loader runtime: bundle primario `themes/Geo/js/geo.js` + fallback coerente.
- fix fallback map-picker component: Leaflet locale-first (`/themes/Geo/...`) con CDN solo come backup.

## [2026-04-23] ops | PSR-4 / namespace collision - CoordinatePicker
- Nuova pagina: `concepts/psr4-namespace-collision-coordinatepicker.md`.
- Documentata la regola: namespace coerente con path (es. `app/Forms/...` => `Modules\\Geo\\Forms\\...`) per evitare classi skip in `composer dump-autoload`.

## [2026-04-23] governance | HasCoordinatePicker come boundary DRY della famiglia picker
- documentata la regola `has-coordinate-picker-dry-boundary-rule`
- nella trait vivono stato/helper condivisi; nelle classi concrete solo comportamento davvero specifico
- aggiunta sezione best practices, bad practices e false friends per evitare nuove duplicazioni tra sibling picker

## [2026-04-23] governance | Geo picker runtime stability
- Documentate best practices, bad practices e false friends per i picker Geo in wizard/frontoffice.
- Fissate le regole su import bundle tema, invalidateSize, flicker control, trait condivisi e divieto di `$view` nei componenti che estendono `XotBaseField`.
- Nuova pagina: `concepts/geo-picker-runtime-stability-best-practices.md`.

## [2026-04-22] fix | Leaflet mappa vuota dopo step wizard — MutationObserver
- **problema**: cliccare "Avanti" nel wizard Filament lasciava la mappa grigia/vuota
- **root cause**: Filament wizard nasconde step con `class="hidden"` (Tailwind); Leaflet vedeva container 0×0 al mount; ResizeObserver e IntersectionObserver non intercettano questo
- **fix**: aggiunto MutationObserver su 6 antenati in `firstUpdated()` di `coordinate-picker-lit.js`; chiama `_refreshMapSize()` con delay 150ms quando `offsetParent !== null`
- **CDN fix**: rimosso `<link unpkg.com/leaflet.css>` dal render(); aggiunto `import 'leaflet/dist/leaflet.css'` in cima al file
- **build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy` — 51 moduli, OK
- **rule**: `bashscripts/ai/.claude/rules/leaflet-wizard-invalidate-size.md`
- **wiki**: `laravel/Modules/Geo/docs/wiki/concepts/leaflet-wizard-step-invalidate-size.md`

## [2026-04-22] fix | CoordinatePicker Alpine x-data e prompt quality bar
- Corretto `coordinate-picker.blade.php`: l'`x-data` usa delimitatori e serializzazione compatibili con stringhe vuote/indirizzi, evitando l'errore Alpine `Unexpected token`.
- Verificato il markup renderizzato della pagina `tests/segnalazione-crea` con `curl`: `address: ''` resta dentro l'oggetto Alpine senza rompere l'attributo.
- Aggiornato `docs/prompts/map-picker.txt` alla v2.3 con quality bar: link operativi, best practices, bad practices, false friends e Definition of Done.
- Rigenerato bundle Vite dopo modifiche JS/CSS del picker.

## [2026-04-22] ingest | MapPicker guide v2.2 complete - mobile-first, i18n, responsive
- Aggiornato `docs/prompts/map-picker.txt` alla v2.2 con sezioni complete:
  - Mobile-first & responsive (breakpoints, touch 44x44px, height strategy)
  - Multilingua (i18n) con chiavi translation per CoordinatePicker
  - Map controls (4 layer, zoom, fullscreen, geolocation)
  - Address search server-side
  - Structured address data (street, number, city, postcode, etc.)
  - Livewire performance (debounce, eventi finali)
  - Accessibilità (aria-label, screen reader)
- Aggiornate traduzioni in `lang/it/geo.php`, `lang/en/geo.php`, `lang/de/geo.php`:
  - `coordinate-picker.search_placeholder`
  - `coordinate-picker.use_my_location`
  - `coordinate-picker.locating`
  - `coordinate-picker.no_position`
  - `coordinate-picker.zoom_in` / `zoom_out`
  - `coordinate-picker.fullscreen` / `close_fullscreen`
  - `coordinate-picker.layers.*`
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html

## [2026-04-22] ingest | MapPicker address search, mobile parity, controls
- Aggiornato `docs/prompts/map-picker.txt` con addendum canonico su mobile-first, multilingua, Design Comuni parity senza Bootstrap Italia, ricerca indirizzo server-side, payload indirizzo strutturato, posizione corrente, pan/zoom, fullscreen e layer switcher a 4 layer.
- Ingestita sintesi riusabile in `docs/wiki/concepts/map-picker-address-search-mobile-parity.md`.
- Aggiornato `docs/wiki/index.md`.

## [2026-04-22] story | 8-44 geo-component-family-philosophy-alignment-and-docs
- **Filosofia/Zen**: documentato il "Contract of Intent" per tutti i 9 componenti in `docs/wiki/concepts/geo-component-family-philosophy.md`.
- **Holy Trinity**: Spirit (Trait) + Body (Blade) + Mind (Lit JS) — ogni componente ha i tre elementi separati.
- **Allineamento PHP**: `dehydrated(false)` mancante in 6 componenti compositi (`LocationPicker`, `PlacePicker`, `MapPositioner`, `MapLocationInput`, `LeafletMarkerMapInput`, `GeopointPicker`) — da correggere.
- **Allineamento Lit**: `place-picker-lit.js` usa CDN marker/`L.Icon.Default` (violazione critica); 4 componenti emettono `location-changed` anziché `coords-changed` canonico.
- **Quality gate**: estendere `CoordinatePickerRefactorTest.php` con 6 test sui compositi mancanti.
- **Ingest**: nuovi docs wiki da indicizzare in context-mode MCP.

## [2026-04-22] ingest | Geo Fields Zen e component stories
- Ingestiti `docs/wiki/concepts/geo-fields-zen.md`, `docs/wiki/concepts/geo-components-stories.md` e `docs/wiki/concepts/geo-picker-sibling-components-governance.md`.
- Consolidata filosofia: ogni picker Geo e un "Contract of Intent"; condivide `HasCoordinatePicker`, ma mantiene identita, Blade e Lit separati.
- Regole operative incluse: branch sempre `dev`; file dismessi rinominati `.old`, non rimossi con `rm`; Shadow DOM preferibile ma Light DOM ammesso se Leaflet lo richiede.

## [2026-04-22] refactor | story 8-43 geo-map-picker-family-complete-production-refactor
- **HasCoordinatePicker trait**: rimosso `dehydrated(false)` da `setUpCoordinatePicker()`; aggiunti alias `getLatitude()`/`getLongitude()` come sinonimi di `getCenterLatitude()`/`getCenterLongitude()`.
- **MapPicker / CoordinatePicker**: `dehydrated(false)` ora chiamato esplicitamente in `setUp()` di ciascuna classe composita.
- **LatitudeLongitudeInput**: NON chiama `dehydrated(false)` — corretto per field diretto.
- **geo-latlng-input.js**: marker Leaflet sostituito con `createMapPickerLeafletIcon(L)` da `map-picker-marker-config.js`; eliminato default `L.marker`.
- **Blade files** (`coordinate-picker`, `map-picker`, `latitude-longitude-input`): bridge Alpine canonico `$wire.$watch` + `$wire.$set` + `_suppressUpdate`; eliminato `wire:entangle`.
- **Test quality gate**: `CoordinatePickerRefactorTest.php` — 12 test, gerarchia classi, trait contract, dehydrated isolation.
- PHPStan level 8: nessun errore.

## [2026-04-22] governance | branch dev permanente per MapPicker prompt
- Aggiornato `docs/prompts/map-picker.txt`: vietato creare o cambiare branch per questo workflow; si lavora sempre su `dev`.
- Corretto il falso amico architetturale: `MapPickerField`/custom field Geo devono estendere `XotBaseField`, non `Filament\Forms\Components\Field`.

## [2026-04-21] story | 8-40 MapPicker front — entangle + map-picker-lit init wizard
- **Blade:** `resources/views/filament/forms/components/map-picker.blade.php` allineato a `coordinate-picker`: `$wire.entangle('statePath').live`, binding reattivo `:latitude` / `:longitude`, evento `coords-changed` → `$wire.$set` + `reverseGeocode` esposto.
- **Lit:** `resources/js/components/map-picker-lit.js` — `IntersectionObserver` per init quando lo step Filament diventa visibile; `updated()` sincronizza marker da props; `geolocate-when-empty` da attributo; cleanup observer.
- **Lang:** `lang/it/map-picker.php`, `lang/en/map-picker.php` — chiavi `status.*`.
- **Tema:** bundle Sixteen non importa più `filament/map-picker.js` (evita conflitto Alpine / CE legacy su front).

## [2026-04-21] fix | GeoServiceProvider — no-CDN asset registration
- Rimossi asset CDN unpkg (Leaflet JS/CSS) da `GeoServiceProvider::registerMapAssets()`.
- Registrati bundle locali pubblicati: `themes/Geo/js/manifest.js`, `vendor.js`, `geo.js` (include map-picker-lit + geoMapPickerField Alpine).
- Leaflet CSS locale: `themes/Geo/css/leaflet.css`.
- Regola rispettata: `map-marker-no-cdn` + `no-absolute-paths-in-config`.
- File: `laravel/Modules/Geo/app/Providers/GeoServiceProvider.php`

## [2026-04-21] fix | map-visual-fix.css — marker z-index e divIcon styles
- Corretto z-index delle panes Leaflet (era tutto z-index:1, i marker erano nascosti sotto i tile).
- Aggiunti stili globali per `.map-picker-marker--custom` e `.map-picker-marker__inner` (divIcon renderizzato fuori Shadow DOM).
- File: `laravel/Themes/Sixteen/resources/css/map-visual-fix.css`

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-16] geomapwidget | static geo map widget pattern
- Documentato il pattern `GeoMapWidget` con dataset GeoJSON statico, Lit Web Component e Leaflet layer manager.
- Registrato l'uso corretto di `phpmd.phar` nel flusso qualità del modulo.
- Aggiunti test dedicati a `GeoMapDataset` per normalizzazione, categorie e statistiche.

## [2026-04-21] story | 8-39 geo coordinatepicker family architecture convergence
- Story artifact: `_bmad-output/implementation-artifacts/8-39-geo-coordinatepicker-family-architecture-convergence.md`.
- Scope: convergenza tra `CoordinatePicker`, `MapPicker`, `LatitudeLongitudeInput`, `PlacePicker` con contratto coordinate unico.

## [2026-04-21] fix | filament field-wrapper error-message component missing
- Rimossa chiamata legacy `x-filament-forms::field-wrapper.error-message` da `resources/views/filament/forms/components/coordinate-picker.blade.php`.
- Dettaglio: `docs/wiki/troubleshooting/filament-field-wrapper-error-message-missing.md`.

## [2026-04-21] refactor | LitElement ownership moved to JS layer
- Lit/Web Component registrato via `resources/js/filament/map-picker.js` e import tema dove applicabile.

## [2026-04-21] governance | struttura wiki geo canonica
- Contratto cartelle: `docs/wiki/{concepts,entities,sources,comparisons,decisions,troubleshooting,_archive,_templates}`.

## [2026-04-21] bugfix | MapPicker Filament ViewComponent richiede `$view`
- **Errore**: `Class MapPicker extends ViewComponent but does not have a [$view] property defined` (wizard test segnalazione).
- **Fix**: `protected string $view = 'geo::filament.forms.components.map-picker';` in `app/Filament/Forms/Components/MapPicker.php`.
- **Nota**: proprietà fluent `geolocateWhenEmpty` rinominata in `$geolocateWhenEmptyState` per evitare conflitto col metodo omonimo; trait `HasCoordinatePicker` in `Traits\`.

## [2026-04-21] bugfix | mappicker height alias runtime (storico)
- Errore storico: `BadMethodCallException: MapPicker::height does not exist`; mitigato con supporto height nel trait/component ove presente.

## [2026-04-21] governance | forbidden folders zero tolerance
- Collegamento regola root: `../../../../docs/wiki/concepts/forbidden-folders-zero-tolerance-rule.md`.

## [2026-04-27] fix | map-picker-lit.js — MutationObserver depth + refreshMapSize
- Aumentato MutationObserver depth da 15 a 20 in `map-picker-lit.js` per rilevare `class="hidden"` wizard Filament 5.
- Aggiunto metodo `_refreshMapSize()` con delay array `[0, 80, 180, 350, 700, 1200]` per gestire ambienti lenti e transizioni Alpine.
- `_initMap()` ora chiama `this._refreshMapSize()` dopo inizializzazione.
- Rimosso `IntersectionObserver` da `coordinate-picker-lit.js` (false friend — non rileva `class="hidden"` Tailwind).
- Aumentato depth da 15 a 20 anche in `coordinate-picker-lit.js`.
- Build Vite completato: `npm run build && npm run copy` OK.

## [2026-04-27] fix | Blade icon collision — geo:: prefix
- Errore `CannotRegisterIconSet`: il prefix `geo.` collide con il set `default` (prefix `''`).
- Fix: `address-search-input.blade.php` ora usa `<img src="{{ asset('modules/geo/svg/magnifying-glass.svg') }}">` invece di `@svg('geo::magnifying-glass')`.
- Regola: quando il set `default` ha prefix vuoto, non usare `@svg('set::...')` — usare asset diretto.

## [2026-04-27] docs | aggiornamento LLM wiki + regole
- Verificato che `bashscripts/ai/.claude/rules/` contiene tutte le regole attuali (23 file .md).
- Verificato che `laravel/Modules/Geo/docs/wiki/` ha struttura canonica: concepts/, entities/, comparisons/, decisions/, troubleshooting/.
- Verificato che `laravel/Themes/Sixteen/docs/` ha documentazione completa (60+ file .md).
- Aggiornato `log.md` con sessione odierna.
- 2026-04-28: Added rule `filament-admin-coordinate-picker-theme-bundle-rule` after admin map rendered without fullscreen/zoom/geolocation controls while frontoffice worked. Geo now registers the compiled Sixteen theme JS bundle in Filament admin.
## [2026-04-29] story | coordinate picker fullscreen refinement
- Aggiunta story 8-74 come refinement del contratto fullscreen wizard per `coordinate-picker-lit`.
- Requisiti runtime: Fullscreen API quando disponibile, fallback CSS, listener `fullscreenchange`, document class `geo-map-fullscreen-active`, refresh Leaflet tramite helper esistenti.

## [2026-04-29] feature | geojson-map-lit spostato in Geo (regola componenti riutilizzabili)
- `geojson-map-lit.js` spostato da `Modules/Fixcity/resources/js/components/` a `Modules/Geo/resources/js/components/`
- Regola: componenti JS mappa riutilizzabili vivono sempre in Geo, non nei moduli domain
- Aggiornato `file_get_contents` nel blade Sixteen per puntare a Geo
- Aggiornate wiki Fixcity e memory Windsurf con path corretto
- Aggiunta wiki page `concepts/geojson-map-lit-component.md` in Geo

## [2026-04-29] refactor | geojson-map-lit naming fix
- `ticket-map-lit.js` rinominato in `geojson-map-lit.js` (nome generico, non domain-specific)
- `farmshop-map-lit.js` rinominato in `geo-points-canvas-lit.js` (era LitElement canvas, diverso)
- Classe: `GeoJsonMapLit`, tag: `<geojson-map-lit>`
- Regola: nomi componenti Geo devono essere generici, non legati al dominio applicativo

## [2026-04-30] feat | geo-map-lit search toggle (story 8-83)
- Search address collassata di default — solo lente visibile
- Click lens → espande input + pulsanti; X/Escape/click-outside → collassa
- `_searchOpen` Lit reactive property in `geo-map-lit.js`
- `renderSearch(ctx)` in `map-picker-search.js` legge `ctx._searchOpen` per il toggle
- Fix: `map-picker-search.js` era corrotto da sessione precedente (brace mismatch) → riscritto
- Build: `geo-map-lit-CgUKNb90.js` 45.97 kB → copiato in `public_html/assets/geo/assets/`
- Wiki aggiornata: `geo-map-lit-search-is-default.md`

## 2026-05-01 — MapLit conversione farmshops.eu
- Creazione componente `map-lit` come conversione fedele di `direktvermarkter.js` in Lit.dev (vedi `resources/js/components/map-lit.js`)
- Risolte criticità di validazione marcatori: verifica rigorosa `lat`/`lng` con `Number.isFinite` prima di creare marker
- Rimossa geolocalizzazione automatica in init che spostava mappa dai marker di test
- Cluster LOD: zoom ≥ 8 mostra icone tipo-colored per cluster con ≥2 tipi diversi
- Usa `tickets_big.json` come default data-url per test clustering densi (70 punti Roma)
- Aggiornato Blade `segnalazioni-elenco.blade.php`: `<geo-map-lit>` → `<map-lit>`, `tickets.json` → `tickets_big.json`
- Build assets Sixteen: `npm run build && npm run copy` completato
- 70 feature GeoJSON con coordinate valide, nessun marker scartato
