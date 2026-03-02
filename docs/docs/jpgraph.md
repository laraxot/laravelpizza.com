# JpGraph 4.4.2 Guide

## Overview
JpGraph 4.4.2 is a PHP charting library with 200+ functions for server-side chart generation with PDF embedding support.

## Installation
```bash
composer require jpgraph/jpgraph
```

## Key Features
- 200+ chart functions
- Server-side chart generation
- PDF embedding support
- Multi-language support
- Advanced interpolation
- Image map support
- Multi-Y axis support

## Basic Chart Types

### 1. Line Charts
```php
use JpGraph\Graph\Graph;
use JpGraph\Plot\LinePlot;

$graph = new Graph(800, 600);
$graph->SetScale('intint');

$lineplot = new LinePlot($data);
$graph->Add($lineplot);
$graph->Stroke();
```

### 2. Bar Charts
```php
use JpGraph\Plot\BarPlot;

$barplot = new BarPlot($data);
$graph->Add($barplot);
$graph->Stroke();
```

### 3. Pie Charts
```php
use JpGraph\Plot\PiePlot;

$pieplot = new PiePlot($data);
$graph->Add($pieplot);
$graph->Stroke();
```

### 4. Scatter Plots
```php
use JpGraph\Plot\ScatterPlot;

$scatterplot = new ScatterPlot($ydata, $xdata);
$graph->Add($scatterplot);
$graph->Stroke();
```

## PDF Integration

### 1. Generate Chart for PDF
```php
// Generate chart as image
$graph = new Graph(800, 400);
// ... chart configuration
$graph->Stroke('temp_chart.png');

// Embed in PDF
$pdf = new HTML2PDF();
$pdf->writeHTML('<img src="temp_chart.png" />');
$pdf->Output('chart.pdf', 'D');
```

### 2. Chart Export Service
```php
class ChartExportService
{
    public static function generateChart($data, $type = 'line')
    {
        $graph = new Graph(800, 400);
        // Configure graph based on type
        $graph->Stroke();
        return $graph;
    }
}
```

## Advanced Features

### 1. Multi-Y Axis
```php
$graph = new Graph(800, 600);
$graph->SetScale('intint');
$graph->SetY2Scale('intint');
$graph->AddY2($y2data);
```

### 2. Image Maps
```php
$graph->SetImageMap($imgmap);
$graph->Stroke();
```

### 3. Advanced Interpolation
```php
$lineplot = new LinePlot($data);
$lineplot->SetStepInterpolation();
$graph->Add($lineplot);
```

## Survey Integration Pattern

### 1. SurveyResponse Data Access
```php
class SurveyResponse
{
    public static function getResponsesForSurvey($surveyId)
    {
        return DB::table("lime_survey_{$surveyId}")
            ->selectRaw('COUNT(*) as count, DATE_FORMAT(submitdate, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month');
    }
}
```

### 2. Chart Generation for Survey
```php
class SurveyChartGenerator
{
    public static function generateMonthlyChart($surveyId)
    {
        $data = SurveyResponse::getResponsesForSurvey($surveyId)->get();
        
        $graph = new Graph(800, 400);
        $graph->SetScale('textlin');
        
        $lineplot = new LinePlot($data->pluck('count')->toArray());
        $graph->Add($lineplot);
        
        return $graph;
    }
}
```

### 3. Question Type Handling
```php
class QuestionChart
{
    public function getItemAnswers()
    {
        if ($this->question_type === 'Y') {
            return ['Y', 'N'];
        }
        // Handle other question types
    }
}
```

## Optimization Techniques

### 1. Caching
```php
$redis = Redis::connection();
$chartData = $redis->get("chart_{$surveyId}");
if (!$chartData) {
    $chartData = self::generateChart($surveyId);
    $redis->setex("chart_{$surveyId}", 3600, $chartData);
}
```

### 2. Parallel Processing
```php
// Process multiple charts in parallel
foreach ($surveys as $survey) {
    $chart = self::generateChart($survey->id);
}
```

### 3. Image Optimization
```php
// Optimize image size for PDF
$graph->SetImgFormat('png', 80); // 80% quality
```

## Error Handling

### 1. Chart Generation Errors
```php
try {
    $graph = new Graph(800, 400);
    $graph->Stroke();
} catch (Exception $e) {
    Log::error('Chart generation failed: ' . $e->getMessage());
    // Return default chart or error message
}
```

### 2. Data Validation
```php
if (empty($data)) {
    throw new \InvalidArgumentException('No data provided for chart generation');
}
```

## Performance Considerations

1. **Memory Management**: Clear graph objects after use
2. **Caching Strategy**: Use Redis for frequently accessed charts
3. **Image Optimization**: Reduce image size for PDF embedding
4. **Batch Processing**: Process multiple charts in batches
5. **Database Optimization**: Use proper indexing for survey data queries

## Security Considerations

1. **Input Validation**: Validate all chart parameters
2. **File Validation**: Verify chart file types
3. **Path Validation**: Prevent path traversal attacks
4. **Resource Limits**: Implement memory and time limits
5. **Error Handling**: Don't expose sensitive information in errors

## Common Issues

### 1. Chart Not Displaying
- Check file permissions
- Verify GD library is installed
- Check memory limits

### 2. PDF Integration Issues
- Ensure HTML2PDF is properly configured
- Check image paths in PDF
- Verify chart dimensions

### 3. Performance Issues
- Implement caching
- Optimize database queries
- Use image compression

## Best Practices

1. **Always validate input data**
2. **Use proper error handling**
3. **Implement caching for frequently accessed charts**
4. **Optimize images for PDF embedding**
5. **Use proper resource cleanup**
6. **Implement proper logging**
7. **Test with various data sizes**
8. **Monitor memory usage**

## Testing

### 1. Unit Testing
```php
public function testChartGeneration()
{
    $data = [1, 2, 3, 4, 5];
    $chart = ChartGenerator::generateLineChart($data);
    $this->assertInstanceOf(Graph::class, $chart);
}
```

### 2. Integration Testing
```php
public function testChartInPDF()
{
    $chart = ChartGenerator::generateChart($surveyId);
    $pdf = $this->generatePdfWithChart($chart);
    $this->assertNotNull($pdf);
}
```

## Troubleshooting

### 1. Common Installation Issues
- Ensure PHP GD extension is enabled
- Check composer installation
- Verify PHP version compatibility

### 2. Configuration Issues
- Check JpGraph configuration
- Verify chart parameters
- Review error logs

### 3. Performance Issues
- Monitor memory usage
- Check cache effectiveness
- Review database queries

## Resources
- Official JpGraph documentation
- GitHub repository
- Community forums
- Stack Overflow questions