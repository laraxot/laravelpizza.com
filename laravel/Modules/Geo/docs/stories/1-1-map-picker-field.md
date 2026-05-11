# Story 1-1: MapPicker Field per Filament

**Status**: `done`
**Module**: Geo
**Epic**: Geo Form Components

---

## Descrizione

Campo Filament v5 personalizzato `MapPicker` che gestisce una mappa interattiva basata su Leaflet, incapsulata in un Web Component Lit. Integrato con Livewire 3 e Alpine.js. Lavora con due colonne reali del database `latitude` e `longitude` senza JSON.

---

## Acceptance Criteria

- [x] **AC1**: `MapPicker::make()` con fluent API `.latitude()` / `.longitude()`
- [x] **AC2**: Due colonne reali DB (`latitude`, `longitude`), nessun JSON
- [x] **AC3**: Lit Web Component `<geo-map-picker>` con Shadow DOM in Blade inline
- [x] **AC4**: Alpine.js orchestratore tra Livewire e Web Component
- [x] **AC5**: Geolocalizzazione browser quando i valori sono null
- [x] **AC6**: Toggle fullscreen con `invalidateSize()` Leaflet
- [x] **AC7**: Layer stradale (OSM) + Layer satellitare (Esri WorldImagery)
- [x] **AC8**: Reverse geocoding con Nominatim (OpenStreetMap)
- [x] **AC9**: Validazione visiva inline (input colorati rosso/verde)
- [x] **AC10**: `$wire.entangle(statePath).live` per `latitude` e `longitude`
- [x] **AC11**: PHPStan level max — zero errori
- [x] **AC12**: Laravel Pint — zero violazioni stile
- [x] **AC13**: Pest tests — 2 test, 9 assertion, tutti verdi

---

## Files Implementati

### PHP
- `Modules/Geo/app/Filament/Forms/Components/MapPicker.php`

### Blade/View
- `Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php`

### Tests
- `Modules/Geo/tests/Unit/Filament/MapPickerTest.php` (2 test)
- `Modules/Geo/tests/Unit/Filament/FilamentComponentsTest.php` (MapPicker test)

---

## Quality Gates Verificati

| Gate      | Risultato                        |
|-----------|----------------------------------|
| PHPStan   | ✅ No errors (level max)         |
| Pint      | ✅ Pass                          |
| Pest      | ✅ 2 passed (9 assertions)       |
| PHPMD     | ⚠️ Non installato nel progetto   |

---

## Note Tecniche

- Il Web Component usa `<script type="module">` inline via `@once` (no FilamentAsset)
- Loop prevention tramite `lastSignature = lat.toFixed(6):lng.toFixed(6)`
- `setUp()` chiama `$this->dehydrated(false)` per evitare idratazione automatica
- `resolveSiblingStatePath()` gestisce path assoluti vs relativi per latitude/longitude
