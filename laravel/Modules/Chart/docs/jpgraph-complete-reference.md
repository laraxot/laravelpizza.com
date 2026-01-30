# JpGraph Complete Reference Guide

**Created:** January 2026
**Author:** Claude Opus 4.5 (claude-opus-4-5-20251101)
**Version:** 1.0.0
**Status:** Production Ready

**Sources:**
- [JpGraph Official Site](https://jpgraph.net/)
- [JpGraph Documentation Portal](https://jpgraph.net/doc/)
- [JpGraph Manual - Bar Graphs](https://jpgraph.net/doc/barcodes.html)
- [mitoteam/jpgraph on GitHub](https://github.com/mitoteam/jpgraph)
- [Packagist: mitoteam/jpgraph](https://packagist.org/packages/mitoteam/jpgraph)

---

## Table of Contents

1. [Overview](#overview)
2. [Installation](#installation)
3. [Chart Types Reference](#chart-types-reference)
4. [Bar Charts Deep Dive](#bar-charts-deep-dive)
5. [Pie Charts Deep Dive](#pie-charts-deep-dive)
6. [Line Charts](#line-charts)
7. [Styling & Customization](#styling--customization)
8. [Gradient Fills](#gradient-fills)
9. [Font Management](#font-management)
10. [Caching System](#caching-system)
11. [Integration with Laravel](#integration-with-laravel)
12. [Alternative Libraries Comparison](#alternative-libraries-comparison)

---

## Overview

JpGraph is a mature, feature-rich PHP library for generating dynamic charts and graphs as PNG, JPG, GIF, or SVG images. It's ideal for server-side chart generation in PDF reports.

### Key Features

| Feature | Description |
|---------|-------------|
| **Chart Types** | 15+ types (Line, Bar, Pie, Radar, Polar, Scatter, Gantt, etc.) |
| **Output Formats** | PNG, JPG, GIF, SVG |
| **PHP Support** | PHP 5.1 through PHP 8.5 (via mitoteam/jpgraph) |
| **Image Size** | Optimized output (typical 2-4KB) |
| **Caching** | Built-in caching system |
| **Anti-aliasing** | Full anti-aliased rendering |
| **Alpha Blending** | Transparency support |
| **Gradients** | 8 gradient fill styles |
| **Fonts** | TTF and built-in font support |

### When to Use JpGraph

| Use Case | JpGraph | Chart.js |
|----------|---------|----------|
| PDF Generation | ✅ Ideal | ❌ Requires canvas |
| Email Reports | ✅ Static images | ❌ Not embedded |
| Interactive Dashboards | ❌ Static | ✅ Ideal |
| Server-side Processing | ✅ Native PHP | ❌ Requires Node |
| Print Quality | ✅ High resolution | ⚠️ Depends on export |

---

## Installation

### Via Composer (Recommended)

```bash
# Install mitoteam/jpgraph (PHP 8.x compatible fork)
composer require mitoteam/jpgraph

# Or specify version
composer require mitoteam/jpgraph:^11.0
```

### Package Features (mitoteam/jpgraph)

- **Maintained fork** of original JpGraph
- **PHP 8.5 compatible** (as of 2025)
- **Composer autoloading** - no manual includes needed
- **PSR-4 namespace** - `mitoteam\jpgraph\*`
- **All chart types included** - no separate module downloads

### Manual Installation (Legacy)

```bash
# Download from jpgraph.net
wget https://jpgraph.net/download/jpgraph-4.4.2.tar.gz
tar -xzf jpgraph-4.4.2.tar.gz

# Copy to project
cp -r jpgraph-4.4.2/src/* vendor/jpgraph/
```

### Verify Installation

```php
<?php
require_once 'vendor/autoload.php';

use mitoteam\jpgraph\Graph;
use mitoteam\jpgraph\plot\BarPlot;

// Create test graph
$graph = new Graph(400, 300);
$graph->SetScale('textlin');
$data = [40, 60, 31, 22];
$plot = new BarPlot($data);
$graph->Add($plot);

// Output to browser or file
$graph->Stroke(); // Browser
// $graph->Stroke('/path/to/image.png'); // File
```

---

## Chart Types Reference

### Available Chart Types

| Type | Class | Use Case |
|------|-------|----------|
| **Line** | `LinePlot` | Trends, time series |
| **Bar** | `BarPlot` | Comparisons, categories |
| **Grouped Bar** | `GroupBarPlot` | Multi-series comparison |
| **Accum Bar** | `AccBarPlot` | Stacked totals |
| **Pie** | `PiePlot` | Distribution, percentages |
| **Pie 3D** | `PiePlot3D` | Visual distribution |
| **Scatter** | `ScatterPlot` | Correlation |
| **Radar** | `RadarPlot` | Multi-variable comparison |
| **Polar** | `PolarPlot` | Circular data |
| **Stock** | `StockPlot` | Financial data (OHLC) |
| **Gantt** | `GanttChart` | Project timelines |
| **Contour** | `ContourPlot` | 3D surface data |
| **Field** | `FieldPlot` | Vector fields |
| **Error** | `ErrorPlot` | Data with error bars |

### Include Requirements

```php
// With Composer (mitoteam/jpgraph)
use mitoteam\jpgraph\Graph;
use mitoteam\jpgraph\plot\BarPlot;
use mitoteam\jpgraph\plot\LinePlot;
use mitoteam\jpgraph\plot\PiePlot;
use mitoteam\jpgraph\plot\PiePlot3D;

// Legacy manual includes
require_once 'jpgraph/jpgraph.php';
require_once 'jpgraph/jpgraph_bar.php';
require_once 'jpgraph/jpgraph_line.php';
require_once 'jpgraph/jpgraph_pie.php';
require_once 'jpgraph/jpgraph_pie3d.php';
```

---

## Bar Charts Deep Dive

### Bar Chart Variants

JpGraph supports **8 different bar chart styles**:

| Variant | Description | Best For |
|---------|-------------|----------|
| `BarPlot` | Standard vertical bars | Category comparison |
| `AccBarPlot` | Accumulated/Stacked bars | Part-to-whole |
| `GroupBarPlot` | Grouped side-by-side | Multi-series |
| `BarPlot` (horizontal) | Horizontal bars | Rankings, long labels |
| `BarPlot` (waterfall) | Waterfall chart | Financial changes |
| `BarPlot` (pattern) | Bars with patterns | B&W printing |
| `BarPlot` (gradient) | Gradient filled bars | Modern look |
| `BarPlot` (3D) | 3D effect bars | Visual impact |

### Basic Bar Chart

```php
use mitoteam\jpgraph\Graph;
use mitoteam\jpgraph\plot\BarPlot;

$data = [40, 60, 31, 22, 85, 70];
$labels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'];

$graph = new Graph(800, 400);
$graph->SetScale('textlin');
$graph->xaxis->SetTickLabels($labels);

$plot = new BarPlot($data);
$plot->SetFillColor('#3b82f6');
$plot->SetWidth(0.6);

// Add data labels on bars
$plot->value->Show();
$plot->value->SetFormat('%d');
$plot->value->SetFont(FF_ARIAL, FS_BOLD, 10);

$graph->Add($plot);
$graph->Stroke('/path/to/chart.png');
```

### Grouped Bar Chart

```php
use mitoteam\jpgraph\plot\GroupBarPlot;

$data1 = [40, 60, 31, 22];  // Series 1
$data2 = [55, 45, 67, 33];  // Series 2

$plot1 = new BarPlot($data1);
$plot1->SetFillColor('#3b82f6');
$plot1->SetLegend('2024');

$plot2 = new BarPlot($data2);
$plot2->SetFillColor('#22c55e');
$plot2->SetLegend('2025');

$grouped = new GroupBarPlot([$plot1, $plot2]);
$graph->Add($grouped);
```

### Stacked Bar Chart

```php
use mitoteam\jpgraph\plot\AccBarPlot;

$data1 = [40, 60, 31, 22];  // Bottom
$data2 = [55, 45, 67, 33];  // Top

$plot1 = new BarPlot($data1);
$plot1->SetFillColor('#3b82f6');

$plot2 = new BarPlot($data2);
$plot2->SetFillColor('#22c55e');

$stacked = new AccBarPlot([$plot1, $plot2]);
$graph->Add($stacked);
```

### Horizontal Bar Chart

```php
$graph = new Graph(600, 400);
$graph->SetScale('textlin');
$graph->Set90AndMargin(100, 20, 50, 30);  // Rotate 90 degrees

$plot = new BarPlot($data);
$plot->SetFillColor('#3b82f6');
$graph->Add($plot);
```

---

## Pie Charts Deep Dive

### 2D Pie Chart

```php
use mitoteam\jpgraph\PieGraph;
use mitoteam\jpgraph\plot\PiePlot;

$data = [40, 25, 20, 15];
$labels = ['Eccellente', 'Buono', 'Sufficiente', 'Insufficiente'];

$graph = new PieGraph(500, 400);
$graph->SetShadow();

$plot = new PiePlot($data);
$plot->SetCenter(0.5, 0.5);
$plot->SetSize(0.35);
$plot->SetLabels($labels);
$plot->SetLabelType(PIE_VALUE_PER);  // Show percentages

// Colors
$plot->SetSliceColors(['#22c55e', '#3b82f6', '#fbbf24', '#ef4444']);

$graph->Add($plot);
$graph->Stroke('/path/to/pie.png');
```

### 3D Pie Chart

```php
use mitoteam\jpgraph\plot\PiePlot3D;

$plot = new PiePlot3D($data);
$plot->SetAngle(45);           // 3D perspective angle
$plot->SetHeight(15);          // 3D thickness
$plot->SetCenter(0.5, 0.55);

// Explode first slice
$plot->ExplodeSlice(0);
// Or explode multiple
$plot->ExplodeAll(10);  // 10 pixel explosion

$graph->Add($plot);
```

### Pie Chart Label Types

```php
// Label format constants
PIE_VALUE_ABS     // Absolute values (40, 25, 20, 15)
PIE_VALUE_PER     // Percentages (40%, 25%, 20%, 15%)
PIE_VALUE_ADJPER  // Adjusted percentages
PIE_VALUE_ADJPERCENTAGE  // With decimal
```

### Donut Chart (Pie with Center Hole)

```php
$plot = new PiePlot($data);
$plot->SetSize(0.4);           // Outer radius
$plot->SetMidSize(0.6);        // Inner radius (creates hole)
```

---

## Line Charts

### Basic Line Chart

```php
use mitoteam\jpgraph\plot\LinePlot;

$data = [40, 60, 31, 22, 85, 70, 55];

$graph = new Graph(800, 300);
$graph->SetScale('textlin');

$plot = new LinePlot($data);
$plot->SetColor('#3b82f6');
$plot->SetWeight(2);

// Add markers
$plot->mark->SetType(MARK_FILLEDCIRCLE);
$plot->mark->SetFillColor('#3b82f6');
$plot->mark->SetSize(6);

$graph->Add($plot);
```

### Filled Area Line

```php
$plot = new LinePlot($data);
$plot->SetFillColor('#3b82f680');  // With alpha
$plot->SetColor('#3b82f6');
```

### Multiple Lines

```php
$plot1 = new LinePlot($data1);
$plot1->SetColor('#3b82f6');
$plot1->SetLegend('2024');

$plot2 = new LinePlot($data2);
$plot2->SetColor('#22c55e');
$plot2->SetLegend('2025');

$graph->Add($plot1);
$graph->Add($plot2);
```

---

## Styling & Customization

### Graph Titles

```php
$graph->title->Set('Monthly Survey Results');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetColor('#1f2937');

$graph->subtitle->Set('Average ratings by month');
$graph->subtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);

$graph->xaxis->title->Set('Month');
$graph->yaxis->title->Set('Rating (0-10)');
```

### Axis Configuration

```php
// X-axis
$graph->xaxis->SetTickLabels(['Gen', 'Feb', 'Mar', 'Apr']);
$graph->xaxis->SetLabelAngle(45);  // Rotate labels
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);

// Y-axis
$graph->yaxis->SetLabelFormat('%d%%');  // Format as percentage
$graph->yaxis->scale->SetGrace(10);      // 10% padding above max
$graph->SetYScale(0, 'lin', 0, 100);     // Force 0-100 range
```

### Margins & Background

```php
// Margins: left, right, top, bottom
$graph->SetMargin(60, 30, 40, 80);

// Background
$graph->SetMarginColor('#f3f4f6');
$graph->SetFrame(true, '#e5e7eb', 1);

// Plot area background
$graph->SetColor('#ffffff');
```

### Grid Lines

```php
// Major grid
$graph->ygrid->SetColor('#e5e7eb');
$graph->ygrid->SetLineStyle('dashed');

// Minor grid
$graph->ygrid->SetMinor(true);
$graph->ygrid->SetMinorColor('#f3f4f6');
```

### Legend

```php
$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#374151');
$graph->legend->SetFillColor('#ffffff');
$graph->legend->SetShadow(false);
$graph->legend->SetPos(0.5, 0.98, 'center', 'bottom');
$graph->legend->SetLayout(LEGEND_HOR);  // Horizontal layout
```

---

## Gradient Fills

### Gradient Styles

JpGraph supports **8 gradient fill styles**:

| Style | Constant | Description |
|-------|----------|-------------|
| Vertical (mid) | `GRAD_MIDVER` | Vertical, light in middle |
| Vertical | `GRAD_VER` | Top to bottom |
| Horizontal | `GRAD_HOR` | Left to right |
| Horizontal (mid) | `GRAD_MIDHOR` | Horizontal, light in middle |
| Center | `GRAD_CENTER` | From edges to center |
| Wide (mid ver) | `GRAD_WIDE_MIDVER` | Wide vertical mid |
| Wide (mid hor) | `GRAD_WIDE_MIDHOR` | Wide horizontal mid |
| Left reflection | `GRAD_LEFT_REFLECTION` | Reflected light effect |
| Right reflection | `GRAD_RIGHT_REFLECTION` | Reflected light effect |

### Using Gradients

```php
// Bar with gradient
$plot = new BarPlot($data);
$plot->SetFillGradient('#3b82f6', '#1d4ed8', GRAD_MIDVER);

// Graph background gradient
$graph->SetBackgroundGradient('#f8fafc', '#e2e8f0', GRAD_VER);
```

### Pattern Fills

```php
// For black & white printing
$plot->SetPattern(PATTERN_DIAG1);  // Diagonal lines
$plot->SetPattern(PATTERN_CROSS);   // Cross-hatch
$plot->SetPattern(PATTERN_STRIPE);  // Stripes
```

---

## Font Management

### Built-in Fonts

| Constant | Font Family |
|----------|-------------|
| `FF_FONT0` | Bitmap tiny |
| `FF_FONT1` | Bitmap small |
| `FF_FONT2` | Bitmap medium |
| `FF_COURIER` | Courier |
| `FF_ARIAL` | Arial |
| `FF_VERDANA` | Verdana |
| `FF_TIMES` | Times |
| `FF_GEORGIA` | Georgia |
| `FF_TREBUCHE` | Trebuchet |
| `FF_COMIC` | Comic Sans |

### Font Styles

| Constant | Style |
|----------|-------|
| `FS_NORMAL` | Normal |
| `FS_BOLD` | Bold |
| `FS_ITALIC` | Italic |
| `FS_BOLDITALIC` | Bold Italic |

### Setting Fonts

```php
// Title font
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 16);

// Axis labels
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);

// Data labels on bars
$plot->value->SetFont(FF_VERDANA, FS_BOLD, 9);
```

### Custom TTF Fonts

```php
// Define font path
define('TTF_DIR', '/path/to/fonts/');

// Use custom font
$graph->title->SetFont(FF_USERFONT, FS_BOLD, 14);
$graph->title->SetTTF('/path/to/fonts/CustomFont.ttf');
```

---

## Caching System

### Enable Caching

```php
// Define cache directory
define('CACHE_DIR', storage_path('jpgraph_cache/'));

// Use cached image
$graph = new Graph(800, 400, 'chart_key_123', 3600);  // 1 hour cache
$graph->SetScale('textlin');

// Check if cached
if ($graph->IsCache()) {
    $graph->StrokeCache();  // Serve from cache
    exit;
}

// Otherwise generate and cache
$plot = new BarPlot($data);
$graph->Add($plot);
$graph->StrokeCSIM();  // Store in cache
```

### Cache Key Strategy

```php
// Create unique cache key from data
$cacheKey = md5(json_encode([
    'survey_id' => $surveyId,
    'field_name' => $fieldName,
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
]));

$graph = new Graph(800, 400, $cacheKey, 3600);
```

---

## Integration with Laravel

### Service Class

```php
<?php

namespace Modules\Chart\Services;

use mitoteam\jpgraph\Graph;
use mitoteam\jpgraph\PieGraph;
use mitoteam\jpgraph\plot\BarPlot;
use mitoteam\jpgraph\plot\PiePlot;
use mitoteam\jpgraph\plot\PiePlot3D;
use mitoteam\jpgraph\plot\LinePlot;

class JpGraphService
{
    public function createBarChart(
        array $data,
        array $labels,
        int $width = 800,
        int $height = 400,
        array $colors = null,
    ): Graph {
        $graph = new Graph($width, $height);
        $graph->SetScale('textlin');
        $graph->SetMargin(60, 30, 40, 80);

        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);

        $plot = new BarPlot($data);
        $plot->SetFillColor($colors[0] ?? '#3b82f6');
        $plot->SetWidth(0.6);

        $plot->value->Show();
        $plot->value->SetFormat('%.1f');
        $plot->value->SetFont(FF_ARIAL, FS_BOLD, 9);

        $graph->Add($plot);

        return $graph;
    }

    public function createPieChart(
        array $data,
        array $labels,
        int $width = 500,
        int $height = 400,
        array $colors = null,
        bool $is3D = false,
    ): PieGraph {
        $graph = new PieGraph($width, $height);
        $graph->SetShadow();

        $plot = $is3D ? new PiePlot3D($data) : new PiePlot($data);
        $plot->SetLabels($labels);
        $plot->SetLabelType(PIE_VALUE_PER);

        if ($colors) {
            $plot->SetSliceColors($colors);
        }

        if ($is3D) {
            $plot->SetAngle(45);
            $plot->ExplodeAll(10);
        }

        $graph->Add($plot);

        return $graph;
    }

    public function saveChart(Graph|PieGraph $graph, string $filename): string
    {
        $path = storage_path("app/charts/{$filename}");
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $graph->Stroke($path);

        return $path;
    }
}
```

### Action Pattern (Recommended)

```php
<?php

namespace Modules\Chart\Actions\JpGraph\V1;

use Modules\Chart\Datas\AnswersChartData;
use mitoteam\jpgraph\Graph;
use mitoteam\jpgraph\plot\BarPlot;
use Spatie\QueueableAction\QueueableAction;

class Bar1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $data): Graph
    {
        $chart = $data->chart;

        $graph = new Graph($chart->width, $chart->height);
        $graph->SetScale('textlin');
        $graph->SetMargin(60, 30, 40, 80);

        // Extract data
        $values = $data->answers->pluck('value')->toArray();
        $labels = $data->answers->pluck('label')->toArray();

        // Configure axes
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);

        // Create plot
        $plot = new BarPlot($values);

        // Apply colors
        if ($chart->list_color) {
            $colors = explode(',', $chart->list_color);
            $plot->SetFillColor($colors[0]);
        }

        // Apply transparency
        if ($chart->transparency) {
            $alpha = (int) ($chart->transparency * 127);
            // JpGraph handles alpha differently per context
        }

        // Show values
        $plot->value->Show();
        $plot->value->SetFormat('%.1f');
        $plot->value->SetFont(FF_ARIAL, FS_BOLD, 9);

        $graph->Add($plot);

        return $graph;
    }
}
```

### Usage in Controller/Widget

```php
use Modules\Chart\Actions\JpGraph\V1\Bar1Action;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;

// Prepare data
$chartData = ChartData::from([
    'type' => 'bar1',
    'width' => 800,
    'height' => 400,
    'list_color' => '#22c55e,#3b82f6,#fbbf24',
]);

$answersChartData = AnswersChartData::from([
    'answers' => collect([
        ['label' => 'Gen', 'value' => 7.5, 'count' => 45],
        ['label' => 'Feb', 'value' => 8.2, 'count' => 52],
        ['label' => 'Mar', 'value' => 6.8, 'count' => 38],
    ]),
    'chart' => $chartData,
]);

// Generate
$graph = app(Bar1Action::class)->execute($answersChartData);

// Save
$imagePath = storage_path('app/charts/monthly-survey.png');
$graph->Stroke($imagePath);
```

---

## Alternative Libraries Comparison

### PHP Chart Libraries Overview

| Library | Composer Package | PHP Version | Active |
|---------|------------------|-------------|--------|
| **JpGraph** | `mitoteam/jpgraph` | 5.1 - 8.5 | ✅ |
| **pChart** | `szymach/c-pchart` | 7.0 - 8.x | ✅ |
| **LibChart** | - | 5.x | ❌ Abandoned |
| **Phplot** | - | 5.2 - 8.x | ⚠️ Limited |

### JpGraph vs pChart

| Feature | JpGraph | pChart |
|---------|---------|--------|
| **Chart Types** | 15+ | 10+ |
| **3D Charts** | ✅ Full support | ⚠️ Limited |
| **Gradients** | ✅ 8 styles | ✅ Basic |
| **Anti-aliasing** | ✅ Full | ✅ Full |
| **Output Size** | 2-4KB typical | 3-6KB typical |
| **Documentation** | ✅ Extensive | ⚠️ Basic |
| **License** | QPL/Commercial | GPL |
| **Gantt Charts** | ✅ Full | ❌ No |
| **Radar Charts** | ✅ Full | ✅ Basic |

### When to Use Each

**Choose JpGraph when:**
- Need Gantt charts for project timelines
- Need 3D pie charts with full control
- Commercial project (buy license)
- Need extensive gradient options
- Need comprehensive documentation

**Choose pChart when:**
- GPL license acceptable
- Basic chart types sufficient
- Need sparklines
- Smaller learning curve needed

### pChart Quick Example

```php
// Install: composer require szymach/c-pchart

use CpChart\Data;
use CpChart\Image;

$data = new Data();
$data->addPoints([40, 60, 31, 22], 'Values');
$data->addPoints(['Gen', 'Feb', 'Mar', 'Apr'], 'Labels');
$data->setAbscissa('Labels');

$image = new Image(700, 230, $data);
$image->drawBarChart();
$image->render('chart.png');
```

---

## Related Documentation

- [Chart.js for Frontend](./chartjs-plugin-datalabels-filament5.md)
- [LimeSurvey Chart Generation](./limesurvey-chart-generation-guide.md)
- [PDF Generation with Charts](../../Quaeris/docs/pdf-generation-with-charts.md)
- [Survey Chart Widget](../../Quaeris/docs/survey-chart-widget-implementation.md)

---

**Last Updated:** January 2026
**Maintainer:** Laraxot Team + Claude Opus 4.5
