# Job Module PDF Reports

## 📋 Overview

Guida completa per generare report PDF del sistema di code e job utilizzando HTML2PDF con integrazione nativa nel modulo Job.

---

## 🎯 Tipi di Report Disponibili

### 1. Queue System Report

Report completo dello stato del sistema di code:

```php
use Modules\Job\Actions\GenerateQueueReportAction;

// Generate queue system report
$pdf = app(GenerateQueueReportAction::class)->execute([
    'period' => [
        'start' => now()->subDay(),
        'end' => now(),
    ],
    'include_sections' => [
        'statistics' => true,
        'health_status' => true,
        'job_history' => true,
        'performance_metrics' => true,
    ],
    'queue_filter' => ['default', 'high', 'low'],
]);
```

### 2. Job Performance Report

Report analitico delle performance dei job:

```php
// Generate performance report
$pdf = app(GeneratePerformanceReportAction::class)->execute([
    'date_range' => [
        'start' => now()->subWeek(),
        'end' => now(),
    ],
    'job_types' => ['ProcessDataJob', 'SendEmailJob', 'GenerateReportJob'],
    'include_charts' => true,
    'include_failures' => true,
]);
```

### 3. Failed Jobs Analysis Report

Report dettagliato dei job falliti:

```php
// Generate failed jobs report
$pdf = app(GenerateFailedJobsReportAction::class)->execute([
    'date_range' => [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    'group_by' => 'exception_class', // 'queue', 'job_class', 'exception_class'
    'include_stack_traces' => false,
    'resolution_status' => 'all', // 'resolved', 'unresolved', 'all'
]);
```

---

## 🏗️ Architettura Report PDF

### 1. Job Report Service

```php
<?php

namespace Modules\Job\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Modules\Job\Models\Job;
use Modules\Job\Models\FailedJob;
use Modules\Job\Models\Task;
use Modules\Job\Models\Result;

class JobReportService
{
    public function generateQueueReport(array $options = []): string
    {
        try {
            $data = $this->prepareQueueData($options);

            $html = view('job::pdf.queue-system-report', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
                'reportId' => $this->generateReportId(),
            ])->render();

            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new JobReportException('Failed to generate queue report: ' . $e->getMessage());
        }
    }

    private function prepareQueueData(array $options): array
    {
        $monitor = app(QueueMonitorService::class);

        return [
            'queue_statistics' => $this->getQueueStatistics($options),
            'health_status' => $monitor->getHealthStatus(),
            'job_history' => $this->getJobHistory($options),
            'performance_metrics' => $this->getPerformanceMetrics($options),
            'failed_jobs_analysis' => $this->getFailedJobsAnalysis($options),
            'recommendations' => $this->generateRecommendations($options),
        ];
    }

    private function getQueueStatistics(array $options): array
    {
        $query = Job::query();

        if (isset($options['queue_filter'])) {
            $query->whereIn('queue_name', $options['queue_filter']);
        }

        if (isset($options['period'])) {
            $query->whereBetween('created_at', $options['period']);
        }

        $jobs = $query->get();

        return [
            'total_jobs' => $jobs->count(),
            'by_queue' => $jobs->groupBy('queue_name')
                           ->map(fn($group) => [
                               'count' => $group->count(),
                               'pending' => $group->whereNull('reserved_at')->count(),
                               'processing' => $group->whereNotNull('reserved_at')->count(),
                               'failed' => $group->where('attempts', '>', 0)->count(),
                           ]),
            'by_status' => [
                'pending' => $jobs->whereNull('reserved_at')->count(),
                'processing' => $jobs->whereNotNull('reserved_at')->count(),
                'failed' => $jobs->where('attempts', '>', 0)->count(),
            ],
            'avg_attempts' => round($jobs->avg('attempts'), 2),
            'max_attempts' => $jobs->max('attempts'),
        ];
    }

    private function getPerformanceMetrics(array $options): array
    {
        $query = Result::query();

        if (isset($options['period'])) {
            $query->whereBetween('created_at', $options['period']);
        }

        $results = $query->get();

        return [
            'total_executions' => $results->count(),
            'successful_executions' => $results->where('status', 'success')->count(),
            'failed_executions' => $results->where('status', 'failed')->count(),
            'success_rate' => $results->count() > 0
                ? round(($results->where('status', 'success')->count() / $results->count()) * 100, 2)
                : 0,
            'avg_execution_time' => round($results->avg('execution_time'), 2),
            'max_execution_time' => $results->max('execution_time'),
            'min_execution_time' => $results->min('execution_time'),
            'memory_usage' => [
                'avg' => round($results->avg('memory_usage') / 1024 / 1024, 2), // MB
                'max' => round($results->max('memory_usage') / 1024 / 1024, 2), // MB
            ],
        ];
    }

    private function getFailedJobsAnalysis(array $options): array
    {
        $query = FailedJob::query();

        if (isset($options['period'])) {
            $query->whereBetween('failed_at', $options['period']);
        }

        $failedJobs = $query->get();

        return [
            'total_failed' => $failedJobs->count(),
            'by_queue' => $failedJobs->groupBy('queue')
                              ->map(fn($group) => $group->count()),
            'by_exception' => $failedJobs->groupBy('exception')
                                ->map(fn($group) => $group->count()),
            'by_job_class' => $failedJobs->map(fn($job) => json_decode($job->payload, true)['displayName'] ?? 'Unknown')
                                ->groupBy(fn($name) => $name)
                                ->map(fn($group) => $group->count()),
            'retry_rate' => $this->calculateRetryRate($failedJobs),
        ];
    }

    private function generateRecommendations(array $options): array
    {
        $recommendations = [];

        $stats = $this->getQueueStatistics($options);
        $performance = $this->getPerformanceMetrics($options);

        // Queue size recommendations
        foreach ($stats['by_queue'] as $queue => $data) {
            if ($data['pending'] > 1000) {
                $recommendations[] = [
                    'type' => 'queue_size',
                    'priority' => 'high',
                    'message' => "Queue '{$queue}' has {$data['pending']} pending jobs. Consider adding more workers.",
                    'action' => 'Scale queue workers',
                ];
            }
        }

        // Failure rate recommendations
        if ($performance['success_rate'] < 90) {
            $recommendations[] = [
                'type' => 'success_rate',
                'priority' => 'high',
                'message' => "Success rate is {$performance['success_rate']}%. Review failing jobs.",
                'action' => 'Investigate job failures',
            ];
        }

        // Performance recommendations
        if ($performance['avg_execution_time'] > 30) {
            $recommendations[] = [
                'type' => 'performance',
                'priority' => 'medium',
                'message' => "Average execution time is {$performance['avg_execution_time']}s. Consider optimization.",
                'action' => 'Optimize slow jobs',
            ];
        }

        return $recommendations;
    }
}
```

### 2. Performance Report Service

```php
class PerformanceReportService
{
    public function generatePerformanceReport(array $options = []): string
    {
        try {
            $data = $this->preparePerformanceData($options);

            $html = view('job::pdf.performance-report', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
            ])->render();

            $html2pdf = new Html2Pdf('L', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]); // Landscape for charts
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new JobReportException('Failed to generate performance report: ' . $e->getMessage());
        }
    }

    private function preparePerformanceData(array $options): array
    {
        return [
            'execution_trends' => $this->getExecutionTrends($options),
            'job_type_performance' => $this->getJobTypePerformance($options),
            'hourly_distribution' => $this->getHourlyDistribution($options),
            'resource_usage' => $this->getResourceUsage($options),
        ];
    }

    private function getExecutionTrends(array $options): array
    {
        $query = Result::query();

        if (isset($options['date_range'])) {
            $query->whereBetween('created_at', $options['date_range']);
        }

        return $query->selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN status = "success" THEN 1 ELSE 0 END) as successful')
                  ->groupBy('date')
                  ->orderBy('date')
                  ->get()
                  ->toArray();
    }

    private function getJobTypePerformance(array $options): array
    {
        $query = Result::query();

        if (isset($options['job_types'])) {
            $query->whereIn('job_type', $options['job_types']);
        }

        if (isset($options['date_range'])) {
            $query->whereBetween('created_at', $options['date_range']);
        }

        return $query->selectRaw('job_type, COUNT(*) as total, AVG(execution_time) as avg_time, MAX(execution_time) as max_time')
                  ->groupBy('job_type')
                  ->orderBy('avg_time', 'desc')
                  ->get()
                  ->toArray();
    }
}
```

---

## 📄 Template PDF

### 1. Queue System Report Template

```blade
{{-- resources/views/pdf/queue-system-report.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;">
                    <h1 style="font-size: 16pt; margin: 0; color: #2c3e50;">
                        Queue System Report
                    </h1>
                    <p style="font-size: 10pt; margin: 3mm 0 0 0; color: #7f8c8d;">
                        Report ID: {{ $reportId }}
                    </p>
                </td>
                <td style="width: 40%; text-align: right; font-size: 9pt;">
                    Generated: {{ $generatedAt->format('d/m/Y H:i') }}<br>
                    Period: {{ $options['period']['start']->format('d/m/Y') }} -
                            {{ $options['period']['end']->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <div style="border-bottom: 2px solid #2c3e50; margin-top: 5mm;"></div>
    </page_header>

    <!-- Health Status -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">System Health</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; padding: 8mm; background-color: {{ $data['health_status'] == 'healthy' ? '#d4edda' : ($data['health_status'] == 'warning' ? '#fff3cd' : '#f8d7da') }}; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ ucfirst($data['health_status']) }}
                    </div>
                    <div style="font-size: 10pt; text-align: center; color: #7f8c8d;">
                        System Status
                    </div>
                </td>
                <td style="width: 50%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['queue_statistics']['total_jobs'] }}
                    </div>
                    <div style="font-size: 10pt; text-align: center; color: #7f8c8d;">
                        Total Jobs
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Queue Statistics -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Queue Statistics</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Queue
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Total
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Pending
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Processing
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Failed
                </th>
            </tr>
            @foreach($data['queue_statistics']['by_queue'] as $queue => $stats)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $queue }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['count'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['pending'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['processing'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['failed'] }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Performance Metrics -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Performance Metrics</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6; vertical-align: top;">
                    <div style="font-size: 16pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['performance_metrics']['success_rate'] }}%
                    </div>
                    <div style="font-size: 9pt; text-align: center; color: #7f8c8d;">
                        Success Rate
                    </div>
                </td>
                <td style="width: 33%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6; vertical-align: top;">
                    <div style="font-size: 16pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['performance_metrics']['avg_execution_time'] }}s
                    </div>
                    <div style="font-size: 9pt; text-align: center; color: #7f8c8d;">
                        Avg Execution Time
                    </div>
                </td>
                <td style="width: 33%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6; vertical-align: top;">
                    <div style="font-size: 16pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['performance_metrics']['memory_usage']['avg'] }}MB
                    </div>
                    <div style="font-size: 9pt; text-align: center; color: #7f8c8d;">
                        Avg Memory Usage
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Recommendations -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Recommendations</h2>

        @foreach($data['recommendations'] as $recommendation)
        <div style="margin-bottom: 8mm; padding: 8mm; background-color: #f8f9fa; border-left: 4px solid {{ $recommendation['priority'] == 'high' ? '#e74c3c' : '#f39c12' }};">
            <div style="font-size: 11pt; font-weight: bold; margin-bottom: 3mm;">
                {{ $recommendation['message'] }}
            </div>
            <div style="font-size: 9pt; color: #7f8c8d;">
                Action: {{ $recommendation['action'] }} | Priority: {{ $recommendation['priority'] }}
            </div>
        </div>
        @endforeach
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    Job Module Report - Generated by PTVX System
                </td>
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. Performance Report Template

```blade
{{-- resources/views/pdf/performance-report.blade.php --}}
<page orientation="L" backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        <h1 style="font-size: 14pt; text-align: center; color: #2c3e50;">
            Job Performance Report
        </h1>
    </page_header>

    <div style="margin: 10mm 0;">
        <!-- Job Type Performance Table -->
        <h2 style="font-size: 12pt; margin-bottom: 5mm;">Job Type Performance</h2>

        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 3mm; text-align: left;">Job Type</th>
                <th style="border: 1px solid #dee2e6; padding: 3mm; text-align: center;">Total</th>
                <th style="border: 1px solid #dee2e6; padding: 3mm; text-align: center;">Avg Time (s)</th>
                <th style="border: 1px solid #dee2e6; padding: 3mm; text-align: center;">Max Time (s)</th>
                <th style="border: 1px solid #dee2e6; padding: 3mm; text-align: center;">Success Rate</th>
            </tr>
            @foreach($data['job_type_performance'] as $job)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 2mm;">{{ $job['job_type'] }}</td>
                <td style="border: 1px solid #dee2e6; padding: 2mm; text-align: center;">{{ $job['total'] }}</td>
                <td style="border: 1px solid #dee2e6; padding: 2mm; text-align: center;">{{ round($job['avg_time'], 2) }}</td>
                <td style="border: 1px solid #dee2e6; padding: 2mm; text-align: center;">{{ round($job['max_time'], 2) }}</td>
                <td style="border: 1px solid #dee2e6; padding: 2mm; text-align: center;">
                    {{ round(($job['successful'] / $job['total']) * 100, 1) }}%
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 7pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    Performance Report - Job Module
                </td>
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

---

## 🔧 Filament Integration

### 1. Queue Report Action

```php
<?php

namespace Modules\Job\Filament\Actions;

use Filament\Actions\Action;
use Modules\Job\Actions\GenerateQueueReportAction;

class ExportQueueReportAction extends Action
{
    public static function make(string $name = 'export_queue_report'): static
    {
        return parent::make($name)
            ->label('Export Queue Report')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->action(function (array $data) {
                $pdf = app(GenerateQueueReportAction::class)->execute([
                    'period' => [
                        'start' => \Carbon\Carbon::parse($data['start_date']),
                        'end' => \Carbon\Carbon::parse($data['end_date']),
                    ],
                    'include_sections' => $data['sections'] ?? [],
                    'queue_filter' => $data['queues'] ?? [],
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "queue_report_{$data['start_date']}_to_{$data['end_date']}.pdf");
            })
            ->form([
                \Filament\Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->default(now()->subDay()),

                \Filament\Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->default(now()),

                \Filament\Forms\Components\CheckboxList::make('sections')
                    ->label('Include Sections')
                    ->options([
                        'statistics' => 'Queue Statistics',
                        'health_status' => 'Health Status',
                        'job_history' => 'Job History',
                        'performance_metrics' => 'Performance Metrics',
                    ])
                    ->default(['statistics', 'health_status', 'performance_metrics']),

                \Filament\Forms\Components\CheckboxList::make('queues')
                    ->label('Queue Filter')
                    ->options([
                        'default' => 'Default Queue',
                        'high' => 'High Priority Queue',
                        'low' => 'Low Priority Queue',
                        'notifications' => 'Notifications Queue',
                    ])
                    ->default(['default', 'high', 'low']),
            ]);
    }
}
```

### 2. Performance Report Action

```php
class ExportPerformanceReportAction extends Action
{
    public static function make(string $name = 'export_performance_report'): static
    {
        return parent::make($name)
            ->label('Export Performance Report')
            ->icon('heroicon-o-chart-bar')
            ->color('success')
            ->action(function (array $data) {
                $pdf = app(GeneratePerformanceReportAction::class)->execute([
                    'date_range' => [
                        'start' => \Carbon\Carbon::parse($data['start_date']),
                        'end' => \Carbon\Carbon::parse($data['end_date']),
                    ],
                    'job_types' => $data['job_types'] ?? [],
                    'include_charts' => $data['include_charts'] ?? false,
                    'include_failures' => $data['include_failures'] ?? true,
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "performance_report_{$data['start_date']}_to_{$data['end_date']}.pdf");
            })
            ->form([
                \Filament\Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->default(now()->subWeek()),

                \Filament\Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->default(now()),

                \Filament\Forms\Components\CheckboxList::make('job_types')
                    ->label('Job Types')
                    ->options([
                        'ProcessDataJob' => 'Data Processing',
                        'SendEmailJob' => 'Email Sending',
                        'GenerateReportJob' => 'Report Generation',
                        'ImportDataJob' => 'Data Import',
                    ]),

                \Filament\Forms\Components\Toggle::make('include_charts')
                    ->label('Include Charts')
                    ->default(true),

                \Filament\Forms\Components\Toggle::make('include_failures')
                    ->label('Include Failures Analysis')
                    ->default(true),
            ]);
    }
}
```

---

## 🧪 Testing

### 1. Unit Tests

```php
<?php

namespace Modules\Job\Tests\Unit;

use Tests\TestCase;
use Modules\Job\Services\JobReportService;
use Modules\Job\Models\Job;
use Modules\Job\Models\FailedJob;

class JobReportTest extends TestCase
{
    /** @test */
    public function it_generates_queue_report()
    {
        // Create test data
        Job::factory()->count(100)->create();
        FailedJob::factory()->count(10)->create();

        $service = app(JobReportService::class);
        $pdfContent = $service->generateQueueReport([
            'period' => [
                'start' => now()->subDay(),
                'end' => now(),
            ]
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(2000, strlen($pdfContent));
        $this->assertStringContainsString('Queue System Report', $pdfContent);
        $this->assertStringContainsString('System Health', $pdfContent);
    }

    /** @test */
    public function it_includes_performance_metrics()
    {
        Job::factory()->count(50)->create();

        $service = app(JobReportService::class);
        $pdfContent = $service->generateQueueReport([
            'include_sections' => ['performance_metrics'],
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertStringContainsString('Performance Metrics', $pdfContent);
    }

    /** @test */
    public function it_handles_large_datasets_efficiently()
    {
        // Create large dataset
        Job::factory()->count(5000)->create();

        $startTime = microtime(true);

        $service = app(JobReportService::class);
        $pdfContent = $service->generateQueueReport();

        $duration = microtime(true) - $startTime;

        // Should generate within reasonable time
        $this->assertLessThan(10, $duration);
        $this->assertStringStartsWith('%PDF', $pdfContent);
    }
}
```

### 2. Feature Tests

```php
/** @test */
public function admin_can_export_queue_report()
{
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
                    ->post('/job/export-queue-report', [
                        'start_date' => now()->subDay()->format('Y-m-d'),
                        'end_date' => now()->format('Y-m-d'),
                        'sections' => ['statistics', 'health_status'],
                        'queues' => ['default', 'high'],
                    ]);

    $response->assertSuccessful();
    $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
}
```

---

## 📊 Performance Optimization

### 1. Caching Strategy

```php
class JobReportService
{
    public function generateCachedQueueReport(array $options = []): string
    {
        $cacheKey = 'job_queue_report_' . md5(json_encode([
            'options' => $options,
            'last_job' => Job::max('updated_at'),
            'last_failed' => FailedJob::max('failed_at'),
        ]));

        return Cache::remember($cacheKey, 1800, function () use ($options) { // 30 minutes
            return $this->generateQueueReport($options);
        });
    }
}
```

### 2. Memory Management

```php
private function optimizeForLargeReports($query)
{
    // Use chunking for large datasets
    $query->chunk(500, function ($jobs) {
        // Process in chunks
    });

    // Limit data for PDF
    return $query->limit(2000)->get();
}
```

---

## 🚀 Error Handling

```php
public function generateWithErrorHandling(array $options = []): string
{
    try {
        return $this->generateQueueReport($options);

    } catch (Html2PdfException $e) {
        Log::error('Job PDF generation failed', [
            'error' => $e->getMessage(),
            'options' => $options,
        ]);

        // Generate simplified fallback
        return $this->generateFallbackReport($options);

    } catch (Exception $e) {
        Log::error('Unexpected error in job PDF generation', [
            'error' => $e->getMessage(),
        ]);

        throw new JobReportException('Failed to generate job report');
    }
}
```

---

## 📚 References

- [HTML2PDF Best Practices](../Xot/docs/html2pdf-best-practices.md)
- [Job Module README](./README.md)
- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Filament Actions Documentation](https://filamentphp.com/docs/3.x/actions/overview)

---

**
**Version:** 1.0.0
**HTML2PDF Version:** 5.2.x
**PHPStan Level:** 10 ✅
