---
title: "Coordinate picker: famiglia di campi mappa Filament (Lit + Leaflet)"
type: reference
status: active
module: Geo
tags: [geo, coordinate-picker, filament, lit, leaflet, livewire, wizard, nominatim]
created: 2026-11-25
updated: 2026-11-25
qmd: "geo coordinate picker map picker place picker geopoint lit leaflet light dom entangle dehydrated wizard fullscreen nominatim helpers hascoordinatepicker"
related:
  - ./maps-and-widgets.md
  - ./address.md
  - ./geocoding-providers.md
  - ./adr/map-components-lit-light-dom.md
---

# Coordinate picker

Scopo: far scegliere una posizione precisa (latitudine/longitudine) su una mappa dentro un form Filament e salvarla sul
modello, con ricerca indirizzo e reverse geocoding. Questa pagina riunisce e sostituisce le pagine "scopo", "filosofia dei
picker", "map-picker-lit", "blade fix", "state binding", "save pattern", regole wizard/fullscreen che erano in `docs/`
(originali nel backup `~/backups/laravelpizza-docs-md-before-cap100.tar.gz`). Gli esempi di dominio legati a un singolo
progetto (segnalazioni, ticket) sono stati tolti: il modulo e' riusabile.

## La famiglia

Tutte in `app/Filament/Forms/Components/`, estendono `XotBaseField` e (tranne `CoordinatePickerHelpers`) hanno una Blade e un
componente Lit propri (`resources/views/filament/forms/components/*.blade.php`, `resources/js/components/*-lit.js`).

| Campo | Vista | Uso |
|---|---|---|
| `CoordinatePicker` | `coordinate-picker` | picker principale: mappa interattiva, ricerca, geolocalizzazione, 4 layer (OSM, Esri satellite, OpenTopoMap, Esri topo), fullscreen, `isMapReadonly()`; stato deidratato (`dehydrated()`) |
| `MapPicker` (alias compatibile `LocationPicker`) | `map-picker`, `location-picker` | picker a mappa con controlli e layer separati (`map-picker-*.js`) |
| `PlacePicker` | `place-picker` | scelta di un luogo con ricerca |
| `GeopointPicker` | `geopoint-picker` | punto geografico puro |
| `LeafletMarkerMapInput` | `leaflet-marker-map-input` | marker trascinabile con memoria della posizione |
| `MapPositioner` | `map-positioner` | regolo di prospettiva: posiziona il centro/zoom |
| `MapLocationInput` | `map-location-input` | input nascosto sincronizzato con la mappa |
| `LatitudeLongitudeInput` | `latitude-longitude-input` (+ `-lit`) | due campi numerici lat/lng |
| `XotBaseCoordinateField` | — | base astratta alternativa con gli stessi metodi del trait |
| `CoordinatePickerHelpers` | — | classe finale: unica sede di `searchAddress`, `reverseGeocode`, `normalizeCoordinate`, `extractCoordinates` |

Trait `Traits/HasCoordinatePicker`: configurazione comune di nove campi della famiglia. API fluente: `latitudeColumn()`,
`longitudeColumn()`, `zoom()`, `center(lat, lng)`, `reverseGeocoding()`, `height()`, `geolocateWhenEmpty()`, `showSearch()`;
getter corrispondenti e `getMapDefaultView()` (vista di partenza da `geo.config.map.default_view`: env `GEO_MAP_DEFAULT_LAT`,
`GEO_MAP_DEFAULT_LNG`, `GEO_MAP_DEFAULT_ZOOM`, default panoramica d'Italia 42.5/12.5/6, cosi' la mappa non si apre mai sul
mondo intero). I due metodi Livewire `searchAddress()` e `reverseGeocode()` sono wrapper `#[Exposed]` + `#[Renderless]` che
delegano a `CoordinatePickerHelpers` (Nominatim con User-Agent contattabile): niente corpi HTTP duplicati nei trait, cosi'
PHPStan livello 10 conserva i tipi `array<...>`. Il trait deve fare `use` di `CoordinatePickerHelpers` (senza import, PHPStan lo
risolve sotto `Traits\` e segnala `class.notFound`; dopo spostamenti di moduli: `composer dump-autoload -o`).

Esempio:

```php
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

CoordinatePicker::make('coordinates')
    ->latitudeColumn('latitude')
    ->longitudeColumn('longitude')
    ->zoom(13)
    ->reverseGeocoding()
    ->geolocateWhenEmpty();

// in mutateFormDataBeforeSave(): array{latitude, longitude} -> colonne
$data = CoordinatePickerHelpers::extractCoordinates($data, 'coordinates', 'latitude', 'longitude');
```

## Flusso dello stato

1. Lo stato del campo e' un array `['latitude' => ?float, 'longitude' => ?float]`; in `afterStateHydrated` viene riempito dal
   record usando le colonne configurate (`normalizeCoordinate()`).
2. La Blade lega lo stato con `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}`: senza
   `applyStateBindingModifiers` i modificatori `live()`/`defer()` vengono ignorati. Il web component non fa mai `entangle` diretto
   (causa cicli): Alpine e' solo livello vista, Livewire resta la fonte di verita'.
3. Il custom element `<coordinate-picker-lit>` emette `coords-changed` (`{latitude, longitude, source: manual|drag|geolocation|geocode, address}`)
   e `fullscreen-changed`; espone `setCoordinates(lat, lng, source)` per aggiornamenti da ricerca indirizzo: normalizza, aggiorna
   marker con lo stesso percorso di click e drag, emette `coords-changed`, centra la mappa.
4. La Blade avvolge la mappa in `wire:ignore`; nei label usa `(state.latitude || state.latitude === 0)` per non scambiare lo 0
   (coordinata valida) con "non impostato" e mostrare `--` quando manca.
5. Salvataggio: il campo deve essere deidratato e il modello deve avere le colonne (o il campo composito) in `$fillable`.
   Attenzione: `CoordinatePicker` e' deidratato, ma `MapPicker` e `LatitudeLongitudeInput` chiamano `dehydrated(false)`; un dato
   "che non arriva al modello" e' quasi sempre `dehydrated(false)` o mass assignment mancante. Per colonne separate usare
   `extractCoordinates()`.

## Regole del componente Lit (ADR [map-components-lit-light-dom](./adr/map-components-lit-light-dom.md))

- Light DOM (`createRenderRoot() { return this; }`): gli stili di Leaflet e del tema si applicano, Livewire vede il markup;
  classi CSS specifiche (es. `.map-picker-leaflet-pane`), non `:host`/`::part`.
- Contenitore mappa dentro `guard([], () => html\`...\`)`: Lit non lo ridisegna, l'istanza Leaflet sopravvive; mai ricreare la
  mappa a ogni `updated()` (si perderebbero zoom, posizione e marker).
- `ResizeObserver` + `invalidateSize()` quando lo step o il tab diventa visibile (wizard: mappa vuota dopo "Avanti").
- Fullscreen = vero overlay: `position: fixed`, z-index sopra header/sidebar/wizard, blocco dello scroll del documento,
  `invalidateSize()` differito dopo ogni toggle e ripristino dello scroll in uscita. La logica sta nel componente Geo, il
  layer visuale (z-index, dimensioni) nel CSS del tema.
- Nessun `fetch` diretto verso servizi esterni dal componente: la ricerca passa dai metodi Livewire (o dal proxy, vedi
  [geocoding-providers.md](./geocoding-providers.md)); debounce 200-500 ms; rimuovere i listener in `disconnectedCallback`;
  niente ID globali (rompono piu' istanze in un wizard), usare classi; le icone sono template `html`, non stringhe.
- Contratto: il componente Geo espone il comportamento (mappa opaca, controlli sempre cliccabili, risultato di ricerca che sposta
  mappa e marker); la parity visiva e' del tema.

## Build e asset

Sorgenti in `resources/js/components/` (Lit 3, Leaflet 1.9, `leaflet.markercluster`, `leaflet.heat`); la build Vite scrive in
`public/` del modulo (`vite.config.js`, `build.outDir`) e `public_html/assets/geo` e' un link simbolico a
`laravel/Modules/Geo/public` (`php artisan xot:module-link`); i file compilati sono versionati perche' il server di produzione
non compila. Input Vite: `resources/css/app.css` e `resources/js/components/coordinate-picker-lit.js`; senza il link la home
rispondeva 500 con `ViteManifestNotFoundException`. Dettagli su build, widget e pagine in [maps-and-widgets.md](./maps-and-widgets.md).

## Test

`tests/Feature/MapPickerIntegrationTest.php`, `tests/Feature/Filament/Forms/`, spec Playwright `tests/Playwright/geo-map-lit*.spec.js`
(vedi [testing.md](./testing.md)).
