# UI Module Documentation

## Overview
The UI module provides shared user interface components, widgets, and styling for the Laraxot system. It includes specialized components for chart rendering, PDF generation interfaces, and survey data visualization. The module integrates with Chart and Quaeris modules to provide professional UI experiences for survey data analysis and reporting.

## Key Features
- **Chart Components**: Reusable chart components with multiple visualization options
- **PDF Generation UI**: Interfaces for PDF report generation with chart embedding
- **Survey Widgets**: Specialized widgets for survey data visualization
- **Responsive Design**: Mobile-first responsive design principles
- **Theme Support**: Integration with Laraxot's theme system
- **Accessibility**: WCAG 2.1 compliant components

## Core Components

### Chart Components
- `ChartWidget` - Interactive chart widget with export capabilities
- `ChartRenderer` - Server-side chart rendering component
- `ChartExportModal` - Modal interface for chart export options
- `PdfChartPreview` - Preview component for charts in PDF context

### PDF Components
- `PdfGeneratorForm` - Form for PDF generation configuration
- `PdfPreview` - Preview component for PDF content
- `PdfExportButton` - Specialized button for PDF exports
- `PdfTemplateSelector` - Component for selecting PDF templates

### Survey Components
- `QuestionChartAnswersTableWidget` - Table widget for question answers
- `SurveyResponseView` - View component for survey responses
- `SurveyFilterPanel` - Filtering interface for survey data

## Chart Integration with PDF Generation

### Chart Component Architecture with Dual Approach Support
```blade
{{-- ChartWidget Component with Support for Both Dynamic and Flip Approaches --}}
<x-filament-widgets::widget class="chart-widget">
    <div class="chart-container" id="chart-{{ $chartId }}">
        <div class="chart-header">
            <select id="data-approach-{{ $chartId }}" onchange="changeDataApproach('{{ $chartId }}')">
                <option value="dynamic" {{ $selectedApproach === 'dynamic' ? 'selected' : '' }}>Dynamic Model</option>
                <option value="flip" {{ $selectedApproach === 'flip' ? 'selected' : '' }}>Flip Approach</option>
            </select>
        </div>
        
        <canvas id="chart-canvas-{{ $chartId }}"></canvas>
        
        <div class="chart-actions">
            <x-ui::button 
                type="button" 
                onclick="exportChartToPng('{{ $chartId }}')"
                class="btn-secondary"
            >
                Export PNG
            </x-ui::button>
            
            <x-ui::button 
                type="button" 
                onclick="exportChartToPdf('{{ $chartId }}')"
                class="btn-primary"
            >
                Export PDF
            </x-ui::button>
        </div>
    </div>
    
    <script>
        function changeDataApproach(chartId) {
            const approachSelect = document.getElementById('data-approach-' + chartId);
            const selectedApproach = approachSelect.value;
            
            // Reload chart with new approach
            fetch('/api/charts/data/' + chartId + '?approach=' + selectedApproach, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update chart with new data
                updateChart(chartId, data);
            });
        }
        
        function exportChartToPng(chartId) {
            const canvas = document.getElementById('chart-canvas-' + chartId);
            const pngData = canvas.toDataURL('image/png');
            
            // Get selected approach
            const approachSelect = document.getElementById('data-approach-' + chartId);
            const selectedApproach = approachSelect.value;
            
            // Send to server for processing
            fetch('/api/charts/export/png', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    chartId: chartId,
                    pngData: pngData,
                    approach: selectedApproach
                })
            });
        }
        
        function exportChartToPdf(chartId) {
            // Get selected approach
            const approachSelect = document.getElementById('data-approach-' + chartId);
            const selectedApproach = approachSelect.value;
            
            // Generate PDF with chart embedded
            fetch('/api/charts/export/pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    chartId: chartId,
                    engine: 'html2pdf', // or 'spatie'
                    approach: selectedApproach
                })
            }).then(response => {
                if (response.ok) {
                    response.blob().then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'chart_' + chartId + '.pdf';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    });
                }
            });
        }
        
        function updateChart(chartId, data) {
            const ctx = document.getElementById('chart-canvas-' + chartId).getContext('2d');
            
            // Destroy existing chart if it exists
            if (window.charts && window.charts[chartId]) {
                window.charts[chartId].destroy();
            }
            
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Responses',
                        data: data.values,
                        backgroundColor: [
                            '#3b82f6', '#ef4444', '#10b981', '#f59e0b',
                            '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Survey Responses'
                        }
                    }
                }
            });
            
            // Store chart reference
            if (!window.charts) window.charts = {};
            window.charts[chartId] = chart;
        }
    </script>
</x-filament-widgets::widget>
```

### PDF Generation Component
```blade
{{-- PdfGeneratorForm Component --}}
<x-ui::form wire:submit.prevent="generatePdf">
    <div class="pdf-generator-form">
        <div class="form-group">
            <x-ui::label for="survey_pdf_id">Survey PDF Template</x-ui::label>
            <x-ui::select 
                id="survey_pdf_id" 
                wire:model="surveyPdfId"
                class="form-control"
            >
                <option value="">Select a template</option>
                @foreach($surveyPdfs as $pdf)
                    <option value="{{ $pdf->id }}">{{ $pdf->name }}</option>
                @endforeach
            </x-ui::select>
        </div>
        
        <div class="form-group">
            <x-ui::label for="pdf_engine">PDF Engine</x-ui::label>
            <x-ui::select 
                id="pdf_engine" 
                wire:model="pdfEngine"
                class="form-control"
            >
                <option value="html2pdf">HTML2PDF</option>
                <option value="spatie">Spatie PDF</option>
            </x-ui::select>
        </div>
        
        <div class="form-group">
            <x-ui::label for="include_charts">Include Charts</x-ui::label>
            <x-ui::checkbox 
                id="include_charts" 
                wire:model="includeCharts"
            />
        </div>
        
        <div class="form-actions">
            <x-ui::button type="submit" class="btn-primary">
                Generate PDF
            </x-ui::button>
        </div>
    </div>
</x-ui::form>
```

## Advanced Chart Integration

### Chart with Dynamic Data from LimeSurvey
```blade
{{-- Chart with LimeSurvey Dynamic Model Integration --}}
<div class="chart-with-dynamic-data">
    <div class="chart-header">
        <h3>{{ $questionText }}</h3>
        <p>Survey: {{ $surveyId }} | Question: {{ $questionId }}</p>
    </div>
    
    <div class="chart-content">
        <canvas id="dynamic-chart-{{ $chartId }}"></canvas>
        
        <div class="chart-data-source">
            <small>Data from lime_survey_{{ $surveyId }} table</small>
        </div>
    </div>
    
    <script>
        // Initialize chart with data from dynamic model
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('dynamic-chart-{{ $chartId }}').getContext('2d');
            
            // Fetch data using dynamic model
            fetch('/api/limesurvey/data/{{ $surveyId }}/{{ $questionId }}')
                .then(response => response.json())
                .then(data => {
                    new Chart(ctx, {
                        type: '{{ $chartType }}',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Responses',
                                data: data.values,
                                backgroundColor: [
                                    '#3b82f6', '#ef4444', '#10b981', '#f59e0b',
                                    '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: '{{ $questionText }}'
                                }
                            }
                        }
                    });
                });
        });
    </script>
</div>
```

### PDF Template Component
```blade
{{-- PDF Template with Chart Embedding --}}
<div class="pdf-template" style="font-family: Arial, sans-serif; max-width: 21cm; margin: 0 auto;">
    <header class="pdf-header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </header>
    
    <main class="pdf-content">
        @foreach($charts as $chart)
            <section class="chart-section">
                <h2>{{ $chart['title'] }}</h2>
                @if($chart['image_path'])
                    <img src="{{ public_path($chart['image_path']) }}" 
                         alt="{{ $chart['title'] }}"
                         style="width: 100%; height: auto; border: 1px solid #ddd;">
                @else
                    <div class="chart-placeholder">
                        <p>No chart data available for: {{ $chart['title'] }}</p>
                    </div>
                @endif
                
                @if($chart['data_table'])
                    <table class="chart-data-table">
                        <thead>
                            <tr>
                                <th>Response</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chart['data_table'] as $row)
                                <tr>
                                    <td>{{ $row['label'] }}</td>
                                    <td>{{ $row['count'] }}</td>
                                    <td>{{ $row['percentage'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        @endforeach
    </main>
    
    <footer class="pdf-footer">
        <p>Page <span class="page-number"></span> of <span class="total-pages"></span></p>
    </footer>
</div>
```

## Server-Side Chart Generation for PDFs

### JpGraph Integration in Components
```php
use Modules\Limesurvey\Models\SurveyResponse;

class PdfChartGenerator
{
    public function generateChartForPdf(string $surveyId, string $fieldName, array $data): string
    {
        $graph = new \Graph(800, 400);
        $graph->SetScale('textlin');
        
        // Set title
        $graph->title->Set($data['title']);
        $graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
        
        // Create plot
        $plot = new \BarPlot($data['values']);
        $plot->SetFillColor('#3b82f6');
        
        // Add value labels
        $plot->value->Show();
        $plot->value->SetFormat('%.0f');
        
        $graph->Add($plot);
        
        // Generate chart image
        $filename = 'temp_charts/pdf_chart_' . time() . '.png';
        $fullPath = public_path($filename);
        
        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $graph->Stroke($fullPath);
        
        return $filename;
    }
    
    public function generatePieChartForPdf(string $surveyId, string $fieldName, array $data): string
    {
        $graph = new \PieGraph(600, 400);
        $graph->title->Set($data['title']);
        $graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
        
        $p1 = new \PiePlot($data['values']);
        $p1->SetLegends($data['labels']);
        $p1->SetSliceColors(['#3b82f6', '#ef4444', '#10b981', '#f59e0b']);
        
        $graph->Add($p1);
        
        $filename = 'temp_charts/pdf_pie_chart_' . time() . '.png';
        $fullPath = public_path($filename);
        
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $graph->Stroke($fullPath);
        
        return $filename;
    }
}
```

### Multi-Engine PDF Component
```php
use Spipu\Html2Pdf\Html2Pdf;
use Spatie\LaravelPdf\Facades\Pdf as SpatiePdf;
use Modules\Limesurvey\Models\SurveyResponse;

class MultiEnginePdfComponent
{
    public function generatePdfWithCharts(array $chartData, string $engine = 'html2pdf'): \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
    {
        switch ($engine) {
            case 'spatie':
                return $this->generateWithSpatie($chartData);
            case 'html2pdf':
            default:
                return $this->generateWithHtml2Pdf($chartData);
        }
    }
    
    private function generateWithHtml2Pdf(array $chartData): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $chartGenerator = new PdfChartGenerator();
        $chartImages = [];
        
        foreach ($chartData as $index => $data) {
            $imagePath = $chartGenerator->generateChartForPdf(
                $data['survey_id'],
                $data['field_name'],
                [
                    'title' => $data['title'],
                    'values' => $data['values']
                ]
            );
            $chartImages[$index] = $imagePath;
        }
        
        $html = $this->buildPdfHtml($chartData, $chartImages);
        
        $html2pdf = new Html2Pdf('L', 'A4', 'en');
        $html2pdf->setTestIsImage(true);
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($html);
        
        $filename = 'survey_report_' . date('Y-m-d') . '.pdf';
        $path = storage_path('app/reports/' . $filename);
        $html2pdf->output($path, 'F');
        
        // Clean up temporary images
        $this->cleanupTempImages($chartImages);
        
        return response()->download($path);
    }
    
    private function generateWithSpatie(array $chartData): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $chartGenerator = new PdfChartGenerator();
        $processedCharts = [];
        
        foreach ($chartData as $index => $data) {
            $imagePath = $chartGenerator->generateChartForPdf(
                $data['survey_id'],
                $data['field_name'],
                [
                    'title' => $data['title'],
                    'values' => $data['values']
                ]
            );
            
            $imageData = file_get_contents(public_path($imagePath));
            $base64Image = 'data:image/png;base64,' . base64_encode($imageData);
            
            $processedCharts[] = [
                'title' => $data['title'],
                'image_base64' => $base64Image,
                'data_table' => $data['data_table'] ?? []
            ];
        }
        
        return SpatiePdf::view('ui.pdf.survey-report', [
            'charts' => $processedCharts,
            'title' => 'Survey Report',
            'date' => now()
        ])
        ->format('a4')
        ->name('survey_report_' . date('Y-m-d') . '.pdf');
    }
    
    private function buildPdfHtml(array $chartData, array $chartImages): string
    {
        $html = '<page backtop="20mm" backbottom="20mm" backleft="15mm" backright="15mm">';
        $html .= '<h1 style="text-align: center; font-size: 18pt; margin-bottom: 20px;">Survey Report</h1>';
        $html .= '<p style="text-align: center; margin-bottom: 20px;">Generated on: ' . date('F j, Y \a\t g:i A') . '</p>';
        
        foreach ($chartData as $index => $data) {
            if (isset($chartImages[$index])) {
                $html .= '<div style="margin: 20px 0; page-break-inside: avoid;">';
                $html .= '<h2 style="font-size: 14pt; margin-bottom: 10px;">' . e($data['title']) . '</h2>';
                $html .= '<img src="' . public_path($chartImages[$index]) . '" style="width: 100%; height: auto; border: 1px solid #ddd;">';
                
                if (!empty($data['data_table'])) {
                    $html .= '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
                    $html .= '<thead><tr><th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Response</th><th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Count</th><th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Percentage</th></tr></thead>';
                    $html .= '<tbody>';
                    
                    foreach ($data['data_table'] as $row) {
                        $html .= '<tr>';
                        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . e($row['label']) . '</td>';
                        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . e($row['count']) . '</td>';
                        $html .= '<td style="border: 1px solid #ddd; padding: 8px;">' . e($row['percentage']) . '%</td>';
                        $html .= '</tr>';
                    }
                    
                    $html .= '</tbody></table>';
                }
                
                $html .= '</div>';
            }
        }
        
        $html .= '</page>';
        
        return $html;
    }
    
    private function cleanupTempImages(array $images): void
    {
        foreach ($images as $imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
```

## Styling and Theming

### CSS for Chart Components
```css
.chart-container {
    position: relative;
    width: 100%;
    height: 400px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.chart-actions {
    margin-top: 1rem;
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.pdf-generator-form {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1.5rem;
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1rem;
}

.form-actions {
    margin-top: 1.5rem;
    text-align: right;
}

.chart-section {
    margin: 2rem 0;
    page-break-inside: avoid;
}

.chart-placeholder {
    text-align: center;
    padding: 2rem;
    background: #f9fafb;
    border: 1px dashed #d1d5db;
    border-radius: 0.5rem;
    color: #6b7280;
}

.chart-data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    font-size: 0.875rem;
}

.chart-data-table th,
.chart-data-table td {
    border: 1px solid #d1d5db;
    padding: 0.5rem;
    text-align: left;
}

.chart-data-table th {
    background-color: #f3f4f6;
    font-weight: 600;
}
```

### Responsive Design
```css
@media (max-width: 768px) {
    .chart-container {
        height: 300px;
        padding: 0.5rem;
    }
    
    .pdf-generator-form {
        padding: 1rem;
        margin: 0.5rem;
    }
    
    .chart-data-table {
        font-size: 0.75rem;
    }
    
    .chart-data-table th,
    .chart-data-table td {
        padding: 0.25rem;
    }
}

@media (max-width: 480px) {
    .chart-container {
        height: 250px;
    }
    
    .chart-actions {
        flex-direction: column;
    }
    
    .chart-actions > * {
        width: 100%;
    }
}
```

## Accessibility Features

### ARIA Attributes for Charts
```blade
<canvas 
    id="accessible-chart-{{ $chartId }}"
    role="img"
    aria-label="Chart showing survey responses for {{ $questionText }}"
    aria-describedby="chart-desc-{{ $chartId }}"
></canvas>

<div id="chart-desc-{{ $chartId }}" class="sr-only">
    Survey responses for "{{ $questionText }}". 
    @foreach($chartData['data_table'] as $row)
        {{ $row['label'] }}: {{ $row['count'] }} responses ({{ $row['percentage'] }}%).
    @endforeach
</div>
```

### Keyboard Navigation
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const chartCanvases = document.querySelectorAll('.chart-container canvas');
    
    chartCanvases.forEach(canvas => {
        canvas.setAttribute('tabindex', '0');
        canvas.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                // Trigger chart export or other action
                exportChartToPng(canvas.id.replace('chart-canvas-', ''));
            }
        });
    });
});
```

## Integration with Other Modules

### Integration with Quaeris Module
```blade
{{-- Survey PDF Generation Interface --}}
<div class="survey-pdf-generator">
    <h2>Generate Survey PDF Report</h2>
    
    <x-ui::form wire:submit.prevent="generateSurveyPdf">
        <div class="form-group">
            <x-ui::label for="survey_pdf_template">PDF Template</x-ui::label>
            <x-ui::select 
                id="survey_pdf_template" 
                wire:model="selectedTemplate"
            >
                <option value="">Select a template</option>
                @foreach($surveyPdfTemplates as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </x-ui::select>
        </div>
        
        <div class="form-group">
            <x-ui::label>Include Charts</x-ui::label>
            <x-ui::checkbox 
                wire:model="includeCharts"
                id="include_charts"
            />
            <x-ui::label for="include_charts">Show charts in report</x-ui::label>
        </div>
        
        <div class="form-group">
            <x-ui::label for="chart_engine">Chart Engine</x-ui::label>
            <x-ui::select 
                id="chart_engine" 
                wire:model="chartEngine"
            >
                <option value="chartjs">Chart.js</option>
                <option value="jpgraph">JpGraph</option>
            </x-ui::select>
        </div>
        
        <div class="form-actions">
            <x-ui::button type="submit" class="btn-primary">
                Generate Report
            </x-ui::button>
        </div>
    </x-ui::form>
</div>
```

### Integration with Chart Module
```blade
{{-- Chart Configuration Interface --}}
<div class="chart-configurator">
    <h3>Configure Chart</h3>
    
    <x-ui::form wire:submit.prevent="updateChartConfig">
        <div class="form-group">
            <x-ui::label for="chart_type">Chart Type</x-ui::label>
            <x-ui::select 
                id="chart_type" 
                wire:model="chart.type"
            >
                <option value="bar1">Vertical Bar</option>
                <option value="bar2">Vertical Bar (Styled)</option>
                <option value="bar3">Vertical Bar (Detailed)</option>
                <option value="horizbar1">Horizontal Bar</option>
                <option value="horizbar2">Horizontal Bar (Styled)</option>
                <option value="pie1">Pie Chart</option>
                <option value="pieAvg">Pie Chart with Average</option>
                <option value="line1">Line Chart</option>
                <option value="lineSubQuestion">Line Chart (Sub-questions)</option>
            </x-ui::select>
        </div>
        
        <div class="form-group">
            <x-ui::label for="chart_width">Width</x-ui::label>
            <x-ui::input 
                id="chart_width" 
                type="number" 
                wire:model="chart.width"
                min="400"
                max="1200"
            />
        </div>
        
        <div class="form-group">
            <x-ui::label for="chart_height">Height</x-ui::label>
            <x-ui::input 
                id="chart_height" 
                type="number" 
                wire:model="chart.height"
                min="200"
                max="800"
            />
        </div>
        
        <div class="form-group">
            <x-ui::label for="chart_color">Color</x-ui::label>
            <x-ui::input 
                id="chart_color" 
                type="color" 
                wire:model="chart.list_color"
            />
        </div>
        
        <div class="form-actions">
            <x-ui::button type="submit" class="btn-primary">
                Update Chart
            </x-ui::button>
        </div>
    </x-ui::form>
</div>
```

## Advanced PDF Features

### Custom PDF Templates with Dual Approach Support
```blade
{{-- Custom PDF Template with Advanced Features and Approach Selection --}}
<div class="pdf-template advanced" 
     style="font-family: Arial, sans-serif; max-width: 21cm; margin: 0 auto; background: white; padding: 2cm;">
    
    <header class="pdf-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 1.5em; margin: 0; color: #1f2937;">{{ $title }}</h1>
                <p style="margin: 0.5em 0 0; color: #6b7280;">Survey ID: {{ $surveyId }} | Data Approach: {{ $dataApproach }}</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0;">Report generated on</p>
                <p style="font-size: 1.2em; font-weight: bold; margin: 0;">{{ $date->format('F j, Y') }}</p>
            </div>
        </div>
        <hr style="margin: 1em 0; border: none; border-top: 1px solid #e5e7eb;">
    </header>
    
    <main class="pdf-content">
        <section class="executive-summary" style="background: #f9fafb; padding: 1em; border-radius: 0.5em; margin-bottom: 2em;">
            <h2 style="font-size: 1.2em; margin-top: 0;">Executive Summary</h2>
            <p>Total responses: {{ $totalResponses }}</p>
            <p>Date range: {{ $dateRange }}</p>
            <p>Data approach: {{ $dataApproach }} (Dynamic Model: {{ $dataApproach === 'dynamic' ? 'Direct field access' : 'Normalized EAV' }})</p>
        </section>
        
        @foreach($charts as $chart)
            <section class="chart-section" style="margin-bottom: 2em;">
                <h2 style="font-size: 1.1em; margin-top: 0; color: #1f2937;">{{ $chart['title'] }}</h2>
                
                @if($chart['image_path'])
                    <div style="display: flex; align-items: flex-start; gap: 1em; margin: 1em 0;">
                        <img src="{{ public_path($chart['image_path']) }}" 
                             alt="{{ $chart['title'] }}"
                             style="width: 60%; height: auto; border: 1px solid #ddd; border-radius: 0.25em;">
                        
                        @if($chart['data_table'])
                            <div style="flex: 1;">
                                <h3 style="font-size: 1em; margin-top: 0;">Detailed Data</h3>
                                <table style="width: 100%; border-collapse: collapse; font-size: 0.9em;">
                                    <thead>
                                        <tr style="background-color: #f3f4f6;">
                                            <th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: left;">Response</th>
                                            <th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">Count</th>
                                            <th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($chart['data_table'] as $row)
                                            <tr>
                                                <td style="border: 1px solid #d1d5db; padding: 0.5em;">{{ $row['label'] }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">{{ $row['count'] }}</td>
                                                <td style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">{{ $row['percentage'] }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="chart-placeholder" style="text-align: center; padding: 2em; background: #fef2f2; border: 1px dashed #fecaca; border-radius: 0.5em; color: #dc2626;">
                        <p>No data available for this chart</p>
                    </div>
                @endif
            </section>
        @endforeach
    </main>
    
    <footer class="pdf-footer" style="margin-top: 2em; padding-top: 1em; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 0.9em;">
        <p>Page <span class="page-number"></span> of <span class="total-pages"></span></p>
        <p>Generated by Laraxot Survey System | Data Approach: {{ $dataApproach }}</p>
    </footer>
</div>
```

### Backend Implementation for Dual Approach PDF Generation
```php
use Modules\Limesurvey\Models\SurveyResponse;
use Modules\Limesurvey\Models\SurveyFlipResponse;

class DualApproachPdfGenerator
{
    public function generatePdfWithCharts(array $chartData, string $surveyId, string $approach = 'dynamic', array $options = []): string
    {
        $chartGenerator = new JpGraphGenerator();
        $chartImages = [];
        
        foreach ($chartData as $index => $chart) {
            if ($approach === 'flip') {
                // Use SurveyFlipResponse (EAV approach)
                $imagePath = $chartGenerator->generateChartFromFlipData(
                    $chart,
                    $surveyId,
                    $chart['question_id'] ?? '',
                    $chart['title'] ?? 'Chart'
                );
            } else {
                // Use SurveyResponse (dynamic table approach)
                $imagePath = $chartGenerator->generateChartFromSurveyData(
                    $chart,
                    $surveyId,
                    $chart['field_name'] ?? '',
                    $chart['title'] ?? 'Chart'
                );
            }
            
            $chartImages[] = $imagePath;
        }
        
        $html = $this->buildPdfHtml($chartData, $chartImages, $approach);
        
        $html2pdf = new Html2Pdf('L', 'A4', 'en');
        $html2pdf->setTestIsImage(true);
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($html);
        
        $filename = 'survey_report_' . $surveyId . '_' . $approach . '_' . date('Y-m-d') . '.pdf';
        $path = storage_path('app/reports/' . $filename);
        $html2pdf->output($path, 'F');
        
        $this->cleanupTempImages($chartImages);
        
        return $path;
    }
    
    public function generateComparisonPdf(array $chartData, string $surveyId): string
    {
        $chartGenerator = new JpGraphGenerator();
        $chartImages = [];
        
        foreach ($chartData as $index => $chart) {
            // Generate charts using both approaches for comparison
            $imagePath = $chartGenerator->generateComparisonChart(
                $chart,
                $surveyId,
                $chart['question_id'] ?? '',
                $chart['field_name'] ?? '',
                $chart['title'] ?? 'Chart'
            );
            
            $chartImages[] = $imagePath;
        }
        
        $html = $this->buildComparisonPdfHtml($chartData, $chartImages);
        
        $html2pdf = new Html2Pdf('L', 'A4', 'en');
        $html2pdf->setTestIsImage(true);
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($html);
        
        $filename = 'survey_comparison_report_' . $surveyId . '_' . date('Y-m-d') . '.pdf';
        $path = storage_path('app/reports/' . $filename);
        $html2pdf->output($path, 'F');
        
        $this->cleanupTempImages($chartImages);
        
        return $path;
    }
    
    private function buildPdfHtml(array $chartData, array $chartImages, string $approach): string
    {
        $html = '<page backtop="20mm" backbottom="20mm" backleft="15mm" backright="15mm">';
        $html .= '<h1 style="text-align: center; font-size: 18pt; margin-bottom: 10px;">Survey Report</h1>';
        $html .= '<p style="text-align: center; margin-bottom: 10px;">Survey ID: ' . e($chartData[0]['survey_id'] ?? 'N/A') . ' | Data Approach: ' . ucfirst($approach) . '</p>';
        $html .= '<p style="text-align: center; margin-bottom: 20px;">Generated on: ' . date('F j, Y \a\t g:i A') . '</p>';
        
        foreach ($chartData as $index => $data) {
            if (isset($chartImages[$index])) {
                $html .= '<div style="margin: 20px 0; page-break-inside: avoid;">';
                $html .= '<h2 style="font-size: 14pt; margin-bottom: 10px;">' . e($data['title']) . '</h2>';
                $html .= '<img src="' . public_path($chartImages[$index]) . '" style="width: 100%; height: auto; border: 1px solid #ddd;">';
                
                if (!empty($data['data_table'])) {
                    $html .= '<table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.8em;">';
                    $html .= '<thead><tr style="background-color: #f3f4f6;"><th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: left;">Response</th><th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">Count</th><th style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">%</th></tr></thead>';
                    $html .= '<tbody>';
                    
                    foreach ($data['data_table'] as $row) {
                        $html .= '<tr>';
                        $html .= '<td style="border: 1px solid #d1d5db; padding: 0.5em;">' . e($row['label']) . '</td>';
                        $html .= '<td style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">' . e($row['count']) . '</td>';
                        $html .= '<td style="border: 1px solid #d1d5db; padding: 0.5em; text-align: right;">' . e($row['percentage']) . '%</td>';
                        $html .= '</tr>';
                    }
                    
                    $html .= '</tbody></table>';
                }
                
                $html .= '</div>';
            }
        }
        
        $html .= '</page>';
        
        return $html;
    }
    
    private function buildComparisonPdfHtml(array $chartData, array $chartImages): string
    {
        $html = '<page backtop="20mm" backbottom="20mm" backleft="15mm" backright="15mm">';
        $html .= '<h1 style="text-align: center; font-size: 18pt; margin-bottom: 10px;">Survey Data Comparison Report</h1>';
        $html .= '<p style="text-align: center; margin-bottom: 10px;">Survey ID: ' . e($chartData[0]['survey_id'] ?? 'N/A') . '</p>';
        $html .= '<p style="text-align: center; margin-bottom: 20px;">Comparing Dynamic Model vs Flip Approach | Generated on: ' . date('F j, Y \a\t g:i A') . '</p>';
        
        foreach ($chartData as $index => $data) {
            if (isset($chartImages[$index])) {
                $html .= '<div style="margin: 20px 0; page-break-inside: avoid;">';
                $html .= '<h2 style="font-size: 14pt; margin-bottom: 10px;">' . e($data['title']) . '</h2>';
                $html .= '<img src="' . public_path($chartImages[$index]) . '" style="width: 100%; height: auto; border: 1px solid #ddd;">';
                $html .= '<p style="text-align: center; font-style: italic;">Comparison of Dynamic Model (blue) vs Flip Approach (red)</p>';
                $html .= '</div>';
            }
        }
        
        $html .= '</page>';
        
        return $html;
    }
}
```

## Performance Optimization

### Chart Caching Component
```php
use Illuminate\Support\Facades\Cache;

class CachedChartComponent
{
    public function getChartWithCache(string $surveyId, string $fieldName, array $options = []): array
    {
        $cacheKey = "ui_chart_{$surveyId}_{$fieldName}_" . md5(serialize($options));
        $ttl = now()->addMinutes(30); // Cache for 30 minutes
        
        return Cache::remember($cacheKey, $ttl, function() use ($surveyId, $fieldName, $options) {
            // Generate chart data using dynamic models
            return $this->generateChartData($surveyId, $fieldName, $options);
        });
    }
    
    private function generateChartData(string $surveyId, string $fieldName, array $options): array
    {
        use Modules\Limesurvey\Models\SurveyResponse;
        
        $query = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->orderBy('count', 'desc');
            
        if (isset($options['date_from'])) {
            $query->where('submitdate', '>=', $options['date_from']);
        }
        
        if (isset($options['date_to'])) {
            $query->where('submitdate', '<=', $options['date_to']);
        }
        
        if (isset($options['limit'])) {
            $query->limit($options['limit']);
        }
        
        $results = $query->get();
        
        $total = $results->sum('count');
        
        $dataTable = $results->map(function($item) use ($total) {
            return [
                'label' => $item->answer,
                'count' => $item->count,
                'percentage' => $total > 0 ? round(($item->count / $total) * 100, 2) : 0
            ];
        });
        
        return [
            'labels' => $results->pluck('answer')->toArray(),
            'values' => $results->pluck('count')->toArray(),
            'data_table' => $dataTable->toArray(),
            'total' => $total
        ];
    }
}
```

## Security Considerations
- **Input Validation**: Validate all chart configuration inputs
- **File Security**: Secure chart image file paths and access
- **XSS Prevention**: Sanitize all data before rendering
- **PDF Content**: Validate HTML content before PDF generation
- **Dynamic Model Access**: Validate survey IDs before accessing dynamic tables
- **CSRF Protection**: Implement CSRF protection for all forms

## Performance Optimization
1. **Caching**: Cache chart data and configurations
2. **Asynchronous Processing**: Generate large charts in background jobs
3. **Image Optimization**: Optimize chart images for size and quality
4. **Memory Management**: Monitor memory usage for large datasets
5. **Database Indexing**: Proper indexing for survey response tables

## Troubleshooting
Common issues and solutions:
- **Chart not displaying**: Check file permissions and paths
- **PDF generation failures**: Verify PDF library dependencies
- **Performance issues**: Implement proper caching and queuing
- **Font rendering**: Ensure proper font libraries are installed
- **Dynamic model access**: Validate survey IDs before accessing dynamic tables
- **Memory issues**: Monitor and adjust memory limits for large reports

## Best Practices
1. **Responsive Design**: Ensure components work on all device sizes
2. **Accessibility**: Implement proper ARIA attributes and keyboard navigation
3. **Performance**: Use caching and async processing for large datasets
4. **Security**: Validate all inputs and secure file paths
5. **Dynamic Models**: Always use dynamic models (SurveyResponse) for LimeSurvey data access
6. **Error Handling**: Implement comprehensive error handling
7. **Testing**: Test components with various data types and edge cases

## Related Modules
- [Chart Module](../Chart/docs/index.md) - Chart generation and data processing
- [Quaeris Module](../Quaeris/docs/index.md) - Survey management and question charts
- [LimeSurvey Module](../Limesurvey/docs/index.md) - Survey data access with dynamic models
- [Xot Module](../Xot/docs/index.md) - Base UI infrastructure and component patterns

## Statistical Analysis for Question Type Y

### Enhanced Statistical Widgets
For question type Y (Yes/No responses), the system provides enhanced statistical analysis capabilities:

```php
namespace Modules\Quaeris\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Limesurvey\Models\SurveyResponse;
use Modules\Quaeris\Models\QuestionChart;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class QuestionChartAnswersYTypeWidget extends XotBaseTableWidget
{
    public ?QuestionChart $record = null;

    public function getTableColumns(): array
    {
        if ($this->record && $this->record->question_type === 'Y') {
            return [
                TextColumn::make('_id')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('submitdate')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                TextColumn::make('label'),
                TextColumn::make('value')->badge(),
                TextColumn::make('Y_count')->badge()->label('Yes Count'),
                TextColumn::make('N_count')->badge()->label('No Count'),
                TextColumn::make('answer'),
                TextColumn::make('answer_lang'),
                TextColumn::make('yes_percentage')
                    ->label('Yes %')
                    ->formatStateUsing(function ($record) {
                        if (isset($record->Y_count) && isset($record->total_count) && $record->total_count > 0) {
                            return round(($record->Y_count / $record->total_count) * 100, 2) . '%';
                        }
                        return 'N/A';
                    }),
            ];
        }
        
        // Fallback to default columns for non-Y types
        return parent::getTableColumns();
    }

    protected function getTableQuery(): Builder
    {
        if ($this->record && $this->record->question_type === 'Y') {
            $field_name = $this->record->field_name;
            $qid = $this->record->question;
            
            return SurveyResponse::getResponsesForSurvey($this->record->surveyId)
                ->withAnswersLabel($qid, $field_name)
                ->selectRaw("
                    submitdate,
                    {$field_name} as value,
                    SUM({$field_name} = 'Y') as Y_count,
                    SUM({$field_name} = 'N') as N_count,
                    COUNT(*) as total_count,
                    (SUM({$field_name} = 'Y') * 100.0 / COUNT(*)) as yes_percentage
                ")
                ->whereNotNull($field_name)
                ->groupBy('submitdate', $field_name)
                ->orderBy('submitdate', 'desc');
        }
        
        // Fallback to default query for non-Y types
        return parent::getTableQuery();
    }
}
```

### Statistical Chart Generation for Y Type Questions
For question type Y, specialized chart generation includes percentage calculations:

```php
class YTypeChartGenerator
{
    public function generateYTypeChart(string $surveyId, string $fieldName): array
    {
        $results = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->get();
        
        $total = $results->sum('count');
        
        $labels = [];
        $values = [];
        $percentages = [];
        
        foreach ($results as $result) {
            $labels[] = $result->answer;
            $values[] = $result->count;
            $percentages[] = $total > 0 ? round(($result->count / $total) * 100, 2) : 0;
        }
        
        // Calculate average for Y type (percentage of 'Y' responses)
        $yesCount = collect($results)->firstWhere('answer', 'Y')?->count ?? 0;
        $averagePercentage = $total > 0 ? round(($yesCount / $total) * 100, 2) : 0;
        
        return [
            'labels' => $labels,
            'values' => $values,
            'percentages' => $percentages,
            'total' => $total,
            'average_percentage' => $averagePercentage,
            'chart_type' => 'pie' // or 'bar' depending on preference
        ];
    }
    
    public function generateYTypeTrendChart(string $surveyId, string $fieldName, string $groupBy = 'date:Y-m'): array
    {
        $sqlGroupBy = $this->getSql($surveyId, $groupBy, 'name');
        
        $results = SurveyResponse::getResponsesForSurvey($surveyId)
            ->selectRaw("
                {$sqlGroupBy} as period,
                COUNT(*) as total,
                SUM(CASE WHEN {$fieldName} = 'Y' THEN 1 ELSE 0 END) as yes_count,
                SUM(CASE WHEN {$fieldName} = 'N' THEN 1 ELSE 0 END) as no_count,
                AVG(CASE WHEN {$fieldName} = 'Y' THEN 1 ELSE 0 END) * 100 as percentage
            ")
            ->whereNotNull($fieldName)
            ->groupBy(DB::raw($sqlGroupBy))
            ->orderBy('period')
            ->get();
        
        return [
            'labels' => $results->pluck('period')->toArray(),
            'values' => $results->pluck('percentage')->toArray(),
            'total_responses' => $results->pluck('total')->toArray(),
            'yes_counts' => $results->pluck('yes_count')->toArray(),
            'no_counts' => $results->pluck('no_count')->toArray(),
            'chart_type' => 'line'
        ];
    }
}
```

### UI Components for Y Type Statistics
Specialized UI components for displaying statistics of Y type questions:

```blade
{{-- Y Type Statistics Component --}}
<div class="y-type-statistics" x-data="yTypeStats({{ $surveyId }}, {{ $questionId }})">
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Responses</h3>
            <p class="stat-value" x-text="stats.total"></p>
        </div>
        
        <div class="stat-card">
            <h3>Yes Responses</h3>
            <p class="stat-value" x-text="stats.yes_count"></p>
            <p class="stat-subtext" x-text="`(${stats.yes_percentage}%)`"></p>
        </div>
        
        <div class="stat-card">
            <h3>No Responses</h3>
            <p class="stat-value" x-text="stats.no_count"></p>
            <p class="stat-subtext" x-text="`(${stats.no_percentage}%)`"></p>
        </div>
        
        <div class="stat-card">
            <h3>Average</h3>
            <p class="stat-value" x-text="`${stats.average_percentage}%`"></p>
            <p class="stat-subtext">Yes responses</p>
        </div>
    </div>
    
    <div class="chart-container">
        <canvas id="y-type-chart" width="400" height="200"></canvas>
    </div>
    
    <script>
        function yTypeStats(surveyId, questionId) {
            return {
                stats: {
                    total: 0,
                    yes_count: 0,
                    no_count: 0,
                    yes_percentage: 0,
                    no_percentage: 0,
                    average_percentage: 0
                },
                
                async init() {
                    const response = await fetch(`/api/stats/y-type/${surveyId}/${questionId}`);
                    const data = await response.json();
                    this.stats = data;
                    this.renderChart();
                },
                
                renderChart() {
                    const ctx = document.getElementById('y-type-chart').getContext('2d');
                    
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Yes', 'No'],
                            datasets: [{
                                data: [this.stats.yes_percentage, this.stats.no_percentage],
                                backgroundColor: [
                                    '#10B981',  // Green for Yes
                                    '#EF4444'   // Red for No
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Yes/No Distribution'
                                }
                            }
                        }
                    });
                }
            };
        }
    </script>
</div>
```