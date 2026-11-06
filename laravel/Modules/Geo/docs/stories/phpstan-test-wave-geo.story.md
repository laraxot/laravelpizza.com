---
title: "[STORY] PHPStan Geo, lane geo della regressione da pull (483 errori a 0)"
type: story
status: review
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Geo
tags: [phpstan, tests, pull, regressione]
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - ./phpstan-cleanup-geo.story.md
  - ./conflict-markers-business-logic-tests.story.md
---

# PHPStan Geo: lane geo

Bucket `geo` del run PHPStan del 2026-10-20: 30 file, 483 errori nella baseline delle 09:00. Dopo la lane: 0 errori sui file presenti alla misura finale (`tests/Unit/Traits/TestModel.php` e' stato rimosso da questa lane; `app/Traits/HasAddresses.php`, `app/Models/Traits/SushiToJsons.php` e `GeographicalScopes.php` sono stati rimossi dopo da un'altra sessione; misura finale su 26 file). Coordinamento del run: vedi la story di Xot in `related`.

## Cosa e' successo

Il pull dei sottomoduli delle 08:57 ha riscritto la working copy di Geo con una versione diversa da `HEAD` (`6fde33ea`): 165 file di `app/` e 42 di `tests/` differiscono da `HEAD`. Le differenze sono di tre tipi, e ciascuna e' una causa sola.

## Cause e correzioni

Quadratura della baseline (483): 50 + 19 (punto 1), 2 (punto 2), 12 (punto 3), 371 (punto 4), 23 (punto 5), 3 (punto 6) e 3 su tre trait poi rimossi da un'altra sessione.

### 1. Alias `@phpstan-type` usati come tipo nativo (50 errori in produzione, 19 nei test collegati)

Una riscrittura automatica ha sostituito `: array` con il nome dell'alias dichiarato nel docblock (`GeoDataset`, `GeoDatasetStats`, `GeoFeature`, `GeoProperties`, `GeoMapConfig`). Quei nomi non sono classi (`rg -P` su `app` e `tests`: nessuna dichiarazione `class|interface|trait|enum`). A runtime ogni chiamata sarebbe stata un `TypeError` in uscita.

Scopo del codice: normalizzare il GeoJSON del widget mappa (`resources/data/geo-map-widget.geojson`) in un dataset tipizzato e calcolarne categorie e statistiche. Il tipo preciso vive nel docblock, quello nativo deve restare `array`.

Corretto in quattro file, solo le firme: `app/Support/GeoMapDataset.php`, `app/Actions/Maps/LoadGeoMapDatasetAction.php`, `app/Actions/Geo/GeoMapDatasetAction.php`, `app/Filament/Widgets/GeoMapWidget.php`. Le firme native sono di nuovo identiche a `HEAD`. Spariscono anche gli errori nei cinque test che leggono quei valori (`GeoMapDatasetTest`, `GeoMapDatasetActionsTest`, `Unit/Filament/GeoMapWidgetTest`, `Unit/Filament/Widgets/GeoMapWidgetTest`, `GetAddressDataFromFullAddressActionTest`).

### 2. Docblock `/** @var */` degradati e tipo di ritorno stretto (2 errori)

- `database/seeders/GeoJsonDownloader.php`: due `/** @var array<string, mixed> */` erano diventati `/* @var */` (commento semplice, nessun effetto per PHPStan). Ripristinati.
- `app/Actions/GetAddressDataFromFullAddressAction.php`: `execute()` era diventato `: AddressData` ma l'ultimo ramo ritorna `null` (nessun provider risponde, e `UpdateClientCoordinatesBulkAction` gestisce il caso). Ripristinato `?AddressData` come in `HEAD`, docblock `@return AddressData|null`.

### 3. Servizi rimasti nella working copy ma eliminati in `HEAD` (12 errori)

`app/Services/GeoDataService.php`, `GeoDataValidator.php`, `GeoService.php`, `HereService.php` sono stati eliminati dal commit `60524329` (2026-10-08) e sostituiti da Action (`LoadGeoHierarchyAction`, `ValidateGeoDataIntegrityAction`, `IsPointInPolygonAction`, `GetHereRouteDurationAndLengthAction`, come dice il decision log di Geo). Il pull li ha riportati. Nessun file del repo li chiama (`rg` su moduli, app, config, routes, tests).

Corretti sul posto (regola 4 del run), senza creare Service nuovi:

- `GeoDataService`, `GeoDataValidator`, `HereService`: contenuto del blob `60524329^` (scritto con `git show` su file). Il blob ha ancora un errore in `getCities()` (`pluck('name','code')` ritorna `Collection<string,string>`, il docblock dichiara righe `array{name, code}`): ora `getCities()` ritorna le righe come `getProvinces()`, e il ramo vuoto e' tipizzato come li'. Nessun chiamante, nessun cambio osservabile.
- `GeoService`: `@param array<mixed> $polygon` e `$c = false` al posto della catena `$i = $j = $c = 0` (le assegnazioni a `$i` e `$j` erano riscritte subito dal `for`).

Copia dei file come erano prima della lane: `scratchpad/geo-backup/` della sessione.

### 4. Test riespansi dal pull (371 errori) ripristinati da `HEAD`

I test della working copy erano scaffold: colonne inventate (`model_type`, `is_primary`, `extra_data`), `Country`/`City` mai esistiti, `shouldReceive()` su una Action concreta, `Tests\TestCase` al posto di `Modules\Geo\Tests\TestCase`, ignore `@phpstan-ignore` non corrispondenti. I blob di `HEAD` (cioe' lo stato dell'8 ottobre, a 0 errori) sono stati scritti sui file con `git show HEAD:<path> > <path>`, mai `checkout` o `restore`:

| File | Errori prima | Note |
|---|---|---|
| `tests/Unit/Models/ComuneTest.php` | 90 | `Comune::factory()` e `mixed` |
| `tests/Unit/Models/comunetest.php` | 90 | stessa causa (due file che differiscono per maiuscole) |
| `tests/Unit/AddressModelTest.php` | 52 | |
| `tests/Unit/Models/AddressTest.php` | 47 | |
| `tests/Feature/AddressIntegrationTest.php` | 28 | colonne inventate |
| `tests/Unit/Actions/CalculateDistanceActionTest.php` | 28 | `shouldReceive` su Action concreta |
| `tests/Pest.php` | 18 | helper su `Country` e `City`, classi inesistenti |
| `tests/Unit/Actions/GetCoordinatesActionTest.php` | 11 | |
| `tests/Unit/Models/BaseModelTest.php` | 4 | |
| `tests/Unit/Traits/HasAddressTest.php` | 3 | duplicava la fixture `HasAddressTestModel` |

Tutti identici a `HEAD` (`git diff --quiet HEAD -- <file>`).

### 5. `LookupPlaceActionTest` (23 errori): test riscritto, non solo ripristinato

`HEAD` ha un file di 9 righe con solo `uses(TestCase::class)` (nessun test). `LookupPlaceAction` esiste e il test della working copy era valido nell'intento ma pieno di `@phpstan-ignore`, `json_encode` non Safe e user agent sbagliato (`<main module>/1.0`, mentre l'Action manda `Xot/1.0`). Riscritto sul modello di `ReverseGeocodeActionTest`: client Guzzle con `MockHandler` iniettato per riflessione, nessuna rete. Cinque test: location dall'OSM id, endpoint e query e user agent, risultato vuoto (`RuntimeException`), errore HTTP 503, errore di rete. PHPStan sulla cartella `tests/Unit/Actions/Nominatim`: 0.

### 6. `tests/Unit/Traits/TestModel.php` (3 errori): rimosso

Classe `TestModelTest extends PHPUnit\Framework\TestCase` in un file chiamato `TestModel.php`, con tabella `test_models` (e' dell'Activity, non di Geo) e un modello duplicato della fixture canonica `tests/Fixtures/Traits/HasAddressTestModel.php`. `HEAD` non ha il file: il commit `60524329` lo aveva eliminato. Rimosso dalla working copy. Recupero: `git -C laravel/Modules/Geo show b1bc1fb3:tests/Unit/Traits/TestModel.php`. La copia pre-lane e' anche in `scratchpad/geo-backup/`.

## Verifica

- PHPStan con `--error-format=json` su tutti i file presenti del bucket (29 alla prima misura, 26 all'ultima), a batch di 8: 0 errori file, 0 generali. Lo script scrive il totale dal JSON, non da un filtro su testo (un primo conteggio con filtro `grep` aveva dato uno zero falso: i path erano passati a PHPStan come un unico argomento).
- `php -l` pulito su tutti i file toccati.
- Pest (`--no-coverage`, solo test senza DB):
  - `LookupPlaceActionTest` (nuovo) e `ReverseGeocodeActionTest`: 9 passati, 2 `todo`.
  - `Unit/Support/GeoMapDatasetTest` e `Unit/Actions/Maps/GeoMapDatasetActionsTest`, che esercitano le quattro firme ripristinate al punto 1: 6 passati.
  - Non lanciati i test ripristinati da `HEAD` che usano il DB (`quaeris_data_test` non esiste).

## Aperto, per decisione dell'utente

1. **Servizi risorti.** Il decision log di Geo (2026-10-08) dice che i servizi di `app/Services`, `SushiToJsons.php` e `GeographicalScopes.php` restano eliminati. Il pull aveva riportato 6 servizi (`BaseGeoService`, `GeoDataService`, `GeoDataValidator`, `GeoService`, `GoogleMapsService`, `HereService`) e i due trait. `SushiToJsons` e `GeographicalScopes` (e `app/Traits/HasAddresses.php`, tutti nel bucket con 1 errore) sono stati rimossi dopo le 09:50 da un'altra sessione, non da questa lane. I 4 servizi del bucket sono tipizzati sul posto e non cancellati; `BaseGeoService` e `GoogleMapsService` non sono nel bucket. Proposta: eliminarli come i due trait, in coerenza con la regola no-services.
2. **Riscrittura automatica del pull.** `app/` differisce da `HEAD` per +2432 / -840 righe, soprattutto stile (Yoda, `new X()`, docblock `@param` compattati). Oltre ai casi corretti qui, 8 file hanno ancora `/* @var` al posto di `/** @var`: oggi a 0 errori, ma il tipo e' perso. Non toccati.
3. **Quattro test del widget rossi, non per i tipi.** `Unit/Filament/GeoMapWidgetTest` (3 su 4) e `Unit/Filament/Widgets/GeoMapWidgetTest` ("exposes expected view") falliscono con `Target [Illuminate\Contracts\View\Factory] is not instantiable` (il widget e' istanziato con `new` senza applicazione avviata, nel costruttore di `XotBaseWidget`) e con la vista `xot::filament.widgets.base` al posto di `geo::filament.widgets.geo-map-widget`. Erano gia' rossi a monte dei tipi (con gli alias come tipo nativo il TypeError sarebbe arrivato dopo). Non toccati: serve decidere se il widget ha un `$view` proprio o se il test va allineato.

## Seconda passata: lane `phpstan-wave-geo`

Stessa giornata, stesso modulo, baseline piu' recente (2026-10-20 09:00, quella del coordinatore `phpstan-test-wave-regression`): **338 errori in 15 file** (335 nei test, 3 in produzione). Stato alla fine: `phpstan analyse Modules/Geo` esce 0 senza output (vedi Verifica). Le cause dei 335 errori nei test sono quelle del punto 4 qui sopra: la baseline misurava le bozze del pull, che la prima passata aveva gia' riportato a `HEAD`.

### Cosa ho trovato all'arrivo (09:44)

- Undici lock `geo-phpstan` / agent `geo` (creati alle 09:40:44) sui test del bucket. Hanno meno di 60 minuti, quindi vivi: non li ho toccati. Rilasciati entro le 09:49; da allora ho rimisurato.
- Rimisura prima di ogni edit, 09:55, sugli 11 file test del bucket (`phpstan analyse` mirato, `--error-format=raw`): exit 0, nessuna riga. Dieci dei file erano identici ai blob di `HEAD` (ora nove: ho riscritto `ComuneTest.php`); `LookupPlaceActionTest.php` e' la riscrittura del punto 5; `TestModel.php` non c'e' piu' (punto 6).
- La baseline contava per identificatore: `property.nonObject` 86, `offsetAccess.nonOffsetAccessible` 54, `method.nonObject` 53, `staticMethod.notFound` 27, `argument.templateType` 23, `pest.expectation.redundant` 18, `property.notFound` 16, `ignore.unmatchedLine` 14, `method.notFound` 9, `argument.type` 7, `class.notFound` 6, `theCodingMachineSafe.function` 5, `trait.unused` 3, altri 15. Una causa sola per file, non 338 problemi.

### Corretto

1. **Tre trait morti riportati dal pull (3 errori `trait.unused`)**: `app/Models/Traits/GeographicalScopes.php`, `app/Models/Traits/SushiToJsons.php`, `app/Traits/HasAddresses.php`. Vengono da `laraxot/dev` (commit `32ff7286`, 2026-10-18, non antenato di `HEAD`); `HEAD` non li ha dal 2026-09-24 e il decision log del 2026-10-08 ha deciso di eliminarli.
   - Scopo di ciascuno e sostituto: `GeographicalScopes` (distanza con float interpolati in SQL) e' coperto da `GeoTrait::scopeWithDistance`, che usa binding; `SushiToJsons` di Geo (caricava `comuni.json` con `Cache::remember`) e' una copia di `Modules\Tenant\Models\Traits\SushiToJsons`, e `Comune` usa `SushiToJson` di Tenant; `HasAddresses` duplica `HasAddress`, il trait canonico (`HasAddressesTest` e `TraitsTest` lo dicono nel commento).
   - Gate di `42-delete-obsolete-files-safely`: `rg -P` e `/bin/grep -rnw` su moduli, temi, app, config, routes, `composer.json` (docs e vendor esclusi) concordano, restano solo la definizione e due commenti nei test; l'unico FQCN fuori dal codice e' `laravel/coverage.xml` (generato). Lock preso e file non caldi. I blob restano nell'indice del modulo (`db706ac2`, `07d3feb3`, `6c1df939`) e in `32ff7286`, quindi la rimozione e' recuperabile in avanti.
   - Nota sullo stato git: nell'indice del modulo i tre file sono `A` (arrivati dal pull) e ora `AD`. Chi committa l'indice com'e' li rimette; per toglierli davvero servono `git rm --cached` o `git add -A` su quei tre path.
2. **`tests/Unit/Models/ComuneTest.php`: 69 commenti di ignore PHPStan che coprivano una specifica fantasma.** Il file (identico a `HEAD`, blob `fafb1aa9`) era a 0 errori solo per quegli ignore: chiamava `Comune::byRegion()`, `byProvince()`, `byCap()`, `byName()`, `byExactName()` e otto combinazioni, che su `Comune` non esistono e non sono mai esistiti (`git log --all -S'function byRegion' -- app/Models/Comune.php` e' vuoto). Solo `byRegion`, `byProvince` e `byCap` esistono, come metodi statici di `ComuneJson`, che restituisce collection di array e non un builder. Gli stessi 16 scenari (caricamento, 12 filtri, create, update, delete) sono gia' in `ComuneModelTest.php`, scritto in Pest con le API reali di `Comune`. Scala delle decisioni, punto 3: il file diventa un'intestazione che spiega il motivo e due `it(...)->skip(...)`; zero ignore. Il corpo vecchio resta in git (`fafb1aa9` in `HEAD`, `5e25f92a` in `laraxot/dev`, ultimo commit `60524329`).
3. **Docs rese false dalla rimozione dei trait** (nessun file cancellato): `traits/has-addresses.md` (avviso di superseded in testa), `model-classification.md` e `models/model-classification.md`, `model-factory-seeder-audit.md` e `models/model-factory-seeder-audit.md`, `geo-models-domain-analysis.md`, `migration-guide.md` e `migration_guide.md` (l'import nell'esempio ora punta al trait di Tenant). Story collegata da `stories/index.md` e da `INDEX.md`.

### I due gemelli `ComuneTest.php` e `comunetest.php`

| Fatto | `ComuneTest.php` | `comunetest.php` |
|---|---|---|
| Tracciato in `HEAD` e in `laraxot/dev` | si (blob `fafb1aa9` / `5e25f92a`) | si (blob `a33e577b` / `f7cfca41`) |
| Contenuto | classe PHPUnit, scope fantasma | Pest, API reali: `findByNome`, `findByCap`, `getComuniByProvincia`, `findComune` |
| Identici | no, `sha256sum` diversi (12496 byte contro 1365) | |
| Residuo del pull del 2026-10-20 o di un filesystem case-insensitive | no: sono due file distinti in `HEAD`, creati in commit diversi lo stesso 2026-01-20 (`a97bbf8b` ore 11:16 `ComuneTest.php`, `a6f5a52c` ore 21:34 `comunetest.php`, allora 317 righe) | |
| Eseguito da Pest/PHPUnit | si | **no**: `phpunit.xml` radice usa `suffix="Test.php"` (maiuscola), `comunetest.php` non lo soddisfa su filesystem case-sensitive |

Non sono duplicati, quindi nessuna dedup secondo `42` (non identici). Entrambi a 0 errori. Li ho corretti per scopo come sopra e non li ho rinominati. Su un checkout case-insensitive (macOS, Windows) i due path collidono e uno sovrascrive l'altro.

### Verifica della seconda passata

- Mirato sugli 11 file test, 09:55: exit 0, output vuoto. Mirato su `ComuneTest.php` e `comunetest.php` dopo la riscrittura: exit 0. Primo tentativo fallito per mia colpa: il letterale `@phpstan-ignore` scritto nel commento di intestazione veniva letto come tag (`ignore.parseError`); riformulato.
- `php -l` su `ComuneTest.php`: pulito.
- Finale, `cd laravel && nice -n 10 ./vendor/bin/phpstan analyse Modules/Geo --memory-limit=2G --no-progress --error-format=raw`, 10:01 UTC: **exit 0, 0 righe di output**, 1m43s. Output in `scratchpad/geo-final.txt`, exit in `scratchpad/geo-final.exit`.
- Pest non lanciato: i test di Geo richiedono il DB (`quaeris_data_test` non esiste).
- Soglia di carico, scostamento dal brief: dalle 09:44 il conteggio `pgrep -f 'phpstan analys[e]'` (che include le shell wrapper) e' stato tra 27 e 112 e la RAM disponibile tra 0 e 20 GiB. Ho aspettato fino alle 09:54, poi ho lanciato un processo alla volta: il primo run mirato con 20 GiB disponibili, il run sui gemelli e quello finale con 5 e 6 GiB, quindi sotto i 10 GiB del brief. Misurato ~0,3 GiB di RSS per processo reale (39 processi, 11 GiB), non l'1 GiB assunto. Nessun OOM, nessun retry.

### Aperto, per decisione dell'utente (seconda passata)

1. **Gemelli di Comune.** Proposta: rinominare `comunetest.php` in un nome che finisca per `Test.php` (per esempio `ComuneReadApiTest.php`), cosi' i suoi quattro test girano e il path non collide piu'; cancellare `ComuneTest.php` solo con decisione dell'owner, perche' e' superseded da `ComuneModelTest.php` ma non identico (regola 42). Prima di attivare `comunetest.php` va provato su MySQL: non verificato qui.
2. **Trait ancora in `laraxot/dev`.** Finche' upstream li ha, ogni pull li riporta. Decidere se eliminarli anche li'.
3. **Altri ignore in Geo**, fuori dalle 338 segnalazioni e non toccati: `app/Models/Traits/HasAddress.php` (4), `app/Models/Traits/HasPlaceTrait.php` (2), `tests/Support/EnsuresGeoDatabaseSchema.php` (1). Coprono errori reali (`argument.type` su `create($data)`, relazioni morph senza generics, trait senza uso): da risolvere alla sorgente in un giro dedicato.
4. **Dato di prova nel JSON di produzione.** `resources/json/comuni.json` ha il record 4, "Bresso" con `cap` `"20091"` (stringa JSON con le virgolette), coerente con un vecchio run del test di creazione di `ComuneTest.php`. Presente in `HEAD` (commit `60524329`). Non toccato: sono dati.
