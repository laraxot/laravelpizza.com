# JpGraph and Chart.js Integration in Laraxot

## Overview

This document provides detailed information about integrating JpGraph and Chart.js libraries for chart generation in the Laraxot framework, including how to create charts, save them as SVG/PNG, and integrate them with the PDF generation system.

## JpGraph Integration

### Installation and Setup

JpGraph is installed via Composer:
```json
{
    "amenadiel/jpgraph": "^4.1"
}
```

The library is configured in the system with proper constant definitions:

```php
// In actions that use JpGraph
if (! defined('Amenadiel\\JpGraph\\FF_ARIAL')) {
    define('Amenadiel\\JpGraph\\FF_ARIAL', 1);
    define('Amenadiel\\JpGraph\\FS_BOLD', 1);
    define('Amenadiel\\JpGraph\\FS_NORMAL', 0);
}
```

### JpGraph Action Architecture

#### Base Action Pattern
Each chart type has a corresponding action class following the pattern:

```php
namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;  // Import specific JpGraph classes
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;

class Pie1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        // 1. Extract data from AnswersChartData
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;
        
        // 2. Create JpGraph object
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        
        // 3. Apply general styling
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);
        
        // 4. Create and configure plot
        $piePlotC = new PiePlotC($data);
        
        // 5. Set colors with transparency
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
        }
        $piePlotC->SetSliceColors($color_array);
        
        // 6. Configure plot properties
        $piePlotC->SetLegends($labels);
        $piePlotC->SetGuideLines(true, false);
        $piePlotC->SetGuideLinesAdjust(1.5);
        $piePlotC->SetLabelType(PIE_VALUE_PER); // Percentage values
        
        // 7. Show values if configured
        if (is_object($piePlotC->value) && method_exists($piePlotC->value, 'Show')) {
            $piePlotC->value->Show();
        }
        
        // 8. Set center size (for doughnut charts)
        $piePlotC->SetMidSize($chart->plot_perc_width / 100);
        
        // 9. Set titles and fonts
        if (isset($graph->title) && $graph->title instanceof Text) {
            $graph->title->Set($chart->title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }
        
        // 10. Configure value appearance
        if (is_object($piePlotC->value)) {
            if (method_exists($piePlotC->value, 'SetFont')) {
                $piePlotC->value->SetFont(FF_ARIAL, FS_BOLD, 10);
            }
            if (method_exists($piePlotC->value, 'SetColor')) {
                $piePlotC->value->SetColor('black');
            }
            if (method_exists($piePlotC->value, 'SetFormat')) {
                $piePlotC->value->SetFormat('%2.1f%%');
            }
        }
        
        // 11. Add plot to graph and return
        $graph->Add($piePlotC);
        return $graph;
    }
}
```

### JpGraph Chart Types and Their Actions

#### 1. Pie Charts (`pie1`, `pieAvg`)
- **Action**: `Pie1Action`, `PieAvgAction`
- **Use Case**: Percentage distributions, categorical data
- **Features**: 
  - Supports "other" category when max values set
  - Configurable center size (doughnut effect)
  - Percentage labels
  - Custom colors with transparency

#### 2. Bar Charts (`bar1`, `bar2`, `bar3`)
- **Actions**: `Bar1Action`, `Bar2Action`, `Bar3Action`
- **Use Case**: Comparison of values, time series
- **Features**:
  - Multiple bar styles (stacked, grouped, individual)
  - Horizontal and vertical options
  - Value labels on bars
  - Customizable axis properties

#### 3. Line Charts (`lineSubQuestion`)
- **Action**: `LineSubQuestionAction`
- **Use Case**: Time-based trends, continuous data
- **Features**:
  - Multiple line types
  - Various markers (circles, triangles, squares)
  - Smooth line options
  - Axis configuration

#### 4. Horizontal Bar Charts (`horizbar1`)
- **Action**: `Horizbar1Action`
- **Use Case**: When categories have long labels
- **Features**:
  - Horizontal orientation
  - Similar styling options as vertical bars
  - Value labels configuration

### JpGraph Styling Actions

#### ApplyGraphStyleAction
Handles general graph styling:

```php
class ApplyGraphStyleAction
{
    public function execute(Graph $graph, ChartData $chart): Graph
    {
        // Apply background color
        if (isset($chart->bg_color)) {
            $graph->SetMarginColor($chart->bg_color);
        }
        
        // Apply padding and margins
        $graph->SetBox(true);
        $graph->SetMargin(50, 50, 60, 50);
        
        // Configure axis if present
        if (isset($graph->xaxis)) {
            $graph->xaxis->SetFont($chart->font_family, $chart->font_style);
        }
        
        // Apply show box setting
        if ($chart->show_box) {
            $graph->SetBox(true);
        } else {
            $graph->SetBox(false);
        }
        
        return $graph;
    }
}
```

#### ApplyPlotStyleAction
Handles plot-specific styling:

```php
class ApplyPlotStyleAction
{
    public function execute(Plot $plot, ChartData $chart): Plot
    {
        // Apply value display settings
        if ($chart->plot_value_show) {
            if (is_object($plot->value) && method_exists($plot->value, 'Show')) {
                $plot->value->Show();
            }
        }
        
        // Apply position formatting
        if ($chart->plot_value_pos) {
            // Specific positioning logic
        }
        
        return $plot;
    }
}
```

## Chart.js Integration

### Chart.js Data Structure

The system provides methods to convert internal chart data to Chart.js compatible formats:

#### Chart.js Type Detection
```php
public function getChartJsType(): string
{
    switch ($this->chart->type) {
        case 'bar1':
        case 'bar2':
        case 'bar3':
            return 'bar';
        case 'pie1':
        case 'pieAvg':
            return 'doughnut';
        case 'lineSubQuestion':
            return 'line';
        case 'horizbar1':
            return 'bar'; // Horizontal bar is still 'bar' in Chart.js but with options
        default:
            return 'bar'; // Default fallback
    }
}
```

#### Chart.js Data Structure
```php
public function getChartJsData(): array
{
    $datasets = [];
    $labels = [];
    
    foreach ($this->answers as $answer) {
        $labels[] = $answer->label;
        $datasets[] = $answer->avg ?? $answer->value;
    }
    
    return [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => $this->chart->title ?? 'Dataset',
                'data' => $datasets,
                'backgroundColor' => $this->chart->getColorsRgba(0.6),
                'borderColor' => $this->chart->getColors(),
                'borderWidth' => 1,
            ]
        ]
    ];
}
```

#### Chart.js Options Generation
```php
public function getChartJsOptionsArray(): array
{
    $baseOptions = [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'position' => 'top',
            ],
            'title' => [
                'display' => true,
                'text' => $this->chart->title ?? ''
            ]
        ]
    ];
    
    // Type-specific options
    switch ($this->getChartJsType()) {
        case 'bar':
            $baseOptions['indexAxis'] = $this->chart->type === 'horizbar1' ? 'y' : 'x';
            $baseOptions['scales'] = [
                'y' => [
                    'beginAtZero' => true
                ]
            ];
            break;
        case 'doughnut':
            $baseOptions['plugins']['legend']['position'] = 'right';
            break;
        case 'line':
            $baseOptions['scales'] = [
                'y' => [
                    'beginAtZero' => true
                ]
            ];
            break;
    }
    
    return $baseOptions;
}
```

### Chart.js JavaScript Options
For direct JavaScript integration:

```php
public function getChartJsOptionsJs(): RawJs
{
    $chartJsType = $this->getChartJsType();
    $method = 'getChartJs'.Str::of($chartJsType)->studly()->toString().'OptionsJs';
    
    if (method_exists($this, $method)) {
        return new RawJs($this->$method());
    }
    
    // Default fallback
    return new RawJs(json_encode($this->getChartJsOptionsArray()));
}
```

## SVG Generation from Chart.js

### Canvas to SVG Conversion

To save Chart.js charts as SVG, you can use HTML5 canvas with conversion:

#### 1. Create Canvas-based Chart
```javascript
// In blade template
<canvas id="chart-{{ $chart->id }}"></canvas>
<script>
    const ctx = document.getElementById('chart-{{ $chart->id }}').getContext('2d');
    const chartData = @json($chartData);
    const chartOptions = @json($chartOptions);
    
    new Chart(ctx, {
        type: '{{ $chartType }}',
        data: chartData,
        options: chartOptions
    });
</script>
```

#### 2. Convert Canvas to SVG
```javascript
// Using chartjs-to-svg or similar library
function convertChartToSVG(chartId) {
    const canvas = document.getElementById(chartId);
    const chart = Chart.getChart(canvas); // Get chart instance
    
    // Convert to SVG using libraries like canvg
    const svg = canvg.fromString(ctx.canvas.toDataURL('image/png'));
    return svg;
}
```

### Server-side SVG Generation

For server-side SVG generation, you would need to extend the system:

```php
class ChartToSvgAction
{
    public function execute(ChartData $chartData, array $chartJsData): string
    {
        // Generate SVG using simple XML
        $svg = '<svg width="'.$chartData->width.'" height="'.$chartData->height.'" xmlns="http://www.w3.org/2000/svg">';
        
        // Add chart elements based on chart type
        switch ($chartData->type) {
            case 'pie1':
                $svg .= $this->generatePieChartSvg($chartJsData, $chartData);
                break;
            case 'bar1':
                $svg .= $this->generateBarChartSvg($chartJsData, $chartData);
                break;
            // Add other chart types
        }
        
        $svg .= '</svg>';
        return $svg;
    }
    
    private function generatePieChartSvg(array $chartJsData, ChartData $chartData): string
    {
        $svg = '';
        $datasets = $chartJsData['datasets'][0]['data'] ?? [];
        $colors = $chartData->getColors();
        
        $centerX = $chartData->width / 2;
        $centerY = $chartData->height / 2;
        $radius = min($chartData->width, $chartData->height) * 0.4;
        
        $total = array_sum($datasets);
        $startAngle = 0;
        
        foreach ($datasets as $i => $value) {
            if ($total == 0) continue;
            
            $percentage = ($value / $total) * 100;
            $angle = (360 * $value) / $total;
            
            $endAngle = $startAngle + $angle;
            $startX = $centerX + $radius * cos(deg2rad($startAngle));
            $startY = $centerY + $radius * sin(deg2rad($startAngle));
            $endX = $centerX + $radius * cos(deg2rad($endAngle));
            $endY = $centerY + $radius * sin(deg2rad($endAngle));
            
            $largeArc = $angle > 180 ? 1 : 0;
            
            $path = "M {$centerX} {$centerY} L {$startX} {$startY} A {$radius} {$radius} 0 {$largeArc} 1 {$endX} {$endY} Z";
            $svg .= '<path d="'.$path.'" fill="'.$colors[$i % count($colors)].'" />';
            
            $startAngle = $endAngle;
        }
        
        return $svg;
    }
    
    private function generateBarChartSvg(array $chartJsData, ChartData $chartData): string
    {
        $svg = '';
        $datasets = $chartJsData['datasets'][0]['data'] ?? [];
        $labels = $chartJsData['labels'] ?? [];
        $colors = $chartData->getColors();
        
        $maxValue = max($datasets);
        if ($maxValue == 0) $maxValue = 1;
        
        $barWidth = ($chartData->width - 100) / count($datasets);
        $barSpacing = $barWidth * 0.2;
        $actualBarWidth = $barWidth - $barSpacing;
        
        $chartHeight = $chartData->height - 50; // Leave space for labels
        $chartTop = 20;
        
        for ($i = 0; $i < count($datasets); $i++) {
            $barHeight = ($datasets[$i] / $maxValue) * $chartHeight;
            $x = 50 + ($i * $barWidth) + ($barSpacing / 2);
            $y = $chartTop + ($chartHeight - $barHeight);
            
            $svg .= '<rect x="'.$x.'" y="'.$y.'" width="'.$actualBarWidth.'" height="'.$barHeight.'" fill="'.$colors[$i % count($colors)].'" />';
            
            // Add label
            $svg .= '<text x="'.($x + $actualBarWidth/2).'" y="'.($chartTop + $chartHeight + 15).'" text-anchor="middle" font-size="10">'.$labels[$i].'</text>';
        }
        
        return $svg;
    }
}
```

## PNG Generation Process

### JpGraph to PNG Workflow

The complete workflow from chart data to PNG file:

1. **Data Preparation**: `AnswersChartData` contains chart configuration and data
2. **Action Selection**: `ChartData::getActionClass()` determines the appropriate action
3. **Graph Creation**: Action creates JpGraph object with data
4. **Styling Application**: `ApplyGraphStyleAction` and `ApplyPlotStyleAction` apply styling
5. **PNG Generation**: `Stroke()` method outputs the graph to PNG file
6. **File Storage**: PNG saved to public directory with naming convention
7. **Model Update**: `QuestionChart` model updated with image path

```php
// In MakeImgByQuestionChartModel2Action
public function execute(QuestionChart $questionChart, Builder $responses, ?AnswersFilterData $answersFilterData = null): array
{
    // 1. Get chart data
    $datas = app(GetChartsDataByQuestionChart::class)
        ->execute($q, $responses, $answersFilterData);
    
    $filenames = [];
    
    foreach ($datas as $k => $data_answers) {
        // 2. Convert to chart data objects
        $answersData = AnswersChartData::from([
            'answers' => $data_answers->answers,
            'chart' => $chart_style,
        ]);
        
        // 3. Get action class and execute
        $action_class = $chart_style->getActionClass();
        $graph = app($action_class)->execute($answersData);
        
        // 4. Save as PNG
        $filename = 'chart/'.$q->id.'-'.$k.'.png';
        $file_path = public_path($filename);
        
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        
        try {
            // 5. Generate the PNG file
            $graph->Stroke($file_path);
        } catch (\Throwable $e) {
            logger()->error('❌ Errore durante Stroke()', [
                'exception' => $e->getMessage(),
                'file_path' => $file_path,
            ]);
        }
        
        $filenames[] = $filename;
    }
    
    // 6. Merge multiple charts if needed
    $fileName = 'chart/'.$q->id.'.png';
    $mergeAction = app(Merge::class);
    if (\is_object($mergeAction) && method_exists($mergeAction, 'execute')) {
        $mergeAction->execute($filenames, $fileName);
    }
    
    // 7. Update model
    $q->img_src = $fileName;
    $q->generated_at = now();
    $q->save();
    
    return [
        'filenames' => $fileName,
    ];
}
```

### PNG Optimization

- **Memory Management**: Set appropriate limits during generation
- **File Cleanup**: Delete old files before generating new ones
- **Error Handling**: Log errors and provide fallback images
- **Caching**: Only regenerate when data changes

## Integration with PDF Generation

### Chart Images in PDFs

Charts are integrated into PDFs through the HTML template system:

```blade
<!-- In PDF template -->
@php
    $imgPath = public_path(ltrim($img->img_src, '/'));
@endphp

@if(File::exists($imgPath))
    <img src="{{ $imgPath }}" style="max-width: 100%; height: auto;" />
@else
    <p style="color: red; font-size: 0.8em;">[Chart not generated for ID {{ $img->id }}]</p>
@endif
```

### HTML2PDF Compatibility

The Spipu HTML2PDF library properly handles PNG images embedded in HTML:

```php
class HtmlService
{
    public static function toPdf(
        string $html,
        string $out = 'show',
        string $pdforientation = 'L',
        string $filename = '',
    ): string {
        $html2pdf = new Html2Pdf($pdforientation, 'A4', 'it');
        $html2pdf->setTestTdInOnePage(false);
        $html2pdf->WriteHTML($html); // This processes the <img> tags
        
        // Return PDF content
        if ($out === 'content_PDF') {
            return $html2pdf->Output($filename.'.pdf', 'S');
        }
    }
}
```

## Best Practices

### 1. Chart Type Selection
- **Pie Charts**: Use for parts of a whole (percentages, proportions)
- **Bar Charts**: Use for comparisons or time series data
- **Line Charts**: Use for trends over time
- **Horizontal Bars**: Use when category labels are long

### 2. Performance Optimization
- Use queued actions for batch chart generation
- Implement proper caching strategies
- Set appropriate memory and time limits
- Monitor and optimize for large datasets

### 3. Styling Consistency
- Define color palettes for different chart types
- Maintain consistent font families and sizes
- Apply appropriate transparency levels
- Consider accessibility and color contrast

### 4. Error Handling
- Always check if image files exist before PDF generation
- Provide fallback images or text when charts fail
- Log generation errors for debugging
- Implement retry mechanisms for failed generations

This architecture provides a robust, scalable system for generating various chart types using both JpGraph and Chart.js, with proper SVG/PNG generation and seamless PDF integration in the Laraxot framework.