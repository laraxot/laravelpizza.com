---
title: "Geo: panoramica del modulo"
type: overview
status: active
module: Geo
tags: [geo, architettura, panoramica]
updated: 2026-11-25
qmd: "geo modulo panoramica architettura geocoding mappe indirizzi comuni leaflet lit sushi actions provider"
related:
  - ../data/address-model.md
  - ../geocoding/providers-and-fallback.md
  - ../maps/map-components.md
---

# Geo: panoramica del modulo

Servizi geografici riutilizzabili da altri moduli: geocodifica con piu' provider, indirizzi italiani con codici ISTAT,
campi Filament per scegliere una posizione, mappe Leaflet/Lit e un proxy lato server per OpenStreetMap.
`module.json`: alias `geo`, provider `GeoServiceProvider` e `Providers\Filament\AdminPanelProvider`. Il modulo non ha
pagine front-office proprie: espone Actions, modelli, campi Filament e Web Component che i temi importano.

## Cosa c'e' e dove

| Area | Dove | Pagina |
|---|---|---|
| Geocodifica, catena di provider, `GEO_DRIVER` | `app/Actions/{GoogleMaps,Nominatim,Photon,Here,Mapbox,OpenCage,BingMaps,LocationIQ,OpenStreetMap}`, `GetAddressDataFromFullAddressAction` | [providers-and-fallback](../geocoding/providers-and-fallback.md) |
| Proxy OpenStreetMap (tile e Nominatim) | `app/Http/Controllers/{OsmTileController,NominatimController}`, `app/Actions/Osm`, `routes/api.php` | [adr/osm-proxy-tile-nominatim](../../adr/osm-proxy-tile-nominatim.md) |
| Scrittura di latitudine/longitudine | `UpdateCoordinatesAction`, `UpdateCoordinatesFromAddressAction`, `UpdateClientCoordinatesBulkAction`, `app/Filament/Actions/UpdateCoordinatesBulkAction` | [update-coordinates](../geocoding/update-coordinates.md) |
| Distanze, raggio, poligoni, cluster, rotte | `app/Actions/{Distance,Math,Polygon,Elevation,TimeZone,Weather,IPGeolocation}` e le Actions in radice | [distance-and-geometry](../geocoding/distance-and-geometry.md) |
| Indirizzo (`Address`, `HasAddress`, enum) | `app/Models/Address.php`, `app/Models/Traits`, `app/Enums`, `app/Actions/Address` | [address-model](../data/address-model.md) |
| Regioni, province, comuni, CAP | `app/Models/{Region,Province,Locality,Comune,...}`, `resources/json/`, `app/Actions/GeoData` | [italian-geography](../data/italian-geography.md) |
| Campi e risorse Filament | `app/Filament/{Forms/Components,Resources,Widgets,Pages}` | [address-forms-and-resources](../filament/address-forms-and-resources.md) |
| Picker coordinate | `CoordinatePicker`, `MapPicker`, `GeopointPicker`, trait `HasCoordinatePicker` | [coordinate-picker](../maps/coordinate-picker.md) |
| Web Component mappa (Lit) | `resources/js/components/` | [map-components](../maps/map-components.md) |
| Widget mappa con dataset GeoJSON | `app/Filament/Widgets/GeoMapWidget.php`, `app/Support/GeoMapDataset.php` | [map-widget-and-dataset](../maps/map-widget-and-dataset.md) |

Decisioni di architettura: [ADR](../../adr/README.md). Cosa promettono le Actions che parlano con l'esterno:
[contratti](../../contracts/README.md). Come si verifica: [testing](../quality/testing.md) e
[phpstan-and-types](../quality/phpstan-and-types.md).

## Regole che il codice impone

- **Connessione dedicata.** `Models\BaseModel` ha `$connection = 'geo'`; tutti i modelli persistenti estendono `BaseModel`
  (non `Model`). `Address` usa `nullableUuidMorphs('model')`, quindi regge sia id interi sia UUID del modello padrone.
- **Business logic in Spatie Queueable Actions**, non in Services: l'ADR [no-service-geo-integrations](../../adr/no-service-geo-integrations.md)
  chiede di non aggiungere classi in `app/Services` (esistono ancora `GeoService`, `GoogleMapsService`, `HereService`,
  `GeocodingService`, `GeoDataService`, `GeoDataValidator`, `MapService`, `BaseGeoService`: debito dichiarato dall'ADR).
- **Configurazione**: `config/config.php` viene registrato da Xot come `geo.config.*` (vedi nota in
  [providers-and-fallback](../geocoding/providers-and-fallback.md#chiavi-di-configurazione)); `config/sushi.php` come `geo.sushi.*`.
  Chiavi principali: `api_keys` (Google, Bing, Mapbox), `driver`, `comuni_json_path`, `rate_limits`, `cache`, `map.default_view`
  (env `GEO_MAP_DEFAULT_LAT|LNG|ZOOM`, default 42.5 / 12.5 / zoom 6), `osm_proxy`, `http_client` (timeout 5 s, 3 tentativi).
- **Provider di servizio.** `GeoServiceProvider` registra a mano `RouteServiceProvider` (senza, `routes/api.php` e il proxy OSM non
  si caricavano), lega `CalculateDistanceActionContract` a `CalculateDistanceAction` e dichiara il namespace Blade `geo`
  (`<x-geo::point-map>`).
- **Lingue**: `lang/{de,en,es,fr,it,pl}`.
- **Dipendenze front-end** (`package.json`): `leaflet ^1.9.4`, `lit ^3.3.2`, `leaflet.markercluster`, `leaflet.heat`; Leaflet e Lit sono
  anche `peerDependencies`, perche' il bundle lo costruisce il tema che importa i componenti.

## Cosa non c'e'

- Nessuna API REST `/api/geo/*` (`routes/api.php` contiene solo le due rotte del proxy OSM; `routes/web.php` e' vuoto di rotte).
  `tests/Feature/GeoApiTest.php` descrive un'API mai esistita ed e' marcato skipped.
- Nessuna rotta web: le pagine pubbliche stanno nel tema (Folio + JSON) e usano i componenti Blade (`resources/views/components`:
  `map-lit`, `point-map`, `farmshops-map`, ...) e i Web Component di Geo.

## Dove sono i riferimenti storici

Gli originali di tutta la documentazione prima della condensazione (2.177 file, tra cui 428 dump in `raw/`, 88 in `phpstan/`,
72 roadmap) sono nell'archivio `~/backups/laravelpizza-docs-md-before-cap100.tar.gz`, membri `laravel/Modules/Geo/docs/...`.
Contenevano in gran parte copie di documenti di altri moduli e output generati (phpmd, phpstan); i fatti specifici di Geo sono
stati riverificati sul codice e sono in queste pagine.
