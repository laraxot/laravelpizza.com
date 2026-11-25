---
title: "Distanze, raggio, poligoni, percorsi e coordinate"
type: reference
status: active
module: Geo
tags: [geo, distanza, haversine, poligono, raggio, percorso, cluster, coordinate]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo distanza haversine raggio poligono st_contains bounding box cluster optimize route coordinate geotrait"
related:
  - ./geocoding-providers.md
  - ./address.md
---

# Distanze, raggio, poligoni e percorsi

Sintesi verificata sul codice delle pagine su polygon/MySQL, haversine, filtri per raggio e ottimizzazione percorsi che erano
in radice di `docs/` (originali nel backup `~/backups/laravelpizza-docs-md-before-cap100.tar.gz`).

## Distanza e raggio

| Cosa | Dove | Note |
|---|---|---|
| Distanza in linea d'aria in SQL | trait `Models/Traits/GeoTrait`: scope `withDistance($lat,$lng)`, `orderByDistance($lat,$lng)`; accessor `distance` | formula haversine in km (`6371 * acos(...)`) sulle colonne `latitude`/`longitude`; coordinate non valide (fuori da ±90/±180) lasciano la query invariata; `withDistance` ordina prima i record con distanza calcolata poi quelli senza coordinate (`distance IS NULL`) |
| Haversine come espressione | `Actions/Math/GenerateHaversineSqlAction` (la costruisce, `Actions/Distance/BuildHaversineSqlAction` delega a lei), `Actions/GetDistanceExpressionAction` (restituisce un `GeoDistanceExpression`), `GeoService::haversine()` | `GeoService::setLatitudeLongitudeField()` cambia i nomi colonna |
| Distanza tra due punti | `Actions/Distance/CalculateGeoDistanceAction`, `Actions/Math/CalculateGeoDistanceAction`, `GeoService::distance(..., 'K'|'M'|'N')` | km, miglia, miglia nautiche |
| Distanza stradale e tempo | `Actions/CalculateDistanceAction(LocationData, LocationData): array` (contratto `Contracts/CalculateDistanceActionContract`, legato nel `GeoServiceProvider`), `GoogleMaps/CalculateDistanceMatrixAction`, `GoogleMaps/CalculateTravelTimeAction`, `Here/GetHereRoute*Action` | chiamano Google Distance Matrix / HERE: richiedono chiave |
| Filtro per raggio | `Actions/FilterCoordinatesInRadiusAction(centerLat, centerLng, array $coordinates, int $radius)` | il raggio e' in **metri**; le coordinate sono array `{latitude, longitude}`; regola di validazione `app/Rules/FilterCoordinatesInRadius` |
| Scope per raggio sugli indirizzi | `Address::scopeNearby($lat, $lng, $radiusKm = 10)` | raggio in km |
| Riquadro attorno a un punto | `Actions/GetBoundingBoxAction($lat, $lng, $distanceKm)` | restituisce `min_lat`, `max_lat`, `min_lon`, `max_lon` |

## Poligoni

- `Models/Traits/GeoTrait::scopeOfInPolygon('zone_polygon', $lat, $lng)` usa le funzioni spaziali MySQL
  (`ST_Contains(ST_GeomFromText('POLYGON(...)'), ST_GeomFromText('POINT(lat lng)'))`) a partire da un campo JSON
  `zone_polygon` (lista di `{lat, lng}`); accetta solo quella colonna (asserzione) ed e' pensato per MySQL/MariaDB.
- Senza database: `Actions/Math/IsPointInPolygonAction(lat, lng, array $polygon): bool` (test punto-in-poligono in PHP; esiste una
  copia in `Actions/Polygon/`), `Actions/Math/CheckPointInPolygonJsonAction(lat, lng, ?string $polygonJson)` e
  `GeoService::is_in_polygon()` / `pointInPolygon()`.
- Per provare un poligono a mano in MySQL: `SELECT ST_CONTAINS(ST_GEOMFROMTEXT('POLYGON((x y, ...))'), ST_GEOMFROMTEXT('POINT(x y)'))`.
  Nello scope del trait sia il poligono sia il punto sono scritti nell'ordine `lat lng`: tenere lo stesso ordine nelle prove.

## Cluster e percorsi

- `Actions/ClusterLocationsAction(array $locations, float $maxDistance = 1.0): array`: raggruppa punti vicini (distanza massima
  in km, calcolata con `CalculateDistanceActionContract`, cioe' distanza stradale Google, non haversine).
- `Actions/OptimizeRouteAction(Collection $locations): Collection`: ordina i punti con il metodo del punto piu' vicino
  (nearest neighbour, non ottimo ma lineare); `Actions/GoogleMaps/OptimizeRouteAction` usa Google Directions (origine, destinazione, modalita', criterio distanza o tempo).
- Il clustering visivo sulla mappa e' lato client (`leaflet.markercluster`), vedi [maps-and-widgets.md](./maps-and-widgets.md).

## Coordinate

`Actions/ValidateCoordinatesAction(lat, lng): bool`, `FormatCoordinatesAction(lat, lng, format = 'decimal')` (decimale,
gradi-minuti-secondi, URL Google Maps), `Traits/HandlesCoordinates`, `Datas/Location/CoordinatesData`,
`Datas/LocationData`. Quota: `Elevation/GetElevationAction(LocationData): float`; fuso orario:
`TimeZone/GetTimeZoneAction(lat, lng): TimeZoneData`; posizione da IP: `IPGeolocation/GetLocationFromIPAction(ip): ?IPLocationData`.

## Esempio

```php
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;
use Modules\Geo\Models\Address;

$vicini = app(FilterCoordinatesInRadiusAction::class)->execute(41.9028, 12.4964, $coordinate, radius: 10_000); // metri
$indirizzi = Address::query()->nearby(41.9028, 12.4964, radiusKm: 10)->get();
```
