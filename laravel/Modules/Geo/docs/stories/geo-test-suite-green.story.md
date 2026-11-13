---
title: "Geo: suite Pest verde (77 failure della CI del 2026-11-10)"
type: story
bmad: true
status: review
created: 2026-11-10
owner: module:Geo
scope: module:Geo
tags: [geo, pest, ci, test, google-maps, sushi, comune, address, filament]
related:
  - Modules/Geo/docs/stories/12.1.retire-geo-test-livewire.story.md
qmd: "geo pest suite verde ci failure google maps travel time comune sushi addressable mapbox livewire test retired"
---

# Geo: suite Pest verde

## Contesto

L'ultima CI della suite Geo (MariaDB, PHP 8.4) chiudeva con
`Tests: 77 failed, 6 risky, 9 todos, 2 skipped, 594 passed`.
Ogni failure e' stato ricondotto a una causa; per ogni causa si e' deciso se sbagliava il codice
(fix in `app/`) o se il test era vecchio rispetto a un comportamento voluto (fix del test).
Locale: niente PHP 8.4 ne' `vendor/`, quindi i fix sono verificati con `php -l` e vanno confermati dalla CI.

## Acceptance Criteria

1. [ ] La CI della suite Geo chiude senza failure (i 7 test di `GeoApiTest` risultano skipped).
2. [x] Nessun file di test cancellato; skip solo per una funzione mai esistita (API REST `/api/geo/*`).
3. [x] Bug reali corretti nel codice dell'app, non mascherati nei test.
4. [x] Nessuna modifica fuori da `laravel/Modules/Geo/`.

## Cause, file, fix

| # | Causa | File | Fix | Test (n.) |
|---|-------|------|-----|-----------|
| 1 | Messaggi d'eccezione: i test confrontavano con `assertSame` un prefisso del messaggio (prima `toThrow()` faceva un controllo di sottostringa) | `tests/Unit/Actions/Bing/GetAddressFromBingMapsActionTest.php`, `GoogleMaps/CalculateDistanceMatrixActionTest.php`, `GetAddressByLatLngFromGoogleMapsActionTest.php`, `GetGeocodingDataActionTest.php`, `OptimizeRouteActionTest.php`, `Elevation/FetchOpenElevationActionTest.php` | Test: messaggio esatto attuale (o `assertStringStartsWith` dove contiene il testo dell'errore Guzzle) | 4 + 3 + 2 + 1 + 2 + 1 = 13 |
| 2 | Bug: `GoogleMapsApiException::requestFailed((string) $status)` dava come messaggio solo `"403"`/`"500"` | `app/Actions/GoogleMaps/CalculateDistanceMatrixAction.php`, `GetAddressFromGoogleMapsAction.php` | Codice: `Richiesta a Google Maps fallita: HTTP <status>`; test allineati | 2 |
| 3 | Bug: la API key mancante lanciava `InvalidArgumentException` (Webmozart) mentre docblock e test dichiarano `RuntimeException` | `app/Actions/GoogleMaps/CalculateTravelTimeAction.php`, `GetAddressByLatLngFromGoogleMapsAction.php`, `GetCoordinatesFromGoogleMapsAction.php` | Codice: `RuntimeException('Google Maps API key not configured')`; Assert resta per lat/lng/indirizzo | 3 |
| 4 | Travel time: i test si aspettavano stati normalizzati (`INVALID_RESPONSE`, `NO_ROUTE`) ma il codice (e `TravelTimeData::fromGoogleResponse`) propaga lo stato Google; i fixture "validi" non avevano `status` nell'elemento, e il codice andava in `Undefined array key` | `app/Actions/GoogleMaps/CalculateTravelTimeAction.php`, `tests/.../CalculateTravelTimeActionTest.php` | Codice: `parseResponse()` difensivo (payload malformato -> `INVALID_RESPONSE`, niente warning); test: stati Google (`INVALID_REQUEST`, `ZERO_RESULTS`) e fixture con `status: OK` come l'API reale | 4 |
| 5 | Fixture Google Geocoding irrealistici (senza `status`, `formatted_address`, `types`): `GoogleMapResponseData`/`GoogleMapResultData` li richiedono | `tests/.../GetAddressFromGoogleMapsActionTest.php` | Test: payload con la forma reale dell'API | 3 |
| 6 | Guzzle `ServerException` non avvolta: l'IP lookup non dava `Failed to get IP location` sugli errori HTTP | `app/Actions/IPGeolocation/FetchIPLocationAction.php` | Codice: `GuzzleException` -> `RuntimeException('Failed to get IP location: ...')` (stesso schema di `FetchOpenElevationAction`) | 1 |
| 7 | Bug: Mapbox passava `province` ad `AddressData`, che non ha quella proprieta': la sigla della regione andava persa | `app/Actions/Mapbox/GetAddressFromMapboxAction.php` | Codice: sigla in `state` | 1 |
| 8 | Elevation: `assertCount(1, $mockHandler)` dopo che la risposta era stata consumata (coda = 0) | `tests/Unit/Actions/Elevation/FetchOpenElevationActionTest.php` | Test: verifica metodo, URL e payload JSON di `getLastRequest()` | 1 |
| 9 | Test non ermetico: `GetAddressDataFromFullAddressAction` chiamava Photon reale (Guzzle) e otteneva un risultato | `tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php` | Test: `Http::fake` 503 + `preventStrayRequests`, `Client` Guzzle con handler 503 nel container | 1 |
| 10 | Fixture senza il `code` della citta', obbligatorio in `GeoDataValidationRules` | `tests/Unit/Actions/GeoData/CheckGeoDataIntegrityActionTest.php` | Test: fixture completo | 1 |
| 11 | Bug: `Address::addressable()` era `morphTo('model')`, quindi relazione chiamata `model` (eager loading di `addressable` registrato col nome sbagliato) | `app/Models/Address.php` | Codice: `morphTo('addressable', 'model_type', 'model_id')` | 2 |
| 12 | Bug: `Address::getRegione()/getProvincia()` usavano `json_extract` sui dati Sushi dei comuni, che contengono stringhe non JSON -> SQLite `malformed JSON` | `app/Models/Address.php` | Codice: filtro in PHP (`findComuneArea()`), ritorno `null` subito se il codice e' vuoto | 2 |
| 13 | `deleted_at` non e' fillable: `update(['deleted_at' => ...])` non faceva nulla | `tests/Unit/AddressModelTest.php` | Test: `delete()` + `trashed()` | 1 |
| 14 | `ComuneModelTest` scriveva in `database/content/comuni.json` (cartella assente in CI) ma il modello legge `resources/json/comuni.json`; i fixture usavano stringhe per `regione`/`provincia`/`cap`, che il modello casta ad `array` | `app/Models/Comune.php`, `config/config.php`, `tests/Unit/Models/ComuneModelTest.php` | Codice: `geo.comuni_json_path` (default null = file del modulo); test: fixture temporaneo in `storage/framework/testing`, `Model::clearBootedModels()` per ricaricare Sushi, dati nel formato `{codice, nome}` | 16 |
| 15 | Data magic factory di laravel-data: `from(array)` passa per `fromArray`/`fromGoogleResponse`/`fromGoogleMaps`/`fromPhotonFeature`; i test passavano array incompleti | `tests/Unit/Datas/DatasTest.php`, `MapDatasTest.php`, `PhotonDatasTest.php` | Test: payload richiesti (lat/lng, payload Google, `countryCode`, `scaledSize`, feature GeoJSON) | 4 + 2 + 1 = 7 |
| 16 | `CoordinatePicker` e' dehydrated di proposito (salva le coordinate, vedi nota in `HasCoordinatePicker`) | `tests/Unit/Filament/Forms/Components/CoordinatePickerTest.php` | Test: atteso `isDehydrated() === true` | 1 |
| 17 | `MapPickerTest` asseriva due valori diversi per lo stesso getter (`latitude` e `data.latitude`) | `tests/Unit/Filament/MapPickerTest.php` | Test: le colonne sono nomi di attributo, senza prefisso statePath | 1 |
| 18 | Bug: `GeoMapWidget` non dichiarava `$view`; la risoluzione per classe non trova la vista e ripiega su `xot::filament.widgets.base` (widget senza mappa) | `app/Filament/Widgets/GeoMapWidget.php` | Codice: `$view = 'geo::filament.widgets.geo-map-widget'` | 2 |
| 19 | Test widget senza applicazione (`XotBaseWidget::__construct` usa il container) e con dataset atteso vuoto | `tests/Unit/Filament/GeoMapWidgetTest.php` | Test: `uses(LightTestCase::class)`; dataset reale di 6 feature | 3 |
| 20 | Il titolo "farmshops.eu Replica" e' passato in `lang/*/geo_map_widget.php`; il JS e' nel bundle, non inline | `tests/Feature/Filament/GeoMapWidgetTest.php` | Test: chiave di traduzione, nessun `<script>`, titolo verificato nel file lang | 1 |
| 21 | Livewire `Test` ritirato dalla story 12.1 e riapparso col mirror (`14c648dc5d`) | `app/Http/Livewire/Test.php`, `Test.test`, `test.test`, `resources/views/livewire/test.blade.php` (rimossi), `app/Http/Livewire/_components.json` | Codice: ritiro riapplicato, cache componenti con la sola `form-search-address-categories` | 1 |
| 22 | Aritmetica dei test di dominio: precisione 7 decimali contro limite 6, punteggio pesato 140/100 | `tests/Unit/GeocodingBusinessLogicTest.php` | Test: arrotondamento alla precisione salvata; pesi 80 (obbligatori) + 20 (opzionali) | 2 |
| 23 | `GeoApiTest` descrive un'API REST `/api/geo/*` mai implementata (`routes/api.php` vuoto, nessun controller, `git log -S"geo/geocode"` vuoto) | `tests/Feature/GeoApiTest.php` | Test: skip motivato nel `beforeEach` | 7 (skipped) |

Totale: 70 test corretti + 7 skipped = 77.

## Punti aperti

- I 6 test `risky` non sono stati toccati.
- `resources/json/comuni.json` (4 righe) salva `regione`/`provincia`/`cap` come stringhe, mentre `Comune` li casta ad `array` e `Address` si aspetta `{codice, nome}`: con quei dati `$comune->regione` vale `null`. Va deciso il formato canonico (story dedicata).
- Le factory di `Comune` (`createComune()` in `tests/Pest.php` e i test root che usano `Comune::factory()`) scrivono nel JSON versionato del modulo. Possono usare `geo.comuni_json_path` per isolarsi.
- Fuori Geo (non toccato): `tests/Unit/Modules/Geo/**` alla radice descrive API diverse da quelle reali (es. `CalculateTravelTimeAction::execute('Milano', 'Roma')` con `Http::fake`, `Comune::province_code`).

## Dev Agent Record

- Verifica locale: `php -l` su ogni file PHP toccato (PHP 8.3, senza vendor). Da confermare con la CI.
- Nessun comando git che modifica lo stato.
