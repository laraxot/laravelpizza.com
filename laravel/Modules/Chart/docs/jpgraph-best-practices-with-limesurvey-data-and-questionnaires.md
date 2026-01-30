# JpGraph Best Practices with LimeSurvey Data and Questionnaires

## Overview

This document outlines best practices for using JpGraph with LimeSurvey survey data and questionnaires. It covers data processing techniques, chart type selection for different question types, performance optimization, and integration patterns specific to survey analysis.

## Understanding LimeSurvey Data Structure

### Question Types and Data Patterns

LimeSurvey has various question types that require different charting approaches:

#### Standard Question Types
- **Y (Yes/No)**: Binary responses requiring pie charts or simple bar charts
- **N (Numbers)**: Numeric responses ideal for line charts, histograms
- **G (Gender)**: Categorical with predefined options (Male/Female/Other)
- **L (List)**: Dropdown with predefined options
- **1 (Array)**: Multiple sub-questions in a table format
- **! (List with Comment)**: List with additional text input

#### Field Name Patterns
LimeSurvey uses specific field naming conventions:
- `123456X12X88` - Standard question reference
- `123456X12X88SQ001` - Sub-question reference
- `123456X12X88SQ001A` - Specific answer reference

### Data Access Patterns

#### Survey Response Model
```php
class SurveyResponse extends BaseModel
{
    // Access data for specific survey
    public static function getResponsesForSurvey($surveyId)
    {
        $table = "lime_survey_{$surveyId}";
        return DB::table($table)->get();
    }
    
    // Process data for specific question
    public function getAnswersByQuestion($questionRef)
    {
        return $this->selectRaw("COUNT(*) as count, {$questionRef} as answer")
                    ->groupBy($questionRef)
                    ->whereNotNull($questionRef)
                    ->get();
    }
}
```

#### Dynamic Model Creation for Survey Tables
```php
class SurveyModelFactory
{
    public function createForSurvey($surveyId)
    {
        $tableName = "lime_survey_{$surveyId}";
        
        return new class($tableName) extends Model
        {
            protected $table;
            
            public function __construct($tableName)
            {
                $this->table = $tableName;
                parent::__construct();
            }
            
            protected $guarded = [];
        };
    }
}
```

## Chart Type Selection by Question Type

### Yes/No Questions (Y Type)
```php
class YesNoChartService extends BaseSurveyChartService
{
    public function generateChart($surveyId, $questionRef)
    {
        // Get response data for Yes/No question
        $responses = $this->getYesNoResponses($surveyId, $questionRef);
        
        // Prepare data for pie chart
        $counts = [
            'Yes' => $responses->where('answer', 'Y')->sum('count'),
            'No' => $responses->where('answer', 'N')->sum('count'),
        ];
        
        // Create pie chart
        $pieGraph = new PieGraph(500, 300);
        $pieGraph->title->Set("Yes/No Response - {$questionRef}");
        
        $piePlot = new PiePlot(array_values($counts));
        $piePlot->SetLabels(array_keys($counts));
        
        // Set colors for better visibility
        $piePlot->SetSliceColors(['#4CAF50', '#F44336']);
        
        $pieGraph->Add($piePlot);
        
        return $this->saveChart($pieGraph, "yesno_{$questionRef}.png");
    }
    
    private function getYesNoResponses($surveyId, $questionRef)
    {
        $table = "lime_survey_{$surveyId}";
        return DB::table($table)
                 ->selectRaw("COUNT(*) as count, {$questionRef} as answer")
                 ->whereNotNull($questionRef)
                 ->groupBy($questionRef)
                 ->get();
    }
}
```

### Numeric Questions (N Type)
```php
class NumericChartService extends BaseSurveyChartService
{
    public function generateChart($surveyId, $questionRef)
    {
        // Get numeric responses
        $responses = $this->getNumericResponses($surveyId, $questionRef);
        $values = $responses->pluck('answer')->map('intval')->toArray();
        
        // Create histogram if there are multiple distinct values
        if (count(array_unique($values)) > 10) {
            return $this->generateHistogram($values, $questionRef);
        } else {
            return $this->generateBarChart($values, $questionRef);
        }
    }
    
    private function generateHistogram($values, $questionRef)
    {
        // Create histogram for continuous numeric data
        $graph = $this->createGraph(600, 400);
        $graph->title->Set("Distribution - {$questionRef}");
        
        // Group values into ranges
        $ranges = $this->createValueRanges($values);
        $rangeCounts = $this->countValuesInRanges($values, $ranges);
        
        $barPlot = new BarPlot($rangeCounts);
        $barPlot->SetFillColor('lightblue');
        $barPlot->SetWidth(0.8);
        
        $graph->xaxis->SetTickLabels(array_keys($ranges));
        $graph->Add($barPlot);
        
        return $this->saveChart($graph, "numeric_hist_{$questionRef}.png");
    }
    
    private function createValueRanges($values)
    {
        $min = min($values);
        $max = max($values);
        $rangeSize = ceil(($max - $min) / 10); // 10 bars
        
        $ranges = [];
        for ($i = $min; $i <= $max; $i += $rangeSize) {
            $end = min($i + $rangeSize - 1, $max);
            $ranges["{$i}-{$end}"] = [$i, $end];
        }
        
        return $ranges;
    }
    
    private function countValuesInRanges($values, $ranges)
    {
        $counts = [];
        foreach ($ranges as $label => $range) {
            $count = 0;
            foreach ($values as $value) {
                if ($value >= $range[0] && $value <= $range[1]) {
                    $count++;
                }
            }
            $counts[] = $count;
        }
        
        return $counts;
    }
}
```

### List Questions (L Type)
```php
class ListChartService extends BaseSurveyChartService
{
    public function generateChart($surveyId, $questionRef)
    {
        // Get list responses
        $responses = $this->getListResponses($surveyId, $questionRef);
        
        // Get answer labels from LimeSurvey
        $answerLabels = $this->getAnswerLabels($questionRef);
        
        // Prepare data
        $labels = [];
        $counts = [];
        
        foreach ($responses as $response) {
            $value = $response->answer;
            $label = $answerLabels[$value] ?? $value;
            
            $labels[] = $label;
            $counts[] = $response->count;
        }
        
        // Create bar chart
        $graph = $this->createGraph(600, 400 + (count($labels) * 10)); // Adjust height for many labels
        $graph->title->Set("List Response - {$questionRef}");
        
        $barPlot = new BarPlot($counts);
        $barPlot->SetFillColor('orange');
        $barPlot->SetWidth(0.7);
        
        // Rotate labels if there are many options
        if (count($labels) > 5) {
            $graph->xaxis->SetTickLabels($labels);
            $graph->xaxis->SetLabelAngle(45);
        } else {
            $graph->xaxis->SetTickLabels($labels);
        }
        
        $graph->Add($barPlot);
        
        return $this->saveChart($graph, "list_{$questionRef}.png");
    }
    
    private function getAnswerLabels($questionRef)
    {
        // Get answer labels from LimeSurvey answers table
        $questionId = $this->extractQuestionId($questionRef);
        
        return DB::table('lime_answers')
                 ->where('qid', $questionId)
                 ->pluck('answer', 'code')
                 ->toArray();
    }
    
    private function extractQuestionId($questionRef)
    {
        // Extract question ID from format like 123456X12X88
        $parts = explode('X', $questionRef);
        return end($parts);
    }
}
```

## Advanced Charting Techniques

### Multi-Question Analysis
```php
class MultiQuestionChartService extends BaseSurveyChartService
{
    public function generateCorrelationChart($surveyId, $questionRefs)
    {
        // Get data for multiple questions
        $datasets = [];
        foreach ($questionRefs as $ref) {
            $responses = $this->getQuestionResponses($surveyId, $ref);
            $datasets[$ref] = $responses;
        }
        
        // Create grouped bar chart
        $graph = $this->createGraph(800, 500);
        $graph->title->Set("Multi-Question Comparison");
        
        $plots = [];
        $colors = ['red', 'blue', 'green', 'orange', 'purple'];
        
        foreach ($questionRefs as $index => $ref) {
            $data = $this->prepareChartData($datasets[$ref]);
            $plot = new BarPlot($data['values']);
            $plot->SetFillColor($colors[$index % count($colors)]);
            $plot->SetLegend($ref);
            
            $plots[] = $plot;
        }
        
        // Create grouped bar plot
        $groupPlot = new GroupBarPlot($plots);
        $graph->Add($groupPlot);
        
        $graph->xaxis->SetTickLabels($data['labels']);
        
        return $this->saveChart($graph, "multi_question_comparison.png");
    }
    
    private function prepareChartData($responses)
    {
        $labels = [];
        $values = [];
        
        foreach ($responses as $response) {
            $labels[] = $response->answer;
            $values[] = $response->count;
        }
        
        return ['labels' => $labels, 'values' => $values];
    }
}
```

### Time-Based Analysis
```php
class TimeBasedChartService extends BaseSurveyChartService
{
    public function generateTimeTrendChart($surveyId, $questionRef, $dateRange = [])
    {
        // Get responses over time
        $responses = $this->getResponsesOverTime($surveyId, $questionRef, $dateRange);
        
        // Group by time periods
        $groupedData = $this->groupResponsesByTime($responses, 'month');
        
        // Create line chart
        $graph = $this->createGraph(800, 400);
        $graph->title->Set("Response Trend - {$questionRef}");
        $graph->SetScale('textlin');
        
        $xLabels = array_keys($groupedData);
        $yValues = array_values($groupedData);
        
        $linePlot = new LinePlot($yValues);
        $linePlot->SetColor('blue');
        $linePlot->SetWeight(2);
        
        $graph->xaxis->SetTickLabels($xLabels);
        $graph->Add($linePlot);
        
        return $this->saveChart($graph, "trend_{$questionRef}.png");
    }
    
    private function groupResponsesByTime($responses, $period = 'month')
    {
        $grouped = [];
        
        foreach ($responses as $response) {
            $date = new DateTime($response->submitdate);
            
            switch ($period) {
                case 'day':
                    $key = $date->format('Y-m-d');
                    break;
                case 'week':
                    $key = $date->format('Y-W');
                    break;
                case 'month':
                    $key = $date->format('Y-m');
                    break;
                case 'year':
                    $key = $date->format('Y');
                    break;
                default:
                    $key = $date->format('Y-m');
            }
            
            if (!isset($grouped[$key])) {
                $grouped[$key] = 0;
            }
            
            $grouped[$key] += $response->count;
        }
        
        return $grouped;
    }
}
```

## Performance Optimization

### Data Preprocessing
```php
class SurveyDataPreprocessor
{
    public function preprocessForCharting($rawData, $chartType)
    {
        switch ($chartType) {
            case 'pie':
                return $this->preprocessForPieChart($rawData);
            case 'bar':
                return $this->preprocessForBarChart($rawData);
            case 'line':
                return $this->preprocessForLineChart($rawData);
            default:
                return $rawData;
        }
    }
    
    private function preprocessForPieChart($rawData)
    {
        // Limit pie chart to top 8-10 categories
        $sorted = collect($rawData)->sortByDesc('count');
        $topCategories = $sorted->take(8)->values()->toArray();
        
        // Group smaller categories as "Other"
        if ($sorted->count() > 8) {
            $otherCount = $sorted->skip(8)->sum('count');
            $topCategories[] = [
                'answer' => 'Other',
                'count' => $otherCount
            ];
        }
        
        return $topCategories;
    }
    
    private function preprocessForBarChart($rawData)
    {
        // Sort bar chart data for better readability
        return collect($rawData)->sortByDesc('count')->values()->toArray();
    }
    
    private function preprocessForLineChart($rawData)
    {
        // Ensure chronological order for line charts
        return collect($rawData)->sortBy('date')->values()->toArray();
    }
}
```

### Memory Management for Large Surveys
```php
class MemoryEfficientChartService
{
    public function generateChartForLargeSurvey($surveyId, $questionRef)
    {
        // Use chunking to process large datasets
        $table = "lime_survey_{$surveyId}";
        
        $counts = [];
        
        DB::table($table)
          ->selectRaw("COUNT(*) as count, {$questionRef} as answer")
          ->whereNotNull($questionRef)
          ->chunk(1000, function($chunk) use (&$counts) {
              foreach ($chunk as $row) {
                  $answer = $row->answer;
                  if (!isset($counts[$answer])) {
                      $counts[$answer] = 0;
                  }
                  $counts[$answer] += $row->count;
              }
          });
        
        // Generate chart with processed data
        return $this->createChartFromCounts($counts, $questionRef);
    }
    
    private function createChartFromCounts($counts, $questionRef)
    {
        // Filter out null/empty responses
        $filteredCounts = array_filter($counts, function($count, $answer) {
            return !empty($answer) && $answer !== null && $count > 0;
        }, ARRAY_FILTER_USE_BOTH);
        
        // Create appropriate chart based on number of categories
        if (count($filteredCounts) <= 10) {
            return $this->createBarChart($filteredCounts, $questionRef);
        } else {
            // For many categories, use top 10 and group others
            $topCounts = array_slice($filteredCounts, 0, 10, true);
            $otherCount = array_sum(array_slice($filteredCounts, 10));
            
            if ($otherCount > 0) {
                $topCounts['Other'] = $otherCount;
            }
            
            return $this->createBarChart($topCounts, $questionRef);
        }
    }
}
```

## Integration with Survey Analysis Pipeline

### Automated Report Generation
```php
class AutomatedSurveyReportService
{
    public function generateComprehensiveReport($surveyId)
    {
        // Get survey info
        $survey = $this->getSurvey($surveyId);
        
        // Get all questions in the survey
        $questions = $this->getSurveyQuestions($surveyId);
        
        // Generate charts for all questions
        $chartPaths = [];
        foreach ($questions as $question) {
            $chartPath = $this->generateQuestionChart($surveyId, $question->fieldname);
            $chartPaths[$question->fieldname] = $chartPath;
        }
        
        // Generate summary charts
        $summaryCharts = $this->generateSummaryCharts($surveyId);
        
        // Create comprehensive report
        $report = $this->createReportDocument($survey, $chartPaths, $summaryCharts);
        
        return $report;
    }
    
    private function generateSummaryCharts($surveyId)
    {
        $summaryCharts = [];
        
        // Time trend chart
        $summaryCharts['trend'] = $this->timeBasedService->generateTimeTrendChart($surveyId);
        
        // Response completeness chart
        $summaryCharts['completeness'] = $this->generateCompletenessChart($surveyId);
        
        // Top responses chart
        $summaryCharts['top'] = $this->generateTopResponsesChart($surveyId);
        
        return $summaryCharts;
    }
    
    private function generateCompletenessChart($surveyId)
    {
        // Calculate response completeness
        $totalRespondents = $this->getTotalRespondents($surveyId);
        $questions = $this->getSurveyQuestions($surveyId);
        
        $completenessData = [];
        foreach ($questions as $question) {
            $answeredCount = $this->getAnsweredCount($surveyId, $question->fieldname);
            $completenessData[$question->title] = ($answeredCount / $totalRespondents) * 100;
        }
        
        // Create bar chart for completeness
        $graph = new Graph(800, 400 + (count($completenessData) * 10));
        $graph->SetScale('intlin');
        $graph->title->Set('Response Completeness by Question');
        
        $barPlot = new BarPlot(array_values($completenessData));
        $barPlot->SetFillColor('lightgreen');
        
        // Rotate labels if many questions
        if (count($completenessData) > 5) {
            $graph->xaxis->SetTickLabels(array_keys($completenessData));
            $graph->xaxis->SetLabelAngle(45);
        } else {
            $graph->xaxis->SetTickLabels(array_keys($completenessData));
        }
        
        $graph->Add($barPlot);
        
        return $this->saveChart($graph, "completeness_{$surveyId}.png");
    }
}
```

## Quality Assurance and Validation

### Data Quality Checks
```php
class SurveyDataQualityChecker
{
    public function validateSurveyData($surveyId)
    {
        $issues = [];
        
        // Check for null responses
        $nullCount = $this->getNullResponseCount($surveyId);
        if ($nullCount > 0) {
            $issues[] = "Found {$nullCount} null responses in survey {$surveyId}";
        }
        
        // Check for invalid values
        $invalidValues = $this->getInvalidValues($surveyId);
        if (!empty($invalidValues)) {
            $issues[] = "Found invalid values: " . implode(', ', $invalidValues);
        }
        
        // Check for consistency
        $inconsistencies = $this->getInconsistencies($surveyId);
        if (!empty($inconsistencies)) {
            $issues[] = "Found inconsistencies: " . implode(', ', $inconsistencies);
        }
        
        return $issues;
    }
    
    private function getNullResponseCount($surveyId)
    {
        $table = "lime_survey_{$surveyId}";
        return DB::table($table)->whereNull('submitdate')->count();
    }
    
    private function getInvalidValues($surveyId)
    {
        $table = "lime_survey_{$surveyId}";
        $responses = DB::table($table)->get();
        
        $invalidValues = [];
        
        foreach ($responses as $response) {
            foreach ($response->getAttributes() as $field => $value) {
                if (strpos($field, 'X') !== false) { // Likely a survey field
                    if ($value !== null && !is_string($value) && !is_numeric($value)) {
                        $invalidValues[] = $field . '=' . $value;
                    }
                }
            }
        }
        
        return array_unique($invalidValues);
    }
}
```

## Best Practices Summary

### 1. Chart Type Selection
- Use pie charts for Yes/No questions or questions with few options
- Use bar charts for categorical data with multiple options
- Use line charts for time-based trends
- Use histograms for numeric data with many distinct values

### 2. Data Processing
- Preprocess data to handle outliers and missing values
- Validate data before chart generation
- Implement memory-efficient processing for large datasets

### 3. Performance
- Cache frequently accessed charts
- Use database indexing for survey data queries
- Implement chunking for large dataset processing

### 4. Usability
- Ensure charts are accessible and readable
- Use appropriate colors and sizing
- Provide clear titles and labels

### 5. Error Handling
- Implement graceful degradation for chart generation failures
- Log errors for debugging
- Provide fallback options

By following these best practices, you can create effective and reliable chart visualizations for LimeSurvey data that provide meaningful insights to survey administrators and respondents.