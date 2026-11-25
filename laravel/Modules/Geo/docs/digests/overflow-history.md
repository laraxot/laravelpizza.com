---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 42 file oltre target 100.

### `contracts/fetch-osm-tile-action.md` — FetchOsmTileAction


# FetchOsmTileAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Osm/FetchOsmTileAction.php`.

## Input

- Z, x, y del tile.
- Referer della pagina che lo chiede (facoltativo).

## Output

- Corpo PNG con ETag e Last-Modified, oppure null se il tile non c'e' ne' in cache ne' da OSM.

## Invarianti

- Mai piu' di una richiesta a OSM per tile prima della scadenza.
- Scadenza mai sotto i 7 giorni.
- User-Agent sempre identificabile con contatto.

### `contracts/get-address-data-from-full-address-action.md` — GetAddressDataFromFullAddressAction


# GetAddressDataFromFullAddressAction

Unico dispatcher della geocodifica lato server: prova il provider preferito (`geo.driver`), poi gli altri in ordine
fisso, e restituisce il primo risultato. Perché è fatto così: [ADR provider preferito con fallback](../adr/geocoding-preferred-provider-with-fallback.md).
Sorgente: `app/Actions/GetAddressDataFromFullAddressAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php`.

## Input

- `string $fullAddress`: indirizzo libero.
- Configurazione: `geo.driver` (`GEO_DRIVER`, default `google_maps`); chiavi dei provider in `services.*`.

## Output

- `AddressData` del primo provider che ne restituisce uno; `null` se nessuno risponde.
- `getErrors()`: i messaggi delle eccezioni dei p

### `contracts/query-nominatim-action.md` — QueryNominatimAction


# QueryNominatimAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Osm/QueryNominatimAction.php`.

## Input

- Endpoint (`search` o `reverse`), parametri della richiesta, lingua della pagina.

## Output

- `{status, data}`: 200 con i risultati di Nominatim, oppure 422, 429, 502 o 503 con un messaggio.

## Invarianti

- Al massimo 1 richiesta al secondo a Nominatim per tutto il sito.
- Solo i parametri ammessi.
- `limit` <= 10.


### `contracts/update-coordinates-from-address-action.md` — UpdateCoordinatesFromAddressAction


# UpdateCoordinatesFromAddressAction

Geocodifica l'indirizzo di un modello qualsiasi e ne scrive `latitude` e `longitude`. Sorgente:
`app/Actions/UpdateCoordinatesFromAddressAction.php`. Chiamanti: `app/Filament/Actions/UpdateCoordinatesBulkAction.php`,
`app/Filament/Forms/Components/CoordinatesSection.php` e le tabelle Filament dei moduli ospiti che geocodificano i
propri clienti (azione di riga e bulk).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php`.

## Input

- `Model $model` con l'attributo `full_address` (o l'accessor `getFullAddressAttribute()`, che ha la precedenza) e le
  colonne `latitude`, `longitude` fillable.

## Output

- `true` se le coordinate sono state scritte; `false` altrimenti, con i motivi in `getErro

### `stories/01.geo-phpstan-fix.story.md` — Geo — PHPStan static call fix


# Geo — PHPStan static call fix

Riferimenti correlati (story precedenti sullo stesso modulo, non cancellate, questa
le aggiorna): `Modules/Geo/docs/stories/phpstan-geo-fix.md`,
`Modules/Geo/docs/stories/phpstan-batch.story.md`,
`Modules/Geo/docs/stories/phpstan-fix.story.md` (stub vuoti, mai
completati da chi li ha creati).

## Contesto

Campagna "PHPStan zero" (`bashscripts/docs/prompts/03-quality-gates.md`). Ultimo
numero noto in `docs/chat/phpstan-modules-zero.md` per Geo era **105 errori**
(nessun owner). Al momento di questo task, uno swarm parallelo (Epic 4,
"filament-canonical-structure") aveva già in corso l'estrazione Schemas/Tables sulle
Resource `AddressResource`/`LocationResource` (working tree con ~50 file `.md`/
Resources modificati non miei, non toccati da questa story). U

### `stories/1-1-map-picker-field.md` — Story 1-1: MapPicker Field per Filament


# Story 1-1: MapPicker Field per Filament

**Status**: `done`
**Module**: Geo
**Epic**: Geo Form Components

---

title: "1 1 map picker field"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "1 1 map picker field"
issues: []
discussions: []
## Descrizione

Campo Filament v5 personalizzato `MapPicker` che gestisce una mappa interattiva basata su Leaflet, incapsulata in un Web Component Lit. Integrato con Livewire 3 e Alpine.js. Lavora con due colonne reali del database `latitude` e `longitude` senza JSON.

### `stories/1-map-picker-field.md` — Story 1-1: MapPicker Field per Filament


# Story 1-1: MapPicker Field per Filament

**Status**: `done`
**Module**: Geo
**Epic**: Geo Form Components

---

## Descrizione

Campo Filament v5 personalizzato `MapPicker` che gestisce una mappa interattiva basata su Leaflet, incapsulata in un Web Component Lit. Integrato con Livewire 3 e Alpine.js. Lavora con due colonne reali del database `latitude` e `longitude` senza JSON.

---

## Acceptance Criteria

- [x] **AC1**: `MapPicker::make()` con fluent API `.latitude()` / `.longitude()`
- [x] **AC2**: Due colonne reali DB (`latitude`, `longitude`), nessun JSON
- [x] **AC3**: Lit Web Component `<geo-map-picker>` con Shadow DOM in Blade inline

### `stories/12.1.retire-geo-test-livewire.story.md` — 12.1 Ritiro Test


# 12.1 Ritiro Test

Ritiro del componente Livewire HTTP `Test`: residuo di sviluppo, vista disallineata, zero chiamanti. `FormSearchAddressCategories` resta HTTP. Map widgets FQCN intatti.

## GitHub (tracciamento)

| Risorsa | Ruolo |
|---------|-------|
| [#88](https://github.com/laraxot/module_geo_fila5/issues/88) | issue |
| [#89](https://github.com/laraxot/module_geo_fila5/discussions/89) | discussion |

```bash
gh -R laraxot/module_geo_fila5 issue create --title "12.1 Ritiro Http/Livewire Test" --body "Canon: laravel/Modules/Geo/docs/stories/12.1.retire-geo-test-livewire.story.md"
```

## Acceptance Criteria

1. [x] `Test.php` assente (vista `livewire/test.blade.php` assente).
2. [x] FormSearchAddressCategories **non** convertito a widget in questa story.

### `stories/13.geo-sync-marker-repair.story.md` — 13 - Geo: riparazione dei marcatori di conflitto lasciati dal sync


# 13 - Geo: riparazione dei marcatori di conflitto lasciati dal sync

## Obiettivo

`phpstan analyse Modules` non partiva perché 15 file PHP di Geo contenevano `<<<<<<<` / `=======` / `>>>>>>>` annidati,
prodotti da `bashscripts/git/subtrees/merge_remote_repo_2.sh` (`commit -am .`). Obiettivo: lasciare per ogni file una
versione che fa quello per cui il file esiste, senza scegliere un lato a caso e senza perdere righe uniche.

Metodo: per ogni file si sono letti i blocchi, si è cercato chi lo chiama e cosa si aspettano i test, e si è provato che
l'insieme delle righe uniche dei due lati coincide con una revisione integra della storia del repository root
(`6e32612c` del 24-Nov 17:48; `eddac6d31` per `OsmProxyTest`, l'ultima versione senza marcatori).

## File in scope e risoluzione

Scopo 

### `stories/asset-build-symlink.story.md` — Geo: build Vite nella cartella public del modulo, servita via symlink


# Geo: build Vite nella cartella public del modulo, servita via symlink

## Perché

`deploy.sh` di Roosko si fermava sulla build di Geo, lasciando l'applicazione in manutenzione. Le cause:

- `laravel-vite-plugin ^1.3` non è compatibile con vite 8, quindi `npm ci` falliva per conflitto di peer;
- gli alias puntavano a `laravel/node_modules`, che sul server non viene installato;
- `outDir` scriveva direttamente in `public_html/assets/geo`. Gli asset dei moduli invece si servono con il
  symlink `public_html/assets/geo` → `Modules/Geo/public` (`xot:module-link`), quindi `npm run copy` non serve più.

## Fatto

- `laravel-vite-plugin ^3.2.1`, via `laravel-mix` e lo spread di `refreshPaths`, alias su `node_modules` del modulo.
- `outDir` = `public/` del modulo, che è versionata: il server non

### `stories/comuni-istat-dataset.story.md` — Elenco completo dei comuni italiani per le select dell'indirizzo


# Elenco completo dei comuni italiani per le select dell'indirizzo

## Problema

`resources/json/comuni.json` contiene 4 comuni di prova. Region, Province e Locality ne ricavano le opzioni di
Regione, Provincia, Comune e CAP dell'indirizzo (AddressForm). Risultato:
- si potevano scegliere solo Lombardia e Sicilia (piu' una voce duplicata con le virgolette);
- in Roosko un cliente non poteva registrare un cantiere in Emilia-Romagna.

Con dati completi la select del Comune andava poi in 500: `cap` e' una lista e Sushi inseriva un array
("Array to string conversion").

## Correzione

- **`resources/json/comuni-istat.json`**:
  - 7.904 comuni;
  - fonte ISTAT, formato di [matteocontrini/comuni-json](https://github.com/matteocontrini/comuni-json): `regione` e `provincia` come `{codice, nome}`,

### `stories/continuation.story.md` — Geo Module — Continuation Task

# Geo Module — Continuation Task

## Stato
Modulo con modifiche non ancora sincronizzate nel proprio .git.

## Task
1. Aggiungere `protected static string $model =` a tutte le table class mancanti
2. Audit `getTableColumns()` — verificare campi modello
3. Migliorare UI/UX (badge, toggleable, sortable)
4. `php -l` su tutti i file toccati
5. `git commit -m "BMAD: table audit"`

## Modelli attesi (da verificare)
- Tabella: `Modules\$m\Filament\Resources\*`
- Modello: `Modules\$m\Models\*`

### `stories/dcp-127-mappa-centratura-senza-https.story.md` — DCP-127: centratura della mappa senza HTTPS


# DCP-127: centratura della mappa senza HTTPS

## Richiesta (utente, 2026-10-13)
Nel wizard `/it/tickets/create?step=form.dati-di-segnalazione::data::wizard-step` le coordinate fisse (`CoordinatePicker::make('location')->center(43.7696, 11.2558)`) vanno contro lo scopo: se il record ha le coordinate si leggono, se sono null la mappa si centra sulla posizione dell'utente (browser). Chi segnala puo' essere ovunque nel mondo. Niente testo «Apri questa pagina in HTTPS per usare la posizione.»; «la mappa deve funzionare sempre», anche senza HTTPS.

## Fase BMAD
Dev (implementazione) e Verify (Playwright reale). Analysis gia' fatta dal coordinatore. Chiusura: second brain.

## Misura di partenza (coordinatore, `http://192.168.1.40:8000`, `isSecureContext=false`)
Mappa sul mondo (centro 19.97/0.

### `stories/dcp-152-marker-dettaglio-ticket-e-pulsanti-mappa-su-pagine-dc.story.md` — DCP-152: marker e pulsanti del picker nelle pagine ospiti


# DCP-152: marker e pulsanti del picker nelle pagine ospiti

## Segnalazioni dell'utente (2026-10-14)
1. `/it/tickets/66`: il marker e' nero, piccolo, con un punto di domanda a fianco. «In questa situazione sappiamo quale e' il tipo di ticket.»
2. Passo 2 del wizard (`/it/tickets/create?step=form.dati-di-segnalazione::data::wizard-step`): i pulsanti dentro la mappa hanno sfondo trasparente; «usa la posizione corrente» non funziona.

## Fase BMAD
Bugfix: analisi, test rosso, fix, verifica, second brain.

## Cause (riprodotte con Playwright, non ipotizzate)
1. **Tre difetti sovrapposti.**
   - `coordinate-picker-lit` iniettava `mapStylesText` ma non `markerCardStylesText` (lo faceva solo `map-lit`): il cerchio del marker non aveva sfondo e il pin SVG (`currentColor`) usciva nero. Misura: `b

### `stories/dcp-93-geo-namespace-blade-e-mappa-sola-lettura-follow-up.story.md` — DCP-93: Geo, cosa resta dopo la mappa di sola lettura


# DCP-93: Geo, cosa resta dopo la mappa di sola lettura

## Fatto (DCP-33, agente `dcp33-geo-map`, riletto dall'orchestratore)
`<x-geo::point-map>` e attributo `readonly` del Lit `coordinate-picker-lit` (marker non trascinabile, nessuna scrittura di stato, nessuna chiamata a Nominatim); `CoordinatePicker->readOnly()` lo rispetta; 27 test Pest verdi (26 rossi prima), PHPStan a zero.

## Difetto trovato (reale, non corretto fuori da Geo)
`GeoServiceProvider` non ridefinisce `$module_ns`: `XotBaseServiceProvider` registrava il namespace `geo` su `Modules\Xot\View\Components`. Corretto in Geo con `Blade::componentNamespace('Modules\\Geo\\View\\Components', 'geo')` in `boot()`. **Lo stesso difetto e' latente in AI, Activity e Mobile** (lo ha rilevato l'agente, non verificato dal vivo): `<x-ai:

### `stories/docs-index-audit.story.md` — Story: Audit e indice della documentazione Geo


# Story: Audit e indice della documentazione Geo

## Status
Done

## Type
Docs-only (audit BMAD, nessuna modifica a file .md esistenti)

## Summary
- Analizzati i 1969 file `.md` sotto `Modules/Geo/docs/` (563 sciolti in root, 103 sottocartelle); rilevati 92 gruppi di duplicati esatti (98 file, hash identico) tramite confronto md5.
- Riscritto `docs/index.md`: indice per argomento (~27 categorie) di tutti i file distinti in root, tabella delle 103 sottocartelle con relativo punto d'ingresso, e sezione "Storico / da consolidare" per duplicati esatti, cartelle di scratch (`root-md-files/`, `_integration/`, `prompts/`) e aree di contenuto probabilmente non specifico di Geo (`roadmap/`, `claude/`, `it/`).
- Nessun file `.md` esistente rinominato, spostato o cancellato; corretti due link non r

### `stories/geo-map-widget-farmshops-inspired.md` — Story: GeoMapWidget farmshops-inspired per modulo Geo


# Story: GeoMapWidget farmshops-inspired per modulo Geo

## Status

Draft

## Story

Come amministratore Filament del modulo `Geo`,
voglio un widget `GeoMapWidget` basato su Leaflet e su un Web Component Lit,
così da visualizzare e navigare un dataset GeoJSON statico lato client con clustering, layer multipli e popup ricchi senza dipendere da chiamate server successive al primo caricamento.

## Contesto

Il progetto sorgente di riferimento verificato è `CodeforKarlsruhe/farmshops.eu`, in particolare:

- `js/direktvermarkter.js`, che usa `L.map`, `L.geoJson`, `L.markerClusterGroup`, layer base OSM/Esri, popup e stato client-side.
- `update_data.js`, che genera un dataset statico ridotto partendo da dati OpenStreetMap e lo espone al frontend come payload già pronto al rendering.
- `js/popup

### `stories/geo-map-widget-farmshops-lod.md` — Story: GeoMapWidget Filament v5 con pattern farmshops e LOD client-side


# Story: GeoMapWidget Filament v5 con pattern farmshops e LOD client-side

## Status
Draft

## Priority
Alta

## Type
Nuova feature / consolidamento architetturale Geo

## Module
Geo

## Date
2026-04-17

---


### `stories/geo-mixed-type-reduction.story.md` — Story: Reduce mixed type usage in Geo module


# Story: Reduce mixed type usage in Geo module

## Status
Done (best-effort, partial — "dove possibile", not full coverage)

## Type
Refactor (typing only, no behavior change)

## Summary
- Module carried roughly 363 `mixed` occurrences (native type-hints and docblocks) across 94 files.
  Reduced 6 occurrences across 5 files where the concrete/union type was genuinely evident from the
  surrounding code, per project convention "cerchiamo di non usare mixed, quando lo troviamo cerchiamo
  di sostituirlo con qualcosa di adeguato".
- Files changed: `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php`, `app/Datas/GeoData.php`,
  `app/Filament/Resources/LocationResource.php`, `app/Filament/Resources/Pages/ListLocations.php`,
  `app/Models/Traits/GeoTrait.php`. Full rationale per change 

### `stories/geo-unit-tests-claude-audit.story.md` — Geo — Unit Tests for claude-audit 100/100


# Geo — Unit Tests for claude-audit 100/100

## Fase BMAD

Build + Measure. Questa story fa parte del batch per portare i moduli Geo, Notify, Tenant a 100/100 claude-audit.

## Problema

Il modulo Geo ha score claude-audit 78-79/100 (Grade B). Il finding principale è "No tests found" nella struttura `laravel/tests/Unit/Modules/Geo/` e `laravel/tests/Feature/Modules/Geo/`. I test esistono in `Modules/Geo/tests/` ma non sono rilevati da claude-audit.

## Obiettivo

Creare unit test nella struttura standard del progetto (`laravel/tests/Unit/Modules/Geo/`) per la business logic critica del modulo Geo, raggiungendo 100/100 claude-audit.

## Azioni

### 1. Test per Actions critiche

Creare test per le seguenti Actions in `laravel/tests/Unit/Modules/Geo/Actions/`:

### `stories/indirizzo-leggibile.story.md` — Geo: full_address con i nomi al posto dei codici ISTAT


# Geo: full_address con i nomi al posto dei codici ISTAT

## Perché

AddressForm salva i codici ISTAT di comune, provincia e regione, ma `full_address` li stampava così come sono:
nell'area clienti di Roosko il cantiere risultava «Viale delle Nazioni 12, 39014, 39, 48122». Lo stesso testo
andava anche al geocoding (`UpdateCoordinatesFromAddressAction`).

## Fatto

- `FormatAddressAction` restituisce «Viale delle Nazioni 12, 48122 Ravenna (RA)»:
  - il comune è preso da `Locality`;
  - la sigla della provincia arriva dal file ISTAT, con una mappa in cache legata alla data di modifica del file;
  - gli indirizzi scritti per nome (geocoding, import) restano com'erano.
- `Address::full_address` e `getFullAddress()` passano da questa action.

## Verifica

- `tests/Unit/Actions/Address/FormatAd

### `stories/map-controls-i18n-it-en-de-es.story.md` — Controlli e popup della mappa tradotti in it, en, de, es


# Controlli e popup della mappa tradotti in it, en, de, es

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (sweep delle pagine, causa, fix, verifica in browser)
- Owner: Modules/Geo (`resources/js/components/map/`)
- Collegata a: [auth-pages-i18n-en-de-es-2026-10-07.story.md](../../../User/docs/stories/auth-pages-i18n-en-de-es-2026-10-07.story.md),
  [tickets-ux-theme-symlink-geolocation-2026-10-07.story.md](../../../../Themes/Sixteen/docs/stories/tickets-ux-theme-symlink-geolocation-2026-10-07.story.md)

## Problema

Su `/en`, `/de`, `/es` i pulsanti della mappa avevano nome accessibile e tooltip in italiano
(`Cerca`, `Usa la mia posizione`, `Schermo intero`, zoom, layer), i messaggi di errore della
geolocalizzazione erano in italiano, e il popup del marker in de/es ricadeva sull'ita

### `stories/map-picker-filament-v5-lit-livewire.md` — Story: MapPicker Filament v5 con Leaflet + Lit + Livewire su colonne latitude/longitude


# Story: MapPicker Filament v5 con Leaflet + Lit + Livewire su colonne latitude/longitude

## Status
Draft

## Priority
Alta

## Type
Refactor strutturale + hardening di custom field Geo

## Module
Geo

## Date
2026-04-17

---


### `stories/map-popup-contrast-and-fit.story.md` — Popup dei marker: testo bianco su bianco, popup tagliato, azioni fuori vista


# Popup dei marker: testo bianco su bianco, popup tagliato, azioni fuori vista

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (riproduzione, causa radice, fix, verifica nel browser)
- Owner: Modules/Geo (`popup-ticket.js`), tema Sixteen (CSS)

## Problema

Cliccando un marker della mappa il popup mostrava codice e indirizzo in bianco su bianco; il popup era piu' alto della mappa
(tagliato in basso, "Dettagli" e "Chiudi" non raggiungibili) e su mobile era piu' largo della mappa.

## Riproduzione

Il database ha 0 segnalazioni, quindi nessun marker. Playwright intercetta `/api/tickets/geojson*` e `/api/ticket-details/*`,
inietta una feature, clicca il marker e misura contrasto (WCAG, colori normalizzati con canvas), geometria e visibilita' delle azioni.
Solo la **home** era rotta, la p

### `stories/marker-popup-and-location-ux.story.md` — Popup marker e posizione: leggibilita e layout


# Popup marker e posizione: leggibilita e layout

- Stato: done (2026-10-07), con un caso non riprodotto (vedi Aperto)
- Fase BMAD: Quick Flow
- Owner: Modules/Geo (map-lit); build e CSS in Themes/Sixteen

## Segnalazione

"Cliccando sul marker il popup ha scritta bianca su sfondo bianco." Altri difetti emersi misurando il popup nel browser.

## Misure (Chrome headless, dati reali del proprietario + mock per gli stati)

Contrasto calcolato su ogni nodo di testo del popup, in tema chiaro e scuro, stati `pending/open/resolved`, caricamento, foto e
mobile 390px: nessun testo sotto 4,5:1. Difetti reali trovati:

- Mobile: popup piu largo della mappa, tagliato a destra e sul bordo inferiore.
- Indirizzo ripetuto tre volte (anteprima in intestazione, "Indirizzo", link mappe); descrizione taglia

### `stories/phpstan-batch.story.md` — phpstan-batch.story



### `stories/phpstan-cleanup-geo.dev.md` — [DEV] PHPStan cleanup modulo Geo


# [DEV] PHPStan cleanup modulo Geo

## Technical Plan

1. Tipizzare tutte le costanti (`const string|int|array`), centralizzando i duplicati:
   - `Modules\Geo\Support\GeoApiEndpoints` (nuovo): `GOOGLE_{GEOCODING,DISTANCE_MATRIX,ELEVATION,DIRECTIONS,TIMEZONE}`,
     `NOMINATIM_{BASE,SEARCH,REVERSE,LOOKUP}`, `MAPBOX_PLACES`, `BING_LOCATIONS`.
   - `Modules\Geo\Support\GeoDataConfig` (nuovo): `JSON_PATH`, `CACHE_TTL`, `CACHE_KEY_{REGIONS,PROVINCES,CITIES,CAP}`.
   - Regole di validazione: `GeoDataValidationRules::RULES|MESSAGES` come unica fonte.
   - Le classi con costanti locali lette dai test via reflection (`GoogleMapsService`, `GoogleMapsAction`) le
     mantengono come alias tipizzato (`private const string GEOCODING_URL = GeoApiEndpoints::GOOGLE_GEOCODING;`).
2. `Cache::remember`: ti

### `stories/phpstan-cleanup-geo.story.md` — [STORY] PHPStan cleanup modulo Geo


# [STORY] PHPStan cleanup modulo Geo

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore; aumenta la qualita'
del codice; usa enum al posto delle costanti».

Gruppo Geo: 104 errori in 56 file (lista: `typeCoverage.constantTypeCoverage` x ~80, `argument.type`/`return.type` su
`Cache::remember`, variabili mai lette, offset/array mai letti nei test, 1 `missingType.generics` in un test).
Verifica: `./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1 --no-progress` (da `laravel/`).

## Analysis

Scopo del codice toccato, non solo l'errore:

- **Costanti di configurazione (URL provider, TTL, chiavi cache, percorso JSON, regole di validazione).** Non sono
  insiemi di stati: restano costanti (non enum) ma tipizzate (`pri

### `stories/phpstan-fix-2.story.md` — phpstan-fix-2.story



### `stories/phpstan-fix.story.md` — phpstan-fix.story



### `stories/phpstan-geo-fix.md` — Problema


## Problema
PHPStan errors in Modules/Geo

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

### `stories/phpstan-ignore-removal.story.md` — [STORY] Geo: rimozione delle annotazioni @phpstan-ignore


# [STORY] Geo: rimozione delle annotazioni @phpstan-ignore

Fase BMAD: Dev (con analisi) + verifica. Regola dell'utente: mai `@phpstan-ignore`, mai baseline, `mixed` solo come ultima spiaggia.

## Analisi (scopo, chi usa, causa)

Metodo: per ogni annotazione tolta, PHPStan su `Modules/Geo` con tutte le annotazioni rimosse e nessuna correzione ancora applicata, per
vedere cosa nascondevano davvero. Risultato: 11 segnalazioni, tutte in 2 file; le altre annotazioni non nascondevano nulla.

| File | Annotazioni | Cosa nascondevano | Esito |
|------|-------------|-------------------|-------|
| `app/Traits/HasAddresses.php` | 6 x `return.type` | Niente: nessuna segnalazione senza annotazione | Tolte |
| `app/Models/Traits/SushiToJsons.php` | `trait.unused` | Niente: il trait e' usato da una fix

### `stories/placeholder-translations-cleanup.story.md` — Via le traduzioni segnaposto dai file di lingua


# Via le traduzioni segnaposto dai file di lingua

Rimosse le voci `helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading` e `hint` uguali al nome del
campo. Le aveva scritte il salvataggio automatico delle chiavi mancanti (`AutoLabelAction`, solo in locale) e
comparivano in produzione come testo sotto e dentro i campi. Eliminati anche i file `.php` senza nome.

Strumento: `php artisan lang:clean-placeholders {Modulo} [--dry-run]` (modulo Lang). Tocca solo i file di soli
dati: quelli che chiamano funzioni restano come sono.

### `stories/quality-gate-closure.story.md` — Story: Quality-gate closure — Modules/Geo (2026-09-04)


# Story: Quality-gate closure — Modules/Geo (2026-09-04)

## BMAD phase
Build + Measure (standing order pillar 5 — chiusura gate qualità di modulo).

## Contesto
PHPStan era già stato misurato a 0 errori su `Modules/Geo` in una sessione precedente della stessa
giornata (2026-09-04), con e senza path arg, dopo un refresh `ide-helper:generate/meta/models`. Questa
story copre il resto del gate: phpmd, phpinsights (verificato non disponibile), pest, coverage, git.

## Coordinamento
- Letti `docs/chat/*.md` per note/collisioni su Geo prima di editare: nessun blocco attivo per oggi
  (le note esistenti — `geo-module-gitmodules-sync.md`, `module-ui-geo-dependency-removal.md`,
  `ui-geo-boundary-lock.md` — riguardano sync git pregressi e il confine architetturale Geo→UI, non
  in conflitto con qu

### `stories/story-001.md` — STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore


# STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore

**Epic:** CI/CD — Release Automation
**Priority:** Should Have
**Story Points:** 5
**Status:** In Progress
**Assigned To:** Unassigned
**Created:** 2026-06-03
**Sprint:** 1

---

## User Story

As a **maintainer del monorepo**
I want to **uno stack di release semantic coerente e un changelog avanzato con report/grafici per contributore**
So that **le release non si duplichino e il contributo di ciascuno sia tracciato e visibile**

---

### `stories/story-002-scheda-contract-unification-2.md` — STORY-002: Unificazione SchedaContract e gerarchia BaseScheda


# STORY-002: Unificazione SchedaContract e gerarchia BaseScheda

**Epic:** Architecture — Module Inheritance & DRY  
**Priority:** Must Have  
**Story Points:** 8  
**Status:** In Progress (Phase 2 completata 2026-06-15)  
**Sprint:** PHPStan Quality Gate  
**Created:** 2026-06-15 (BMAD `/bmad/create-story`)

---

title: "STORY 002 scheda contract unification"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "STORY 002 scheda contract unification"
issues: []
discussions: []

### `stories/story-002-scheda-contract-unification.md` — STORY-002: Unificazione SchedaContract e gerarchia BaseScheda


# STORY-002: Unificazione SchedaContract e gerarchia BaseScheda

**Epic:** Architecture — Module Inheritance & DRY  
**Priority:** Must Have  
**Story Points:** 8  
**Status:** In Progress (Phase 2 completata 2026-06-15)  
**Sprint:** PHPStan Quality Gate  
**Created:** 2026-06-15 (BMAD `/bmad/create-story`)

---

## User Story

**As a** architetto Laraxot  
**I want** un unico `SchedaContract` e `Progressioni\Scheda extends BaseScheda` con `asz()` ereditata  
**So that** le action Ptv usano `$scheda->asz()->ofRangeDate()` senza duplicare query né contratti paralleli

---


### `stories/story-1116-map-marker-fix-2.md` — 📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE


# 📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE

## CONTESTO

La mappa mostra errori visivi durante il pan/zoom: marker e gruppi cluster scompaiono per èra ùtili al ripple `refreshClusters()` con timeout da 180ms.

## SOLUZIONE IMPLEMENTATA

1. **Modifica nel file `map-lit.js`:**
```javascript
// Prima versione problematica:
_map.on('zoomend', () => {
  this._clusterRefreshTimer = setTimeout(() => {
    this._markersLayer.refreshClusters();
  }, 180);
});

// Riparata:
_map.on('zoomend', () => this._markersLayer.refreshClusters());

### `stories/story-1116-map-marker-fix.md` — 📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE


# 📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE

## CONTESTO

La mappa mostra errori visivi durante il pan/zoom: marker e gruppi cluster scompaiono per èra ùtili al ripple `refreshClusters()` con timeout da 180ms.

## SOLUZIONE IMPLEMENTATA

1. **Modifica nel file `map-lit.js`:**
```javascript
// Prima versione problematica:
_map.on('zoomend', () => {
  this._clusterRefreshTimer = setTimeout(() => {
    this._markersLayer.refreshClusters();
  }, 180);
});

// Riparata:
_map.on('zoomend', () => this._markersLayer.refreshClusters());

### `stories/story-2.md` — STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore


# STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore

**Epic:** CI/CD — Release Automation
**Priority:** Should Have
**Story Points:** 5
**Status:** In Progress
**Assigned To:** Unassigned
**Created:** 2026-06-03
**Sprint:** 1

---

title: "STORY 001"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "STORY 001"
issues: []

### `stories/story.md` — STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore


# STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore

**Epic:** CI/CD — Release Automation
**Priority:** Should Have
**Story Points:** 5
**Status:** In Progress
**Assigned To:** Unassigned
**Created:** 2026-06-03
**Sprint:** 1

---

## User Story

As a **maintainer del monorepo**
I want to **uno stack di release semantic coerente e un changelog avanzato con report/grafici per contributore**
So that **le release non si duplichino e il contributo di ciascuno sia tracciato e visibile**

---

### `stories/xotbaseresourcetable-model-audit-batch-geo.story.md` — Story: Geo — audit `$model` + colonne su XotBaseResourceTable (batch-geo)


# Story: Geo — audit `$model` + colonne su XotBaseResourceTable (batch-geo)

**Fase BMAD**: Audit / qualità (verifica tipizzazione e schema, nessuna modifica
funzionale distruttiva).

**Contesto**: audit cross-modulo su tutte le classi `XotBaseResourceTable` per
confermare che dichiarino `protected static string $model = X::class;` con il
model corretto (autorevole = quello dichiarato sulla Resource sorella), e che
`getTableColumns()` referenzi solo colonne realmente esistenti sullo schema DB.

**Owned scope** (file toccati in questo batch, repo `module_geo_fila5`):
- `app/Filament/Resources/AddressResource/Tables/AddressesTable.php`
- `app/Filament/Resources/AddressResource/Tables/AddresssTable.php`
- `app/Filament/Resources/LocationResource/Tables/LocationsTable.php`

## Task 1 — `$mode
- digests/archive-parcheggio.md
- digests/archive-root-md-files.md
