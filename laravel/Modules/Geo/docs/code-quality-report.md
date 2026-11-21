---
title: "code quality report"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "code quality report"
issues: []
discussions: []
---

# Code quality — modulo Geo

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 239
- File di test: 100 — rapporto test/app: 41%
- File con TODO/FIXME/@deprecated: 0
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 137
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 34

### File con Facade in Actions da convertire

- Modules/Geo/app/Actions/UpdateClientCoordinatesBulkAction.php
- Modules/Geo/app/Actions/UpdateCoordinatesFromAddressAction.php
- Modules/Geo/app/Actions/GetCoordinatesByAddressAction.php
- Modules/Geo/app/Actions/GoogleMapsAction.php
- Modules/Geo/app/Actions/GetCoordinatesAction.php
- Modules/Geo/app/Actions/Weather/GetOpenWeatherDataAction.php
- Modules/Geo/app/Actions/BingMaps/GetAddressFromBingMapsAction.php
- Modules/Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php
- Modules/Geo/app/Actions/GeoData/GetGeoDataValidationErrorsAction.php
- Modules/Geo/app/Actions/GeoData/LoadGeoDataAction.php
- Modules/Geo/app/Actions/GeoData/ValidateGeoDataIntegrityAction.php
- Modules/Geo/app/Actions/GeoData/GetCapAction.php
- Modules/Geo/app/Actions/GeoData/ValidateGeoDataAction.php
- Modules/Geo/app/Actions/GeoData/GetCitiesAction.php
- Modules/Geo/app/Actions/GeoData/LoadGeoHierarchyAction.php
- Modules/Geo/app/Actions/GeoData/GetProvincesAction.php
- Modules/Geo/app/Actions/GeoData/ClearGeoDataCacheAction.php
- Modules/Geo/app/Actions/LocationIQ/GetAddressFromLocationIQAction.php
- Modules/Geo/app/Actions/OpenCage/GetAddressFromOpenCageAction.php
- Modules/Geo/app/Actions/Here/GetAddressFromHereMapsAction.php
- Modules/Geo/app/Actions/Here/GetHereRouteSummaryAction.php
- Modules/Geo/app/Actions/Photon/GetAddressFromPhotonAction.php
- Modules/Geo/app/Actions/GoogleMaps/CalculateTravelTimeAction.php
- Modules/Geo/app/Actions/GeoData/GetRegionsAction.php
- Modules/Geo/app/Actions/GoogleMaps/CalculateDistanceMatrixAction.php
- Modules/Geo/app/Actions/GoogleMaps/GoogleMapsHttpAction.php
- Modules/Geo/app/Actions/GoogleMaps/GetCoordinatesFromGoogleMapsAction.php
- Modules/Geo/app/Actions/GoogleMaps/OptimizeRouteAction.php
- Modules/Geo/app/Actions/GoogleMaps/GetGeocodingDataAction.php
- Modules/Geo/app/Actions/GoogleMaps/GetAddressByLatLngFromGoogleMapsAction.php
- Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxLatLngAction.php
- Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php
- Modules/Geo/app/Actions/Nominatim/GetAddressFromNominatimAction.php
- Modules/Geo/app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php

### Complessità / dimensione classi da rivedere

- Modules/Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php:162                                 CyclomaticComplexity      The method extractLocationFromResponse() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GeoData/CheckGeoDataIntegrityAction.php:79                                CyclomaticComplexity      The method isValidProvinceWithUniqueCode() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GeoData/ValidateGeoDataIntegrityAction.php:123                            CyclomaticComplexity      The method isValidProvinceWithUniqueCode() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GetCoordinatesByAddressAction.php:149                                     CyclomaticComplexity      The method extractBingCoordinates() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/Here/GetHereRouteSummaryAction.php:23                                     CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/Polygon/IsPointInPolygonAction.php:21                                     CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Adapters/HereClient.php:20                                                        CyclomaticComplexity      The method getDurationAndLength() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Console/Commands/SushiCommand.php:58                                              CyclomaticComplexity      The method refresh() has a Cyclomatic Complexity of 14. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Datas/Photon/PhotonAddressData.php:32                                             CyclomaticComplexity      The method fromPhotonFeature() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Enums/AddressItemEnum.php:41                                                      ExcessiveMethodLength     The method getColumnDefinitions() has 110 lines of code. Current threshold is set to 100. Avoid really long methods.

## Stato architetturale

- Nessuna violazione `extends \Filament\...` diretto rilevata (regola XotBase rispettata).

## Azioni consigliate

- Convertire le 34 Action con Facade dirette al pattern QueueableAction (niente facade nella cartella Actions).
- Rifattorizzare i metodi/classi elencati sopra (complessità ciclomatica/NPath oltre soglia).

## Confronto con gli altri moduli (rapporto test/app)

| Modulo | app | test | % | facade-in-Actions |
|---|---|---|---|---|
| Activity | - | - | 127% | 5 |
| AI | - | - | 42% | 2 |
| Blog | - | - | 0% | 2 |
| Cms | - | - | 102% | 1 |
| Comment | - | - | 26% | 2 |
| Employee | - | - | 26% | 1 |
| Gdpr | - | - | 52% | 4 |
| Geo | - | - | 41% | 34 |
| Job | - | - | 21% | 3 |
| Lang | - | - | 30% | 3 |
| Media | - | - | 11% | 10 |
| Notify | - | - | 61% | 21 |
| Rating | - | - | 7% | 0 |
| Seo | - | - | 100% | 0 |
| TechPlanner | - | - | 2% | 0 |
| Tenant | - | - | 75% | 6 |
| UI | - | - | 34% | 4 |
| User | - | - | 23% | 4 |
| Xot | - | - | 28% | 57 |



## Come migliorare — modifiche effettive da fare

### 1. Rimuovere le Facade da `app/Actions/`

Regola del progetto (skill `queueable-action-trait`): nelle Action **niente Facade**, le dipendenze si iniettano nel costruttore — il container le risolve automaticamente quando l'Action viene chiamata con `app(XxxAction::class)->execute(...)`.

Facade usate in questo modulo e relativa dipendenza da iniettare al loro posto:

| Facade | Inietta invece |
|---|---|
| `Cache::` | `Illuminate\Contracts\Cache\Repository` |
| `DB::` | `Illuminate\Database\ConnectionInterface` |
| `File::` | `Illuminate\Filesystem\Filesystem` |
| `Http::` | `Illuminate\Http\Client\Factory` |
| `Log::` | `Psr\Log\LoggerInterface` |
| `RateLimiter::` | `Illuminate\Cache\RateLimiter` |
| `Validator::` | `Illuminate\Contracts\Validation\Factory` |

**Esempio concreto** — `Modules/Geo/app/Actions/Weather/GetOpenWeatherDataAction.php`:

```php
// PRIMA
use Illuminate\Support\Facades\Http;

class XxxAction
{
    use QueueableAction;

    public function execute(string $arg): mixed
    {
        $response = Http::get($url);
        // ...
    }
}

// DOPO
use Illuminate\Http\Client\Factory as HttpFactory;

class XxxAction
{
    use QueueableAction;

    public function __construct(private readonly HttpFactory $http)
    {
    }

    public function execute(string $arg): mixed
    {
        $response = $this->http->get($url);
        // ...
    }
}
```

Vantaggio pratico: l'Action diventa testabile senza `Http::fake()` globale — nei test Pest si passa un mock/fake del client via `app()->instance(HttpFactory::class, $fakeClient)` o via binding nel service provider di test.

File da convertire in questo modulo (elenco sopra in "Numeri"), uno alla volta, con `php -l` + PHPStan L max sul singolo file dopo ogni modifica.

### 2. Ridurre la complessità ciclomatica

Metodi/classi oltre soglia (10 per metodo, 50 per classe) in questo modulo:

- Modules/Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php:162                                 CyclomaticComplexity      The method extractLocationFromResponse() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GeoData/CheckGeoDataIntegrityAction.php:79                                CyclomaticComplexity      The method isValidProvinceWithUniqueCode() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GeoData/ValidateGeoDataIntegrityAction.php:123                            CyclomaticComplexity      The method isValidProvinceWithUniqueCode() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/GetCoordinatesByAddressAction.php:149                                     CyclomaticComplexity      The method extractBingCoordinates() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/Here/GetHereRouteSummaryAction.php:23                                     CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Actions/Polygon/IsPointInPolygonAction.php:21                                     CyclomaticComplexity      The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Adapters/HereClient.php:20                                                        CyclomaticComplexity      The method getDurationAndLength() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Console/Commands/SushiCommand.php:58                                              CyclomaticComplexity      The method refresh() has a Cyclomatic Complexity of 14. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Datas/Photon/PhotonAddressData.php:32                                             CyclomaticComplexity      The method fromPhotonFeature() has a Cyclomatic Complexity of 16. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Filament/Forms/Components/Support/CoordinatePickerHelpers.php:94                  CyclomaticComplexity      The method reverseGeocode() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php:271                      CyclomaticComplexity      The method reverseGeocode() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Filament/Forms/LocationForm.php:35                                                CyclomaticComplexity      The method getSchema() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Address.php:96                                                             ExcessiveClassComplexity  The class Address has an overall complexity of 51 which is very high. The configured complexity threshold is 50.
- Modules/Geo/app/Models/Address.php:288                                                            CyclomaticComplexity      The method getFormattedAddressAttribute() has a Cyclomatic Complexity of 21. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/ComuneJson.php:448                                                         CyclomaticComplexity      The method getValidationRules() has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Locality.php:55                                                            CyclomaticComplexity      The method getRows() has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Province.php:58                                                            CyclomaticComplexity      The method getRows() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Region.php:59                                                              CyclomaticComplexity      The method getRows() has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Traits/GeoTrait.php:170                                                    CyclomaticComplexity      The method getLatitudeAttribute() has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- Modules/Geo/app/Models/Traits/HasAddress.php:95                                                   CyclomaticComplexity      The method getFullAddressesAttribute() has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.

Tecnica di refactoring consigliata: **estrarre ogni ramo condizionale in un metodo privato dedicato**, o sostituire lunghe catene if/elseif con una `match()` che delega a metodi/Action più piccoli. Esempio:

```php
// PRIMA — un metodo con 15+ rami
public function resolveType(string $type): string
{
    if ($type === "a") { /* ... */ }
    elseif ($type === "b") { /* ... */ }
    // ... altri 10+ rami
}

// DOPO — dispatch table, ogni ramo è un metodo testabile singolarmente
public function resolveType(string $type): string
{
    return match ($type) {
        "a" => $this->resolveA(),
        "b" => $this->resolveB(),
        default => throw new \InvalidArgumentException("Unknown type: {$type}"),
    };
}
```

Ogni `resolveX()` estratto scende sotto soglia 10 e diventa testabile in isolamento con un test Pest dedicato.

