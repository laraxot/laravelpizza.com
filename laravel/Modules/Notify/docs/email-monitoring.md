# Sistema Monitoraggio Email 

## Panoramica

Sistema di monitoraggio per analizzare e ottimizzare le performance delle email.

## Monitoraggio Template

### 1. Template Monitor

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;

class MailTemplateMonitor
{
    protected const CACHE_PREFIX = 'mail_template_stats_';
    protected const CACHE_TTL = 3600;

    public function getStats(int $templateId): array
    {
        $key = self::CACHE_PREFIX . $templateId;
        return Cache::remember($key, self::CACHE_TTL, function () use ($templateId) {
            $template = MailTemplate::find($templateId);
            if (!$template) {
                return [];
            }

            return [
                'total_sent' => $template->notifications()->count(),
                'total_opened' => $template->notifications()->whereNotNull('opened_at')->count(),
                'total_clicked' => $template->notifications()->whereNotNull('clicked_at')->count(),
                'avg_send_time' => $this->calculateAvgSendTime($template),
                'avg_open_time' => $this->calculateAvgOpenTime($template),
                'avg_click_time' => $this->calculateAvgClickTime($template),
            ];
        });
    }

    public function incrementStats(int $templateId, string $type): void
    {
        $key = self::CACHE_PREFIX . $templateId;
        $stats = $this->getStats($templateId);

        switch ($type) {
            case 'sent':
                $stats['total_sent']++;
                break;
            case 'opened':
                $stats['total_opened']++;
                break;
            case 'clicked':
                $stats['total_clicked']++;
                break;
        }

        Cache::put($key, $stats, self::CACHE_TTL);
    }

    protected function calculateAvgSendTime(MailTemplate $template): float
    {
        $notifications = $template->notifications()
            ->whereNotNull('sent_at')
            ->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->sent_at->diffInSeconds($notification->created_at);
        });

        return $totalTime / $notifications->count();
    }

    protected function calculateAvgOpenTime(MailTemplate $template): float
    {
        $notifications = $template->notifications()
            ->whereNotNull('opened_at')
            ->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->opened_at->diffInSeconds($notification->sent_at);
        });

        return $totalTime / $notifications->count();
    }

    protected function calculateAvgClickTime(MailTemplate $template): float
    {
        $notifications = $template->notifications()
            ->whereNotNull('clicked_at')
            ->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->clicked_at->diffInSeconds($notification->opened_at);
        });

        return $totalTime / $notifications->count();
    }
}
```

### 2. Template Dashboard

```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Services\MailTemplateMonitor;

class MailTemplateStatsWidget extends BaseWidget
{
    protected $templateId;
    protected $monitor;

    public function __construct(MailTemplateMonitor $monitor)
    {
        parent::__construct();
        $this->monitor = $monitor;
    }

    public function setTemplateId(int $templateId): self
    {
        $this->templateId = $templateId;
        return $this;
    }

    protected function getStats(): array
    {
        $stats = $this->monitor->getStats($this->templateId);

        return [
            Stat::make('Inviate', $stats['total_sent'])
                ->description('Totale email inviate')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),

            Stat::make('Aperte', $stats['total_opened'])
                ->description('Totale email aperte')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('warning'),

            Stat::make('Cliccate', $stats['total_clicked'])
                ->description('Totale email cliccate')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('danger'),

            Stat::make('Tempo Medio Invio', round($stats['avg_send_time'], 2) . 's')
                ->description('Tempo medio di invio')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),

            Stat::make('Tempo Medio Apertura', round($stats['avg_open_time'], 2) . 's')
                ->description('Tempo medio di apertura')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Tempo Medio Click', round($stats['avg_click_time'], 2) . 's')
                ->description('Tempo medio di click')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
```

## Monitoraggio Notifiche

### 1. Notifiche Monitor

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailNotification;

class MailNotificationMonitor
{
    protected const CACHE_PREFIX = 'mail_notification_stats_';
    protected const CACHE_TTL = 3600;

    public function getStats(): array
    {
        $key = self::CACHE_PREFIX . 'all';
        return Cache::remember($key, self::CACHE_TTL, function () {
            return [
                'total' => MailNotification::count(),
                'pending' => MailNotification::whereNull('sent_at')->count(),
                'sent' => MailNotification::whereNotNull('sent_at')->count(),
                'opened' => MailNotification::whereNotNull('opened_at')->count(),
                'clicked' => MailNotification::whereNotNull('clicked_at')->count(),
                'failed' => MailNotification::whereNotNull('error')->count(),
                'avg_send_time' => $this->calculateAvgSendTime(),
                'avg_open_time' => $this->calculateAvgOpenTime(),
                'avg_click_time' => $this->calculateAvgClickTime(),
            ];
        });
    }

    public function updateStatus(int $notificationId, string $status): void
    {
        $notification = MailNotification::find($notificationId);
        if (!$notification) {
            return;
        }

        switch ($status) {
            case 'sent':
                $notification->update(['sent_at' => now()]);
                break;
            case 'opened':
                $notification->update(['opened_at' => now()]);
                break;
            case 'clicked':
                $notification->update(['clicked_at' => now()]);
                break;
            case 'failed':
                $notification->update(['error' => 'Failed to send']);
                break;
        }

        Cache::forget(self::CACHE_PREFIX . 'all');
    }

    protected function calculateAvgSendTime(): float
    {
        $notifications = MailNotification::whereNotNull('sent_at')->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->sent_at->diffInSeconds($notification->created_at);
        });

        return $totalTime / $notifications->count();
    }

    protected function calculateAvgOpenTime(): float
    {
        $notifications = MailNotification::whereNotNull('opened_at')->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->opened_at->diffInSeconds($notification->sent_at);
        });

        return $totalTime / $notifications->count();
    }

    protected function calculateAvgClickTime(): float
    {
        $notifications = MailNotification::whereNotNull('clicked_at')->get();

        if ($notifications->isEmpty()) {
            return 0;
        }

        $totalTime = $notifications->sum(function ($notification) {
            return $notification->clicked_at->diffInSeconds($notification->opened_at);
        });

        return $totalTime / $notifications->count();
    }
}
```

### 2. Notifiche Dashboard

```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Services\MailNotificationMonitor;

class MailNotificationStatsWidget extends BaseWidget
{
    protected $monitor;

    public function __construct(MailNotificationMonitor $monitor)
    {
        parent::__construct();
        $this->monitor = $monitor;
    }

    protected function getStats(): array
    {
        $stats = $this->monitor->getStats();

        return [
            Stat::make('Totale', $stats['total'])
                ->description('Totale notifiche')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),

            Stat::make('In Attesa', $stats['pending'])
                ->description('Notifiche in attesa')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Inviate', $stats['sent'])
                ->description('Notifiche inviate')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('success'),

            Stat::make('Aperte', $stats['opened'])
                ->description('Notifiche aperte')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('warning'),

            Stat::make('Cliccate', $stats['clicked'])
                ->description('Notifiche cliccate')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('danger'),

            Stat::make('Fallite', $stats['failed'])
                ->description('Notifiche fallite')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Tempo Medio Invio', round($stats['avg_send_time'], 2) . 's')
                ->description('Tempo medio di invio')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),

            Stat::make('Tempo Medio Apertura', round($stats['avg_open_time'], 2) . 's')
                ->description('Tempo medio di apertura')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Tempo Medio Click', round($stats['avg_click_time'], 2) . 's')
                ->description('Tempo medio di click')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
```

## Monitoraggio Queue

### 1. Queue Monitor

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailQueue;

class MailQueueMonitor
{
    protected const CACHE_PREFIX = 'mail_queue_stats_';
    protected const CACHE_TTL = 3600;

    public function getStats(): array
    {
        $key = self::CACHE_PREFIX . 'all';
        return Cache::remember($key, self::CACHE_TTL, function () {
            return [
                'total' => MailQueue::count(),
                'pending' => MailQueue::where('status', 'pending')->count(),
                'processing' => MailQueue::where('status', 'processing')->count(),
                'completed' => MailQueue::where('status', 'completed')->count(),
                'failed' => MailQueue::where('status', 'failed')->count(),
                'avg_processing_time' => $this->calculateAvgProcessingTime(),
                'avg_retry_time' => $this->calculateAvgRetryTime(),
            ];
        });
    }

    public function updateStatus(int $jobId, string $status): void
    {
        $job = MailQueue::find($jobId);
        if (!$job) {
            return;
        }

        $job->update(['status' => $status]);
        Cache::forget(self::CACHE_PREFIX . 'all');
    }

    protected function calculateAvgProcessingTime(): float
    {
        $jobs = MailQueue::where('status', 'completed')->get();

        if ($jobs->isEmpty()) {
            return 0;
        }

        $totalTime = $jobs->sum(function ($job) {
            return $job->updated_at->diffInSeconds($job->created_at);
        });

        return $totalTime / $jobs->count();
    }

    protected function calculateAvgRetryTime(): float
    {
        $jobs = MailQueue::where('attempts', '>', 1)->get();

        if ($jobs->isEmpty()) {
            return 0;
        }

        $totalTime = $jobs->sum(function ($job) {
            return $job->updated_at->diffInSeconds($job->created_at);
        });

        return $totalTime / $jobs->count();
    }
}
```

### 2. Queue Dashboard

```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Services\MailQueueMonitor;

class MailQueueStatsWidget extends BaseWidget
{
    protected $monitor;

    public function __construct(MailQueueMonitor $monitor)
    {
        parent::__construct();
        $this->monitor = $monitor;
    }

    protected function getStats(): array
    {
        $stats = $this->monitor->getStats();

        return [
            Stat::make('Totale', $stats['total'])
                ->description('Totale job')
                ->descriptionIcon('heroicon-m-queue-list')
                ->color('success'),

            Stat::make('In Attesa', $stats['pending'])
                ->description('Job in attesa')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('In Elaborazione', $stats['processing'])
                ->description('Job in elaborazione')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),

            Stat::make('Completati', $stats['completed'])
                ->description('Job completati')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Falliti', $stats['failed'])
                ->description('Job falliti')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Tempo Medio Elaborazione', round($stats['avg_processing_time'], 2) . 's')
                ->description('Tempo medio di elaborazione')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),

            Stat::make('Tempo Medio Retry', round($stats['avg_retry_time'], 2) . 's')
                ->description('Tempo medio di retry')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
```

## Best Practices

### 1. Monitoraggio Alert

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailMonitoringAlert
{
    protected const CACHE_PREFIX = 'mail_alert_';
    protected const CACHE_TTL = 3600;

    public function checkAlerts(): array
    {
        return [
            'templates' => $this->checkTemplateAlerts(),
            'notifications' => $this->checkNotificationAlerts(),
            'queue' => $this->checkQueueAlerts(),
        ];
    }

    protected function checkTemplateAlerts(): array
    {
        $alerts = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $stats = app(MailTemplateMonitor::class)->getStats($template->id);

            if ($stats['total_sent'] > 0) {
                $openRate = ($stats['total_opened'] / $stats['total_sent']) * 100;
                $clickRate = ($stats['total_clicked'] / $stats['total_sent']) * 100;

                if ($openRate < 20) {
                    $alerts[] = [
                        'type' => 'low_open_rate',
                        'template_id' => $template->id,
                        'template_name' => $template->name,
                        'rate' => $openRate,
                        'threshold' => 20,
                    ];
                }

                if ($clickRate < 5) {
                    $alerts[] = [
                        'type' => 'low_click_rate',
                        'template_id' => $template->id,
                        'template_name' => $template->name,
                        'rate' => $clickRate,
                        'threshold' => 5,
                    ];
                }
            }
        }

        return $alerts;
    }

    protected function checkNotificationAlerts(): array
    {
        $alerts = [];
        $stats = app(MailNotificationMonitor::class)->getStats();

        if ($stats['total'] > 0) {
            $failureRate = ($stats['failed'] / $stats['total']) * 100;

            if ($failureRate > 5) {
                $alerts[] = [
                    'type' => 'high_failure_rate',
                    'rate' => $failureRate,
                    'threshold' => 5,
                ];
            }
        }

        return $alerts;
    }

    protected function checkQueueAlerts(): array
    {
        $alerts = [];
        $stats = app(MailQueueMonitor::class)->getStats();

        if ($stats['total'] > 0) {
            $failureRate = ($stats['failed'] / $stats['total']) * 100;
            $pendingRate = ($stats['pending'] / $stats['total']) * 100;

            if ($failureRate > 5) {
                $alerts[] = [
                    'type' => 'high_queue_failure_rate',
                    'rate' => $failureRate,
                    'threshold' => 5,
                ];
            }

            if ($pendingRate > 20) {
                $alerts[] = [
                    'type' => 'high_pending_rate',
                    'rate' => $pendingRate,
                    'threshold' => 20,
                ];
            }
        }

        return $alerts;
    }
}
```

### 2. Monitoraggio Report

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailMonitoringReport
{
    protected const CACHE_PREFIX = 'mail_report_';
    protected const CACHE_TTL = 3600;

    public function generateReport(): array
    {
        return [
            'templates' => $this->generateTemplateReport(),
            'notifications' => $this->generateNotificationReport(),
            'queue' => $this->generateQueueReport(),
            'alerts' => app(MailMonitoringAlert::class)->checkAlerts(),
        ];
    }

    protected function generateTemplateReport(): array
    {
        $report = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $stats = app(MailTemplateMonitor::class)->getStats($template->id);
            $report[$template->id] = [
                'name' => $template->name,
                'version' => $template->version,
                'stats' => $stats,
                'performance' => [
                    'open_rate' => $stats['total_sent'] > 0 ? ($stats['total_opened'] / $stats['total_sent']) * 100 : 0,
                    'click_rate' => $stats['total_sent'] > 0 ? ($stats['total_clicked'] / $stats['total_sent']) * 100 : 0,
                ],
            ];
        }

        return $report;
    }

    protected function generateNotificationReport(): array
    {
        $stats = app(MailNotificationMonitor::class)->getStats();

        return [
            'stats' => $stats,
            'performance' => [
                'success_rate' => $stats['total'] > 0 ? (($stats['total'] - $stats['failed']) / $stats['total']) * 100 : 0,
                'open_rate' => $stats['sent'] > 0 ? ($stats['opened'] / $stats['sent']) * 100 : 0,
                'click_rate' => $stats['opened'] > 0 ? ($stats['clicked'] / $stats['opened']) * 100 : 0,
            ],
        ];
    }

    protected function generateQueueReport(): array
    {
        $stats = app(MailQueueMonitor::class)->getStats();

        return [
            'stats' => $stats,
            'performance' => [
                'success_rate' => $stats['total'] > 0 ? (($stats['total'] - $stats['failed']) / $stats['total']) * 100 : 0,
                'processing_rate' => $stats['total'] > 0 ? ($stats['completed'] / $stats['total']) * 100 : 0,
            ],
        ];
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Performance Basse**
   - Verifica cache
   - Controlla query
   - Debug stats

2. **Alert Falsi**
   - Verifica soglie
   - Controlla dati
   - Debug alert

3. **Report Errati**
   - Verifica calcoli
   - Controlla fonti
   - Debug report

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailMonitoringDebugger
{
    protected $templateMonitor;
    protected $notificationMonitor;
    protected $queueMonitor;
    protected $alert;
    protected $report;

    public function __construct(
        MailTemplateMonitor $templateMonitor,
        MailNotificationMonitor $notificationMonitor,
        MailQueueMonitor $queueMonitor,
        MailMonitoringAlert $alert,
        MailMonitoringReport $report
    ) {
        $this->templateMonitor = $templateMonitor;
        $this->notificationMonitor = $notificationMonitor;
        $this->queueMonitor = $queueMonitor;
        $this->alert = $alert;
        $this->report = $report;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'alerts' => $this->debugAlerts(),
            'reports' => $this->debugReports(),
        ];
    }

    protected function debugTemplates(): array
    {
        $debug = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $debug[$template->id] = [
                'name' => $template->name,
                'version' => $template->version,
                'stats' => $this->templateMonitor->getStats($template->id),
                'cache' => [
                    'key' => 'mail_template_stats_' . $template->id,
                    'exists' => Cache::has('mail_template_stats_' . $template->id),
                ],
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $stats = $this->notificationMonitor->getStats();

        return [
            'stats' => $stats,
            'cache' => [
                'key' => 'mail_notification_stats_all',
                'exists' => Cache::has('mail_notification_stats_all'),
            ],
        ];
    }

    protected function debugQueue(): array
    {
        $stats = $this->queueMonitor->getStats();

        return [
            'stats' => $stats,
            'cache' => [
                'key' => 'mail_queue_stats_all',
                'exists' => Cache::has('mail_queue_stats_all'),
            ],
        ];
    }

    protected function debugAlerts(): array
    {
        return [
            'templates' => $this->alert->checkTemplateAlerts(),
            'notifications' => $this->alert->checkNotificationAlerts(),
            'queue' => $this->alert->checkQueueAlerts(),
        ];
    }

    protected function debugReports(): array
    {
        return [
            'templates' => $this->report->generateTemplateReport(),
            'notifications' => $this->report->generateNotificationReport(),
            'queue' => $this->report->generateQueueReport(),
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
- [Laravel Events](https://laravel.com/project_docs/events) 
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Commands](https://laravel.com/docs/artisan) 
- [Laravel Events](https://laravel.com/docs/events) 
