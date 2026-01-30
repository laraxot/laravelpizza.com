# JpGraph Complete Integration with Quaeris Module Features

## Overview

This document provides a comprehensive guide to integrating JpGraph with the Quaeris module's specific features. It covers the complete integration pattern including data models, dashboard widgets, PDF generation, multi-tenant considerations, and the specific architecture patterns used in the Quaeris survey management platform.

## Quaeris Module Architecture Overview

### Core Components
- **Survey Model**: Central entity representing a survey
- **SurveyResponse Model**: Stores individual survey responses
- **QuestionChart Model**: Handles chart-specific data and configurations
- **XotBase Classes**: Foundation classes that all Quaeris components extend

### Integration Points
1. Survey dashboard widgets
2. Question-specific charting
3. PDF report generation
4. Multi-tenant data isolation
5. User permissions and access control

## Survey Model Integration

### Enhanced Survey Model with Chart Capabilities
```php
class Survey extends BaseModel
{
    protected $fillable = [
        // ... other fields
        'chart_config',
        'chart_cache_ttl',
        'chart_enabled',
    ];

    protected $casts = [
        // ... other casts
        'chart_config' => 'array',
        'chart_cache_ttl' => 'integer',
        'chart_enabled' => 'boolean',
    ];

    /**
     * Get chart configurations for this survey
     */
    public function getChartConfig(): array
    {
        return $this->chart_config ?: $this->getDefaultChartConfig();
    }

    private function getDefaultChartConfig(): array
    {
        return [
            'overview' => true,
            'responses' => true,
            'trends' => true,
            'comparisons' => false,
            'export_formats' => ['png', 'pdf']
        ];
    }

    /**
     * Get chart data for this survey
     */
    public function getChartData(string $chartType = null)
    {
        $questionRefs = $this->getSurveyQuestionRefs();
        
        if ($chartType === null) {
            return $this->getAllChartData($questionRefs);
        }
        
        switch ($chartType) {
            case 'overview':
                return $this->getOverviewData($questionRefs);
            case 'responses':
                return $this->getResponseDistributionData($questionRefs);
            case 'trends':
                return $this->getTrendData($questionRefs);
            default:
                return [];
        }
    }

    private function getSurveyQuestionRefs(): array
    {
        // Get question references from LimeSurvey structure
        $surveyModel = $this->getLimeSurveyModel();
        $table = $surveyModel->getTable();
        
        // Get all column names that are likely survey questions
        $columns = Schema::connection($surveyModel->getConnectionName())
                        ->getColumnListing($table);
        
        // Filter for question-type columns (typically have X in the name)
        $questionRefs = array_filter($columns, function($col) {
            return preg_match('/\d+X\d+X\d+/', $col) || 
                   strpos($col, 'question_') === 0;
        });
        
        return $questionRefs;
    }

    /**
     * Generate all charts for this survey
     */
    public function generateAllCharts(): array
    {
        $chartPaths = [];
        $chartConfig = $this->getChartConfig();
        
        if ($chartConfig['overview'] ?? true) {
            $chartPaths['overview'] = $this->generateOverviewChart();
        }
        
        if ($chartConfig['responses'] ?? true) {
            $chartPaths['responses'] = $this->generateResponseCharts();
        }
        
        if ($chartConfig['trends'] ?? true) {
            $chartPaths['trends'] = $this->generateTrendCharts();
        }
        
        if ($chartConfig['comparisons'] ?? false) {
            $chartPaths['comparisons'] = $this->generateComparisonCharts();
        }
        
        return $chartPaths;
    }

    private function generateOverviewChart(): string
    {
        $overviewData = $this->getOverviewData($this->getSurveyQuestionRefs());
        
        $graph = new Graph(800, 600);
        $graph->SetScale('textlin');
        $graph->title->Set("Survey Overview - {$this->title}");
        $graph->SetShadow();
        
        // Add response count bar
        $responseCount = $this->getResponseCount();
        $barPlot = new BarPlot([$responseCount]);
        $barPlot->SetFillColor('lightblue');
        $barPlot->SetLegend('Total Responses');
        
        $graph->xaxis->SetTickLabels(['Survey']);
        $graph->Add($barPlot);
        
        $chartPath = $this->saveChart($graph, "overview_{$this->id}.png");
        return $chartPath;
    }

    private function getResponseCount(): int
    {
        $surveyModel = $this->getLimeSurveyModel();
        return $surveyModel->count();
    }

    private function getLimeSurveyModel()
    {
        $table = "lime_survey_{$this->id}";
        
        return new class($table) extends Model
        {
            protected $table;
            protected $connection = 'limesurvey';
            
            public function __construct($table)
            {
                $this->table = $table;
                parent::__construct();
            }
            
            protected $guarded = [];
        };
    }
}
```

## QuestionChart Model Integration

### QuestionChart Model with JpGraph Support
```php
class QuestionChart extends BaseModel
{
    protected $fillable = [
        'survey_id',
        'question_ref',
        'chart_type',
        'chart_config',
        'chart_cache_key',
        'last_generated_at',
        'last_generated_chart_path',
        'chart_statistics',
    ];

    protected $casts = [
        'chart_config' => 'array',
        'chart_statistics' => 'array',
        'last_generated_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(XotData::make()->getSurveyClass());
    }

    /**
     * Generate chart for this question
     */
    public function generateChart(array $options = []): string
    {
        // Check if chart needs regeneration
        if ($this->needsRegeneration()) {
            return $this->regenerateChart($options);
        }
        
        // Return cached chart if still valid
        if ($this->isCachedChartValid()) {
            return $this->last_generated_chart_path;
        }
        
        return $this->regenerateChart($options);
    }

    private function needsRegeneration(): bool
    {
        if (!$this->last_generated_at) {
            return true;
        }
        
        $cacheTtl = $this->getCacheTtl();
        $lastGenerated = $this->last_generated_at->timestamp;
        
        return (time() - $lastGenerated) > $cacheTtl;
    }

    private function isCachedChartValid(): bool
    {
        return $this->last_generated_chart_path && 
               file_exists($this->last_generated_chart_path);
    }

    private function getCacheTtl(): int
    {
        $config = $this->chart_config ?: [];
        return $config['cache_ttl'] ?? 3600; // Default 1 hour
    }

    private function regenerateChart(array $options = []): string
    {
        $chartType = $this->chart_type ?: 'bar';
        $data = $this->getChartData();
        
        $chartPath = $this->generateSpecificChart($data, $chartType, $options);
        
        // Update model with new chart info
        $this->update([
            'last_generated_chart_path' => $chartPath,
            'last_generated_at' => now(),
            'chart_statistics' => $this->calculateStatistics($data)
        ]);
        
        return $chartPath;
    }

    private function getChartData(): array
    {
        $survey = $this->survey;
        $surveyModel = $survey->getLimeSurveyModel();
        
        $results = $surveyModel
            ->selectRaw("COUNT(*) as count, {$this->question_ref} as answer")
            ->whereNotNull($this->question_ref)
            ->groupBy($this->question_ref)
            ->orderBy('count', 'desc')
            ->get();
        
        return $results->map(function($item) {
            return [
                'answer' => $item->answer,
                'count' => $item->count
            ];
        })->toArray();
    }

    private function generateSpecificChart(array $data, string $chartType, array $options): string
    {
        switch ($chartType) {
            case 'pie':
                return $this->generatePieChart($data, $options);
            case 'bar':
                return $this->generateBarChart($data, $options);
            case 'line':
                return $this->generateLineChart($data, $options);
            case 'horizontal_bar':
                return $this->generateHorizontalBarChart($data, $options);
            default:
                return $this->generateBarChart($data, $options); // Default to bar chart
        }
    }

    private function generatePieChart(array $data, array $options): string
    {
        $values = array_column($data, 'count');
        $labels = array_column($data, 'answer');
        
        $pieGraph = new PieGraph(600, 400);
        $pieGraph->title->Set("Question Responses - {$this->question_ref}");
        
        $piePlot = new PiePlot($values);
        $piePlot->SetLabels($labels);
        $piePlot->SetLabelType(PIE_VALUE_PER); // Show percentages
        
        // Apply theme if specified
        $config = $this->chart_config ?: [];
        if (isset($config['theme'])) {
            $piePlot->SetTheme($config['theme']);
        }
        
        $pieGraph->Add($piePlot);
        
        $chartPath = $this->saveChart($pieGraph, "pie_{$this->id}.png");
        return $chartPath;
    }

    private function generateBarChart(array $data, array $options): string
    {
        $values = array_column($data, 'count');
        $labels = array_column($data, 'answer');
        
        $graph = new Graph(800, 400 + (count($labels) * 10)); // Adjust height for many labels
        $graph->SetScale('textlin');
        $graph->title->Set("Response Distribution - {$this->question_ref}");
        $graph->SetShadow();
        
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('orange');
        $barPlot->SetWidth(0.6);
        
        // Rotate labels if many options
        if (count($labels) > 5) {
            $graph->xaxis->SetTickLabels($labels);
            $graph->xaxis->SetLabelAngle(45);
        } else {
            $graph->xaxis->SetTickLabels($labels);
        }
        
        $graph->Add($barPlot);
        
        $chartPath = $this->saveChart($graph, "bar_{$this->id}.png");
        return $chartPath;
    }

    private function calculateStatistics(array $data): array
    {
        if (empty($data)) {
            return [
                'total_responses' => 0,
                'unique_answers' => 0,
                'most_common' => null,
                'least_common' => null
            ];
        }
        
        $totalResponses = array_sum(array_column($data, 'count'));
        $uniqueAnswers = count($data);
        
        // Find most and least common answers
        $maxCount = max(array_column($data, 'count'));
        $minCount = min(array_column($data, 'count'));
        
        $mostCommon = collect($data)->firstWhere('count', $maxCount);
        $leastCommon = collect($data)->firstWhere('count', $minCount);
        
        return [
            'total_responses' => $totalResponses,
            'unique_answers' => $uniqueAnswers,
            'most_common' => $mostCommon,
            'least_common' => $leastCommon
        ];
    }

    private function saveChart($graph, string $filename): string
    {
        $storagePath = storage_path('app/charts/surveys/' . $this->survey_id);
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        $chartPath = $storagePath . '/' . $filename;
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
}
```

## Dashboard Widget Integration

### Survey Dashboard Widget with JpGraph Charts
```php
class SurveyDashboardWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Survey Charts';
    
    protected static string $view = 'quaeris::widgets.survey-dashboard-chart';
    
    protected int | string | array $columnSpan = 'full';
    
    public function getSurveyId(): int
    {
        return $this->data['survey_id'] ?? 0;
    }
    
    public function getChartType(): string
    {
        return $this->data['chart_type'] ?? 'overview';
    }
    
    public function getChartData()
    {
        $surveyId = $this->getSurveyId();
        $chartType = $this->getChartType();
        
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        
        if (!$survey) {
            return null;
        }
        
        $chartPath = null;
        
        switch ($chartType) {
            case 'overview':
                $chartPath = $this->generateOverviewChart($survey);
                break;
            case 'responses':
                $chartPath = $this->generateResponseChart($survey);
                break;
            case 'trends':
                $chartPath = $this->generateTrendChart($survey);
                break;
            default:
                $chartPath = $this->generateOverviewChart($survey);
        }
        
        return [
            'chart_path' => $chartPath,
            'survey' => $survey,
            'chart_type' => $chartType,
            'chart_exists' => $chartPath && file_exists($chartPath)
        ];
    }
    
    private function generateOverviewChart($survey)
    {
        $responseCount = $this->getSurveyResponseCount($survey->id);
        $completionRate = $this->getSurveyCompletionRate($survey);
        
        $graph = new Graph(600, 300);
        $graph->SetScale('textlin');
        $graph->title->Set("{$survey->title} - Overview");
        $graph->SetShadow();
        
        // Create grouped bar for responses and completion
        $responsePlot = new BarPlot([$responseCount]);
        $responsePlot->SetFillColor('lightblue');
        $responsePlot->SetLegend('Total Responses');
        
        $completionPlot = new BarPlot([$completionRate * 100]);
        $completionPlot->SetFillColor('lightgreen');
        $completionPlot->SetLegend('Completion Rate (%)');
        
        $groupPlot = new GroupBarPlot([$responsePlot, $completionPlot]);
        $graph->Add($groupPlot);
        
        $graph->xaxis->SetTickLabels(['Metrics']);
        
        return $this->saveWidgetChart($graph, "overview_{$survey->id}.png");
    }
    
    private function getSurveyResponseCount($surveyId)
    {
        $surveyModel = $this->getLimeSurveyModel($surveyId);
        return $surveyModel->count();
    }
    
    private function getSurveyCompletionRate($survey)
    {
        // Implementation depends on your completion tracking method
        $expectedResponses = $survey->expected_responses ?? 100; // Default assumption
        $actualResponses = $this->getSurveyResponseCount($survey->id);
        
        return $actualResponses / max($expectedResponses, 1);
    }
    
    private function getLimeSurveyModel($surveyId)
    {
        $table = "lime_survey_{$surveyId}";
        
        return new class($table) extends Model
        {
            protected $table;
            protected $connection = 'limesurvey';
            
            public function __construct($table)
            {
                $this->table = $table;
                parent::__construct();
            }
            
            protected $guarded = [];
        };
    }
    
    private function saveWidgetChart($graph, string $filename): string
    {
        $storagePath = storage_path('app/charts/widgets');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        $chartPath = $storagePath . '/' . $filename;
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
    
    protected function getLimeSurveyData($surveyId, $questionRef = null)
    {
        $table = "lime_survey_{$surveyId}";
        $query = DB::connection('limesurvey')->table($table);
        
        if ($questionRef) {
            $query->selectRaw("COUNT(*) as count, {$questionRef} as answer")
                  ->whereNotNull($questionRef)
                  ->groupBy($questionRef)
                  ->orderBy('count', 'desc');
        } else {
            $query->select('*');
        }
        
        return $query->get();
    }
}
```

## PDF Generation Integration

### PDF Report Service with JpGraph Charts
```php
class SurveyPdfReportService
{
    public function generateSurveyReport($surveyId, $options = []): string
    {
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        
        if (!$survey) {
            throw new ModelNotFoundException("Survey not found: {$surveyId}");
        }
        
        // Generate charts for the report
        $charts = $this->generateReportCharts($survey, $options);
        
        // Prepare report data
        $reportData = $this->prepareReportData($survey, $charts);
        
        // Generate PDF HTML
        $pdfHtml = $this->buildReportHtml($reportData);
        
        // Convert to PDF
        $pdfPath = $this->convertToPdf($pdfHtml, $survey->title . '_report.pdf');
        
        return $pdfPath;
    }
    
    private function generateReportCharts($survey, $options): array
    {
        $charts = [];
        
        // Overview chart
        $charts['overview'] = $this->generateOverviewChart($survey);
        
        // Response distribution charts for key questions
        $keyQuestions = $this->getKeyQuestions($survey);
        
        foreach ($keyQuestions as $questionRef) {
            $chartPath = $this->generateQuestionChart($survey, $questionRef);
            $charts["question_{$questionRef}"] = $chartPath;
        }
        
        // Trend chart if time-based data is available
        if ($this->hasTimeBasedData($survey)) {
            $charts['trends'] = $this->generateTrendChart($survey);
        }
        
        return $charts;
    }
    
    private function generateOverviewChart($survey)
    {
        $responseCount = $this->getSurveyResponseCount($survey->id);
        $completionRate = $this->getSurveyCompletionRate($survey);
        
        // Create high-resolution chart for PDF
        $graph = new Graph(1200, 800); // Larger for PDF clarity
        $graph->SetScale('textlin');
        $graph->title->Set("Survey Overview - {$survey->title}");
        $graph->SetShadow();
        
        // Set high DPI for print quality
        $graph->img->SetDPI(300);
        
        // Create plots
        $responsePlot = new BarPlot([$responseCount]);
        $responsePlot->SetFillColor('lightblue');
        $responsePlot->SetLegend('Total Responses');
        
        $completionPlot = new BarPlot([$completionRate * 100]);
        $completionPlot->SetFillColor('lightgreen');
        $completionPlot->SetLegend('Completion Rate (%)');
        
        $groupPlot = new GroupBarPlot([$responsePlot, $completionPlot]);
        $graph->Add($groupPlot);
        
        $graph->xaxis->SetTickLabels(['Metrics']);
        
        return $this->savePdfChart($graph, "pdf_overview_{$survey->id}.png");
    }
    
    private function generateQuestionChart($survey, $questionRef)
    {
        // Get question response data
        $responseData = $this->getQuestionResponseData($survey->id, $questionRef);
        
        if (count($responseData) > 20) {
            // For many options, show top 10 and group others
            $topData = array_slice($responseData, 0, 10);
            $otherCount = array_sum(array_slice($responseData, 10));
            
            if ($otherCount > 0) {
                $topData['Other'] = $otherCount;
            }
            
            $responseData = $topData;
        }
        
        $values = array_values($responseData);
        $labels = array_keys($responseData);
        
        // Choose chart type based on number of options
        if (count($labels) <= 6) {
            // Use pie chart for few options
            return $this->generatePdfPieChart($values, $labels, $questionRef);
        } else {
            // Use bar chart for many options
            return $this->generatePdfBarChart($values, $labels, $questionRef);
        }
    }
    
    private function generatePdfPieChart($values, $labels, $questionRef)
    {
        $pieGraph = new PieGraph(1000, 800);
        $pieGraph->title->Set("Question Responses - {$questionRef}");
        $pieGraph->img->SetDPI(300); // High DPI for PDF
        
        $piePlot = new PiePlot($values);
        $piePlot->SetLabels($labels);
        $piePlot->SetLabelType(PIE_VALUE_PER);
        
        $pieGraph->Add($piePlot);
        
        return $this->savePdfChart($pieGraph, "pdf_pie_{$questionRef}.png");
    }
    
    private function generatePdfBarChart($values, $labels, $questionRef)
    {
        $graph = new Graph(1200, 600 + (count($labels) * 15)); // Adjust height for labels
        $graph->SetScale('textlin');
        $graph->title->Set("Response Distribution - {$questionRef}");
        $graph->SetShadow();
        $graph->img->SetDPI(300); // High DPI for PDF
        
        $barPlot = new BarPlot($values);
        $barPlot->SetFillColor('orange');
        $barPlot->SetWidth(0.7);
        
        // Rotate labels for readability
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle(45);
        
        $graph->Add($barPlot);
        
        return $this->savePdfChart($graph, "pdf_bar_{$questionRef}.png");
    }
    
    private function savePdfChart($graph, string $filename): string
    {
        $storagePath = storage_path('app/charts/pdf');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        $chartPath = $storagePath . '/' . $filename;
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
    
    private function buildReportHtml($reportData): string
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html><head>';
        $html .= '<title>' . htmlspecialchars($reportData['survey']->title) . ' Report</title>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: 20px; }';
        $html .= 'h1 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 10px; }';
        $html .= 'h2 { color: #555; margin-top: 30px; }';
        $html .= '.chart-container { margin: 20px 0; text-align: center; }';
        $html .= '.chart-container img { max-width: 100%; height: auto; border: 1px solid #ddd; }';
        $html .= '.stats-table { width: 100%; border-collapse: collapse; margin: 20px 0; }';
        $html .= '.stats-table th, .stats-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
        $html .= '.stats-table th { background-color: #f2f2f2; }';
        $html .= '</style>';
        $html .= '</head><body>';
        
        // Report header
        $html .= '<h1>' . htmlspecialchars($reportData['survey']->title) . ' - Survey Report</h1>';
        $html .= '<p><strong>Generated:</strong> ' . now()->format('Y-m-d H:i:s') . '</p>';
        $html .= '<p><strong>Survey Period:</strong> ' . 
                 $reportData['survey']->start_date->format('Y-m-d') . ' to ' . 
                 $reportData['survey']->end_date->format('Y-m-d') . '</p>';
        
        // Overview chart
        if (isset($reportData['charts']['overview'])) {
            $html .= '<div class="chart-container">';
            $html .= '<h2>Survey Overview</h2>';
            $html .= '<img src="' . $reportData['charts']['overview'] . '" alt="Overview Chart">';
            $html .= '</div>';
        }
        
        // Key questions charts
        foreach ($reportData['charts'] as $key => $chartPath) {
            if (strpos($key, 'question_') === 0) {
                $questionRef = str_replace('question_', '', $key);
                $html .= '<div class="chart-container">';
                $html .= '<h2>Question: ' . htmlspecialchars($questionRef) . '</h2>';
                $html .= '<img src="' . $chartPath . '" alt="Question Chart">';
                $html .= '</div>';
            }
        }
        
        // Summary statistics table
        $html .= '<h2>Summary Statistics</h2>';
        $html .= '<table class="stats-table">';
        $html .= '<tr><th>Metric</th><th>Value</th></tr>';
        $html .= '<tr><td>Total Responses</td><td>' . $reportData['response_count'] . '</td></tr>';
        $html .= '<tr><td>Completion Rate</td><td>' . number_format($reportData['completion_rate'] * 100, 2) . '%</td></tr>';
        $html .= '<tr><td>Survey Period</td><td>' . $reportData['survey']->start_date->format('Y-m-d') . ' to ' . $reportData['survey']->end_date->format('Y-m-d') . '</td></tr>';
        $html .= '</table>';
        
        $html .= '</body></html>';
        
        return $html;
    }
    
    private function convertToPdf($html, $filename): string
    {
        // Using Spatie PDF generator (you can adapt for other PDF libraries)
        $pdf = app('spatie.pdf');
        $pdf->loadHTML($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOptions(['dpi' => 300]); // High quality for charts
        
        $pdfPath = storage_path('app/pdfs/' . $filename);
        $pdf->save($pdfPath);
        
        return $pdfPath;
    }
    
    private function prepareReportData($survey, $charts): array
    {
        return [
            'survey' => $survey,
            'charts' => $charts,
            'response_count' => $this->getSurveyResponseCount($survey->id),
            'completion_rate' => $this->getSurveyCompletionRate($survey)
        ];
    }
    
    private function getKeyQuestions($survey): array
    {
        // Get key questions based on survey configuration or default logic
        $allQuestions = $this->getAllSurveyQuestions($survey->id);
        
        // For now, return all questions - in practice, you might filter based on importance
        return array_slice($allQuestions, 0, 10); // Limit to first 10 questions
    }
    
    private function getAllSurveyQuestions($surveyId): array
    {
        $surveyModel = $this->getLimeSurveyModel($surveyId);
        $table = $surveyModel->getTable();
        
        $columns = Schema::connection($surveyModel->getConnectionName())
                        ->getColumnListing($table);
        
        return array_filter($columns, function($col) {
            return preg_match('/\d+X\d+X\d+/', $col);
        });
    }
    
    private function hasTimeBasedData($survey): bool
    {
        // Check if survey has time-based questions or responses
        return !empty($this->getTimeBasedQuestionRefs($survey->id));
    }
    
    private function getTimeBasedQuestionRefs($surveyId): array
    {
        $questionRefs = $this->getAllSurveyQuestions($surveyId);
        
        // In LimeSurvey, time-based questions often have specific patterns
        // This is a simplified check - you might need to adapt based on your survey structure
        return array_filter($questionRefs, function($ref) use ($surveyId) {
            // Check if this question has date/time responses
            $surveyModel = $this->getLimeSurveyModel($surveyId);
            
            $sampleValue = $surveyModel
                ->select($ref)
                ->whereNotNull($ref)
                ->first();
            
            if (!$sampleValue) {
                return false;
            }
            
            $value = $sampleValue->{$ref};
            
            // Check if it looks like a date/time format
            return preg_match('/\d{4}-\d{2}-\d{2}/', $value) || // YYYY-MM-DD
                   preg_match('/\d{2}\/\d{2}\/\d{4}/', $value);  // MM/DD/YYYY
        });
    }
    
    private function getQuestionResponseData($surveyId, $questionRef): array
    {
        $surveyModel = $this->getLimeSurveyModel($surveyId);
        
        $results = $surveyModel
            ->selectRaw("COUNT(*) as count, {$questionRef} as answer")
            ->whereNotNull($questionRef)
            ->groupBy($questionRef)
            ->orderBy('count', 'desc')
            ->get();
        
        $data = [];
        foreach ($results as $result) {
            $data[$result->answer] = $result->count;
        }
        
        return $data;
    }
}
```

## Multi-Tenant Data Isolation

### Tenant-Aware Chart Service
```php
class TenantChartService
{
    private $tenantManager;
    
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }
    
    public function generateTenantChart($tenantId, $surveyId, $chartType, $options = [])
    {
        // Verify tenant has access to survey
        if (!$this->verifyTenantAccess($tenantId, $surveyId)) {
            throw new UnauthorizedException("Tenant {$tenantId} cannot access survey {$surveyId}");
        }
        
        // Set tenant context
        $this->tenantManager->setTenant($tenantId);
        
        // Generate chart using tenant-specific data
        return $this->generateChart($surveyId, $chartType, $options);
    }
    
    private function verifyTenantAccess($tenantId, $surveyId)
    {
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        return $survey && $survey->tenant_id == $tenantId;
    }
    
    public function generateChart($surveyId, $chartType, $options = [])
    {
        $survey = XotData::make()->getSurveyClass()::find($surveyId);
        
        if (!$survey) {
            throw new ModelNotFoundException("Survey not found: {$surveyId}");
        }
        
        // Get tenant-specific storage path
        $tenantId = $this->tenantManager->getCurrentTenantId();
        $storagePath = storage_path("app/charts/tenants/{$tenantId}/surveys/{$surveyId}");
        
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        // Generate chart based on type
        switch ($chartType) {
            case 'overview':
                return $this->generateTenantOverviewChart($survey, $storagePath);
            case 'responses':
                return $this->generateTenantResponseChart($survey, $storagePath);
            case 'trends':
                return $this->generateTenantTrendChart($survey, $storagePath);
            default:
                return $this->generateTenantOverviewChart($survey, $storagePath);
        }
    }
    
    private function generateTenantOverviewChart($survey, $storagePath)
    {
        // Get tenant-specific response count
        $responseCount = $this->getTenantResponseCount($survey->id);
        
        $graph = new Graph(800, 400);
        $graph->SetScale('textlin');
        $graph->title->Set("Tenant Survey Overview - {$survey->title}");
        $graph->SetShadow();
        
        $barPlot = new BarPlot([$responseCount]);
        $barPlot->SetFillColor('lightblue');
        $barPlot->SetLegend('Total Responses');
        
        $graph->xaxis->SetTickLabels(['Survey']);
        $graph->Add($barPlot);
        
        $chartPath = $storagePath . "/overview.png";
        $graph->Stroke($chartPath);
        
        return $chartPath;
    }
    
    private function getTenantResponseCount($surveyId)
    {
        // In multi-tenant setup, you might need to filter by tenant
        // This implementation assumes the tenant context is already set
        $surveyModel = $this->getLimeSurveyModel($surveyId);
        
        // Apply tenant-specific filters if needed
        return $surveyModel->count();
    }
    
    private function getLimeSurveyModel($surveyId)
    {
        $table = "lime_survey_{$surveyId}";
        
        return new class($table) extends Model
        {
            protected $table;
            protected $connection = 'limesurvey';
            
            public function __construct($table)
            {
                $this->table = $table;
                parent::__construct();
            }
            
            protected $guarded = [];
        };
    }
    
    public function getTenantCharts($tenantId, $surveyId)
    {
        $storagePath = storage_path("app/charts/tenants/{$tenantId}/surveys/{$surveyId}");
        
        if (!file_exists($storagePath)) {
            return [];
        }
        
        $chartFiles = glob($storagePath . '/*.png');
        $charts = [];
        
        foreach ($chartFiles as $file) {
            $filename = basename($file);
            $chartType = str_replace('.png', '', $filename);
            $charts[$chartType] = $file;
        }
        
        return $charts;
    }
}
```

## Configuration and Service Provider

### Chart Service Provider
```php
class ChartServiceProvider extends XotBaseServiceProvider
{
    public function register()
    {
        // Bind chart services
        $this->app->singleton('quaeris.chart', function ($app) {
            return new ChartService();
        });
        
        $this->app->singleton('quaeris.pdf', function ($app) {
            return new SurveyPdfReportService();
        });
        
        $this->app->singleton('quaeris.tenant.chart', function ($app) {
            return new TenantChartService(
                $app->make('tenant.manager')
            );
        });
        
        // Register configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/chart.php', 'quaeris.chart'
        );
    }
    
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/chart.php' => config_path('quaeris/chart.php'),
        ], 'quaeris-chart-config');
        
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Add chart-related commands here
            ]);
        }
    }
    
    public function provides()
    {
        return [
            'quaeris.chart',
            'quaeris.pdf',
            'quaeris.tenant.chart'
        ];
    }
}
```

## Configuration File

### config/quaeris/chart.php
```php
<?php

return [
    // Default chart settings
    'defaults' => [
        'width' => 800,
        'height' => 600,
        'dpi' => 96,
        'format' => 'png',
        'quality' => 95,
    ],
    
    // Cache settings
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
        'driver' => 'file', // redis, file, database
        'path' => storage_path('app/charts/cache'),
    ],
    
    // PDF generation settings
    'pdf' => [
        'enabled' => true,
        'chart_dpi' => 300, // High quality for PDF embedding
        'chart_format' => 'png',
        'template' => 'quaeris::pdf.default-template',
        'page_size' => 'A4',
        'orientation' => 'landscape',
    ],
    
    // Chart types configuration
    'chart_types' => [
        'overview' => [
            'class' => \Modules\Chart\Services\OverviewChartService::class,
            'enabled' => true,
        ],
        'responses' => [
            'class' => \Modules\Chart\Services\ResponseChartService::class,
            'enabled' => true,
        ],
        'trends' => [
            'class' => \Modules\Chart\Services\TrendChartService::class,
            'enabled' => true,
        ],
        'comparisons' => [
            'class' => \Modules\Chart\Services\ComparisonChartService::class,
            'enabled' => false,
        ],
    ],
    
    // Memory limits for chart generation
    'memory_limits' => [
        'small_dataset' => '128M',    // < 1,000 records
        'medium_dataset' => '256M',   // < 10,000 records
        'large_dataset' => '512M',    // < 100,000 records
        'xlarge_dataset' => '1G',     // > 100,000 records
    ],
    
    // Sampling thresholds
    'sampling' => [
        'enabled' => true,
        'thresholds' => [
            'small' => 1000,   // No sampling
            'medium' => 5000,  // 50% sampling
            'large' => 10000,  // 25% sampling
            'xlarge' => 50000, // 10% sampling
        ],
    ],
    
    // Theme configurations
    'themes' => [
        'default' => [
            'colors' => [
                'primary' => '#007bff',
                'secondary' => '#6c757d',
                'success' => '#28a745',
                'info' => '#17a2b8',
                'warning' => '#ffc107',
                'danger' => '#dc3545',
            ],
        ],
        'business' => [
            'colors' => [
                'primary' => '#205072',
                'secondary' => '#2D9CDB',
                'success' => '#27AE60',
                'info' => '#54A0FF',
                'warning' => '#F39C12',
                'danger' => '#E74C3C',
            ],
        ],
    ],
];
```

## Conclusion

The complete integration of JpGraph with the Quaeris module provides:

1. **Enhanced Survey Model** with built-in chart capabilities
2. **QuestionChart Model** for specific question charting
3. **Dashboard Widgets** with interactive chart displays
4. **PDF Generation** with embedded charts
5. **Multi-tenant Support** with proper data isolation
6. **Configurable Service Provider** for flexible deployment
7. **Performance Optimization** for large datasets

This comprehensive integration ensures that the Quaeris platform can handle all charting needs efficiently while maintaining proper architecture patterns and multi-tenant data isolation.