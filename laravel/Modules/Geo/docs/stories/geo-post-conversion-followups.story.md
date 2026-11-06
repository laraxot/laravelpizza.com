---
title: "Geo: seguiti dopo la conversione dei Service (forma dei dati, test, ignore)"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Geo
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: [test-database-guard, xot-test-harness-truth]
related: [services-to-actions-geo, services-zombie-delete-wave3, dcp-242-test-actions-geo-contro-firme-reali, docs-organization-geo]
tags: [geo, services, getCities, comuni-json, facade, classmap, phpstan-ignore, refresh-database, test, blueprint, ratchet-w1, ratchet-w2]
qmd: "geo seguiti conversione service getCities comuni.json formato regions GeoServiceFacade classmap HasAddress HasPlaceTrait EnsuresGeoDatabaseSchema comunetest GeoApiTest RefreshDatabase blueprint"
---

# Geo: seguiti dopo la conversione dei Service

Fase BMAD: Plan (scheda di lavoro per domani). La conversione dei Service e' nella story `services-to-actions-geo.story.md`, di un'altra sessione: NON si tocca e NON si ripete. Qui solo cio' che resta, riverificato sul disco il 2026-10-20 13:50-14:10 UTC (cifre volatili). Nessun PHP, Pest o PHPStan eseguito per scriverla.

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' del codice con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo, non il messaggio d'errore.

## Scopo
Geo risolve indirizzi, coordinate, distanze e la gerarchia regione > provincia > comune (dati da `resources/json/comuni.json`). I cinque Service sono spariti, i loro compiti stanno in Action (`Actions/GeoData/*`, `Distance`, `GoogleMaps`). Il rischio dopo una conversione e' che restino punti dove due pezzi di codice leggono lo stesso dato in due forme, test che provano un mondo che non c'e', e silenziatori messi per non guardare. Capire quale consumatore e' quello vero decide cosa si corregge.

## Stato misurato
- `getCities`: la funzione non esiste piu' (`rg -n 'function getCities' Modules/Geo/app` vuoto). Successori con la forma `codice => nome`: `Actions/GeoData/GetCitiesAction.php:24-26` e `LoadGeoHierarchyAction.php:59-61`; le province restano `{name, code}` (`:45`). Stessa chiave di cache `geo.cities.%s` (`Support/GeoDataConfig.php:28`) in entrambi. Chiamanti in `app`: zero; solo `tests/Unit/Actions/GeoData/LoadGeoHierarchyActionTest.php`.
- `resources/json/comuni.json` (2262 byte): lista piatta di 4 comuni (`id`, `nome`, `cap`, `provincia`, `regione`, ...), non `{"regions":[{"provinces":[{"cities":[]}]}]}`. Lo leggono in forma piatta `Models/{Region.php:60,Province.php:59,Locality.php:57,Comune.php:127}` e `GeoJsonModel.php:21`; lo leggono in forma ad albero `LoadGeoDataAction.php:44` (richiede `$data['regions']`) e quindi tutte le Action `GeoData`. Il record 4 (Bresso) ha valori con virgolette letterali (`"cap": "\"20091\""`, `"provincia": "\"Milano\""`). `Console/Commands/SushiCommand.php:63` cerca `base_path('database/content/comuni.json')`, che non esiste.
- `Facades/GeoServiceFacade.php:25` accessor `'geo.service'`: nessun binding (`rg -n "geo\.service"` solo il file), zero riferimenti in codice, config, test, json. Non e' un guasto vivo: e' irraggiungibile. `Contracts/GeocodingServiceInterface.php` zero riferimenti; `GeocodingServiceContract.php` solo `UI/app/Adapters/Map/NullGeocodingServiceAdapter.php`.
- Classmap: `laravel/vendor/composer/autoload_classmap.php` (10:37) ha ancora 6 path Geo inesistenti (`Modules\Geo\Services\{BaseGeoService,GeoDataService,GeoDataValidator,GeoService,GoogleMapsService,HereService}`); altrove Xot 21, Tenant 6, Notify 2, Lang 2, User 2, UI 1.
- `@phpstan-ignore` residui: 7. `Models/Traits/HasAddress.php:221,243` (`missingType.iterableValue`, ma il docblock dichiara `array<string, mixed>`), `:232,249` (`argument.type` su `create($data)`/`update($data)`); `Models/Traits/HasPlaceTrait.php:18,24` (`-next-line` nudo su `morphOne`/`morphMany`); `tests/Support/EnsuresGeoDatabaseSchema.php:10` (nessun test lo usa). `HasAddress` non ha consumatori in `Modules/*/app`; `HasPlaceTrait` solo test e `tests/Fixtures/Traits/HasPlaceTraitPhpstanProbe.php`.
- Test: `tests/Unit/Models/ComuneTest.php` (neutralizzato, 2 skip) e `comunetest.php` (4 test veri su `findByNome`, `findByCap`, `getComuniByProvincia`, `findComune`; mai raccolto per il suffisso); `ComuneModelTest.php` esiste. `RefreshDatabase` con `Tests\TestCase` radice in 4 file: `Feature/GeoApiTest.php:10`, `Unit/Actions/Geocoding/GeocodeAddressActionTest.php:10`, `Unit/Actions/GeoData/CheckGeoDataIntegrityActionTest.php:10`, `ValidateGeoDataActionTest.php:11` (`rg -n 'RefreshDatabase' Modules/Geo/tests`). `GeoApiTest`: 7 test su `/api/geo/{geocode,reverse,suggestions,distance,elevation}`; `routes/api.php` e `web.php` contengono solo `declare(strict_types=1)`.
- Filament: 58 file in `app/Filament`; `docs/bmad/filament-blueprint.md` ESISTE (tracciato dal 2026-10-16) ma elenca 2 Resource e nessuno dei 7 widget, 8 pagine, 1 blocco, 1 campo, 1 form. `extends` diretti: 0. Stringhe: 6 letterali (`Blocks/MapBlock.php:29,31,36`; `Widgets/LocationMapTableWidget.php:14`, `LocationMapWidget.php:33`, `Resources/LocationResource/Pages/ListLocations.php:14`) e 8 chiavi passate come testo a `->label()`/`->placeholder()` (`Forms/LocationForm.php:39-83`).

## Lavoro
1. **Forma di `getCities`**: nessun consumatore, quindi non c'e' contratto da rompere; tenere `codice => nome` e cancellare il doppione fra `GetCitiesAction` e `LoadGeoHierarchyAction::executeCities`. Rischio basso. Decisione 1.
2. **`comuni.json`**: decidere chi e' il consumatore vero (modelli piatti o Action ad albero) e adeguare l'altro; correggere le virgolette del record 4; capire se `SushiCommand` va ripuntato o cancellato. Rischio medio (il file e' la sola fonte). Decisione 2.
3. **`GeoServiceFacade` e `GeocodingServiceInterface`**: cancellare (zero riferimenti, regola 25). Rischio basso.
4. **Classmap**: `composer dump-autoload` richiede il via dell'utente (`post-autoload-dump` esegue `artisan package:discover` e `filament:upgrade`). Nel frattempo i 6 path stantii danno un warning solo se qualcuno fa `class_exists` su quei nomi.
5. **7 ignore**: non aggiungere altro. `EnsuresGeoDatabaseSchema` (zero consumatori) si cancella. Per `HasAddress` e `HasPlaceTrait`: o si tengono con tipi veri (`@return MorphOne<Place, $this>`, `@param array<string, mixed>` gia' presente) e senza ignore, o si cancellano con `TraitsTest` e il probe (decisione 3). Rischio basso.
6. **Test**: `comunetest.php` -> portare i 4 test in `ComuneModelTest.php` (o rinominarlo `ComuneReadApisTest.php`) e cancellare `ComuneTest.php` solo dopo il diff; i 4 `RefreshDatabase` -> `Modules\Geo\Tests\TestCase` con `DatabaseTransactions`, senza `migrate:fresh`; `GeoApiTest` -> stub `->skip('/api/geo/* not implemented')` (mai creare route per far passare un test). Rischio medio.
7. **Blueprint**: elencare widget, pagine, blocco, campo, form; togliere ogni dubbio sulla regola 2 con le 14 stringhe (6 letterali in `lang/<locale>/`, 8 chiavi senza `__()`: verificare a schermo se la base le traduce). Rischio basso.

## Acceptance criteria
- [ ] `rg -n 'function getCities|GeoServiceFacade|GeocodingServiceInterface' Modules/Geo/app` non stampa nulla (tranne cio' che si decide di tenere).
- [ ] `rg -n '@phpstan-ignore' Modules/Geo/app Modules/Geo/tests` non stampa nulla.
- [ ] `rg -n 'RefreshDatabase' Modules/Geo/tests` non stampa nulla.
- [ ] `find Modules/Geo/tests -name 'comunetest.php'` non stampa nulla e i 4 test sono in un `*Test.php`.
- [ ] `rg -n '/api/geo' Modules/Geo/tests/Feature/GeoApiTest.php` mostra solo test con `->skip(`.
- [ ] Il lettore di `comuni.json` ha una sola forma: `python3 -I -c "import json;d=json.load(open('Modules/Geo/resources/json/comuni.json'));print(type(d).__name__)"` coincide con la forma letta da tutte le Action e i modelli.
- [ ] Dopo il via: `python3 -I` sul classmap non trova piu' path Geo mancanti.

## Verifica
Rilanciare i comandi di "Stato misurato" (qualunque zero con il `rg` ripetuto su un caso noto, es. `rg -n 'GeoServiceFacade'` deve trovare il file stesso prima della cancellazione). PHPStan mirato sui file toccati, in coda `flock`; nessun Pest finche' i vincoli non cadono.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta.
- PHPStan solo mirato e in coda `flock` di `11-phpstan.md`; un solo run completo a swarm fermo e a RAM libera. `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP. Forward-only. Pest resta Pest. `services-to-actions-geo.story.md` non si modifica.
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.

## Decisioni aperte
1. Forma delle citta': mappa (oggi) o lista `{name, code}` come le province? 2. `comuni.json`: convertire il file all'albero, o far leggere l'albero dalle Action partendo dalla lista piatta? E i 4 record sono dati di prova o i soli comuni previsti? 3. `HasAddress`/`HasPlaceTrait`: tenere (API per i modelli di altri progetti) o cancellare. 4. `composer dump-autoload`: quando e chi. 5. Le 5 domande lasciate dalla story della conversione (gemelli duplicati `Distance`/`Math`, `ValidateGeoDataIntegrityAction::getErrors`) restano di quella story.

## Come ripartire
1. Rilancia i comandi di "Stato misurato", annota le differenze in fondo, e porta le decisioni 1-3 all'utente.
2. Parti da cio' che non dipende da nessuna decisione: voci 3 e 5 (cancellare `GeoServiceFacade`, `GeocodingServiceInterface`, `EnsuresGeoDatabaseSchema`), con `rg -w` a due metodi prima.
3. Poi i test (voce 6) senza eseguirli: diff di `comunetest.php`, sostituzione di `RefreshDatabase`, stub di `GeoApiTest`.
