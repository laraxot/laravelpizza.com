---
title: Regola — mai estendere Filament\Widgets direttamente
type: rule
tags: [filament, widget, xotbase]
qmd:
  index: true
created_at: 2026-06-10
updated_at: 2026-06-10
---

# Regola — mai estendere Filament\Widgets direttamente

| OK | NO |
|----|-----|
| `extends XotBaseWidget` (minimo) | `extends Filament\Widgets\Widget` |
| `extends XotBaseSchemaWidget` | `extends Filament\Widgets\ChartWidget` |
| `extends XotBaseTableWidget` | `extends Filament\Widgets\TableWidget` |

Canon: [xotbase-filament-widget-hierarchy](../concepts/xotbase-filament-widget-hierarchy.md)
