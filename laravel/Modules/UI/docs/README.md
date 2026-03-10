# Modulo UI - Componenti Condivisi

## Overview

Il modulo **UI** fornisce componenti Blade, widget Filament e asset condivisi per tutti i moduli e temi.

## Struttura Componenti

```
resources/views/components/ui/
├── buttons/
│   ├── primary.blade.php
│   └── secondary.blade.php
├── cards/
│   ├── base.blade.php
│   └── collapsible.blade.php
├── forms/
│   ├── input.blade.php
│   └── select.blade.php
└── layout/
    ├── container.blade.php
    └── divider.blade.php
```

## Utilizzo

```blade
<x-ui::ui.button type="primary">
    Salva
</x-ui::ui.button>

<x-ui::ui.card>
    Contenuto
</x-ui::ui.card>
```

## Widget Filament

- `CalendarWidget`: FullCalendar integration
- `StatsOverviewWidget`: Statistiche dashboard
- `ChartWidget`: Grafici integrati

## Collegamenti

- [Regole Posizionamento](../../.cursor/rules/ui-components-rules.mdc)
- [Filament Widgets](./widgets/)

## Regole Fondamentali

1. **MAI posizionare componenti in root** - Usare solo `Modules/UI/resources/views/components/ui/`
2. **Prefisso obbligatorio** - Usare `<x-ui::ui.componente />`
3. **PHPDoc completo** per ogni componente

## Backlinks

- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)
