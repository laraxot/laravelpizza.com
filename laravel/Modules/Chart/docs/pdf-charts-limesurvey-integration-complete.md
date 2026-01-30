# Professional PDF Generation with Charts and LimeSurvey Integration

## Overview

This document provides a comprehensive guide to implementing professional PDF generation with dynamic charts that integrate with LimeSurvey survey data. It covers the complete workflow from data retrieval to final PDF delivery, following Laraxot principles and best practices.

## 1. Introduction

PDF generation with embedded charts is a critical feature for survey analytics platforms. This guide covers:

- **Data Flow**: From LimeSurvey database → Chart generation → PDF creation
- **Technology Stack**: Using SPIPU HTML2PDF and JpGraph for chart rendering
- **Integration Pattern**: Seamless integration with Filament dashboard widgets
- **Performance Considerations**: Caching, queuing, and optimization strategies

## 2. Complete Integration Workflow

The complete workflow follows a multi-step process:

```
Survey Data (LimeSurvey DB) → Data Processing → Chart Generation → Image Storage → HTML Template → PDF Generation → Download
```

### 2.1 Data Retrieval from LimeSurvey

```php
use Modules\Limesurvey\Models\SurveyResponse;

// Retrieve survey responses with filtering
$responses = SurveyResponse::getResponsesForSurvey((string) $surveyId)
    ->withParticipants()
    ->where('submitdate', '!=', null)
    ->where('submitdate', '>=', $startDate)
    ->where('submitdate', '<=', $endDate)
    ->withAllAnswers('subquery')
    ->get();
```

### 2.2 Chart Data Processing

Process the retrieved data into chart-ready format:

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\QuestionChart;

use Modules\Chart\Datas\ChartData;
use Modules\Chart\Datas\AnswersChartData;

class GetChartsDataByQuestionChart
{
    public function execute(
        \Modules\Quaeris\Models\QuestionChart $questionChart,
        $responses,
        ?\Modules\Quaeris\Datas\AnswersFilterData $answersFilterData = null
    ): array {
        // Process survey responses into chart data
        $processedData = [];
        
        foreach ($questionChart->charts as $chartIndex => $chart) {
            // Process specific chart data
            $chartData = ChartData::from($chart->toArray());
            
            // Apply filters if provided
            if ($answersFilterData !== null) {
                // Add title, subtitle, footer for first chart
                if ($chartIndex === 0) {
                    $chartData->title = app(GetTitleAction::class)
                        ->execute($questionChart, $answersFilterData);
                }
            }
            
            // Collect answers for this chart
            $answers = $this->processAnswersForChart($responses, $chart);
            
            $processedData[] = AnswersChartData::from([
                'answers' => $answers,
                'chart' => $chartData,
            ]);
        }
        
        return $processedData;
    }
    
    private function processAnswersForChart($responses, $chart)
    {
        // Implement chart-specific answer processing logic
        // This depends on chart type and question format
        return collect($responses)
            ->map(function ($response) use ($chart) {
                // Extract answer values based on chart requirements
                return $this->extractAnswerValue($response, $chart);
            })
            ->filter()
            ->values();
    }
}
```

## 3. Chart Generation Process

### 3.1 Chart Image Creation

Generate chart images using JpGraph and store them for PDF integration:

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\QuestionChart;

use Illuminate\Support\Facades\File;
use Modules\Quaeris\Datas\AnswersFilterData;

class MakeImgByQuestionChartModel2Action
{
    public function execute(
        \Modules\Quaeris\Models\QuestionChart $questionChart,
        $responses,
        ?AnswersFilterData $answersFilterData = null
    ): array {
        // Get chart data
        $datas = app(GetChartsDataByQuestionChart::class)
            ->execute($questionChart, $responses, $answersFilterData);

        $filenames = [];

        foreach ($datas as $k => $data_answers) {
            $answers = $data_answers->answers;
            $chart_obj = $questionChart->charts[$k];

            // Convert chart style to DTO
            $chart_style = \Modules\Chart\Datas\ChartData::from($chart_obj->toArray());

            // Add title/subtitle for first chart
            if ($k === 0 && $answersFilterData !== null) {
                $chart_style->title = app(GetTitleAction::class)
                    ->execute($questionChart, $answersFilterData);
                $chart_style->subtitle = app(GetSubtitleAction::class)
                    ->execute($questionChart, $answersFilterData);
                $chart_style->footer = app(GetFooterAction::class)
                    ->execute($questionChart, $answersFilterData);
            }

            // Create answers data
            $answersData = \Modules\Chart\Datas\AnswersChartData::from([
                'answers' => $answers,
                'chart' => $chart_style,
            ]);

            // Execute chart generation action
            $action_class = $chart_style->getActionClass();
            $graphAction = app($action_class);
            $graph = $graphAction->execute($answersData);

            // Save as PNG
            $filename = 'chart/'.$questionChart->id.'-'.$k.'.png';
            $file_path = public_path($filename);

            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            $graph->Stroke($file_path);

            if (!File::exists($file_path)) {
                logger()->error('Chart image not generated', [
                    'file_path' => $file_path,
                    'question_chart_id' => $questionChart->id,
                ]);
                continue;
            }

            $filenames[] = $filename;
        }

        // Merge multiple charts if needed
        if (count($filenames) > 1) {
            $fileName = 'chart/'.$questionChart->id.'.png';
            app(\Modules\Chart\Actions\JpGraph\V1\Merge::class)->execute($filenames, $fileName);
        } else {
            $fileName = $filenames[0] ?? 'chart/NoDataImage.jpeg';
        }

        // Update model with image path
        $questionChart->img_src = $fileName;
        $questionChart->generated_at = now();
        $questionChart->save();

        return [
            'q' => $questionChart,
            'filenames' => $fileName,
        ];
    }
}
```

## 4. PDF Generation with SPIPU HTML2PDF

### 4.1 HTML Template for PDF

Create a comprehensive HTML template that includes chart images:

```blade
{{-- Modules/Quaeris/resources/views/pdf/template1.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $surveyPdf->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .chart-container {
            margin: 10px 0;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .page {
            page-break-after: always;
        }
        
        @media print {
            body { font-size: 10pt; }
            .chart-container { height: 300px; }
        }
    </style>
</head>
<body>
    @foreach($rows as $row)
        <div class="page">
            <table>
                {{-- Title row --}}
                <tr>
                    @foreach($row as $img)
                        <td style="width: {{ ($img->col_size * 100) / 12 }}%">
                            @php
                                $q_title = $img->getQuestionBreads()
                                    ->pluck('title')
                                    ->implode(' - ');
                            @endphp
                            <p style="font-size: {{ $pdf->font_size_question }}%;">
                                {!! $q_title !!}
                            </p>
                        </td>
                    @endforeach
                </tr>
                
                {{-- Chart row --}}
                <tr>
                    @foreach($row as $img)
                        <td style="width: {{ ($img->col_size * 100) / 12 }}%">
                            <h3>{{ mb_convert_encoding($img->title, 'Windows-1252', 'UTF-8') }}</h3>
                            
                            @php
                                $imgPath = public_path(ltrim($img->img_src, '/'));
                            @endphp

                            @if(File::exists($imgPath))
                                <img src="{{ $imgPath }}" 
                                     style="max-width: 100%; height: auto;" />
                            @else
                                <p style="color: red;">
                                    [Chart not generated for ID {{ $img->id }}]
                                </p>
                            @endif
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
    @endforeach
</body>
</html>
```

### 4.2 PDF Generation Action

Implement the complete PDF generation process:

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Actions\SurveyPdf;

use Illuminate\Http\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Spipu\Html2Pdf\Html2Pdf;
use Modules\Limesurvey\Models\SurveyResponse;
use Modules\Quaeris\Datas\AnswersFilterData;
use Modules\Quaeris\Datas\DashboardFilterData;

class MakePdf2Action
{
    public function execute(
        \Modules\Quaeris\Models\SurveyPdf $surveyPdf,
        ?AnswersFilterData $answersFilterData = null
    ): BinaryFileResponse {
        // Initialize Html2Pdf
        $html2pdf = new Html2Pdf('L', 'A4', 'it');
        $html2pdf->setTestIsImage(false); // Disable image validation

        // Prepare response query
        $dashboardFilterData = DashboardFilterData::fromArray([
            'survey_pdf_id' => $answersFilterData->survey_pdf_id,
            'question_filter' => $answersFilterData->question_filter,
            'startDate' => $answersFilterData->date_from,
            'endDate' => $answersFilterData->date_to,
        ]);

        $responses = SurveyResponse::getResponsesForSurvey((string) $surveyPdf->survey_id)
            ->withParticipants()
            ->where('submitdate', '!=', null)
            ->ofDashboardFilterData($dashboardFilterData)
            ->withAllAnswers('subquery');

        // Generate images BEFORE HTML generation
        $questionCharts = $surveyPdf->questionCharts->where('show_on_pdf', 1);

        foreach ($questionCharts as $questionChart) {
            app(MakeImgByQuestionChartModel2Action::class)
                ->execute($questionChart, $responses, $answersFilterData);
        }

        // Generate HTML
        $html = app(MakeHtmlBySurveyPdfModelAction::class)
            ->execute($surveyPdf, $answersFilterData);

        if ($html instanceof \Illuminate\View\View) {
            $html = $html->render();
        }

        // Write HTML to PDF
        $html2pdf->writeHTML($html);

        // Generate filename
        $survey_date_to = $answersFilterData->date_to;
        if ($survey_date_to === null || $survey_date_to === '0000-00-00') {
            $survey_date_to = date('W / o');
        } else {
            $survey_date_to = date('W / o', strtotime((string) $survey_date_to));
        }

        $filename = \Illuminate\Support\Str::slug($surveyPdf->name.'_sett_'.$survey_date_to).'.pdf';

        // Save PDF
        $path = Storage::disk('cache')->path($filename);
        $html2pdf->output($path, 'F');

        // Return download response
        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
```

## 5. Integration with Filament Dashboard

### 5.1 Adding PDF Export to Dashboard

Integrate PDF export functionality into dashboard pages:

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Pages;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Gate;
use Modules\Quaeris\Actions\SurveyPdf\MakePdf2Action;
use Modules\Quaeris\Datas\AnswersFilterData;
use Modules\Quaeris\Models\SurveyPdf;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class DashboardV2 extends XotBaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    if (!isset($this->filters['survey_pdf_id'])) {
                        return;
                    }

                    $answersFilterData = AnswersFilterData::from([
                        'date_from' => $this->filters['startDate'] ?? now()->subDays(30),
                        'date_to' => ($this->filters['endDate'] ?? now()->format('Y-m-d')).' 23:59:59',
                        'question_filter' => $this->filters['question_filter'] ?? null,
                    ]);

                    $surveyPdf = SurveyPdf::find($this->filters['survey_pdf_id']);

                    if (!$surveyPdf) {
                        return;
                    }

                    return app(MakePdf2Action::class)->execute($surveyPdf, $answersFilterData);
                }),
        ];
    }

    public static function canAccess(): bool
    {
        $filters = request()->get('filters') ?? [];
        
        if (empty($filters) || !isset($filters['survey_pdf_id'])) {
            return true;
        }

        $survey_pdf_id = $filters['survey_pdf_id'] ?? null;
        if (empty($survey_pdf_id)) {
            return true;
        }

        $survey_pdf = SurveyPdf::firstWhere(['id' => $survey_pdf_id]);

        if (!$survey_pdf) {
            return true;
        }

        return Gate::allows('dashboard', $survey_pdf);
    }
}
```

## 6. Performance Optimization

### 6.1 Caching Strategies

Implement caching for expensive operations:

```php
public function execute(
    SurveyPdf $surveyPdf,
    ?AnswersFilterData $answersFilterData = null
): BinaryFileResponse {
    $cacheKey = 'pdf_'.md5(serialize([
        $surveyPdf->id,
        $answersFilterData?->toArray()
    ]));

    return cache()->remember($cacheKey, now()->addMinutes(30), function () use ($surveyPdf, $answersFilterData) {
        return $this->generatePdf($surveyPdf, $answersFilterData);
    });
}
```

### 6.2 Queue-based PDF Generation

For large reports, use background job processing:

```php
<?php

namespace Modules\Quaeris\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Quaeris\Models\SurveyPdf;

class GeneratePdfReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected SurveyPdf $surveyPdf,
        protected array $filters
    ) {}

    public function handle()
    {
        $answersFilterData = \Modules\Quaeris\Datas\AnswersFilterData::from($this->filters);
        
        $pdfAction = app(\Modules\Quaeris\Actions\SurveyPdf\MakePdf2Action::class);
        $response = $pdfAction->execute($this->surveyPdf, $answersFilterData);
        
        // Store the generated PDF or send notification
        // Implementation depends on your needs
    }
}
```

## 7. Troubleshooting Common Issues

### 7.1 Chart Images Not Appearing in PDF

**Problem**: Chart images don't appear in the final PDF.

**Solutions**:
1. Verify absolute paths in templates
2. Disable image validation in Html2Pdf
3. Check directory permissions
4. Ensure images are generated before HTML rendering

### 7.2 Memory Issues with Large Charts

**Problem**: Chart generation fails due to memory limits.

**Solutions**:
1. Increase memory limit
2. Reduce chart dimensions
3. Implement image optimization

### 7.3 LimeSurvey Connection Issues

**Problem**: Failure to retrieve data from LimeSurvey database.

**Solutions**:
1. Check database configuration
2. Add proper error handling
3. Implement retry mechanisms

## 8. Security Considerations

### 8.1 Access Control

Ensure proper authorization for PDF generation:

```php
public static function canAccess(): bool
{
    return Gate::allows('generate-pdf', SurveyPdf::find(request('filters.survey_pdf_id')));
}
```

### 8.2 Input Validation

Validate all input parameters:

```php
public function execute(array $filters)
{
    $validated = validator($filters, [
        'survey_pdf_id' => 'required|exists:survey_pdfs,id',
        'startDate' => 'date',
        'endDate' => 'date|after_or_equal:startDate',
        'question_filter' => 'nullable|string',
    ])->validate();
    
    return $validated;
}
```

## 9. References

For more information on related topics, see:
- [LimeSurvey Integration Guide](../../Quaeris/docs/limesurvey-pdf-export-integration.md)
- [Filament Dashboard Widgets Implementation](../../Quaeris/docs/filament-dashboard-widgets-implementation.md)
- [JpGraph Implementation Guide](jpgraph-complete-guide.md)
- [SPIPU PDF Integration](pdf-integration-complete-guide.md)

This guide provides a comprehensive approach to implementing professional PDF generation with charts in your LimeSurvey integration system.