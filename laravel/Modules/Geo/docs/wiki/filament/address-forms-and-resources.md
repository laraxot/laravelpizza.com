---
title: "Filament: campi indirizzo, picker, risorse e pagine di Geo"
type: reference
status: active
module: Geo
tags: [geo, filament, address, resource, form-component, widget, page]
updated: 2026-11-25
qmd: "filament AddressResource LocationResource AddressesField AddressField AddressSection CoordinatesSection LocationSelector picker widget pagine XotBase"
related:
  - ../data/address-model.md
  - ../data/italian-geography.md
  - ../maps/coordinate-picker.md
---

# Filament: campi indirizzo, picker, risorse e pagine di Geo

Tutto estende le classi `XotBase*` (mai Filament direttamente): `XotBaseResource`, `XotBaseWidget`, `XotBasePage`, `XotBaseField`,
`XotBaseSection`, `XotBaseRepeater`, `XotBaseBulkAction`, `XotBaseDashboard`.

## Risorse

- **`AddressResource`** (`$model = Address::class`): form in `AddressResource\Schemas\AddressForm` (select a cascata regione ->
  provincia -> comune -> CAP, poi `route`, `street_number`, `is_primary`; vedi [italian-geography](../data/italian-geography.md)),
  infolist in `Schemas\AddressInfolist`, tabelle `Tables\AddressesTable`, pagine `Create/Edit/List/ViewAddress`.
  `AddressResource::getSearchStep()` espone lo stesso quartetto di select per i wizard dei moduli ospiti. Nessun
  `navigationGroup`: lo gestisce `XotBaseResource`.
- **`LocationResource`** (`$model = Location::class`): form `LocationForm`, infolist, `LocationsTable`, pagine `Create/Edit/List/ViewLocation`
  (le stesse quattro pagine sono duplicate in `Resources/Pages/`).

## Campi form

| Campo | Cosa fa | Vista Blade (`resources/views/filament/forms/components/`) |
|---|---|---|
| `AddressesField` (estende `XotBaseRepeater`) | repeater di indirizzi con lo schema di `AddressResource`; `name` e `is_primary` compaiono solo con piu' di un indirizzo; attivare `is_primary` su una riga lo spegne sulle altre; con un solo indirizzo `is_primary` e' sempre `true` (`dehydrateStateUsing`); `defaultItems(1)`, `columnSpanFull()`, `live()` | `addresses-field` |
| `AddressField`, `AddressSection`, `AddressInput` | sezione/campo singolo di indirizzo | `address-input` |
| `LocationSelector` (`XotBaseGroup`) | selezione geografica gerarchica | - |
| `CoordinatesSection` | latitudine/longitudine con validazione e azione «geocodeCoordinates» (usa `UpdateCoordinatesFromAddressAction`) | - |
| `CoordinatePicker`, `MapPicker`, `GeopointPicker`, `LocationPicker`, `PlacePicker`, `LatitudeLongitudeInput`, `MapPositioner`, `MapLocationInput`, `LeafletMarkerMapInput` | famiglia dei picker su mappa (Web Component Lit) | `coordinate-picker`, `map-picker`, `geopoint-picker`, `location-picker`, `place-picker`, `latitude-longitude-input(-lit)`, `map-positioner`, `map-location-input`, `leaflet-marker-map-input` |

I picker condividono `Traits\HasCoordinatePicker` e `CoordinatePickerHelpers`; ruoli, differenze e persistenza delle coordinate:
[coordinate-picker](../maps/coordinate-picker.md). Famiglia di Web Component: [map-components](../maps/map-components.md).
`Modules\Geo\Filament\Forms\LocationForm` e `Filament\Widgets\LocationWidget` sono wrapper per i form/widget di posizione.

## Widget e pagine

- **Widget**: `GeoMapWidget` (mappa con dataset GeoJSON, vedi [map-widget-and-dataset](../maps/map-widget-and-dataset.md)), `LocationMapWidget`,
  `LocationMapTableWidget`, `LocationWidget`, `LatLngWidget`, `OSMMapWidget`, `BaseMapWidget`. Le copie con estensione
  `.disabled`, `.fila3`, `.disabled2..4` in `app/Filament/Widgets` e `app/Filament/Pages` (Dotswan, Webbingbrasil, OSMMap) sono varianti
  spente e non caricate.
- **Pagine**: `Dashboard`, `LocationMap`, `LocationMapTable`, `LatLng`, `OSMMap`, `SettingPage`.
- **Azioni**: `Filament\Actions\UpdateCoordinatesBulkAction` ([update-coordinates](../geocoding/update-coordinates.md)).

## Regole per chi aggiunge un campo

- Estendere sempre la base `XotBase*` corrispondente; `declare(strict_types=1)`; etichette in `lang/*/` (chiave `geo::...`), non stringhe nel
  codice (`AddressesField` ha ancora l'etichetta «Aggiungi Indirizzo» scritta nel metodo `setUp()`: debito).
- Icone: file `.svg` in `resources/svg/` e `<x-filament::icon icon="geo-...">`, non SVG inline nelle viste.
- Ogni Web Component Lit usato da un campo deve essere importato dal bundle del tema che mostra il form; altrimenti il browser vede un
  tag sconosciuto e la mappa non appare (verifica: `customElements.get('<tag>')` nella console).
