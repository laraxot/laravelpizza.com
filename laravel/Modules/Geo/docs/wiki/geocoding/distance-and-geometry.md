---
title: "Distanze, raggio, poligoni, cluster e altri calcoli geografici"
type: reference
status: active
module: Geo
tags: [geo, distanza, haversine, poligono, raggio, cluster, rotte, elevazione, fuso-orario]
updated: 2026-11-25
qmd: "distanza haversine raggio bounding box poligono point in polygon cluster optimize route elevation timezone weather ip geolocation GeoTrait withDistance orderByDistance"
related:
  - ../data/address-model.md
  - providers-and-fallback.md
---

# Distanze, raggio, poligoni, cluster e altri calcoli geografici

Le funzioni di calcolo di Geo sono Queueable Actions (`use QueueableAction`, metodo `execute()`); quelle che interrogano il
database passano dal trait `Models\Traits\GeoTrait` (usato da `Address`, `Location`, `Place`, ...).

## Distanza tra punti

| Cosa | Dove | Note verificate |
|---|---|---|
| Distanza in PHP tra due coppie lat/lng | `Actions\Distance\CalculateGeoDistanceAction::execute(lat1, lon1, lat2, lon2, unit)` | Haversine: `gradi * 60 * 1.1515` = miglia terrestri; `'K'` (default) moltiplica per 1,609344, `'N'` per 0,8684. Ritorna `0.0` per punti uguali, `null` se manca una coordinata. Esiste una copia identica in `Actions\Math\CalculateGeoDistanceAction` |
| Distanza e tempo di percorrenza su strada | `Actions\CalculateDistanceAction` (implementa `Contracts\CalculateDistanceActionContract`, legato dal `GeoServiceProvider`) | Usa la Distance Matrix di Google (`GoogleMaps\CalculateDistanceMatrixAction`); valida le coordinate e lancia `DistanceCalculationException` |
| Tempo di viaggio | `GoogleMaps\CalculateTravelTimeAction`, `Here\GetHereRouteDurationAndLengthAction`, `Here\GetHereRouteSummaryAction` | richiedono la chiave del provider |
| Espressione SQL di distanza | `Actions\GetDistanceExpressionAction` (ritorna un `GeoDistanceExpression`), `Actions\Math\GenerateHaversineSqlAction`, `Actions\Distance\BuildHaversineSqlAction` | vedi attenzione sotto; Xot ha la propria `Xot\Actions\Geo\GetDistanceExpressionAction` |
| Su modello Eloquent | `GeoTrait::distance()`, `distanceCustomField()`, `scopeWithDistance($lat, $lng)`, `scopeOrderByDistance()`, `scopeOfInPolygon()` | `scopeWithDistance` ignora coordinate non finite o fuori range (|lat| > 90, |lng| > 180), usa 6371 km con binding e ordina con `distance IS NULL` prima di `distance`, cosi' i record senza coordinate non dominano la lista |
| Altri scope | `Address::scopeNearby($lat, $lng, $radiusKm = 10)`, `Location::scopeWithinDistance()` | |

**Attenzione (verificato sul codice):** `GenerateHaversineSqlAction` interpola le coordinate nella stringa SQL (non usa binding) e
usa `6371 * acos(...) * 1.1515`, quindi mescola raggio terrestre in km e fattore miglia: il risultato non e' ne' km ne' miglia.
Per codice nuovo usare lo scope `withDistance` del trait (binding, 6371 km) o `CalculateGeoDistanceAction` con l'unita' esplicita.
`BuildHaversineSqlAction` dichiara nel docblock che la formula di riferimento resta quella di `GenerateHaversineSqlAction`.

## Raggio, bounding box e poligoni

- `GetBoundingBoxAction::execute(lat, lng, distanceKm)`: riquadro attorno a un punto (raggio terrestre 6371 km).
- `FilterCoordinatesInRadiusAction::execute(centerLat, centerLng, coordinates, radius)`: filtra un array di coordinate; la
  `Rules\FilterCoordinatesInRadius` (regola di validazione) la usa. La classe senza suffisso `Actions\FilterCoordinatesInRadius`
  e' un duplicato orfano con la condizione invertita (vedi [providers-and-fallback](providers-and-fallback.md#debito-noto-verificato-sul-codice-il-2026-11-25)).
- Punto in poligono (ray casting): `Actions\Polygon\IsPointInPolygonAction` e `Actions\Math\IsPointInPolygonAction`
  (stessa firma `execute(lat, lng, array $polygon): bool`), e `Actions\Math\CheckPointInPolygonJsonAction` per un poligono in JSON.
- `ValidateCoordinatesAction`, `FormatCoordinatesAction` (formato `decimal` di default), `GetCoordinatesAction` e
  `GetCoordinatesByAddressAction` (geocodifica diretta con Google, ritornano `LocationData` / `CoordinatesData`).

## Cluster, rotte e dati accessori

- `ClusterLocationsAction::execute(array $locations, float $maxDistance = 1.0)`: raggruppa le posizioni per distanza.
  Il vecchio file `.wip` duplicato non e' caricato da PSR-4.
- `OptimizeRouteAction::execute(Collection $locations)` ordina un percorso per minimizzare la distanza totale;
  `GoogleMaps\OptimizeRouteAction` e' la variante Google.
- `Elevation\GetElevationAction` / `FetchOpenElevationAction` (Open-Elevation) e `GoogleMaps\FetchGoogleMapsElevationAction`.
- `TimeZone\GetTimeZoneAction::execute(lat, lng): TimeZoneData`; `Weather\GetOpenWeatherDataAction::execute(lat, lng): ?array`;
  `IPGeolocation\GetLocationFromIPAction::execute(string $ip): ?IPLocationData` (con `FetchIPLocationAction`, errori HTTP
  avvolti in `RuntimeException`).
- Dati per la mappa: `Actions\Map\{GetMapMarkersAction,GetMapStatsAction,ExportMapDataAction}` e `Actions\Maps\*`
  (dataset GeoJSON, vedi [map-widget-and-dataset](../maps/map-widget-and-dataset.md)).

I test delle Actions stanno in `tests/Unit/Actions/` (una cartella per provider: `GoogleMaps`, `Nominatim`, `Here`, `Mapbox`,
`IPGeolocation`, `Elevation`, ...), con le chiamate HTTP simulate ([testing](../quality/testing.md)).
