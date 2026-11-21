---
title: "Geo — Unit Tests for claude-audit 100/100"
type: story
module: Geo
epic: "claude-audit-perfection"
slug: geo-unit-tests-claude-audit-100
status: ready-for-dev
priority: high
created: 2026-09-27
updated: 2026-09-27
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/XXXX"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/XXXX"
related:
  - "docs/stories/notify-unit-tests-claude-audit-100.story.md"
  - "docs/stories/tenant-unit-tests-claude-audit-100.story.md"
  - "../../../docs/wiki/guidelines/claude-audit-static-free-tier.md"
---

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

- **Geocoding/GeocodeAddressActionTest.php** - Geocodifica indirizzi
- **Geocoding/GetGeocodingSuggestionsActionTest.php** - Suggerimenti geocodifica
- **GeoData/LoadGeoDataActionTest.php** - Caricamento dati geografici (regioni/province/comuni)
- **GeoData/ValidateGeoDataActionTest.php** - Validazione integrità dati
- **GeoData/CheckGeoDataIntegrityActionTest.php** - Controllo integrità JSON
- **UpdateCoordinatesActionTest.php** - Aggiornamento coordinate bulk/singolo
- **GetBoundingBoxActionTest.php** - Calcolo bounding box
- **Polygon/IsPointInPolygonActionTest.php** - Point-in-polygon
- **Nominatim/ReverseGeocodeActionTest.php** - Reverse geocoding
- **Nominatim/SearchPlacesActionTest.php** - Ricerca luoghi
- **GoogleMaps/GetAddressFromGoogleMapsActionTest.php** - Geocoding Google Maps
- **GoogleMaps/CalculateDistanceMatrixActionTest.php** - Distance matrix
- **GoogleMaps/CalculateTravelTimeActionTest.php** - Travel time
- **GoogleMaps/OptimizeRouteActionTest.php** - Route optimization
- **Elevation/GetElevationActionTest.php** - Elevation data
- **Elevation/FetchOpenElevationActionTest.php** - OpenElevation API

### 2. Test per Models

Creare test in `laravel/tests/Unit/Modules/Geo/Models/`:

- **ComuneTest.php** - Model Comune (business logic)
- **ProvinceTest.php** - Model Province
- **RegionTest.php** - Model Region
- **AddressTest.php** - Model Address con trait HasAddresses

### 3. Test per Traits

Creare test in `laravel/tests/Unit/Modules/Geo/Traits/`:

- **HasAddressesTest.php** - Trait per gestione indirizzi
- **HandlesCoordinatesTest.php** - Trait per gestione coordinate

### 4. Test per Data Objects (DTO)

Creare test in `laravel/tests/Unit/Modules/Geo/Datas/`:

- **CoordinatesDataTest.php** - DTO coordinate
- **AddressDataTest.php** - DTO indirizzo
- **GeocodingDataTest.php** - DTO risultato geocodifica
- **PlaceDataTest.php** - DTO luogo
- **RouteDataTest.php** - DTO route
- **TravelTimeDataTest.php** - DTO travel time

### 5. Feature Tests

Creare test in `laravel/tests/Feature/Modules/Geo/`:

- **GeoApiTest.php** - Endpoint API Folio per geocoding
- **MapPickerIntegrationTest.php** - Integrazione map picker Filament

## Acceptance Criteria

1. ✅ Tutti i test passano: `./vendor/bin/pest laravel/tests/Unit/Modules/Geo laravel/tests/Feature/Modules/Geo`
2. ✅ PHPStan L10 pulito: `./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1`
3. ✅ claude-audit score 100/100 per modulo Geo
4. ✅ Test coverage ≥ 80% per Actions e Models critici
5. ✅ Nessun test flaky o dipendente da servizi esterni (usare mock/fake)

## Technical Notes

### Pattern Testing

Seguire il pattern di `laravel/tests/Unit/Modules/Chart/Actions/CreateChartActionTest.php`:
- Usa `uses(TestCase::class, RefreshDatabase::class, WithFaker::class)`
- `beforeEach` per setup action e factory
- `describe` / `it` per organizzazione
- `expect()` per assertions
- Mock servizi esterni (HTTP client, API keys)

### Mock Strategy

Per Actions che chiamano API esterne (Google Maps, Nominatim, Here, Bing, OpenElevation):
- Usa `Http::fake()` di Laravel
- Crea fixture JSON realistici in `laravel/tests/Fixtures/Geo/`
- Testa sia success che error cases

### Geo Data Testing

Il file `Modules/Geo/resources/json/comuni.json` contiene i dati geografici italiani. I test devono:
- Verificare caricamento e parsing corretto
- Testare validazione integrità (regioni, province, comuni presenti)
- Testare query: getRegions, getProvinces, getCities, getCap

### Dependencies

- Modulo Xot (TestCase base)
- Modulo User (User factory per test)
- Laravel HTTP Client testing utilities

## Definition of Done

- [ ] Story creata e commitata
- [ ] Tutti i test Actions implementati
- [ ] Tutti i test Models implementati
- [ ] Tutti i test Traits implementati
- [ ] Tutti i test DTO implementati
- [ ] Feature tests implementati
- [ ] Tutti i test passano
- [ ] PHPStan L10 OK
- [ ] claude-audit 100/100 verificato
- [ ] Story aggiornata con risultati

## Story Points Breakdown

- **Actions tests (15 actions × 3 test each):** 8 punti
- **Models tests (4 models × 3 test each):** 3 punti
- **Traits tests (2 traits × 3 test each):** 2 punti
- **DTO tests (6 DTOs × 2 test each):** 2 punti
- **Feature tests (2 areas × 3 test each):** 2 punti
- **Fix flaky/setup issues:** 2 punti
- **Verifica finale + docs:** 1 punto
- **Totale:** 20 punti

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5 (kilo-auto/free)

### File List (da creare)

- `laravel/tests/Unit/Modules/Geo/Actions/Geocoding/GeocodeAddressActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Geocoding/GetGeocodingSuggestionsActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GeoData/LoadGeoDataActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GeoData/ValidateGeoDataActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GeoData/CheckGeoDataIntegrityActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/UpdateCoordinatesActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GetBoundingBoxActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Polygon/IsPointInPolygonActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Nominatim/ReverseGeocodeActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Nominatim/SearchPlacesActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GoogleMaps/GetAddressFromGoogleMapsActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GoogleMaps/CalculateDistanceMatrixActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GoogleMaps/CalculateTravelTimeActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/GoogleMaps/OptimizeRouteActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Elevation/GetElevationActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Actions/Elevation/FetchOpenElevationActionTest.php`
- `laravel/tests/Unit/Modules/Geo/Models/ComuneTest.php`
- `laravel/tests/Unit/Modules/Geo/Models/ProvinceTest.php`
- `laravel/tests/Unit/Modules/Geo/Models/RegionTest.php`
- `laravel/tests/Unit/Modules/Geo/Models/AddressTest.php`
- `laravel/tests/Unit/Modules/Geo/Traits/HasAddressesTest.php`
- `laravel/tests/Unit/Modules/Geo/Traits/HandlesCoordinatesTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/CoordinatesDataTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/AddressDataTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/GeocodingDataTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/PlaceDataTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/RouteDataTest.php`
- `laravel/tests/Unit/Modules/Geo/Datas/TravelTimeDataTest.php`
- `laravel/tests/Feature/Modules/Geo/GeoApiTest.php`
- `laravel/tests/Feature/Modules/Geo/MapPickerIntegrationTest.php`
- `laravel/tests/Fixtures/Geo/*.json` (fixture per mock HTTP)

---

*This story was created using BMAD Method v6 - Phase 4 (Implementation Planning)*