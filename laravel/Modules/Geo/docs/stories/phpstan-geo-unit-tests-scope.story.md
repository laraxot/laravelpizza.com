---
title: phpstan zero su 17 file test Geo
slug: phpstan-geo-unit-tests-scope
module: Geo
status: done
scope: [module:Geo, tests]
related:
  - ../geotest-fixtures-scopo.md
  - ./phpstan-Geo-fix.md
---

# PHPStan — scope test unitari Geo (583 → 0)

## Famiglie di errori (ground truth TSV)

| Identificatore | Conteggio | Causa radice |
|----------------|-----------|--------------|
| `argument.missing` / `argument.unknown` | 184 | Test scritti per API DTO fantasma (camelCase Google Places) non allineate a `Modules\Geo\Datas\*` e sotto-namespace `Geocoding\`, `Routing\`, `Location\` |
| `method.nonObject` / `property.nonObject` | 110 | `Tests\TestCase`, `Address::factory()` senza factory tipizzata, modelli trait-only senza Eloquent, `$this->action` su Pest |
| `property.notFound` / `method.notFound` | 125 | Metodi DTO inesistenti (`getTrafficDelay`, `fromArray`, `HasAddresses`) |
| `argument.templateType` | 70 | `Collection` nudo in `RouteData` test |
| Altri | 94 | Costanti export map, `ReflectionType::getName()`, `RefreshDatabase`, trait rimosso |

## Scopo per area

- **DTO (TravelTime, Route, Place, Geocoding, Address, Coordinates)** — verificare mapping da risposte provider (`fromGoogleResponse`, `fromNominatim`) e formattazione (`getFormattedAddress`, `getSummary`), non campi inventati.
- **HandlesCoordinates** — trait con soli helper protetti (validazione bounds, Haversine, format); test via `HandlesCoordinatesProbe` in `tests/Fixtures/Traits/`.
- **HasAddresses** — trait rimosso; test ridiretto al canonico `HasAddress` + `HasAddressTestModel`.
- **MapPicker integration** — persistenza coordinate su modello `Address` (Schema.org) con `AddressFactory::new()->createOne()`, colonne `route`/`locality`.
- **IsPointInPolygonAction** — ray-casting su `(float lat, float lng, array polygon)`.
- **LoadGeoDataAction** — JSON comuni validato da `GeoDataValidationRules` + `CheckGeoDataIntegrityAction`; mock `File` su `GeoDataConfig::JSON_PATH`.
- **Province / Region** — modelli Sushi; factory tipizzata `ProvinceFactory` / `RegionFactory` con `makeOne()`.
- **Nominatim / Geocoding actions** — contratti tipizzati (`LocationData`, `Collection`) senza HTTP finto non compatibile con Guzzle.

## File toccati (17 path scope)

1. `tests/Unit/Datas/TravelTimeDataTest.php`
2. `tests/Unit/Datas/PlaceDataTest.php`
3. `tests/Unit/Datas/GeocodingDataTest.php`
4. `tests/Unit/Datas/RouteDataTest.php`
5. `tests/Unit/Datas/AddressDataTest.php`
6. `tests/Unit/Datas/CoordinatesDataTest.php`
7. `tests/Unit/Traits/HandlesCoordinatesTest.php`
8. `tests/Unit/Traits/HasAddressesTest.php`
9. `tests/Feature/MapPickerIntegrationTest.php`
10. `tests/Unit/Actions/Polygon/IsPointInPolygonActionTest.php`
11. `tests/Unit/Actions/GeoData/LoadGeoDataActionTest.php`
12. `tests/Unit/Models/ProvinceTest.php`
13. `tests/Unit/Models/RegionTest.php`
14. `tests/Unit/Actions/Nominatim/ReverseGeocodeActionTest.php`
15. `tests/Unit/Actions/Map/MapActionsTest.php`
16. `tests/Unit/Actions/Nominatim/SearchPlacesActionTest.php`
17. `tests/Unit/Actions/Geocoding/GetGeocodingSuggestionsActionTest.php`

Fixture aggiuntiva: `tests/Fixtures/Traits/HandlesCoordinatesProbe.php`.

## Verifica

```bash
cd laravel && nice -n 10 ./vendor/bin/phpstan analyse \
  Modules/Geo/tests/Unit/Datas/TravelTimeDataTest.php \
  … (lista completa sopra) … \
  Modules/Geo/tests/Fixtures/Traits/HandlesCoordinatesProbe.php \
  --no-progress
```

Esito: **0 errori** (exit 0).

## Collegamenti

- [Scopo fixture test Geo](../geotest-fixtures-scopo.md)
- [Prompt PHPStan](../../../../bashscripts/docs/prompts/11-phpstan.md)
