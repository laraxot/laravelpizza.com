---
title: "Mappe: widget Filament, pagine, componenti Blade, build e asset"
type: reference
status: active
module: Geo
tags: [geo, mappe, widget, filament, leaflet, lit, geojson, cluster, vite, asset]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo mappe widget geomapwidget geojson cluster leaflet lit vite build asset symlink pagine filament point-map layer marker"
related:
  - ./coordinate-picker.md
  - ./geocoding-providers.md
  - ./geometry-and-distance.md
---

# Mappe, widget e asset

Sintesi unica delle pagine su GeoMapWidget, map-lit, mappe statiche, test mappa, configurazione Vite e lezioni "map-lit" che
erano in radice di `docs/` (originali nel backup `~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). Per i campi di
form con mappa vedi [coordinate-picker.md](./coordinate-picker.md).

## Widget e pagine Filament

| Classe | Ruolo |
|---|---|
| `Filament/Widgets/GeoMapWidget` (`final`, estende `XotBaseWidget`) | mappa Leaflet resa da un web component Lit, a larghezza piena, con un payload GeoJSON caricato una volta dal backend. Vista esplicita `geo::filament.widgets.geo-map-widget` (la risoluzione per classe di `XotBaseWidget` ripiegherebbe su una vista senza mappa). Dataset di default `resources/data/geo-map-widget.geojson`; zoom: iniziale 6, aggregazione 8, dettaglio 12; layer: cluster, punti, heatmap, zone; basi: OpenStreetMap e Esri World Imagery |
| `Filament/Widgets/BaseMapWidget` | base astratta (`geo::filament.widgets.base-map`): le figlie implementano `getMapMarkers()` |
| `LocationMapWidget`, `LocationWidget`, `LatLngWidget`, `OSMMapWidget`, `WebbingbrasilMap` | widget per posizioni, lat/lng e OSM; le varianti `*.disabled` sono tolte dal caricamento (compatibilita' con Filament 4/5) |
| `Filament/Pages/{Dashboard, LatLng, LocationMap, LocationMapTable, OSMMap, SettingPage}` | pagine admin del modulo; `DotswanMap` e `WebbingbrasilMap` sono disattivate (`*.disabled`) |
| `View/Components/PointMap` | componente Blade `<x-geo::point-map>`; il provider registra il namespace con `Blade::componentNamespace('Modules\\Geo\\View\\Components', 'geo')` |
| `Http/Livewire/FormSearchAddressCategories`, `View/Components/FormSearchAddressCategories` | ricerca indirizzi per categoria |

Dati del widget: `Actions/Maps/LoadGeoMapDatasetAction` legge e valida una `FeatureCollection` (errori espliciti se il file manca
o il JSON non e' valido) e normalizza le proprieta' a soli scalari; `GetGeoMapDatasetCategoriesAction`,
`GetGeoMapDatasetStatsAction` (conteggi di punti, zone, categorie), `BuildGeoMapWidgetPayloadAction` (restituisce un
`GeoMapWidgetData`); `Actions/Geo/Support/GeoMapDatasetAction` e il value object `Support/GeoMapDataset` fanno la stessa
lettura (il secondo non ha chiamanti, resta per compatibilita'). Per mappe a marker da filtri: `Actions/Map/GetMapMarkersAction`,
`GetMapStatsAction`, `ExportMapDataAction($filters, $format = 'json')`. Le classi DTO sono in `Datas/Map/`
(`MarkerData`, `GeoMapLayerConfigData`, `GeoMapWidgetData`, `PositionData`, `SizeData`, `IconData`). I marker di `Place` usano
`config('geo.markers.types.<tipo>')` (vedi l'avvertenza sui nomi delle chiavi in [geocoding-providers.md](./geocoding-providers.md)).

## Front-end

- Sorgenti: `resources/js/components/` (web component Lit: `coordinate-picker-lit.js`, `geo-map-lit-new.js`,
  `geo-points-canvas-lit.js`, ...), `resources/js/components/map/` (moduli condivisi: `layers.js`, `controls/`, `events.js`,
  `default-view.js`, `approximate-location.js`, `labels.js`, `legend.js`, `feature-*.js`, `endpoints.js`), `resources/js/widgets/`.
  I componenti map-lit (`geo-map-lit-new.js`, `map-lit.js`) usano `leaflet.markercluster` e `leaflet.heat`.
- Vista di partenza: punto salvato → centro del campo → zona dal fuso orario del browser (zoom 6, senza rete) →
  `geo.config.map.default_view` → panoramica d'Italia cablata. La posizione precisa del browser e' un miglioramento
  progressivo (richiede `isSecureContext` e permesso): niente geolocalizzazione per IP tramite terzi. Se il GPS non c'e', il
  pulsante "usa la mia posizione" ricentra sul punto salvato o sulla vista iniziale e scrive un invito neutro in un paragrafo
  `role="status" aria-live="polite"` (traduzione `location_unavailable`).
- Tile: i layer in `map/layers.js` (strada OSM, umanitario, satellite e topografico Esri) passano dal proxy quando il layout
  dichiara `data-geo-tile-url` (vedi [geocoding-providers.md](./geocoding-providers.md)); le attribuzioni (ODbL, Esri) restano
  visibili sulla mappa.
- Regola storica per le mappe visualizzate: niente API a pagamento per mappe statiche o dinamiche; usare tile e servizi
  gratuiti/open (OSM, Nominatim, export OSM per le immagini statiche). Il modulo contiene comunque action Google/Mapbox/Bing
  opzionali per geocoding e distanze lato server.

### Lezioni dai componenti Lit

- Meno listener non e' meno stabilita': i listener `zoomend`/`moveend` che forzavano un refresh dei cluster facevano sparire i
  marker; si lascia gestire a `markercluster` (`removeOutsideVisibleBounds: true`, niente refresh manuale, niente
  `animate: false` combinato a transform CSS).
- Mappa bianca con `L is not defined` o `markerClusterGroup is not a function`: plugin non inclusi nel bundle; gli alias in
  `vite.config.js` (`leaflet`, `leaflet.markercluster`, `leaflet.heat`) e `window.L = L` prima dell'uso dei plugin.
- `Cannot read property 'addLayer' of undefined`: `_markersLayer` e' nullo, attendere la fine di `_initMap()`. Il GPS non
  centra se lat/lng sono valorizzati ma invalidi: ometterli per la geolocalizzazione automatica.
- Popup: niente `min-height` forzati sull'header (creava una fascia bianca); marker di stato a strati (`__inner` 36 px,
  `__glyph-pad` 28 px, punta 8 px, `iconAnchor [20, 44]`).

## Build e asset

- `npm run build` (nella cartella del modulo, dipendenze del modulo in `package.json`) scrive in `Modules/Geo/public`
  (`build.outDir`, `manifest.json`, file in `assets/`); `public_html/assets/geo` e' un link simbolico relativo a
  `laravel/Modules/Geo/public` (`php artisan xot:module-link`). Nessuna copia in `public_html`: `npm run copy` non esiste piu'
  e `AssetAction` non copia file da `resources/`. Gli asset compilati sono versionati perche' il server di produzione non
  compila. Il plugin Laravel Vite usa `publicDirectory: ../../../public_html` e `buildDirectory: assets/geo`.
- Senza il link, le pagine che caricano gli asset Geo rispondono 500 con `ViteManifestNotFoundException`.
- `GeoServiceProvider` non ridefinisce `$module_ns`: registra esplicitamente il `RouteServiceProvider` del modulo (rotte
  `routes/api.php` del proxy OSM) e il namespace dei componenti Blade. Il metodo `registerMapAssets()` (CSS/JS Filament) e'
  presente ma la chiamata e' commentata.
- Residui del vecchio front office presenti nel working tree: `resources/views/layouts/{plane,master,app}.blade.php`,
  `resources/views/home/index.blade.php`, `resources/css/geo.css`, `resources/js/jquery-3.3.1.js`, `resources/views/maps/farmshops/`
  (mappa di un progetto specifico) e `resources/views/contribute/`. La documentazione storica riportava di aver rimosso il layout
  `plane` e i suoi asset perche' senza riferimenti; il sync li ha reintrodotti. Candidati alla rimozione con un test di guardia.

## Test

`tests/Feature/Filament/GeoMapWidgetTest.php`, `tests/Unit/Actions/Maps`, `tests/Unit/Support`, spec Playwright in
`tests/Playwright/` (cluster, legenda, filtri, stabilita' GPS) e `tests/Browser/` (vedi [testing.md](./testing.md)).
