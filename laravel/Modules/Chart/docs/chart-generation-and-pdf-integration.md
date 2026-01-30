# Chart Generation and PDF Integration in Laraxot

## Overview

This document explains how to create charts using multiple libraries (JpGraph, Chart.js) and integrate them into PDF documents using Spipu HTML2PDF in the Laraxot framework.

## Chart Generation Systems

### 1. JpGraph System

The primary chart generation system uses JpGraph library with a modular action-based architecture.

#### Action-Based Chart Generation

Charts are generated through a series of action classes in the Chart module:

- **Action Location**: `Modules/Chart/app/Actions/JpGraph/V1/`
- **Naming Convention**: `{ChartType}Action.php` (e.g., `Pie1Action.php`, `Bar1Action.php`)

```php
class Pie1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        // Get data from answers
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        
        // Create JpGraph instance
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        
        // Apply styling and create plot
        $piePlotC = new PiePlotC($data);
        $piePlotC->SetSliceColors(explode(',', $chart->list_color));
        $piePlotC->SetLegends($labels);
        
        // Add the plot to graph
        $graph->Add($piePlotC);
        
        return $graph;
    }
}
```

#### Chart Data Flow
1. `AnswersChartData` contains chart configuration and data
2. `ChartData` defines the chart type and styling options
3. `getActionClass()` determines which action to use based on chart type
4. Action executes and returns JpGraph object
5. `Stroke()` method saves chart as PNG image

#### Supported JpGraph Chart Types
- `bar1`, `bar2`, `bar3`: Bar charts
- `pie1`: Pie charts
- `pieAvg`: Average pie charts  
- `horizbar1`: Horizontal bar charts
- `lineSubQuestion`: Line charts

### 2. Chart.js Integration

Chart.js is used for frontend visualization but can also be processed through dedicated actions.

#### Chart.js Data Processing

The system provides methods to generate Chart.js compatible data:

```php
// In AnswersChartData
public function getChartJsType(): string
public function getChartJsData(): array
public function getChartJsOptionsArray(): array
public function getChartJsOptionsJs(): RawJs
```

#### Chart.js Options Processing
- `getChartJsBarOptionsJs()` - Returns JavaScript for bar charts
- `getChartJsDoughnutOptionsJs()` - Returns JavaScript for doughnut charts
- `getChartJsBarOptionsArray()` - Returns array options for bar charts
- `getChartJsDoughnutOptionsArray()` - Returns array options for doughnut charts

## PNG Generation Process

### 1. QuestionChart Image Generation

The `MakeImgByQuestionChartModel2Action` handles the complete PNG generation workflow:

```php
class MakeImgByQuestionChartModel2Action
{
    public function execute(QuestionChart $questionChart, Builder $responses, ?AnswersFilterData $answersFilterData = null): array
    {
        // Get chart data
        $datas = app(GetChartsDataByQuestionChart::class)
            ->execute($q, $responses, $answersFilterData);
        
        foreach ($datas as $k => $data_answers) {
            $answersData = AnswersChartData::from([
                'answers' => $answers,
                'chart' => $chart_style,
            ]);

            $action_class = $chart_style->getActionClass();
            $graph = app($action_class)->execute($answersData);
            
            // Save as PNG
            $filename = 'chart/'.$q->id.'-'.$k.'.png';
            $file_path = public_path($filename);
            $graph->Stroke($file_path);
        }
        
        // Merge multiple charts if needed
        $fileName = 'chart/'.$q->id.'.png';
        $mergeAction = app(Merge::class);
        $mergeAction->execute($filenames, $fileName);
        
        // Update QuestionChart model
        $q->img_src = $fileName;
        $q->generated_at = now();
        $q->save();
    }
}
```

### 2. PNG Storage and Naming

- **Storage Location**: `/public/chart/`
- **Naming Pattern**: `chart/{question_chart_id}-{index}.png`
- **Merged Chart**: `chart/{question_chart_id}.png`
- **No Data Image**: `chart/NoDataImage.jpeg`

## SVG Generation

### SVG Support Status
The current implementation primarily generates PNG images using JpGraph. For SVG generation, you would need to extend the system:

#### Adding SVG Support

1. **Create SVG Actions**: Extend the action pattern for SVG output
```php
class Pie1SvgAction
{
    public function execute(AnswersChartData $answersChartData): string
    {
        // Generate SVG content instead of JpGraph object
        return $svgContent;
    }
}
```

2. **Save SVG Files**: Store SVG content to public directory
```php
file_put_contents($svgPath, $svgContent);
```

3. **Update Chart Types**: Add SVG-specific chart types
```php
// In ChartData.php
public function getActionClass(): string
{
    if ($this->engine_type === 'svg') {
        $engine = 'Svg';
    } else {
        $engine = 'JpGraph\V1';
    }
    $action = Str::studly($this->type).'Action';
    return '\\Modules\\Chart\\Actions\\'.$engine.'\\'.$action;
}
```

## PDF Integration

### 1. HTML to PDF Flow

The PDF generation process integrates charts as follows:

1. **Data Preparation**: `MakeHtmlBySurveyPdfModelAction` prepares data
2. **HTML Generation**: Template references chart images
3. **PDF Conversion**: `HtmlService::toPdf()` converts HTML to PDF

### 2. Chart Integration in Templates

Charts are included in PDF templates using the `img_src` attribute:

```blade
@php
    $imgPath = public_path(ltrim($img->img_src, '/'));
@endphp

@if(File::exists($imgPath))
    <img src="{{ $imgPath }}" />
@else
    <p style="color: red;">[Grafico non generato per ID {{ $img->id }}]</p>
@endif
```

### 3. PDF Generation Process

```php
class MakePdfAction
{
    public function execute(SurveyPdf $surveyPdf, ?AnswersFilterData $answersFilterData = null): BinaryFileResponse|View
    {
        // Generate HTML with charts
        $html = app(MakeHtmlBySurveyPdfModelAction::class)->execute($surveyPdf);
        
        // Convert to PDF
        $content = HtmlService::toPdf(html: $out, out: 'content_PDF');
        
        // Save and return
        File::put($filename, $content);
        return response()->download($filename);
    }
}
```

## Chart Configuration

### Chart Model Attributes

The `Chart` model supports extensive configuration:

```php
class Chart extends BaseModel
{
    // Visual properties
    public string $type;           // Chart type (bar1, pie1, etc.)
    public int $width;            // Chart width
    public int $height;           // Chart height
    public string $list_color;    // Color scheme
    public string $font_family;   // Font family
    public string $font_size;     // Font size
    public string $font_style;    // Font style
    
    // Display properties
    public bool $plot_value_show; // Show values on plot
    public int $plot_value_pos;   // Value position
    public int $plot_perc_width;  // Plot percentage width
    public ?string $transparency; // Transparency level
    
    // Labels and titles
    public ?string $title;        // Chart title
    public ?string $subtitle;     // Chart subtitle
    public ?string $footer;       // Chart footer
    public ?string $answer_value_txt;   // Answer text
    public ?string $answer_value_no_txt; // No answer text
}
```

### Chart Data Processing

The `ChartData` and `AnswersChartData` classes handle data transformation:

```php
// ChartData contains style and configuration
ChartData::from([
    'type' => 'bar1',
    'width' => 800,
    'height' => 600,
    'list_color' => 'red,blue,green',
    // ... other config
]);

// AnswersChartData contains actual data
AnswersChartData::from([
    'answers' => $answersCollection,
    'chart' => $chartData,
]);
```

## Performance Considerations

### 1. Memory Management
- Set high memory limits: `ini_set('memory_limit', '8095M')`
- Set execution time: `ini_set('max_execution_time', '300')`
- Process charts in batches for large datasets

### 2. Queue Processing
- Use `QueueableAction` for heavy chart generation
- Process multiple charts asynchronously
- Handle failures gracefully

### 3. Image Caching
- Charts are generated once and cached
- `generated_at` timestamp tracks generation time
- Re-generate only when needed

## Best Practices

### 1. Chart Type Selection
- Use `bar1` for simple bar charts
- Use `pie1` for percentage data
- Use `lineSubQuestion` for time-based trends
- Consider data size and complexity

### 2. Styling Consistency
- Use consistent color schemes across related charts
- Maintain font families and sizes
- Apply appropriate transparency levels
- Consider accessibility and color contrast

### 3. Error Handling
- Check if image files exist before including in PDF
- Provide fallback images for missing charts
- Log generation errors for debugging
- Handle JpGraph exceptions gracefully

### 4. Performance Optimization
- Use queued actions for batch processing
- Implement proper caching strategies
- Monitor memory usage during generation
- Optimize chart complexity for PDF rendering

This architecture provides a flexible, scalable system for creating various chart types and integrating them seamlessly into PDF documents within the Laraxot framework.
