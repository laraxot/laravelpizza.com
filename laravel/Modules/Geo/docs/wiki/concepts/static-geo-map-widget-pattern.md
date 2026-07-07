---
type: concept
module: Geo
sources:
  - ../../stories/1-1-map-picker-field.md
  - ../../../../../../docs/quality-tools-setup.md
confidence: high
updated: 2026-04-16
---

# Static Geo Map Widget Pattern

## Intent

Pattern per widget Filament GEO che devono mostrare una mappa Leaflet performante con dataset statico locale, stato client-side persistente e zero round-trip server durante l'interazione ordinaria.

## Struttura

- `Filament Widget` PHP minimale: espone config, dataset e serializzazione JSON
- `Support object` dedicato: parsing GeoJSON, normalizzazione, categorie, statistiche
- `Lit Web Component`: isolamento UI con Shadow DOM reale
- `Leaflet layer manager`: gestione base layers, cluster, points, heatmap, zones
- `GeoJSON statico`: file locale nel modulo, caricato una sola volta lato client

## Regole

- Tutto resta dentro `Modules/Geo`
- Nessuna dipendenza CDN
- Dipendenze reali e verificabili: `leaflet`, `leaflet.markercluster`, `leaflet.heat`, `lit`
- Dataset max ~3000 punti per mantenere il pattern single-load di `farmshops.eu`
- Niente fetch incrementali per popup o dettaglio se il dataset è già sufficiente
- LOD obbligatorio: `cluster` → `aggregate` → `detail`

## Motivazione

Questo pattern replica l'idea chiave di `farmshops.eu`: performance stabili con dataset statico, clustering client-side e UX immediata. La differenza nel modulo Geo è l'incapsulamento rigoroso in Filament v5 + Lit + Vite locale.

## Implementazione corrente

- Widget: `Modules/Geo/app/Filament/Widgets/GeoMapWidget.php`
- Support: `Modules/Geo/app/Support/GeoMapDataset.php`
- View: `Modules/Geo/resources/views/filament/widgets/geo-map-widget.blade.php`
- Web Component: `Modules/Geo/resources/js/widgets/geo-map-widget.js`
- Dataset sample: `Modules/Geo/resources/data/geo-map-widget.geojson`

## Quality Gates

- `phpstan` sul perimetro del widget
- `phpmd` via `php tools/phpmd.phar ...`
- `phpinsights` via `.phar` workflow del progetto
- `pest` per dataset support object e widget config

## Pattern `geo-map-lit` (ticket-list pubblico)

Variante del pattern per pagine pubbliche (non Filament admin):

- **Generatore**: `Modules/Fixcity/app/Actions/GenerateTicketsJsonAction::execute()`
- **Output path**: `base_path('../public_html/data/tickets.json')` (un livello sopra `laravel/`)
- **Endpoint**: `/data/tickets.json` (servito da `public_html/data/`)
- **Componente**: `<geo-map-lit data-url="/data/tickets.json">` via Vite bundle `assets/geo`
- **Trigger rigenerazione**: da `ListTickets` page header action, o a mano via tinker

### Path corretto

```php
// ✅ CORRETTO (public_html è UN livello sopra laravel/)
$outputPath = base_path('../public_html/data/tickets.json');

// ❌ SBAGLIATO (due livelli su — non esiste)
$outputPath = base_path('../../public/data/tickets.json');

// ❌ SBAGLIATO (public_html non è dentro laravel/)
$outputPath = base_path('public_html/data/tickets.json');
```

### Fix bug noti (story 8-78, 2026-04-29)

- `GenerateTicketsJsonAction`: usava `$t->title` (campo inesistente) → corretto in `$t->name`
- `$t->type->value` su stringa → corretto con `getAttribute('type')` + `BackedEnum` check
- Path errato → corretto in `../public_html/data/tickets.json`

## Regole correlate

- [geo-map-controls-unification-rule](./geo-map-controls-unification-rule.md) — controlli mappa devono essere unificati tra `geo-map-lit` e `coordinate-picker-lit`
- [geo-vite-build-contract](./geo-vite-build-contract.md)
- [geo-map-lit entity](../entities/geo-map-lit.md)