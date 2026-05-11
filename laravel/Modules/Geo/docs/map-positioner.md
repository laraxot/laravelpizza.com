# MapPositioner (Filament v5)

## Overview
`MapPositioner` è l'evoluzione del componente di selezione geografica nel modulo `Geo`. Utilizza un'architettura **Unified State** per gestire coordinate geografiche `{ latitude, longitude }` in modo atomico e robusto.

## Stack Tecnico
- **PHP**: `MapPositioner` (extends `XotBaseField`)
- **UI Boundary**: Lit Web Component (`map-positioner-lit`)
- **Glue Layer**: Alpine.js (adapter minimale)
- **Engine**: Leaflet.js
- **Validation**: Playwright (visual regression)

## Caratteristiche Principali
- **Unified State**: Lo stato del form è un singolo oggetto, riducendo race conditions tra input separati.
- **Auto-Resize**: Gestione robusta dell'inizializzazione in container inizialmente nascosti (es. step successivi di un Wizard).
- **Shadow DOM**: Isolamento completo degli stili Leaflet.
- **Playwright Ready**: Predisposto per screenshot automatizzati e test di fumo visivi.

## Utilizzo in Filament
```php
use Modules\Geo\Filament\Forms\Components\MapPositioner;

MapPositioner::make('location')
    ->defaultLocation(41.9028, 12.4964)
    ->zoom(15)
    ->height('500px');
```

## Strumenti Visivi (Playwright)
Per generare uno screenshot di anteprima del componente:
```bash
npx playwright screenshot --viewport-size=1024,768 http://localhost:8000/tests/map-positioner docs/img/map-positioner-preview.png
```

---
*Documentazione generata per LLM Wiki. Aprile 2026.*
