# Chart Export Libraries and Integration Guide

## Overview

This document provides a comprehensive guide to chart export libraries and their integration with external systems like LimeSurvey. It covers the main libraries used in the Laraxot framework: SPIPU HTML2PDF, JpGraph, and Spatie Laravel PDF, with a focus on how they work together to create professional chart exports.

## 1. Library Comparison

### 1.1 SPIPU HTML2PDF

**Purpose**: Converts HTML content to PDF format with extensive CSS support.

**Key Features**:
- Converts HTML to PDF using PHP
- Supports CSS styling and page layouts
- Compatible with PHP 7.2 - 8.4
- Requires GD and MBString PHP extensions
- Uses TCPDF as the underlying PDF engine

**Use Case in Project**: Primary PDF generation for survey reports containing JpGraph-generated charts

**Advantages**:
- Easy HTML-to-PDF conversion
- Good CSS support
- Handles images well
- Stable and well-maintained

**Disadvantages**:
- Limited JavaScript support
- May require image path adjustments for PDF contexts
- Requires specific HTML structure for PDF features

### 1.2 JpGraph

**Purpose**: PHP library for creating professional charts and graphs.

**Key Features**:
- Supports multiple chart types (line, bar, pie, scatter, etc.)
- High-quality output with small file sizes
- Web-friendly image generation
- Alpha blending support
- Over 400 named colors
- Multiple Y-axes support

**Use Case in Project**: Generates charts for survey data visualization, saved as PNG images for PDF embedding

**Advantages**:
- High-quality charts
- Small image size
- Extensive documentation
- Flexible scales (linear, logarithmic, text)
- Professional appearance

**Disadvantages**:
- Output as static images
- PHP-only library (no JavaScript integration)
- Requires specific configuration for each chart type

### 1.3 Spatie Laravel PDF

**Purpose**: Laravel wrapper for Browsershot (Puppeteer) for PDF generation.

**Key Features**:
- Uses headless Chrome/Chromium for rendering
- Supports modern CSS features (grid, flexbox, Tailwind)
- Blade view integration
- Queueable for background processing

**Use Case in Project**: Alternative PDF generation method using modern web standards

**Advantages**:
- Modern CSS support
- JavaScript execution capability
- Clean, professional output
- Laravel integration

**Disadvantages**:
- Requires Chrome/Chromium installation
- Higher resource usage
- More complex setup

## 2. JpGraph Implementation

### 2.1 Chart Types Available

The JpGraph integration supports multiple chart types through action classes:

- `Pie1Action` - Standard pie charts with percentage labels
- `PieAvgAction` - Pie charts with average calculations
- `Bar2Action` - Vertical bars with accumulation
- `Bar3Action` - Vertical bars stacked
- `Horizbar1Action` - Horizontal bars
- `LineSubQuestionAction` - Line charts for sub-questions

### 2.2 Chart Configuration

Charts are configured through the Chart model with various properties:

```php
protected $fillable = [
    'id', 'post_id', 'post_type', 'type', 'width', 'height',
    'color', 'bg_color', 'font_family', 'font_size', 'font_style',
    'y_grace', 'yaxis_hide', 'list_color', 'grace', 'x_label_angle',
    'show_box', 'x_label_margin', 'plot_perc_width', 'plot_value_show',
    'plot_value_format', 'plot_value_pos', 'plot_value_color',
    'group_by', 'sort_by', 'transparency', 'colors'
];
```

### 2.3 JpGraph Action Implementation

Example implementation of a JpGraph action:

```php
class Pie1Action
{
    public function execute(AnswersChartData $answersChartData): Graph
    {
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;

        // Create pie graph with specified dimensions
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create pie plot
        $piePlotC = new PiePlotC($data);
        
        // Apply colors and styling
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
        }
        $piePlotC->SetSliceColors($color_array);

        // Configure labels and formatting
        $piePlotC->SetLabelType(PIE_VALUE_PER);
        $piePlotC->value->SetFormat('%2.1f%%');

        // Add to graph and return
        $graph->Add($piePlotC);
        return $graph;
    }
}
```

## 3. PDF Generation Integration

### 3.1 SPIPU HTML2PDF Implementation

The SPIPU HTML2PDF integration handles the final PDF generation:

```php
class MakePdf2Action
{
    public function execute(SurveyPdf $surveyPdf, ?AnswersFilterData $answersFilterData = null): BinaryFileResponse
    {
        // Initialize HTML2PDF
        $html2pdf = new Html2Pdf('L', 'A4', 'it');
        $html2pdf->setTestIsImage(false); // Disable image validation

        // Generate chart images
        foreach ($questionCharts as $questionChart) {
            app(MakeImgByQuestionChartModel2Action::class)
                ->execute($questionChart, $responses, $answersFilterData);
        }

        // Generate HTML content
        $html = app(MakeHtmlBySurveyPdfModelAction::class)->execute($surveyPdf, $answersFilterData);

        // Convert HTML to PDF
        $html2pdf->writeHTML($html);
        
        // Output PDF file
        $path = Storage::disk('cache')->path($filename);
        $html2pdf->output($path, 'F');
        
        return response()->download($path, $filename, $headers);
    }
}
```

### 3.2 HTML Template Structure

The HTML template used for PDF generation:

```blade
@php
    $imgPath = public_path(ltrim($img->img_src, '/'));
@endphp

@if(File::exists($imgPath))
    <img src="{{ $imgPath }}" />
@else
    <p style="color: red;">[Chart not generated for ID {{ $img->id }}]</p>
@endif
```

## 4. Chart Export Actions

### 4.1 Widget Export Actions

The system provides actions for exporting charts from Filament widgets:

```php
class ExportChartFromWidgetAction
{
    public function execute(
        ChartWidget $widget,
        string $chartId,
        ?string $filenameBase = null,
        string $disk = 'public',
    ): array {
        $base64Data = $this->simulateChartExport($widget, $chartId);

        // Export to SVG
        $svgResult = app(ExportChartToSvgAction::class)->execute(
            base64Data: $base64Data,
            filename: $filenameBase.'.svg',
            disk: $disk
        );

        // Export to PNG
        $pngResult = app(ExportChartToPngAction::class)->execute(
            base64Data: $base64Data,
            filename: $filenameBase.'.png',
            disk: $disk,
            quality: 95
        );

        return [
            'svg' => $svgResult,
            'png' => $pngResult,
            'widget_class' => $widgetClass,
            'chart_id' => $chartId,
            'exported_at' => now()->toISOString(),
        ];
    }
}
```

### 4.2 Image Export Actions

Specific actions for different export formats:

- `ExportChartToSvgAction` - Export charts to SVG format
- `ExportChartToPngAction` - Export charts to PNG format
- `ExportChartFromWidgetAction` - Export from Filament widgets

## 5. Integration with External Systems

### 5.1 LimeSurvey Integration

The chart export system integrates with LimeSurvey through:

- Direct database access to LimeSurvey tables
- Dynamic model creation for survey-specific tables
- Data transformation from LimeSurvey format to chart-ready format
- Question/answer mapping between LimeSurvey and chart configurations

### 5.2 Data Processing Flow

1. **Data Retrieval**: Retrieve survey responses from LimeSurvey
2. **Data Transformation**: Convert to chart-ready format
3. **Chart Generation**: Generate chart using JpGraph
4. **Image Storage**: Save as PNG for PDF embedding
5. **PDF Creation**: Combine images and text in PDF format
6. **Delivery**: Return PDF to user

## 6. Performance Optimization

### 6.1 Chart Generation Optimization

- Use memory-intensive operations in background jobs
- Cache generated images for reuse
- Implement proper error handling to prevent failures
- Optimize chart dimensions for PDF clarity

### 6.2 PDF Generation Optimization

- Generate all images before creating HTML
- Use appropriate image quality settings
- Implement proper file cleanup after generation
- Use caching for frequently accessed PDFs

## 7. Best Practices

### 7.1 Chart Design Principles

1. **Consistency**: Use consistent colors and styling across all charts
2. **Clarity**: Ensure charts are readable in PDF format
3. **Simplicity**: Avoid overly complex charts that don't translate well to print
4. **Accessibility**: Include proper labels and legends for all charts

### 7.2 PDF Generation Best Practices

1. **Image Paths**: Always use absolute paths for images in PDF templates
2. **Image Validation**: Check image existence before including in PDF
3. **Memory Management**: Set appropriate memory limits for large charts
4. **Error Handling**: Implement comprehensive error handling for all steps
5. **File Cleanup**: Clean up temporary files after PDF generation

## 8. Troubleshooting Common Issues

### 8.1 Chart Images Not Appearing in PDF

**Problem**: Generated chart images don't appear in final PDF.

**Solutions**:
1. Verify image paths are absolute in HTML template
2. Disable image validation: `$html2pdf->setTestIsImage(false)`
3. Check file permissions for chart directory
4. Ensure images are generated before HTML processing

### 8.2 Memory Issues with Large Charts

**Problem**: Chart generation fails due to memory exhaustion.

**Solutions**:
1. Increase memory limit in action: `ini_set('memory_limit', '-1')`
2. Optimize chart dimensions and complexity
3. Use background job processing for large reports
4. Implement proper error handling for memory issues

### 8.3 Chart Quality Issues

**Problem**: Charts appear pixelated or low-quality in PDF.

**Solutions**:
1. Increase chart dimensions in Chart model configuration
2. Use appropriate PNG quality settings (95-100)
3. Optimize chart resolution for PDF printing (300 DPI equivalent)
4. Consider using vector formats when possible

## 9. Future Enhancements

### 9.1 Spatie Laravel PDF Integration

Consider implementing Spatie Laravel PDF as an alternative to SPIPU HTML2PDF:

```php
use Spatie\LaravelPdf\Facades\Pdf;

// Modern CSS support with Tailwind
Pdf::view('pdfs.chart-report', $data)
    ->format('A4')
    ->name('chart-report.pdf');
```

### 9.2 Chart.js Export Integration

Add client-side chart export capabilities:

```javascript
// Export Chart.js charts as images for PDF embedding
const canvas = document.getElementById('myChart');
const image = canvas.toDataURL('image/png');
```

### 9.3 Performance Improvements

- Implement chart caching with proper invalidation
- Add queue-based processing for large reports
- Optimize database queries with proper indexing
- Implement progressive chart loading for large datasets

## 10. Security Considerations

1. **File Access**: Validate and sanitize all file paths
2. **Data Input**: Sanitize data before processing
3. **User Permissions**: Ensure proper access controls for chart export
4. **File Storage**: Secure chart and PDF storage and prevent unauthorized access

This guide provides the foundation for implementing professional chart export functionality using the available PHP libraries in the Laraxot framework.