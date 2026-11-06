---
title: "[STORY] Geo: app/Services eliminata, ogni metodo mappato su Action o Adapter con prova"
type: story
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Geo
tags: [services, queueable-action, adapters, geo, zombie, probe]
qmd: "geo services eliminati geoservice geodataservice geodatavalidator googlemapsservice basegeoservice equivalenza probe haversine"
related:
  - services-zombie-delete-wave3.story.md
  - ../architecture/actions-over-services.md
  - ../../../Tenant/docs/stories/services-to-actions-tenant.story.md
  - ../../../Xot/docs/bmad/services-to-queueable-actions-census.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Geo: app/Services eliminata, ogni metodo mappato su Action o Adapter con prova

Fase BMAD: Verify + Dev + Docs. Ultimo modulo del giro "services to queueable actions".

## Richiesta

Ordine dell'utente: le cartelle `laravel/Modules/<modulo>/app/Services/` non devono esistere, perche' un Service diventa una classe
senza confini mentre una Spatie QueueableAction ha un solo caso d'uso, un solo `execute()`, ed e' tipizzabile, accodabile e testabile da
sola. Le classi che non sono casi d'uso (adapter, validator, base class, contratti) non diventano Action finte: si ricollocano fuori da
`Services`. Per Geo: `BaseGeoService`, `GeoDataService`, `GeoDataValidator`, `GeoService`, `GoogleMapsService` (920 righe),
`HereService` gia' tolto prima.

## Stato trovato

Questa e' la quarta volta che i cinque file attraversano la working copy:

| Commit del modulo | Data | Effetto |
|---|---|---|
| `b1bc1fb3` | 2026-09-24 | aggiunti |
| `60524329` | 2026-10-08 | cancellati; nello stesso diff nascono `Adapters/GoogleMapsClient.php`, `Adapters/HereClient.php`, `Support/GeoApiEndpoints.php`, `Support/GeoDataConfig.php` e spariscono `tests/Unit/Services/*` |
| `32ff7286` | 2026-10-18 | riaggiunti (sync con `laraxot/dev`) |
| `05f8ba18` | 2026-10-20 12:48 | cancellati di nuovo (commit automatico del sync, 5 file, 920 righe) |

Il 2026-10-20 la cancellazione e' stata fatta nella working copy da un'altra sessione (lane `lane-svc-docs`, ore 12:43), i file sono
ricomparsi identici a `HEAD` alle 12:44:09 (la story wave3 parla di merge o staging; l'attore preciso non e' tracciato) e la stessa lane
li ha cancellati di nuovo; il commit automatico `05f8ba18` ha fissato la cancellazione. **Io non ho cancellato nessun file**: ho verificato che la cancellazione non perda comportamento, ho chiuso quello che
mancava (un difetto in un successore, test, docs) e ho documentato. Prima di qualunque verifica ho copiato i blob da `HEAD` in uno
scratchpad, cosi' la prova e' stata eseguita sul codice originale e non sulla memoria.

Blob recuperabili con `git -C laravel/Modules/Geo show <hash>` (presenti nell'albero del commit `5b92f7ee` e precedenti):

| File | Righe | Blob |
|---|---|---|
| `BaseGeoService.php` | 145 | `0570c29486295d68e9ca0305cb38e77a06426934` |
| `GeoDataService.php` | 253 | `d451087eedb6716a92b4e4f1dc9e5fb6fbd7f01d` |
| `GeoDataValidator.php` | 216 | `f7f63b8dd0aba29d4e9a1331a01a5a25aedf606f` |
| `GeoService.php` | 217 | `599d57dd0d31453cb929bca73f1f5ea05a7be465` |
| `GoogleMapsService.php` | 89 | `b83ca30b1e64ec8c998028f06cfbbdede9da356a` |
| `HereService.php` (gia' tolto, `b686930f`) | 74 | `e86e425caeb3d9ec66540c6de3976d22eaffc0ef` |

## Scopo dei cinque file

- `GeoService`: 8 metodi statici. Distanza tra due coordinate (formula GeoDataSource, miglia/km/miglia nautiche), espressione SQL
  haversine per `orderBy`, punto in poligono (ray casting) anche da stringa JSON, piu' un singleton con due campi statici
  (`$latitude_field`, `$longitude_field`) che servivano solo a `haversine()`.
- `GeoDataService`: legge `Modules/Geo/resources/json/comuni.json` (struttura `regions > provinces > cities`), la valida e serve
  regioni, province, citta', CAP con cache 24 ore.
- `GeoDataValidator`: regole di validazione Laravel del JSON piu' controllo di unicita' dei codici regione, provincia e citta'.
- `GoogleMapsService` + `BaseGeoService`: client HTTP Google Maps (reverse geocoding, distance matrix, elevazione) con cache,
  rate limit e retry nella classe base.

## Chiamanti (due metodi indipendenti, ogni zero ricontrollato)

1. `rg -P` su tutti i file non `.md` di `laravel` e `bashscripts`, esclusi `vendor`, `node_modules`, `storage`: FQCN con 1-4
   backslash (`Geo\\{1,4}Services\b`) e nomi corti con `\b`. Le cinque classi compaiono solo in: `coverage.xml` (artefatto generato),
   docblock "Sostituisce ..." di sei Action successori, i file `docs/*.cleaned`. Nessun `use`, nessun `::class`, nessuna stringa.
2. `git grep -w -I` sul repo padre e sul repo del modulo, esclusi `.md` e `.cleaned`: stesso insieme piu' `contribution_analysis.json`
   (report generato con i path dei file). Nessun test sotto `Geo/tests` li cita (la cartella `tests/Unit/Services` era sparita con
   `60524329`).
3. Dinamici: nessun binding nel `GeoServiceProvider`, nessuna voce in `_components.json` di Geo (sono di Commands e View Components),
   nessuna rotta, nessuna config; `GeoServiceProvider`, `EventServiceProvider`, `RouteServiceProvider` e `AdminPanelProvider` non
   hanno `bind`, `singleton` ne' alias. `rg 'Services'` su `Geo/app`, `tests`, `config`, `routes`, `resources` trova solo la facade
   `GeoServiceFacade`, un commento in `Transformers/GeoJsonResource.php` e chiavi `config('services.*')` che non c'entrano.
4. Altri moduli: `rg` su `Modules` e `Themes` per `Geo.{0,6}Services` fuori dalle docs: zero.

Il controllo e' stato fatto anche sui successori: i metodi che davvero girano in produzione sono pochi (vedi tabella), il resto delle
Action Geo e' coperto da test ma non chiamato dentro il monorepo.

## Decisione per metodo

Nessuna Action nuova: ogni metodo aveva gia' un successore, e quelli che non erano casi d'uso erano gia' stati ricollocati in
`Adapters/` e `Support/` dal commit `60524329`. Le decisioni sono quindi `reuse` o `relocate` (gia' fatto) o `retire`.

| Metodo originale | Decisione | Successore | Esito della prova |
|---|---|---|---|
| `GeoService::distance` | reuse | `Distance/CalculateGeoDistanceAction` (unico con chiamante vivo: `Models/Traits/GeoTrait.php`) e il gemello `Math/CalculateGeoDistanceAction` | uguali su 77 combinazioni (11 coppie di punti, di cui 5 con `null`, x 7 unita') |
| `GeoService::haversine` | reuse | `Math/GenerateHaversineSqlAction` (uguale); `Distance/BuildHaversineSqlAction` aveva un difetto, corretto (vedi sotto) | uguali a meno degli spazi |
| `GeoService::getInstance`, `setLatitudeField`, `setLongitudeField`, `setLatitudeLongitudeField` | retire | i nomi dei campi sono parametri di `execute()` | `haversine` con campi custom uguale |
| `GeoService::is_in_polygon` | reuse | `Polygon/IsPointInPolygonAction` e `Math/IsPointInPolygonAction` | uguali su 9 poligoni x 8 punti |
| `GeoService::pointInPolygon` | reuse | `Math/CheckPointInPolygonJsonAction` | uguali su 72 casi piu' 8 input JSON anomali, stesse eccezioni |
| `GeoDataValidator::validate` | reuse | `GeoData/ValidateGeoDataAction` | uguali su 10 dataset |
| `GeoDataValidator::getErrors` | reuse | `GeoData/GetGeoDataValidationErrorsAction` | uguali su 8 dataset invalidi, stessi messaggi italiani |
| `GeoDataValidator::checkIntegrity` | reuse | `GeoData/CheckGeoDataIntegrityAction` (e il doppione `ValidateGeoDataIntegrityAction`) | uguali su 10 dataset, duplicati inclusi |
| `GeoDataService::getRegions` | reuse | `GeoData/GetRegionsAction` | uguali |
| `GeoDataService::getProvinces` | reuse | `GeoData/GetProvincesAction` | uguali |
| `GeoDataService::getCities` | reuse con differenza di forma | `GeoData/GetCitiesAction` | **diverso**, vedi "Differenze" |
| `GeoDataService::getCap` | reuse | `GeoData/GetCapAction` | uguali |
| `GeoDataService::clearCache` | reuse | `GeoData/ClearGeoDataCacheAction` | uguali |
| `GeoDataService::loadData` (privato) | reuse | `GeoData/LoadGeoDataAction` | uguali, stesse eccezioni |
| `GoogleMapsService::reverseGeocode`, `getDistanceMatrix`, `getElevation` | relocate | `Adapters/GoogleMapsClient` (vivo: `FetchGoogleMapsElevationAction`) | uguali in successo, HTTP 500, JSON non array, chiave mancante, chiavi di cache |
| `BaseGeoService` (`getApiKey`, `makeRequest`, `buildHttpClient`, `getCacheKey`) | relocate | `Adapters/GeoHttpClientBase` | uguali (e' la base di `GoogleMapsClient`) |

Perche' `retire` per il singleton: `GeoService` teneva i nomi delle colonne in proprieta' statiche condivise da tutta la richiesta
(e da tutto il worker in Octane o in coda). Chi chiamava `setLatitudeField()` cambiava il comportamento di `haversine()` per chiunque
venisse dopo. Il successore riceve i nomi come argomenti e non ha stato.

## Prova di equivalenza (probe prima/dopo)

Script: `scratchpad/svc-geo/probe.php` della sessione (bootstrap reale dell'app senza DB, `CACHE_STORE=array`, base path su cartella
temporanea con fixture del JSON, `Http::fake` per Google). Carica le copie esatte dei blob originali (stesso hash di
`git hash-object`) e li confronta, input per input, con le Action e gli Adapter vivi. Risultato: **330 confronti uguali, 20 diversi**,
e i venti sono tutti spiegati:

| Diversi | Gruppo | Spiegazione |
|---|---|---|
| 2 | `haversine`: `Distance/BuildHaversineSqlAction` contro tutti gli altri | difetto reale, corretto qui |
| 8 | `getErrors`: `ValidateGeoDataIntegrityAction::getErrors` contro `GeoDataValidator` e `GetGeoDataValidationErrorsAction` | il doppione non passa i messaggi italiani (restano `validation.required`); i due che contano sono uguali |
| 4 | `getCities`: Service contro `GetCitiesAction` e `LoadGeoHierarchyAction::executeCities` | cambio di forma, vedi sotto |
| 6 | Google 500 e JSON non array: `GoogleMapsHttpAction` contro Service e Adapter | l'Action non antepone "Errore durante la richiesta a google_maps: " al messaggio; Service e Adapter sono identici |

Dentro i 330 uguali: tutte le eccezioni (classe e messaggio), i `null`, la cache scritta con la stessa chiave
(`geo_google_maps_<md5>`), `clearCache` che toglie solo `geo.regions`, e tutto il blocco GeoData sul file reale `comuni.json`.

### Difetto trovato e corretto: `Distance/BuildHaversineSqlAction`

Dichiarava di sostituire `GeoService::haversine()` ma produceva SQL sbilanciato: `cos(radians(45.1)` con una parentesi chiusa in
meno (13 aperte, 12 chiuse). Nessun chiamante di produzione lo usava, per questo non era mai emerso. Rosso prima (2 test falliti:
parentesi sbilanciate e diversa da `GenerateHaversineSqlAction`), verde dopo l'aggiunta di una sola `)`. File toccati:
`app/Actions/Distance/BuildHaversineSqlAction.php` (1 riga) e il test nuovo
`tests/Unit/Actions/Distance/BuildHaversineSqlActionTest.php` (3 test).

### Differenze che non ho appianato

- **`getCities` cambia forma.** Il Service restituiva una lista di `{name, code}` (come `getProvinces`); i due successori restituiscono
  la mappa `codice => nome` (come le regioni), e lo dichiarano nel docblock. Le due forme usano la stessa chiave di cache
  `geo.cities.<provincia>`: se qualcosa avesse mai popolato la cache col Service, l'Action leggerebbe per 24 ore la forma sbagliata.
  Non e' successo (il Service non aveva chiamanti). Ho tenuto la forma delle Action perche' e' quella di tutti e due i successori; se
  un consumatore serve la lista, il blob `d451087e` ha il codice originale.
- **`comuni.json` reale non e' nel formato atteso.** Il file e' una lista piatta di comuni (`nome`, `sigla_provincia`, `cap`, ...); il
  codice vuole `{"regions": [{"provinces": [{"cities": [...]}]}]}`. Con il file vero ogni metodo GeoData, vecchio e nuovo, lancia
  `RuntimeException: Il file JSON dei comuni non è valido`. Il comportamento e' preservato (identico), ma la funzione e' inerte sui dati
  reali. Non e' una regressione di questa story.
- **`GeoServiceFacade` non e' collegata.** Accessor `'geo.service'`, nessun binding in tutto il repo, nessun chiamante, e i quattro
  `@method` del docblock (`getAddressFromCoordinates`, `getCountryCode`, ...) non esistono. La story `services-zombie-delete-wave3`
  scrive che "punta ad Action": non e' cosi'. Non l'ho toccata (fuori dai cinque file).

## Duplicati interni a Geo (segnalati, non cancellati)

Coppie con output identico o quasi: `Distance/CalculateGeoDistanceAction` e `Math/CalculateGeoDistanceAction`;
`Distance/BuildHaversineSqlAction` e `Math/GenerateHaversineSqlAction`; `Polygon/IsPointInPolygonAction` e
`Math/IsPointInPolygonAction`; `GeoData/CheckGeoDataIntegrityAction` e `GeoData/ValidateGeoDataIntegrityAction`;
`GoogleMaps/GoogleMapsHttpAction` e `Adapters/GoogleMapsClient`; `Bing/GetAddressFromBingMapsAction` e `BingMaps/...`;
`GeoData/LoadGeoHierarchyAction` e il quartetto `GetRegions/GetProvinces/GetCities/GetCap`. `LoadGeoHierarchyAction` e
`GoogleMapsHttpAction` espongono piu' metodi pubblici (`executeRegions`, `executeReverseGeocode`, ...) invece di un solo `execute()`: sono
Service con altro nome, da dividere o ritirare. Decisione per ciascuna coppia: all'owner del modulo.

## Modifiche

- `app/Services/` (5 file): assente nel commit `05f8ba18`; nessun `.bak`, nessun segnaposto. Verificato con `ls` e con `find` su
  `laravel/Modules` e `laravel/Themes` (nessuna cartella `*/app/Services` in tutto il monorepo).
- `app/Actions/Distance/BuildHaversineSqlAction.php`: parentesi mancante.
- `tests/Unit/Actions/Distance/BuildHaversineSqlActionTest.php`: nuovo.
- Docs: questa story; link negli indici `00-INDEX.md`, `INDEX.md`, `stories/index.md`; voce in `decision-log.md`; nota di stato sulle
  guide che citavano le classi come vive (elenco sotto). `services-zombie-delete-wave3.story.md` non e' stata toccata: un'altra lane
  la stava modificando in quel momento. Sue imprecisioni da correggere dall'owner: dice che la facade "punta ad Action" (l'accessor
  `geo.service` non e' collegato) e indica `ValidateGeoDataIntegrityAction` come unico successore di `GeoDataValidator` (copre
  `checkIntegrity`, non `getErrors` coi messaggi italiani).

### Docs corrette

Guide con esempi che usavano le classi ritirate, ora con una nota che rimanda a questa story: `json-database.md`,
`json_database.md`, `json-usage.md`, `json_usage.md`, `best-practices.md`, `best_practices.md`, `BEST_PRACTICES.md`,
`addressresource_improvements.md`, `addressresource-improvements.md`, `address-resource-improvements.md`, `services/geocoding.md`,
`phpstan.md`. Le coppie con nome diverso e contenuto uguale sono duplicati (snake_case e kebab-case dello stesso file): segnalati, non
unificati.

Non toccate, perche' sono cronaca di un momento passato (analisi, roadmap PHPStan, log di conflitti, story): `phpstan/*`,
`phpstan-*.md`, `analysis/*`, `code-quality*.md`, `complexity-refactoring-plan.md`, `merge-conflicts/*`, `git-conflicts/*`,
`stories/phpstan-*`, `wiki/log.md`, `todo.md`, `stabilization-roadmap.md`, `ponytail-audit.md`, `roadmap-vision.md`,
`analisi-moduli-ottimizzazioni.md`, `farmshops-integration-analysis.md`, `PHILOSOPHY.md`, `README.md.cleaned`, `readme.md.cleaned`
(questi ultimi due sono avanzi di una pulizia e hanno ancora un albero con `Services/`).

## const e mixed

Nei file che ho scritto: nessuna `const`, nessun `mixed`, nessun `@phpstan-ignore`. Nessuna `->label()`.

## Verifica

- `ls laravel/Modules/Geo/app/Services`: `No such file or directory`.
- `find laravel/Modules laravel/Themes -type d -path '*/app/Services'`: nessun output.
- Pest: `BuildHaversineSqlActionTest` e `GeoMathActionsTest`, 9 passati (11 asserzioni).
- `php -l` sui due file toccati: nessun errore.
- PHPStan, solo `laravel/phpstan.neon`, dal gate condiviso (`flock` + `nice -n 10`, `--memory-limit=2G`) su tutto `Modules/Geo`:
  exit 0, output vuoto. Una prima passata aveva trovato un errore nel mio test (`preg_replace` non Safe), corretto con
  `use function Safe\preg_replace`; la passata finale e' a 0. Nessun baseline, nessun ignore, `Geo/phpstan-baseline.neon` non usato
  ne' toccato.
- Riferimenti residui alle cinque classi: zero con entrambi i metodi (sopra), tranne docblock, `coverage.xml`,
  `contribution_analysis.json` e docs storiche.

## Rischi

- **Terza risurrezione possibile.** I file sono tornati due volte in dieci giorni da merge di `laraxot/dev`. Il ref locale
  `laraxot/dev` oggi non li contiene (verificato con `git ls-tree`), ma cinque rami `dependabot/*` si': un merge da quelli li
  riporterebbe. Controllare `git status` del modulo dopo ogni pull.
- **Classmap di Composer vecchia.** `laravel/vendor/composer/autoload_classmap.php` elenca ancora i sei path (come quelli di Tenant);
  `vendor` non e' tracciato. Chi ha un autoload ottimizzato e fa `class_exists('Modules\Geo\Services\GeoService')` otterrebbe un
  warning di include: serve `composer dump-autoload`, che non ho lanciato perche' tocca tutto il monorepo.
- **Il Service e' sparito prima della mia verifica.** Se la cancellazione fosse stata sbagliata non avrei potuto fermarla; la prova
  ha dato esito positivo, ma l'ordine "verifica poi cancella" non e' stato rispettato dalla sessione che ha cancellato.

## Aperto per l'owner di Geo

1. Forma di `getCities`: lista di coppie o mappa `codice => nome`? (cambiare un successore e' una modifica di contratto.)
2. `comuni.json` reale e codice GeoData non combaciano: convertire il file o la logica?
3. `GeoServiceFacade`: collegarla a un'Action o ritirarla.
4. Quale gemello tenere per ciascuna coppia di duplicati sopra, e se dividere `LoadGeoHierarchyAction` e `GoogleMapsHttpAction`.
5. `ValidateGeoDataIntegrityAction::getErrors` senza messaggi italiani: allinearlo o ritirarlo insieme al doppione.
