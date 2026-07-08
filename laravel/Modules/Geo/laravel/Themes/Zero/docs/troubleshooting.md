# Zero Theme Troubleshooting Guide

## Advanced Charting Libraries

### JpGraph 4.4.2 (Recommended)
JpGraph is the primary PHP charting library for PDF generation in Zero theme:

**Key Features:**
- ✅ PHP 8.2+ support (latest version 4.4.2)
- ✅ 200+ built-in functions for chart generation
- ✅ 400+ named colors and 200+ country flags
- ✅ Advanced interpolation with cubic splines
- ✅ Multi-Y-axis support and background image support
- ✅ Image map generation for drill-down charts
- ✅ Built-in caching system for performance optimization
- ✅ Open source and free for personal use

**Supported Chart Types:**
- **Line Charts**: Line, filled line, step line, line with markers
- **Bar Charts**: Standard, horizontal, grouped, stacked, accumulated
- **Pie Charts**: 2D, 3D, exploding pie charts
- **Advanced**: Radar, polar, contour, stock, Gantt, geographic maps

**Installation:**
```bash
# JpGraph: pacchetto amenadiel/jpgraph (vedi Modules/Chart/docs/jpgraph-composer-and-namespaces.md)
composer require amenadiel/jpgraph
```

**Usage Example:**
```php
use Modules\Limesurvey\Models\SurveyResponse;

class ZeroThemeJpGraphGenerator
{
    public function generateChartForPdf(Chart $chart, string $surveyId, string $fieldName, string $title): string
    {
        $data = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();
        
        $graph = new \Graph($chart->width ?? 800, $chart->height ?? 400);
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        
        // Map font family and style
        $fontFamily = $this->mapFontFamily($chart->font_family);
        $fontStyle = $this->mapFontStyle($chart->font_style);
        $graph->title->SetFont($fontFamily, $fontStyle, $chart->font_size);
        
        // Create plot based on chart type
        $values = $data->pluck('count')->toArray();
        $labels = $data->pluck('answer')->toArray();
        $plot = $this->createPlot($chart->type, $values);
        $plot->SetFillColor($chart->list_color ?? '#3b82f6');
        
        // Set labels if applicable
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
            if (count($labels) > 5) {
                $graph->xaxis->SetLabelAngle(45);
            }
        }
        
        $graph->Add($plot);
        
        // Generate chart image
        $filename = 'charts/' . $chart->id . '_' . time() . '.png';
        $fullPath = public_path($filename);
        
        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $graph->Stroke($fullPath);
        
        return $filename;
    }
}
```

### Alternative PHP Chart Libraries

| Library | License | PHP Support | Best For | Pros | Cons |
|---------|---------|-------------|----------|------|------|
| **JpGraph** | Open Source | 8.2+ | PDF Generation | 200+ functions, 400+ colors, caching | Steep learning curve |
| **Libchart** | Open Source | 5.6+ | Simple Charts | Easy to use, lightweight | Limited chart types |
| **PHPlot** | Open Source | 5.6+ | Basic Charts | Mature, stable | Less actively maintained |
| **SVGGraph** | Open Source | 5.6+ | SVG Charts | Vector graphics, responsive | Limited 3D support |
| **ChartDirector** | Commercial | 5.6+ | Enterprise | Professional, extensive features | Expensive licensing |
| **Highcharts** | Commercial | JavaScript | Frontend Interactivity | Excellent interactivity | Backend not PHP |

### Chart.js (Frontend Alternative)
For interactive frontend charts, Chart.js is recommended:

**Installation:**
```bash
npm install chart.js chartjs-plugin-datalabels chartjs-plugin-annotation
```

**Usage:**
```javascript
// In your Blade template
<canvas id="myChart"></canvas>

<script>
const ctx = document.getElementById('myChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March'],
        datasets: [{
            label: 'Responses',
            data: [12, 19, 3],
            backgroundColor: '#3b82f6'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top'
            }
        }
    }
});
</script>
```

## Troubleshooting
Common issues and solutions:
- **Filament download action does nothing**: verify the action returns a response and pass `$tableFilters` directly (no wrapper): [IndennitaCondizioniLavoro rule](../../../Modules/IndennitaCondizioniLavoro/docs/action-return-type-rule.md)
- **Chart not displaying**: Check file permissions and paths
- **PDF generation failures**: Verify PDF library dependencies
- **Performance issues**: Implement proper caching and queuing
- **Filter not applying**: Validate filter data format
- **Action filters**: Pass raw table filters (no wrapper keys) if the action normalizes input
- **JpGraph not found**: Verify installation and autoloader configuration
- **Memory issues**: Optimize chart dimensions and implement Redis caching
- **Chart generation failures**: Check file permissions and directory creation
- **PDF embedding issues**: Verify chart image paths and HTML generation