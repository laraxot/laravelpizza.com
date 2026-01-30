# Filament 5 Method Visibility Rules

**Created:** January 2026
**Author:** Claude Opus 4.5 (claude-opus-4-5-20251101)
**Version:** 1.0.0
**Status:** Production Ready - Critical Rules

---

## Overview

In Filament 5.x (with Livewire 4.x), certain methods MUST be `public` because they are called from outside the class via Livewire's reactive system or Filament's internal components.

**Common Error:**
```
Symfony\Component\ErrorHandler\Error\FatalError
Access level to Filament\Tables\Concerns\InteractsWithTable::getTableActions() must be public
(as in class Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords)
```

---

## Critical Methods That MUST Be Public

### Table-Related Methods (InteractsWithTable trait)

These methods are called by Filament's table rendering system:

| Method | Why Public |
|--------|------------|
| `getTableActions()` | Called by table rendering to get row actions |
| `getTableBulkActions()` | Called by table rendering to get bulk actions |
| `getTableHeaderActions()` | Called by table rendering to get header actions |
| `getTableFilters()` | Called by table rendering to get filters |
| `getTableColumns()` | Called by table rendering to get columns |

### Widget Methods

| Method | Why Public |
|--------|------------|
| `getFormSchema()` | Called by Livewire for form rendering |
| `getHeading()` | Called by widget rendering |
| `getData()` | Usually protected (called internally) |
| `getOptions()` | Usually protected (called internally) |

---

## Correct Implementation Pattern

### XotBaseRelationManager

```php
<?php

namespace Modules\Xot\Filament\Resources\RelationManagers;

abstract class XotBaseRelationManager extends FilamentRelationManager
{
    // CRITICO: MUST be public
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make()->iconButton(),
            'detach' => DetachAction::make()->iconButton(),
        ];
    }

    // CRITICO: MUST be public
    public function getTableBulkActions(): array
    {
        return [
            'delete_bulk' => DeleteBulkAction::make()->iconButton(),
        ];
    }

    // CRITICO: MUST be public
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    // CRITICO: MUST be public
    public function getTableFilters(): array
    {
        return [];
    }
}
```

### HasXotTable Trait

```php
<?php

namespace Modules\Xot\Filament\Traits;

trait HasXotTable
{
    // CRITICO: MUST be public - called by Filament InteractsWithTable
    public function getTableActions(): array
    {
        // Implementation
    }

    // CRITICO: MUST be public
    public function getTableBulkActions(): array
    {
        // Implementation
    }

    // CRITICO: MUST be public
    public function getTableHeaderActions(): array
    {
        // Implementation
    }

    // CRITICO: MUST be public
    public function getTableFilters(): array
    {
        return [];
    }
}
```

---

## Livewire View Requirements

### Root Tag Requirement

All Livewire component views MUST have a single root HTML element:

**CORRECT:**
```blade
<div>
    <!-- Content here -->
    <h1>Title</h1>
    <p>Content</p>
</div>
```

**WRONG:**
```blade
<h1>Title</h1>
<p>Content</p>
<!-- No single root element! -->
```

### Error When Violated
```
Livewire\Exceptions\RootTagMissingFromViewException
Livewire encountered a missing root tag when trying to render a component.
When rendering a Blade view, make sure it contains a root HTML tag.
```

---

## Filament 5 Nested Resources

When using nested resources (ManageRelatedRecords), ensure:

1. **Relation Manager/Page Property:**
```php
protected static ?string $relatedResource = LessonResource::class;
```

2. **Nested Resource Property:**
```php
protected static ?string $parentResource = CourseResource::class;
```

3. **Custom Relationship Names:**
```php
public static function getParentResourceRegistration(): ?ParentResourceRegistration
{
    return CourseResource::asParent()
        ->relationship('lessons')
        ->inverseRelationship('course');
}
```

4. **URL Parameter Registration:**
```php
public static function getRelations(): array
{
    return [
        'lessons' => LessonsRelationManager::class,  // Key = relationship name
    ];
}
```

---

## ChartWidget with RawJs

When using JavaScript options in chart widgets:

```php
<?php

use Filament\Support\RawJs;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class MyChartWidget extends XotBaseChartWidget
{
    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [[
                'data' => [7.2, 8.1, 6.8],
                'voteCounts' => [45, 52, 38],  // Custom property for formatter
            ]],
            'labels' => ['Gen', 'Feb', 'Mar'],
        ];
    }

    // Can return array | RawJs | null
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            plugins: {
                datalabels: {
                    formatter: function(v, ctx) {
                        var votes = ctx.dataset.voteCounts[ctx.dataIndex];
                        return v.toFixed(1) + " (" + votes + " voti)";
                    }
                }
            }
        }
JS);
    }
}
```

---

## Debugging Checklist

When you encounter visibility errors:

1. **Check method visibility** - Must be `public` if called by Filament/Livewire
2. **Check return types** - Ensure they match parent class/trait
3. **Check view root element** - Must have single root HTML tag
4. **Clear caches:**
   ```bash
   php artisan cache:clear
   php artisan view:clear
   php artisan filament:cache-components
   ```

---

## Related Documentation

- [Filament Nested Resources](https://filamentphp.com/docs/5.x/resources/nesting)
- [Livewire Component Requirements](https://livewire.laravel.com/docs/components)
- [XotBaseChartWidget Documentation](./xot-base-chart-widget.md)

---

## SimpleChartWidget Patterns (January 2026)

### Custom Dataset Properties Pattern

When using Chart.js datalabels with multiple data sources:

```php
protected function getData(): array
{
    $avgRatings = [7.2, 8.1, 6.8];
    $voteCounts = [45, 52, 38];
    $totalSum = array_sum($voteCounts);

    return [
        'datasets' => [[
            'data' => $avgRatings,
            // Custom properties accessible in JavaScript formatter
            'voteCounts' => $voteCounts,   // For dual labels
            'totalSum' => $totalSum,        // For percentage calculations
            'percentageData' => [...],      // Pre-calculated percentages
        ]],
        'labels' => ['Gen', 'Feb', 'Mar'],
    ];
}
```

### JavaScript Formatter Access Pattern

Access custom dataset properties in formatters:

```javascript
formatter: function(v, ctx) {
    // Access custom property from dataset
    var voteCounts = ctx.dataset.voteCounts || [];
    var voters = voteCounts[ctx.dataIndex] || 0;
    return voters > 0 ? voters.toLocaleString("it-IT") + " voti" : "";
}
```

### Vertical vs Horizontal Bar Positioning

**CRITICAL DIFFERENCE:**

| Bar Type | anchor: 'end' Points To | align: 'top' Places Label |
|----------|-------------------------|---------------------------|
| **Horizontal** (indexAxis: 'y') | RIGHT end of bar | ABOVE right end ✓ |
| **Vertical** (default) | TOP of bar | OUTSIDE bar top ✓ |

**For Vertical Bar Dual Labels (Stacked Above):**
```javascript
labels: {
    count: {
        anchor: 'end', align: 'top', offset: 4,  // Closer to bar
        // ...
    },
    average: {
        anchor: 'end', align: 'top', offset: 28, // Stacked above count
        // ...
    }
}
```

### Working Examples

| Widget | Chart Type | Pattern | Key Feature |
|--------|------------|---------|-------------|
| `Simple04ChartWidget` | Vertical Bar | Dual stacked labels | offset-based stacking |
| `Simple08ChartWidget` | Doughnut | Center dual labels | percentages array |
| `Simple11ChartWidget` | Doughnut | Value + Percent | HSL colors |
| `Simple13ChartWidget` | Bar | Average + Voters | voteCounts array |
| `Simple20ChartWidget` | Bar | Value + Percentage | totalSum property |
| `Simple21ChartWidget` | Bar | Reference example | Complete pattern |

---

## 🚨 CRITICO: NO Custom Constructors in Livewire Widgets

**NEVER override the constructor in Livewire/Filament widgets!**

### Error

```
Internal Server Error: Cannot call constructor
```

### Why

Livewire manages component instantiation. The parent constructor has parameters that you can't pass when calling `parent::__construct()`.

### ❌ WRONG Pattern

```php
class MyWidget extends XotBaseChartWidget
{
    protected ChartService $chartService;

    public function __construct(?ChartService $chartService = null)
    {
        $this->chartService = $chartService ?? new ChartService;
        parent::__construct(); // ❌ FAILS - wrong parameters
    }
}
```

### ✅ CORRECT Patterns

**Option 1: Self-contained with constants**
```php
class MyWidget extends XotBaseChartWidget
{
    private const DATA = [7.5, 8.0, 7.3];
    private const LABELS = ['A', 'B', 'C'];

    protected function getData(): array
    {
        return [
            'datasets' => [['data' => self::DATA]],
            'labels' => self::LABELS,
        ];
    }
}
```

**Option 2: Create service in method**
```php
protected function getData(): array
{
    $chartService = new ChartService(); // Create when needed
    return $chartService->getChartData();
}
```

**Option 3: Use mount() for initialization**
```php
public ?ChartService $chartService = null;

public function mount(): void
{
    $this->chartService = new ChartService();
}
```

---

**Last Updated:** 28 January 2026
**Maintainer:** Laraxot Team + Claude Opus 4.5
