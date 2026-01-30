# LimeSurvey Chart Generation - Chart Module Guide

**Created:** January 2026
**Author:** Claude Opus 4.5 (claude-opus-4-5-20251101)
**Version:** 1.0.0
**Status:** Production Ready

---

## Table of Contents

1. [Overview](#overview)
2. [Dual Library Strategy](#dual-library-strategy)
3. [Chart.js for Frontend](#chartjs-for-frontend)
4. [JpGraph for PDF](#jpgraph-for-pdf)
5. [Data Transformation](#data-transformation)
6. [Chart Types for Surveys](#chart-types-for-surveys)
7. [Color Management](#color-management)

---

## Overview

The Chart module provides chart generation capabilities for both:

1. **Interactive dashboards** (Chart.js - frontend)
2. **PDF exports** (JpGraph - server-side PNG)

This document explains how to generate charts from LimeSurvey survey data.

---

## Dual Library Strategy

### Why Two Libraries?

| Aspect | Chart.js | JpGraph |
|--------|----------|---------|
| Environment | Browser (JavaScript) | Server (PHP) |
| Output | Canvas/SVG | PNG/JPG/SVG |
| Interactivity | Full (hover, zoom, click) | None (static image) |
| Use Case | Filament dashboards | PDF reports |
| Dependencies | NPM package | Composer package |

### Workflow

```
Survey Data (Limesurvey Module)
        ↓
    +---+---+
    |       |
    v       v
Chart.js   JpGraph
(Frontend) (Backend)
    |       |
    v       v
Dashboard  PDF
```

---

## Chart.js for Frontend

### Asset Registration (CRITICAL)

**🚨 All Chart.js plugins are registered ONLY in this module.**

```php
// Modules/Chart/app/Providers/Filament/AdminPanelProvider.php
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;

public function boot(): void
{
    FilamentAsset::register([
        Js::make('chart-js-plugins', Vite::asset(
            'resources/js/filament-chart-js-plugins.js',
            'assets/chart'
        ))->module(),
    ]);
}
```

### Plugin Registration

```javascript
// Modules/Chart/resources/js/filament-chart-js-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

### Widget Implementation

Widgets in other modules (Quaeris) extend `XotBaseChartWidget`:

```php
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class SurveyChartWidget extends XotBaseChartWidget
{
    protected function getData(): array
    {
        return [
            'datasets' => [[
                'data' => [...],
                'voters' => [...],  // Custom property for formatter
            ]],
            'labels' => [...],
        ];
    }

    protected function getOptions(): array
    {
        $options = parent::getOptions();
        $options['plugins']['datalabels'] = [
            'formatter' => 'function(value, ctx) {
                var voters = ctx.dataset.voters[ctx.dataIndex];
                return value.toFixed(1) + "\\n" + voters + " voti";
            }',
        ];
        return $options;
    }
}
```

---

## JpGraph for PDF

### Available Actions

| Action Class | Chart Type | Use Case |
|--------------|------------|----------|
| `Bar1Action` | Vertical bars | Monthly counts |
| `Bar2Action` | Grouped bars | Comparisons |
| `Bar3Action` | Stacked bars | Composition |
| `HorizBar1Action` | Horizontal bars | Rankings |
| `Pie1Action` | Pie chart | Distribution |
| `PieAvgAction` | Pie with average | Rating distribution |
| `LineSubQuestionAction` | Line chart | Trends |

### Basic Usage

```php
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;
use Modules\Chart\Actions\JpGraph\V1\Bar1Action;

// 1. Prepare chart configuration
$chartData = ChartData::from([
    'type' => 'bar1',
    'width' => 800,
    'height' => 400,
    'list_color' => '#22c55e,#3b82f6,#fbbf24,#ef4444',
    'transparency' => 0.8,
]);

// 2. Prepare answers data
$answersChartData = AnswersChartData::from([
    'answers' => collect([
        ['label' => 'Jan', 'value' => 7.2, 'count' => 45],
        ['label' => 'Feb', 'value' => 8.1, 'count' => 52],
        ['label' => 'Mar', 'value' => 6.8, 'count' => 38],
    ]),
    'chart' => $chartData,
]);

// 3. Generate chart
$graph = app(Bar1Action::class)->execute($answersChartData);

// 4. Save as PNG
$imagePath = public_path('chart/monthly-survey.png');
$graph->Stroke($imagePath);
```

### Chart Type Selection

```php
// Get action class from chart type
$actionClass = match($chartType) {
    'bar1' => Bar1Action::class,
    'bar2' => Bar2Action::class,
    'bar3' => Bar3Action::class,
    'horizbar1' => HorizBar1Action::class,
    'pie1' => Pie1Action::class,
    'pieAvg' => PieAvgAction::class,
    'lineSubQuestion' => LineSubQuestionAction::class,
    default => Bar1Action::class,
};

$graph = app($actionClass)->execute($answersChartData);
```

---

## Data Transformation

### From LimeSurvey to Chart.js

```php
use Illuminate\Support\Facades\DB;
use Modules\Limesurvey\Models\SurveyResponse;

// Query monthly stats
$monthlyStats = SurveyResponse::getResponsesForSurvey($surveyId)
    ->whereNotNull('submitdate')
    ->select([
        DB::raw("DATE_FORMAT(submitdate, '%Y-%m') as month"),
        DB::raw("DATE_FORMAT(submitdate, '%b') as month_label"),
        DB::raw("COUNT(*) as response_count"),
        DB::raw("AVG(CAST(`$fieldName` AS DECIMAL(10,2))) as avg_rating"),
    ])
    ->groupBy(DB::raw("DATE_FORMAT(submitdate, '%Y-%m')"))
    ->groupBy(DB::raw("DATE_FORMAT(submitdate, '%b')"))
    ->orderBy('month')
    ->get();

// Transform for Chart.js
$chartJsData = [
    'datasets' => [[
        'data' => $monthlyStats->pluck('avg_rating')->toArray(),
        'voters' => $monthlyStats->pluck('response_count')->toArray(),
        'backgroundColor' => [...],
    ]],
    'labels' => $monthlyStats->pluck('month_label')->toArray(),
];
```

### From LimeSurvey to JpGraph

```php
// Transform for JpGraph (AnswersChartData format)
$answers = $monthlyStats->map(fn($row) => [
    'label' => $row->month_label,
    'value' => (float) $row->avg_rating,
    'count' => (int) $row->response_count,
])->toArray();

$answersChartData = AnswersChartData::from([
    'answers' => collect($answers),
    'chart' => ChartData::from([...]),
]);
```

---

## Chart Types for Surveys

### Recommended Chart Types by Data

| Data Type | Chart.js | JpGraph | When to Use |
|-----------|----------|---------|-------------|
| Monthly counts | `bar` | `bar1` | Response volume over time |
| Monthly averages | `bar` | `bar1` | Rating trends over time |
| Rating distribution | `doughnut` | `pie1` | Score breakdown (1-10) |
| Category counts | `bar` | `horizbar1` | Answer option comparison |
| Trend over time | `line` | `lineSubQuestion` | Long-term patterns |
| Multiple metrics | `bar` | `bar2` | Comparing different questions |

### Combined Count + Average

Use multiline datalabels for DRY approach:

```php
$options['plugins']['datalabels'] = [
    'formatter' => 'function(value, ctx) {
        var count = ctx.dataset.voters[ctx.dataIndex];
        return value.toFixed(1) + "\\n" + count + " voti";
    }',
];
```

---

## Color Management

### Rating Color Scale

```php
// Chart module color service (conceptual)
class ChartColorService
{
    public static function getRatingColor(float $rating): string
    {
        return match (true) {
            $rating >= 8.5 => '#22c55e',  // Green - Excellent
            $rating >= 7.5 => '#3b82f6',  // Blue - Good
            $rating >= 6.0 => '#fbbf24',  // Amber - Average
            default => '#ef4444',          // Red - Poor
        };
    }

    public static function getRatingColors(array $ratings): array
    {
        return array_map([self::class, 'getRatingColor'], $ratings);
    }
}
```

### JpGraph Color Format

JpGraph uses comma-separated hex colors:

```php
$chartData = ChartData::from([
    'list_color' => '#22c55e,#3b82f6,#fbbf24,#ef4444',
]);
```

### Chart.js Color Format

Chart.js accepts various formats:

```php
'backgroundColor' => [
    'rgba(34, 197, 94, 0.8)',   // Green with alpha
    'rgba(59, 130, 246, 0.8)',  // Blue with alpha
    '#fbbf24',                   // Hex
    'rgb(239, 68, 68)',         // RGB
],
```

---

## Related Documentation

- [chartjs-plugin-datalabels Guide](./chartjs-plugin-datalabels-filament5.md)
- [Survey Chart Widget Implementation](../../Quaeris/docs/survey-chart-widget-implementation.md)
- [Question Types Reference](../../Limesurvey/docs/question-types-complete-reference.md)
- [PDF Generation Workflow](../../Quaeris/docs/pdf-generation-workflow.md)

---

**Last Updated:** January 2026
**Maintainer:** Laraxot Team + Claude Opus 4.5
