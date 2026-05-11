# Geo Module — Documentation Index

## Architecture

| Documento | Descrizione |
|-----------|-------------|
| [Filament Forms Components](./filament-forms-components.md) | **Guida principale** per componenti form: AddressInput, AddressSection, MapInput, ecc. |
| [Module Philosophy](./module-philosophy.md) | Perché Geo possiede la geolocalizzazione e come i moduli la consumano |

## Components

| Componente | Tipo | Path | Descrizione |
|-----------|------|------|-------------|
| **AddressInput** | Filament Field | `app/Filament/Forms/Components/AddressInput.php` | ✅ Campo indirizzo con pulsante geolocalizzazione |
| **AddressSection** | Filament Section | `app/Filament/Forms/Components/AddressSection.php` | Sezione campi indirizzo separati (via, civico, città, CAP) |
| **LatitudeLongitudeInput** | Filament Field | `app/Filament/Forms/Components/LatitudeLongitudeInput.php` | Coppia input testuali lat/lng (schema interno; mappa opzionale futura) |
| **LeafletMarkerMapInput** | Filament Field | `app/Filament/Forms/Components/LeafletMarkerMapInput.php` | Mappa Leaflet OSM, marker trascinabile, sync su due campi sibling lat/lng |
| AddressField | Filament Field | `app/Filament/Forms/Components/AddressField.php` | Legacy (verificare se deprecare) |
| AddressesField | Filament Field | `app/Filament/Forms/Components/AddressesField.php` | Multi-indirizzo (repeater-like) |

## Actions

| Action | Path | Descrizione |
|--------|------|-------------|
| GetCoordinatesAction | `app/Actions/GetCoordinatesAction.php` | Geocoding indirizzo → coordinate |
| ReverseGeocodeAction | `app/Actions/Nominatim/ReverseGeocodeAction.php` | Coordinate → indirizzo (Nominatim) |
| SearchPlacesAction | `app/Actions/Nominatim/SearchPlacesAction.php` | Ricerca luoghi (Nominatim) |

## Models

| Documento | Descrizione |
|-----------|-------------|
| [Analisi dominio modelli (sovrapposizioni, raccomandazioni)](./geo-models-domain-analysis.md) | **Partenza consigliata**: Address vs Location vs Place, Comune vs ComuneJson, IT vs US |

| Modello | Path | Descrizione breve |
|---------|------|-------------------|
| Address | `app/Models/Address.php` | Indirizzo PostalAddress persistito, morph, integrazione comuni IT |
| Location | `app/Models/Location.php` | Punto + campi testo semplificati (legacy/leggero) |
| Place | `app/Models/Place.php` | Snapshot geocoding / Places |
| Comune | `app/Models/Comune.php` | Comuni IT (Sushi + JSON) |

## Enums

| Enum | Path | Descrizione |
|------|------|-------------|
| AddressItemType | `app/Enums/AddressItemType.php` | Tipi di indirizzo (home, work, etc.) |

## Translations

| Lingua | Path | Namespace |
|--------|------|-----------|
| Italiano | `lang/it/address.php` | `geo::address.*` |
| English | `lang/en/address.php` | `geo::address.*` |
| Geolocation | `lang/it/geolocation.php` | `geo::geolocation.*` |

## Widgets

| Widget | Path | Descrizione |
|--------|------|-------------|
| LocationWidget | `app/Filament/Widgets/LocationWidget.php` | Widget mappa per admin panel |
| OSMMapWidget | `app/Filament/Widgets/OSMMapWidget.php` | Widget OpenStreetMap |

## Zen: Domain-Driven Design

**Geo possiede tutto ciò che è geo-spaziale.** I moduli consumatori (Fixcity, Municipal, User, etc.) importano i componenti da Geo.

### Nota UX geolocalizzazione

`AddressInput` espone stato di caricamento durante "use my location" (spinner + stato accessibile), per evitare click ripetuti e incertezza utente.

```php
// ✅ CORRETTO: importa da Geo
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label('Indirizzo')
    ->required()

// ❌ SBAGLIATO: reinventare geolocalizzazione nel modulo dominio
Placeholder::make('address')
    ->content(new HtmlString(\Blade::render('...')))
```

**Perché**:
- **Single Responsibility**: Geo = posizione, Fixcity = ticket
- **DRY**: Un solo componente, molti consumatori
- **Consistency**: Stesso comportamento in tutti i moduli
- **Maintainability**: Fix in un posto, beneficio ovunque
