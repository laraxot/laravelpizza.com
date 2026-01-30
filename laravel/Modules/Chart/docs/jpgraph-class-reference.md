# JpGraph Class Reference - Complete API Documentation

**Created:** January 2026
**Author:** Claude Opus 4.5 (claude-opus-4-5-20251101)
**Version:** 1.0.0
**Status:** Production Ready

**Sources:**
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html)
- [Graph Class](https://jpgraph.net/download/manuals/classref/Graph.html)
- [BarPlot Class](https://jpgraph.net/download/manuals/classref/BarPlot.html)
- [LinePlot Class](https://jpgraph.net/download/manuals/classref/LinePlot.html)
- [PiePlot Class](https://jpgraph.net/download/manuals/classref/PiePlot.html)
- [PieGraph Class](https://jpgraph.net/download/manuals/classref/PieGraph.html)
- [AccBarPlot Class](https://jpgraph.net/download/manuals/classref/AccBarPlot.html)
- [GroupBarPlot Class](https://jpgraph.net/download/manuals/classref/GroupBarPlot.html)

---

## Table of Contents

1. [Graph Class](#graph-class)
2. [PieGraph Class](#piegraph-class)
3. [BarPlot Class](#barplot-class)
4. [LinePlot Class](#lineplot-class)
5. [PiePlot Class](#pieplot-class)
6. [GroupBarPlot Class](#groupbarplot-class)
7. [AccBarPlot Class](#accbarplot-class)
8. [Quick Reference Tables](#quick-reference-tables)

---

## Graph Class

The main canvas class for line, bar, and other plot types (except pie charts).

**File:** `jpgraph.php`

### Public Properties

| Property | Type | Description |
|----------|------|-------------|
| `xaxis` | Axis | X-axis configuration |
| `yaxis` | Axis | Y-axis configuration |
| `xgrid` | Grid | X-axis grid lines |
| `ygrid` | Grid | Y-axis grid lines |
| `legend` | Legend | Legend box properties |
| `title` | Text | Primary graph title |
| `subtitle` | Text | Secondary title |
| `subsubtitle` | Text | Tertiary title |
| `tabtitle` | GraphTabTitle | Optional tab title |
| `img` | RotImage | Image canvas |

### Constructor

```php
__construct($aWidth = 300, $aHeight = 200, $aCachedName = '', $aTimeOut = 0, $aInline = true)
```

| Parameter | Default | Description |
|-----------|---------|-------------|
| `$aWidth` | 300 | Graph width in pixels |
| `$aHeight` | 200 | Graph height in pixels |
| `$aCachedName` | '' | Cache filename (empty = no caching) |
| `$aTimeOut` | 0 | Cache timeout in minutes |
| `$aInline` | true | Inline streaming flag |

**Example:**
```php
$graph = new Graph(800, 400);
$graph->SetScale('textlin');
```

### Plot Management Methods

#### `Add($aPlot)`
Adds plot objects to the primary Y-axis.

```php
$graph->Add($barplot);
$graph->Add([$line1, $line2]);  // Multiple plots
```

#### `AddY2($aPlot)`
Adds plots to the secondary (right) Y-axis.

```php
$graph->SetY2Scale('lin');
$graph->AddY2($lineplot);
```

#### `AddBand($aBand, $aToY2 = false)`
Adds vertical or horizontal bands to emphasize scale regions.

```php
$band = new PlotBand(HORIZONTAL, BAND_SOLID, 0, 50, 'lightgreen');
$graph->AddBand($band);
```

#### `AddLine($aLine, $aToY2 = false)`
Adds vertical or horizontal lines.

```php
$line = new PlotLine(HORIZONTAL, 100, 'red');
$graph->AddLine($line);
```

#### `AddText($aTxt, $aToY2 = false)`
Adds text objects at arbitrary positions.

```php
$txt = new Text('Important note');
$txt->SetPos(100, 50);
$graph->AddText($txt);
```

### Scale Configuration

#### `SetScale($aAxisType, $aYMin = 1, $aYMax = 1, $aXMin = 1, $aXMax = 1)`
Configures X and Y axis scaling.

| Scale Type | Description |
|------------|-------------|
| `'textlin'` | Text X-axis, linear Y-axis (most common) |
| `'textlog'` | Text X-axis, logarithmic Y-axis |
| `'linlin'` | Linear both axes |
| `'linlog'` | Linear X, logarithmic Y |
| `'loglin'` | Logarithmic X, linear Y |
| `'loglog'` | Logarithmic both axes |
| `'intlin'` | Integer X-axis, linear Y-axis |
| `'intlog'` | Integer X-axis, logarithmic Y-axis |
| `'datlin'` | Date X-axis, linear Y-axis |
| `'datlog'` | Date X-axis, logarithmic Y-axis |

**Example:**
```php
$graph->SetScale('textlin');
$graph->SetScale('linlin', 0, 100, 0, 50);  // With explicit ranges
```

#### `SetY2Scale($aAxisType, $aY2Min = 1, $aY2Max = 1)`
Configures secondary Y-axis.

```php
$graph->SetY2Scale('lin', 0, 100);
```

#### `SetTickDensity($aYDensity = TICKD_NORMAL, $aXDensity = TICKD_NORMAL)`
Controls tick mark frequency.

| Constant | Description |
|----------|-------------|
| `TICKD_DENSE` | Many tick marks |
| `TICKD_NORMAL` | Default density |
| `TICKD_SPARSE` | Fewer tick marks |
| `TICKD_VERYSPARSE` | Minimal tick marks |

### Appearance: Margins

#### `SetMargin($lm, $rm, $tm, $bm)`
Sets pixel margins around plot area.

```php
$graph->SetMargin(60, 30, 40, 80);  // left, right, top, bottom
```

#### `Set90AndMargin($lm, $rm, $tm, $bm)`
Rotates graph 90 degrees and sets margins (for horizontal bars).

```php
$graph->Set90AndMargin(100, 20, 50, 30);
```

#### `SetAngle($aAngle)`
Rotates graph arbitrary degrees (0-360).

```php
$graph->SetAngle(45);
```

### Appearance: Colors

#### `SetColor($aColor)`
Sets plot area background color.

```php
$graph->SetColor('#ffffff');
```

#### `SetMarginColor($aColor)`
Sets margin/border region color.

```php
$graph->SetMarginColor('#f3f4f6');
```

#### `SetBackgroundGradient($aFrom, $aTo, $aGradType, $aStyle)`
Applies gradient background.

| Gradient Type | Description |
|---------------|-------------|
| `GRAD_VER` | Top to bottom |
| `GRAD_HOR` | Left to right |
| `GRAD_MIDHOR` | Horizontal, light in middle |
| `GRAD_MIDVER` | Vertical, light in middle |
| `GRAD_CENTER` | From edges to center |
| `GRAD_RAISED_PANEL` | Raised 3D effect |
| `GRAD_DIAGONAL` | Diagonal gradient |

| Style | Description |
|-------|-------------|
| `BGRAD_FRAME` | Entire image |
| `BGRAD_PLOT` | Plot area only |
| `BGRAD_MARGIN` | Margin area only |

```php
$graph->SetBackgroundGradient('#f8fafc', '#e2e8f0', GRAD_VER, BGRAD_FRAME);
```

#### `SetBackgroundImage($aFileName, $aBgType = BGIMG_FILLPLOT, $aImgFormat = '')`
Sets background image.

| Type | Description |
|------|-------------|
| `BGIMG_FILLPLOT` | Fill plot area |
| `BGIMG_FILLFRAME` | Fill entire frame |
| `BGIMG_COPY` | Copy at original size |
| `BGIMG_CENTER` | Center in plot area |

### Appearance: Frame and Border

#### `SetFrame($aDrawImgFrame = true, $aImgFrameColor = 'black', $aImgFrameWeight = 1)`
Creates border around entire image.

```php
$graph->SetFrame(true, '#e5e7eb', 1);
```

#### `SetBox($aDrawPlotFrame = true, $aPlotFrameColor = 'black', $aPlotFrameWeight = 1)`
Creates border around plot region.

```php
$graph->SetBox(true, '#d1d5db', 1);
```

#### `SetShadow($aShowShadow = true, $aShadowWidth = 5, $aShadowColor = 'gray')`
Adds drop shadow around image.

```php
$graph->SetShadow(true, 4, '#9ca3af');
```

### Appearance: Axis Style

#### `SetAxisStyle($aStyle)`
Specifies axis arrangement.

| Style | Description |
|-------|-------------|
| `AXSTYLE_SIMPLE` | Single axis lines (default) |
| `AXSTYLE_BOXIN` | Box with ticks inside |
| `AXSTYLE_BOXOUT` | Box with ticks outside |

### Advanced Features

#### `SetAlphaBlending($aFlg = true)`
Enables transparency support (requires GD 2.01+).

```php
$graph->SetAlphaBlending(true);
// Use colors like: 'red@0.5' for 50% transparent red
```

#### `SetClipping($aFlg = true)`
Clips plots outside boundaries.

```php
$graph->SetClipping(true);
```

#### `Set3DPerspective($aDir, $aHorizon = 100, $aSkewDist = 150, $aQuality = true, ...)`
Applies 3D perspective transformation.

| Direction | Description |
|-----------|-------------|
| `SKEW3D_UP` | Skew upward |
| `SKEW3D_DOWN` | Skew downward |
| `SKEW3D_LEFT` | Skew left |
| `SKEW3D_RIGHT` | Skew right |

### Output Methods

#### `Stroke($aStrokeFileName = '')`
Renders and outputs the graph.

```php
$graph->Stroke();                    // Output to browser
$graph->Stroke('/path/to/file.png'); // Save to file
$img = $graph->Stroke('__IMG_HANDLER'); // Get GD handle
```

#### `StrokeCSIM($aScriptName = '', $aCSIMName = '', $aBorder = 0)`
Outputs graph with client-side image map.

```php
$graph->StrokeCSIM(basename(__FILE__), 'mymap', 0);
```

### Image Format

#### `SetImgFormat($aFormat, $aQuality = 75)`
Sets output format.

| Format | Description |
|--------|-------------|
| `'png'` | PNG format (default) |
| `'jpeg'` | JPEG format |
| `'gif'` | GIF format |

```php
$graph->SetImgFormat('jpeg', 90);  // JPEG at 90% quality
```

---

## PieGraph Class

Specialized canvas for pie charts. Extends Graph.

**File:** `jpgraph_pie.php`

### Constructor

```php
__construct($width = 300, $height = 200, $cachedName = '', $timeout = 0, $inline = 1)
```

### Methods

#### `Add($aObj)`
Adds pie plots to the graph.

```php
$piegraph = new PieGraph(400, 400);
$pieplot = new PiePlot($data);
$piegraph->Add($pieplot);
```

#### `SetAntiAliasing($aFlg = true)`
Enables anti-aliased rendering (5-8x slower).

```php
$piegraph->SetAntiAliasing(true);
```

#### `SetColor($c)`
Sets background color (synonym for SetMarginColor).

```php
$piegraph->SetColor('#f9fafb');
```

---

## BarPlot Class

Creates vertical bar charts. Extends Plot.

**File:** `jpgraph_bar.php`

### Constructor

```php
__construct($datay, $datax = false)
```

### Appearance Methods

#### `SetFillColor($aColor)`
Sets bar fill color.

```php
$bar->SetFillColor('#3b82f6');
$bar->SetFillColor(['red', 'blue', 'green']);  // Per-bar colors
```

#### `SetFillGradient($aFromColor, $aToColor, $aStyle)`
Applies gradient fill.

| Style | Description |
|-------|-------------|
| `GRAD_VER` | Vertical gradient |
| `GRAD_HOR` | Horizontal gradient |
| `GRAD_MIDHOR` | Horizontal, light middle |
| `GRAD_MIDVER` | Vertical, light middle |
| `GRAD_RAISED_PANEL` | 3D raised effect |
| `GRAD_LEFT_REFLECTION` | Left reflection |
| `GRAD_RIGHT_REFLECTION` | Right reflection |

```php
$bar->SetFillGradient('#3b82f6', '#1d4ed8', GRAD_MIDVER);
```

#### `SetPattern($aPattern, $aColor = 'black')`
Adds fill patterns (for B&W printing).

| Pattern | Description |
|---------|-------------|
| `PATTERN_DIAG1` | Diagonal lines / |
| `PATTERN_DIAG2` | Diagonal lines \ |
| `PATTERN_DIAG3` | Wide diagonal / |
| `PATTERN_DIAG4` | Wide diagonal \ |
| `PATTERN_CROSS1` | Cross-hatch |
| `PATTERN_CROSS2` | Wide cross-hatch |
| `PATTERN_STRIPE1` | Vertical stripes |
| `PATTERN_STRIPE2` | Horizontal stripes |

#### `SetShadow($aColor = 'black', $aHSize = 3, $aVSize = 3, $aShow = true)`
Adds drop shadow to bars.

```php
$bar->SetShadow('#9ca3af', 3, 3);
```

#### `SetNoFill()`
Disables fill (transparent bars).

### Dimension Methods

#### `SetWidth($aWidth)`
Sets bar width as fraction of tick spacing (0.0-1.0).

```php
$bar->SetWidth(0.6);  // 60% of available space
```

#### `SetAbsWidth($aWidth)`
Sets bar width in absolute pixels.

```php
$bar->SetAbsWidth(25);  // 25 pixels wide
```

### Positioning Methods

#### `SetAlign($aAlign)`
Aligns bars between tick marks.

| Alignment | Description |
|-----------|-------------|
| `'left'` | Left-aligned |
| `'center'` | Centered (default) |
| `'right'` | Right-aligned |

#### `SetValuePos($aPos)`
Positions value labels.

| Position | Description |
|----------|-------------|
| `'top'` | Above bar (default) |
| `'center'` | Center of bar |
| `'bottom'` | Bottom of bar |

```php
$bar->SetValuePos('center');
```

#### `SetYBase($aYStartValue)`
Sets baseline for bars (default: 0).

```php
$bar->SetYBase(100);  // Bars start at Y=100
```

### Value Display

```php
$bar->value->Show();
$bar->value->SetFormat('%d');
$bar->value->SetFont(FF_ARIAL, FS_BOLD, 9);
$bar->value->SetColor('#374151');
```

---

## LinePlot Class

Creates line charts with optional markers. Extends Plot.

**File:** `jpgraph_line.php`

### Public Properties

| Property | Type | Description |
|----------|------|-------------|
| `mark` | PlotMark | Marker at each data point |
| `value` | DisplayValue | Value display settings |

### Constructor

```php
__construct($datay, $datax = false)
```

### Line Style Methods

#### `SetColor($aColor)`
Sets line color.

```php
$line->SetColor('#3b82f6');
```

#### `SetStyle($aStyle)`
Sets line rendering style.

| Style | Description |
|-------|-------------|
| `'solid'` | Solid line (default) |
| `'dotted'` | Dotted line |
| `'dashed'` | Dashed line |

```php
$line->SetStyle('dashed');
```

#### `SetStepStyle($aFlag = true)`
Enables step-style rendering (staircase effect).

```php
$line->SetStepStyle(true);
```

### Fill Methods

#### `SetFillColor($aColor, $aFilled = true)`
Fills area under line.

```php
$line->SetFillColor('#3b82f680');  // With alpha
```

#### `SetFillGradient($aFromColor, $aToColor, $aNumColors = 100, $aFilled = true)`
Applies gradient fill under line.

```php
$line->SetFillGradient('#ffffff', '#3b82f6');
```

#### `SetFillFromYMin($f = true)`
Fills from minimum Y value instead of zero.

### Area Methods

#### `AddArea($aMin, $aMax, $aFilled = LP_AREA_NOT_FILLED, $aColor = 'gray9', $aBorder = LP_AREA_BORDER)`
Adds colored area under line between X values.

```php
$line->AddArea(2, 5, LP_AREA_FILLED, '#ef4444');
```

### Marker Configuration

```php
$line->mark->SetType(MARK_FILLEDCIRCLE);
$line->mark->SetFillColor('#3b82f6');
$line->mark->SetSize(6);
```

| Marker Type | Description |
|-------------|-------------|
| `MARK_NONE` | No marker |
| `MARK_SQUARE` | Square |
| `MARK_UTRIANGLE` | Up triangle |
| `MARK_DTRIANGLE` | Down triangle |
| `MARK_DIAMOND` | Diamond |
| `MARK_CIRCLE` | Circle outline |
| `MARK_FILLEDCIRCLE` | Filled circle |
| `MARK_CROSS` | Cross |
| `MARK_STAR` | Star |
| `MARK_X` | X mark |

### Performance

#### `SetFastStroke($aFlg = true)`
Optimized rendering for thousands of points.

```php
$line->SetFastStroke(true);
```

**Restrictions:** No plotmarks, solid lines only, width = 1.

### Bar Chart Integration

#### `SetBarCenter($aFlag = true)`
Aligns line points to bar centers (for combined charts).

```php
$line->SetBarCenter(true);
```

---

## PiePlot Class

Creates pie chart slices. Used with PieGraph.

**File:** `jpgraph_pie.php`

### Constructor

```php
__construct($data)
```

### Positioning Methods

#### `SetCenter($x, $y = 0.5)`
Positions pie center (fractions 0.0-1.0).

```php
$pie->SetCenter(0.5, 0.5);  // Center of graph
```

#### `SetSize($aSize)`
Sets pie radius.

| Value | Interpretation |
|-------|----------------|
| 0-1 | Fraction of graph size |
| >1 | Absolute pixels |

```php
$pie->SetSize(0.35);
```

### Explosion Methods

#### `Explode($aExplodeArr)`
Explodes specific slices.

```php
$pie->Explode([100, 0, 100]);  // Explode slices 0 and 2 by 100 pixels
```

#### `ExplodeAll($radius = 20)`
Explodes all slices uniformly.

```php
$pie->ExplodeAll(15);
```

#### `ExplodeSlice($e, $radius = 20)`
Explodes single slice.

```php
$pie->ExplodeSlice(0, 30);  // Explode first slice by 30 pixels
```

### Label Methods

#### `SetLabels($aLabels, $aLblPosAdj = 'auto')`
Sets custom slice labels with printf formatting.

```php
$pie->SetLabels(['Categoria A\\n%.1f%%', 'Categoria B\\n%.1f%%']);
```

#### `SetLabelType($aType)`
Sets label value format.

| Type | Description |
|------|-------------|
| `PIE_VALUE_ABS` | Absolute values |
| `PIE_VALUE_PER` | Percentages |
| `PIE_VALUE_ADJPER` | Adjusted percentages (sum to 100%) |

```php
$pie->SetLabelType(PIE_VALUE_PER);
```

#### `SetLabelPos($aLblPosAdj)`
Adjusts label positioning (fraction of radius).

```php
$pie->SetLabelPos(0.6);  // 60% of radius
```

### Legend Methods

#### `SetLegends($aLegend)`
Sets legend text with printf formatting.

```php
$pie->SetLegends(['Aprile (%d)', 'Maggio (%d)', 'Giugno (%d)']);
```

### Color and Style Methods

#### `SetSliceColors($aColors)`
Sets custom colors per slice.

```php
$pie->SetSliceColors(['#22c55e', '#3b82f6', '#fbbf24', '#ef4444']);
```

#### `SetTheme($aTheme)`
Applies predefined color theme.

| Theme | Description |
|-------|-------------|
| `'earth'` | Earth tones |
| `'pastel'` | Pastel colors |
| `'sand'` | Sand/desert tones |
| `'water'` | Blue/aqua tones |

```php
$pie->SetTheme('water');
```

#### `SetColor($aColor)`
Sets border color around slices.

```php
$pie->SetColor('#ffffff');
```

#### `SetShadow($aColor = 'darkgray', $aDropWidth = 4)`
Adds drop shadow.

```php
$pie->SetShadow('#6b7280', 5);
```

#### `ShowBorder($exterior = true, $interior = true)`
Controls border visibility.

```php
$pie->ShowBorder(true, false);  // Outer only
```

### Guide Lines

#### `SetGuideLines($aFlg = true, $aCurved = true, $aAlways = false)`
Enables lines connecting labels to slices.

```php
$pie->SetGuideLines(true, true);
```

#### `SetGuideLinesAdjust($aVFactor, $aRFactor = 0.8)`
Fine-tunes guide line spacing.

### Rotation

#### `SetStartAngle($aStart)`
Rotates first slice from default 0° (3 o'clock).

```php
$pie->SetStartAngle(90);  // Start at 12 o'clock
```

---

## GroupBarPlot Class

Creates grouped (side-by-side) bar charts. Extends BarPlot.

**File:** `jpgraph_bar.php`

### Constructor

```php
__construct($plots)  // Array of BarPlot or AccBarPlot objects
```

### Example

```php
$bar1 = new BarPlot($data1);
$bar1->SetFillColor('#3b82f6');
$bar1->SetLegend('2024');

$bar2 = new BarPlot($data2);
$bar2->SetFillColor('#22c55e');
$bar2->SetLegend('2025');

$grouped = new GroupBarPlot([$bar1, $bar2]);
$graph->Add($grouped);
```

### Notes

- Width set on GroupBarPlot affects total width of all bars
- Each individual bar has equal width
- Default width is 70%

---

## AccBarPlot Class

Creates stacked (accumulated) bar charts. Extends BarPlot.

**File:** `jpgraph_bar.php`

### Constructor

```php
__construct($plots)  // Array of BarPlot objects
```

### Example

```php
$bar1 = new BarPlot($data1);
$bar1->SetFillColor('#3b82f6');
$bar1->SetLegend('Categoria A');

$bar2 = new BarPlot($data2);
$bar2->SetFillColor('#22c55e');
$bar2->SetLegend('Categoria B');

$stacked = new AccBarPlot([$bar1, $bar2]);  // bar2 on top of bar1
$graph->Add($stacked);
```

### Combining with GroupBarPlot

```php
// Create 4 bar plots
$b1 = new BarPlot($data1);
$b2 = new BarPlot($data2);
$b3 = new BarPlot($data3);
$b4 = new BarPlot($data4);

// Stack pairs
$acc1 = new AccBarPlot([$b1, $b2]);
$acc2 = new AccBarPlot([$b3, $b4]);

// Group the stacks
$grouped = new GroupBarPlot([$acc1, $acc2]);
$graph->Add($grouped);
```

---

## Quick Reference Tables

### Font Constants

| Constant | Font Family |
|----------|-------------|
| `FF_FONT0` | Tiny bitmap |
| `FF_FONT1` | Small bitmap |
| `FF_FONT2` | Medium bitmap |
| `FF_COURIER` | Courier |
| `FF_ARIAL` | Arial |
| `FF_VERDANA` | Verdana |
| `FF_TIMES` | Times |
| `FF_GEORGIA` | Georgia |
| `FF_TREBUCHE` | Trebuchet |
| `FF_COMIC` | Comic Sans |

### Font Style Constants

| Constant | Style |
|----------|-------|
| `FS_NORMAL` | Normal |
| `FS_BOLD` | Bold |
| `FS_ITALIC` | Italic |
| `FS_BOLDITALIC` | Bold Italic |

### Color Formats

```php
'red'           // Named color
'#3b82f6'       // Hex
'red@0.5'       // 50% transparent red
[120, 150, 200] // RGB array
```

### Common Graph Setup Pattern

```php
<?php
require_once 'vendor/autoload.php';

// Create graph
$graph = new Graph(800, 400);
$graph->SetScale('textlin');
$graph->SetMargin(60, 30, 40, 80);

// Title
$graph->title->Set('Monthly Survey Results');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// X-axis labels
$graph->xaxis->SetTickLabels(['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu']);
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);

// Create plot
$data = [7.5, 8.2, 6.8, 7.9, 8.5, 9.1];
$bar = new BarPlot($data);
$bar->SetFillColor('#3b82f6');
$bar->SetWidth(0.6);
$bar->value->Show();
$bar->value->SetFormat('%.1f');

// Add and render
$graph->Add($bar);
$graph->Stroke('/path/to/output.png');
```

---

## Related Documentation

### Project Documentation
- [JpGraph Class Reference Complete](./jpgraph-class-reference-complete.md) - ⭐ **COMPLETE** - Guida approfondita Class Reference con pattern di utilizzo nel progetto, esempi pratici dal codebase, e best practices
- [JpGraph Complete Reference](./jpgraph-complete-reference.md) - Overview and installation
- [JpGraph Deep Dive and Alternatives](./jpgraph-deep-dive-and-alternatives.md) - Analisi approfondita e confronto con alternative
- [JpGraph Complete Guide](./jpgraph-complete-guide.md) - Guida completa con esempi pratici
- [LimeSurvey Chart Generation](./limesurvey-chart-generation-guide.md) - Integration with survey data
- [Chart.js Plugin Guide](./filament-charts-professional-guide.md) - Frontend alternative

### Official JpGraph Resources
- [JpGraph Official Site](https://jpgraph.net/)
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html) - ⭐ **RIFERIMENTO PRINCIPALE** - Class Reference completa ufficiale
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals) - Tutorial 750+ pagine
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php) - Guide pratiche
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php) - Domande frequenti

---

**Last Updated:** January 2026  
**Maintainer:** Laraxot Team + Claude Opus 4.5  
**Source:** [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html)
