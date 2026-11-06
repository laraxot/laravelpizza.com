---
id: DCP-242
title: "DCP-242: test delle Action Geo riscritti sulle firme reali (LoadGeoData, ReverseGeocode, SearchPlaces, GetGeocodingSuggestions, Map)"
type: story
epic: DCP-240
status: done-with-open-points
priority: P1
owner: module:Geo
created: 2026-10-15
updated: 2026-10-15
tags: [geo, phpstan, pest, test-contro-api-inesistenti, nominatim, guzzle]
related:
  - bmad-output/epic-phpstan-modules-test-contro-api-inesistenti.md
  - Modules/Geo/docs/stories/phpstan-geo-unit-tests-scope.story.md
qmd: "dcp-242 geo test actions firme reali LoadGeoDataAction ReverseGeocodeAction SearchPlacesAction GetGeocodingSuggestionsAction MapActionsTest guzzle mockhandler senza sorgente"
---

# DCP-242: test delle Action Geo sulle firme reali

## Fase BMAD
Correzione alla sorgente e verifica. Scope: solo i cinque file di test sotto `Modules/Geo/tests/Unit/Actions/`. Produzione non toccata. Gli altri test di Geo (Datas, Traits, Feature, Models, Fixtures) sono di un'altra sessione e non sono stati toccati.

## Misura di partenza
- Epic DCP-240, misura 13:34 UTC: 39 errori PHPStan in questi cinque file (13 LoadGeoData, 8 ReverseGeocode, 8 Map, 5 GetGeocodingSuggestions, 5 SearchPlaces). Numeri dell'epic, non rimisurati da questa sessione.
- Quando questa sessione e' partita (13:38 UTC) i cinque file erano gia' stati riscritti da qualcun altro tra le 13:36:44 e le 13:37:34 (mtime). Su quella versione PHPStan dava 0 errori, ma Pest era ROSSO: 8 test su 14 falliti. Quindi "PHPStan a zero" non bastava: i test erano rotti in un altro modo e in parte tautologici (riflessione sulla firma, costruzione di un DTO).

## Causa radice
1. Test scritti senza leggere le Action. Esempi: `GetGeocodingSuggestionsAction::execute()` non ha il parametro `limit`; `ReverseGeocodeAction::execute()` ha solo `latitude` e `longitude` e ritorna `LocationData`, non un array con `display_name`; `SearchPlacesAction::execute($query, ?string $country, int $limit)` riceveva il limite al posto del paese.
2. `Http::fake()` non intercetta nulla: le Action Nominatim creano da sole un `GuzzleHttp\Client` nel costruttore e non usano la facade `Http`. La simulazione corretta, gia' usata da `FetchIPLocationActionTest`, e' un `MockHandler` iniettato nella proprieta' privata `client`.
3. Base di test sbagliata. `Modules\Geo\Tests\TestCase::setUp()` forza `pub_theme = Meetup` nel singleton `XotData`, ma `Themes/Meetup` non ha `resources/views`. Il primo test del processo passa; dal secondo il boot di `FolioServiceProvider` lancia `Exception: realpath not find dir[.../Themes/Meetup/resources/views/pages]`. Misurato sui cinque file: il secondo e il terzo test di LoadGeoData, ReverseGeocode e SearchPlaces, il secondo di GetGeocodingSuggestions. Nessuno di questi test ha bisogno di DB o tema: passano a `LightTestCase`.
4. Aspettative sul comportamento sbagliate: `LoadGeoDataAction` con `{"provinces": []}` non arriva mai a «Regioni mancanti nel file JSON» perche' `ValidateGeoDataAction` boccia prima il documento («non e' valido»).

## Scopo ricostruito e cosa e' stato fatto
| File | Cosa doveva garantire | Come |
|---|---|---|
| `GeoData/LoadGeoDataActionTest` | `comuni.json` diventa la collezione delle regioni (indici 0..n, gerarchia regione > provincia > comune intatta); ogni documento non valido e' rifiutato, non letto a meta'. | `File::shouldReceive` sul percorso di `GeoDataConfig::JSON_PATH`. 10 test: due percorsi felici, file mancante (e `get` mai chiamato), JSON sintatticamente rotto (`Safe\Exceptions\JsonException`, non inghiottito), 6 documenti non validi in dataset (scalare, senza `regions`, `regions` non array, regione senza province, comune senza CAP, codice regione duplicato, quest'ultimo copre `CheckGeoDataIntegrityAction`). |
| `Nominatim/ReverseGeocodeActionTest` | Coordinate in ingresso, indirizzo (`display_name`) in uscita come `LocationData`; richiesta corretta a Nominatim; gli errori HTTP arrivano al chiamante. | `MockHandler` iniettato. Verifica host `nominatim.openstreetmap.org`, path `/reverse`, query `lat, lon, format=json`, `User-Agent: Xot/1.0`, `ClientException` su 400, `ServerException` su 503, `ConnectException` su rete assente. Le coordinate restituite sono quelle richieste, non quelle arrotondate da Nominatim. |
| `Nominatim/SearchPlacesActionTest` | Ricerca testuale che ritorna `Collection<LocationData>`; parametri inviati; zero risultati e guasti HTTP segnalati. | `MockHandler` iniettato. Mappatura in ordine (lat/lon float, `address` = `display_name`), query di default (`limit=10`, `accept-language=it`, nessun `countrycodes`), paese e limite inoltrati, `User-Agent: FixCity Application`, apostrofi e accenti intatti (2 casi), `RuntimeException 'No results found for query'` su `[]`, `RuntimeException 'Failed to search places:'` su 503. |
| `Geocoding/GetGeocodingSuggestionsActionTest` | Contratto della Action: lista vuota per query vuota, nessun errore per nessuna query. | `LightTestCase`; 1 test + 3 casi in dataset. Il resto e' `SENZA SORGENTE` (sotto). |
| `Map/MapActionsTest` | Marker, statistiche ed export della mappa rispettano i tipi; i formati dell'export sono le costanti di `ExportMapDataAction`. | Ripristinate le costanti `FORMAT_*` (un'altra sessione le aveva sostituite con stringhe) e aggiunto il ripiego su json per formato omesso o ignoto. Le statistiche: vedi sotto. |

Tolto `uses(TestCase, RefreshDatabase)`: nessuno di questi test usa il DB.

## SENZA SORGENTE (nessun test cancellato, nessuna produzione inventata)
Restano come `->todo()` con il motivo nel nome. Prove nel repo:
1. `ReverseGeocodeAction`: parametro `zoom`. `execute(float $latitude, float $longitude)`; `git log -S"zoom" -- app/Actions/Nominatim/ReverseGeocodeAction.php` vuoto: il comportamento non e' mai esistito. Il vecchio test `execute(45.4642, 9.1900, 18)` e `Http::assertSent(... 'zoom=18')` non aveva sorgente.
2. `ReverseGeocodeAction`: corpo vuoto `[]`. `$data['display_name']` non e' protetto, il risultato e' `Undefined array key` (ErrorException sotto Laravel). Il vecchio test «handles empty response» si aspettava un array. Decisione: guardia nella produzione o contratto che lancia?
3. `GetGeocodingSuggestionsAction`: suggerimenti reali per una query valida e limite massimo. L'Action e' uno stub che torna `[]` («Sostituisce GeocodingService::getSuggestions()»), `execute(string $query)` senza `limit`; `git log -S"limit"` vuoto. Decisione: implementare l'autocomplete (provider?) o dichiarare lo stub definitivo.
4. `GetMapStatsAction`: contatori `total` e `categories`. Nel worktree il file e' lo stub del 9 ottobre (`return []`, mtime 2026-10-09) e il test originale falliva. Ma `HEAD` e `MERGE_HEAD` del repo `laravel/Modules/Geo` (unione in corso dalle 13:15) hanno entrambi `@return MapStats` e `return ['total' => 0, 'categories' => 0]` (commit 12c826a6f del repo radice). Cioe' il worktree e' in ritardo rispetto ai due rami. Non ho toccato la produzione: il test attuale verifica solo la parte vera in entrambe le versioni («nessun contatore diverso da zero»), il test del formato resta `todo`. Quando il file di produzione sara' ripristinato in avanti, sostituire il `todo` con `assertSame(['total' => 0, 'categories' => 0], $stats)`.

## Osservazioni di produzione (non modificata, da decidere)
- `LoadGeoDataAction`: il ramo «Regioni mancanti nel file JSON» e' irraggiungibile (la validazione boccia prima con «non e' valido»).
- `LoadGeoDataAction` si aspetta `{"regions": [{provinces: [{cities: [...]}]}]}` ma `resources/json/comuni.json` e' una lista piatta di 4 comuni (`nome`, `regione`, `provincia`, `cap`, ...): sul file vero l'Action lancia «non e' valido». Nessun test la esercita sul file reale.
- `SearchPlacesAction`: con zero risultati lancia `RuntimeException`, mentre i vecchi test si aspettavano una collezione vuota. Il test ora fissa il comportamento del codice (messaggio esplicito, scelta deliberata).
- `Modules\Geo\Tests\TestCase`: la causa 3 vale per tutti i file di test che la usano (55 file dichiarano `TestCase::class`, quanti falliscono dal secondo test in poi non e' stato misurato). Fuori scope: file condiviso.

## Verifica (output reale, 2026-10-15)
- `php -l` sui cinque file: «No syntax errors detected» x5.
- PHPStan sui cinque percorsi, dalla cartella `laravel/` con `bashscripts/tools/heavy-slot.sh`: exit 0, `{"errors":0,"file_errors":0}` (json con `totals`). Prima: 39 (epic); sulla versione trovata alle 13:38: 0 errori ma 8 test su 14 rossi.
- Pest, un file per volta con `pest-scratch-db.sh`:
  - LoadGeoDataActionTest: 10 passed (39 assertions)
  - ReverseGeocodeActionTest: 4 passed, 2 todos (12 assertions)
  - SearchPlacesActionTest: 7 passed (16 assertions)
  - GetGeocodingSuggestionsActionTest: 4 passed, 2 todos (4 assertions)
  - MapActionsTest: 4 passed, 1 todo (8 assertions)
- Non eseguito: `phpstan analyse Modules` intero (soglia `typeCoverage`), come da regola.

## Lezioni
- «PHPStan a zero» su un test non dice che il test funzioni: eseguirlo.
- Un'Action che costruisce il proprio `Client` non si simula con `Http::fake()`; guardare come lo fa il test vicino.
- Quando test e produzione non concordano, controllare prima `git log -S` e i due rami di un'unione in corso, non solo il worktree.

## Correzione del TestCase di Geo (DCP-240, stessa giornata)
Il dato che la story non poteva avere: 12 altri file Geo erano rossi a runtime anche con PHPStan a zero, tutti con «un test passa, il successivo fallisce». Causa: `Modules\Geo\Tests\TestCase::setUp()` forzava `pub_theme = Meetup` e `Themes/Meetup` non ha `resources/views`, quindi dal secondo test del processo il boot di Folio lanciava `realpath not find dir[.../Themes/Meetup/resources/views/pages]`.
- Fix: tolte le due righe `pub_theme` (config e `XotData::update`); restano `main_module`. Il tema reale e `Sixteen`; `XotData::update()` modifica solo l'oggetto in memoria (`save()` e un `wip`), quindi nessun file toccato. Nessun altro test Geo cita `Meetup`.
- Prova: `RegionTest`, `ProvinceTest`, `AddressDataTest`, `HasAddressesTest`, `MapPickerIntegrationTest`, `IsPointInPolygonActionTest`, `CoordinatesDataTest`, `GeocodingDataTest`, `PlaceDataTest`, `RouteDataTest`, `TravelTimeDataTest`, `HandlesCoordinatesTest`: prima 1-2 falliti ciascuno, ora tutti passati (output Pest per file); PHPStan sui 13 file exit 0, `file_errors` 0.
- Non misurato: gli altri ~80 file Geo che dichiarano il TestCase; `Seo/tests/TestCase.php` forza anch'esso `Meetup` (DEC-49).
