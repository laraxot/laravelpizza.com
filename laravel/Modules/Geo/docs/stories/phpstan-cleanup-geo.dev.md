---
title: "[DEV] PHPStan cleanup modulo Geo"
type: dev
module: Geo
status: done-with-open-decision
created: 2026-10-06
updated: 2026-10-28
tags: [phpstan, geo, constants, bmad]
related:
  - ./phpstan-cleanup-geo.story.md
---

# [DEV] PHPStan cleanup modulo Geo

## Technical Plan

1. Tipizzare tutte le costanti (`const string|int|array`), centralizzando i duplicati:
   - `Modules\Geo\Infrastructure\Config\GeoApiEndpoints`: `GOOGLE_{GEOCODING,DISTANCE_MATRIX,ELEVATION,DIRECTIONS,TIMEZONE}`,
     `NOMINATIM_{BASE,SEARCH,REVERSE,LOOKUP}`, `MAPBOX_PLACES`, `BING_LOCATIONS`.
   - `Modules\Geo\Infrastructure\Config\GeoDataConfig`: `JSON_PATH`, `CACHE_TTL`, `CACHE_KEY_{REGIONS,PROVINCES,CITIES,CAP}`.
   - Regole di validazione: `GeoDataValidationRules::RULES|MESSAGES` come unica fonte.
   - Le classi con costanti locali lette dai test via reflection (`GoogleMapsService`, `GoogleMapsAction`) le
     mantengono come alias tipizzato (`private const string GEOCODING_URL = GeoApiEndpoints::GOOGLE_GEOCODING;`).
2. `Cache::remember`: tipi corretti + metodi privati `loadProvinces()`/`loadCities()`, regioni via `mapWithKeys`.
3. Variabili/offset mai letti: verifica dell'intento (vedi Analysis della story).
4. Test: da stub a test con assert veri.

## Files to Modify

App (49 file): `Actions/GoogleMapsAction`, `Actions/GoogleMaps/*` (10), `Actions/{Nominatim,Mapbox,Bing,BingMaps,
Here,LocationIQ,OpenCage,Photon,IPGeolocation,Elevation,TimeZone,Weather}/*` (16), `Actions/GeoData/*` (9),
`Actions/Math/IsPointInPolygonAction`, `Actions/GetCoordinatesAction`, `Actions/GetCoordinatesByAddressAction`,
`Adapters/GoogleMapsClient`, `Services/{GoogleMapsService,GeoDataService,GeoDataValidator,GeoService}`,
`Models/{Locality,ComuneJson,Policies/GeoBasePolicy}`, `Filament/Widgets/LocationMapWidget`,
`database/seeders/{GeoJsonDownloader,RegionSeeder}`.
Canonicali: `app/Infrastructure/Config/GeoApiEndpoints.php`, `app/Infrastructure/Config/GeoDataConfig.php`.
Test (10): `Unit/{GeocodingBusinessLogicTest,Models/AddressBusinessLogicTest,Actions/{GetCoordinatesActionTest,
GetBoundingBoxActionTest,GetAddressDataFromFullAddressActionTest,GoogleMapsActionTest,FormatCoordinatesActionTest,
Maps/BuildGeoMapWidgetPayloadActionTest},Filament/Forms/LatitudeLongitudeInputTest}`, `Feature/AddressIntegrationTest`.
Docs: `docs/services/geocoding.md`, `docs/json-database.md`, `docs/00-index.md`, `docs/stories/index.md` + questa coppia.

## Implementation Steps

- [x] Letto contesto, chiamanti, doc (`json-database.md`, `services/geocoding.md`), storia git delle costanti
- [x] Creati `GeoApiEndpoints` e `GeoDataConfig`; alias tipizzati nelle classi che duplicavano gli URL
- [x] `GeoData/*`, `GeoDataService`, `GeoDataValidator`, `ValidateGeoDataIntegrityAction` sulle fonti uniche
- [x] Rimosse le `public const CACHE_KEY/CACHE_TTL` di `Get*Action` (nessun consumatore fuori da Geo; aggiornato
      `ClearGeoDataCacheAction`)
- [x] Corretti i tipi di ritorno regioni/citta' (mappa codice => nome) e le closure di `Cache::remember`
- [x] `OptimizeRouteAction`, `Locality`, `GeoBasePolicy`, `RegionSeeder`, `IsPointInPolygonAction`, `GeoService`
- [x] `GetCoordinatesAction`: JSON non valido -> `RuntimeException` (contratto del docblock)
- [x] Test: implementati assert mancanti, rimosse assegnazioni duplicate, `BuildGeoMapWidgetPayloadActionTest`
- [x] Doc aggiornati (owner esistenti) + indici

## Testing

Pest NON eseguito: `phpunit.xml` forza sqlite `:memory:` ma `.env.testing` punta a MySQL (`techplanner_data_test`) con
`APP_ENV=local`; per la regola "dati DB sacri" nessun test e' stato avviato (i test Geo usano `DatabaseTransactions`).
Verifiche alternative: `php -l` su tutti i file toccati; smoke in PHP puro (`scratchpad/geo/smoke.php`): alias delle
costanti = valori attesi dai test di reflection, `RULES`/`MESSAGES` (10/23 voci), ray-casting punto dentro/fuori in
`Math\IsPointInPolygonAction` e `GeoService::is_in_polygon`, `Safe\json_decode` -> `JsonException` avvolta in
`RuntimeException`, valori numerici bounding box (equatore: ampiezza lat = lon; lat 89: ampiezza lon 1.03 > lat 0.018).

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1 --no-progress
# 104 errori prima -> 0 errori di codice; restano 61 classConstant.nativeTypeNotSupported (php ^8.2, vedi sotto)
php -l <file>   # su tutti i file toccati
grep -rnE "GetCitiesAction::CACHE|GetRegionsAction::CACHE|GetProvincesAction::CACHE|GetCapAction::CACHE" Modules Themes   # nessun risultato
```

Decisione aperta: PHPStan deriva la versione minima da `laravel/composer.json` (`"php": "^8.2"`), quindi le costanti
tipizzate (8.3+) sono segnalate `classConstant.nativeTypeNotSupported` (61 in Geo), mentre quelle non tipizzate fanno
scendere `constantTypeCoverage` (rule attiva solo con analisi dei path completi `Modules/`, i `@var` non contano).
Le due regole sono inconciliabili con `^8.2`: serve `"php": "^8.3"` (o `config.platform.php`) nel `composer.json`
radice, fuori dallo scope Geo. Lo stesso problema e' stato rilevato dal gruppo Lang e in
`docs/bmad/incidenti/const-to-enum-initiative.md`.

## Suspicious / non toccato

- `Actions/Bing/GetAddressFromBingMapsAction` e `Actions/BingMaps/GetAddressFromBingMapsAction`: duplicati.
- `Actions/Math/IsPointInPolygonAction`, `Actions/Polygon/IsPointInPolygonAction` e `GeoService::is_in_polygon`:
  stesso algoritmo in 3 posti (Polygon\ dichiara di sostituire gli altri). Corretti sul posto, non unificati.
- `Actions/GeoData/*`, `GeoDataService`, `LoadGeoHierarchyAction`: nessun chiamante e il loro file sorgente
  (`comuni.json` = lista piatta, non `{regions: [...]}`) non e' compatibile: con i dati attuali lanciano
  "Il file JSON dei comuni non e' valido".
- Letterali Nominatim ancora inline in `Forms/Components/CoordinatePicker`, `Filament/Forms/Components/Support/
  CoordinatePickerHelpers`, `Traits/HasCoordinatePicker` (non segnalati; candidati a `GeoApiEndpoints`).
- Endpoint Bing in chiaro (`http://dev.virtualearth.net`).

## Lessons Learned

- **`nativeTypeNotSupported` vs `constantTypeCoverage`**: con `require.php ^8.2` le due regole si escludono; una
  tipizzazione delle costanti e' completa solo se `composer.json` dichiara `^8.3`. Prima di tipizzare centinaia di
  costanti controllare la versione minima vista da PHPStan.
- **`constantTypeCoverage` non e' visibile su un path parziale** (`areFullPathsAnalysed`): `analyse Modules/Geo` non
  mostra mai quegli errori, vanno verificati con `analyse Modules`. I `@var string` sopra le costanti non contano.
- **Un `@return`/`@var` sbagliato e' la causa**, non il sintomo: l'errore su `Cache::remember` nasceva da
  `Collection<int, array{...}>` dichiarato su una mappa `codice => nome`. Correggere il tipo vero + estrarre la
  closure in un metodo con `@return` preciso, non aggiungere cast.
- **Errori di docblock su classi anonime possono essere cache stale** (`ftm-<file>`): lo stesso contenuto copiato in
  un file con altro nome ha 0 errori. Il test e' stato comunque riscritto con proprieta' esplicita (neutro).
- **Un test che istanzia e non asserta e' un test mancante**: la variabile "mai letta" indicava l'assert dimenticato
  (`$patient['type']` mai usato -> `model_type` hardcoded), non codice da cancellare.

## Round 2026-10-28 — paramTypeCoverage

File: `Actions/GoogleMaps/GetAddressFromGoogleMapsAction`, `Actions/Maps/BuildGeoMapWidgetPayloadAction`,
`Filament/Forms/Components/AddressesField`, `Filament/Widgets/OSMMapWidget`, `Models/{ComuneJson,Locality}`,
`Rules/FilterCoordinatesInRadius`. Dettaglio per file nella Analysis della story. Verifica:
`cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress --error-format=raw | grep Modules/Geo/` (vuoto).

