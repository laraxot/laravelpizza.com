---
qmd: "email consolidated"
issues: []
discussions: []
title: "email: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# email: Consolidated Documentation

Consolidated from **42** individual files.

## Table of Contents

- [---](#email-analytics-1)
- [Analytics Email - il progetto](#email-analytics)
- [Sistema Backup Email](#email-backup-1)
- [---](#email-backup-2)
- [Sistema Backup Email ](#email-backup)
- [---](#email-best-practices-1)
- [Best Practices per il Sistema Email](#email-best-practices)
- [---](#email-cache-1)
- [Sistema Cache Email ](#email-cache)
- [---](#email-html-best-practices-1)
- [Best Practices HTML per Email](#email-html-best-practices)
- [Email Integration](#email-integration)
- [---](#email-logs-1)
- [Sistema Log Email ](#email-logs)
- [---](#email-monitoring-1)
- [Sistema Monitoraggio Email ](#email-monitoring)
- [---](#email-notifications-1)
- [Sistema Notifiche Email - il progetto](#email-notifications)
- [---](#email-plugins-analysis-1)
- [Analisi Plugin Email per Filament - il progetto](#email-plugins-analysis)
- [Analisi Plugin Email per Filament - il progetto](#email-plugins)
- [---](#email-queue-1)
- [Sistema Code Email - il progetto](#email-queue)
- [---](#email-sending-troubleshooting-1)
- [Troubleshooting: Sistema di Invio Email in Notify](#email-sending-troubleshooting)
- [---](#email-translations-1)
- [Integrazione Traduzioni Email - il progetto](#email-translations)
- [---](#email-wysiwyg-editor-1)
- [Editor WYSIWYG per Email - il progetto](#email-wysiwyg-editor)
- [Analytics Email - il progetto](#email_analytics)
- [Sistema Backup Email ](#email_backup)
- [Best Practices per il Sistema Email](#email_best_practices)
- [Sistema Cache Email ](#email_cache)
- [Best Practices HTML per Email](#email_html_best_practices)
- [Sistema Log Email ](#email_logs)
- [Sistema Monitoraggio Email ](#email_monitoring)
- [Sistema Notifiche Email - il progetto](#email_notifications)
- [Analisi Plugin Email per Filament - il progetto](#email_plugins_analysis)
- [Sistema Code Email - il progetto](#email_queue)
- [Troubleshooting: Sistema di Invio Email in Notify](#email_sending_troubleshooting)
- [Integrazione Traduzioni Email - il progetto](#email_translations)
- [Editor WYSIWYG per Email - il progetto](#email_wysiwyg_editor)

---

## email-analytics-1

*Consolidated from: `email-analytics.md`*

title: "Analytics Email - il progetto"
type: concept
tags: [email, analytics]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-analytics-1 analytics email - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Analytics Email - il progetto

## Panoramica

Sistema di tracciamento e analisi per le email in il progetto.

## Struttura Database

### 1. Tabelle

```php
// database/migrations/create_notify_mail_stats_table.php
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('recipient_email');
    $table->string('status');
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('opened_at')->nullable();
    $table->timestamp('clicked_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('device_type')->nullable();
    $table->string('browser')->nullable();
    $table->string('platform')->nullable();
    $table->string('ip_address')->nullable();
    $table->timestamps();
});

// database/migrations/create_notify_mail_links_table.php
Schema::create('notify_mail_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('original_url');
    $table->string('tracking_url');
    $table->integer('clicks')->default(0);
    $table->timestamps();
});
```

### 2. Modelli

```php
namespace Modules\Notify\Models;

class MailStat extends Model
{
    protected $fillable = [
        'mail_template_id',
        'recipient_email',
        'status',
        'sent_at',
        'opened_at',
        'clicked_at',
        'clicked_links',
        'device_type',
        'browser',
        'platform',
        'ip_address',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'clicked_links' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}

class MailLink extends Model
{
    protected $fillable = [
        'mail_template_id',
        'original_url',
        'tracking_url',
        'clicks',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}
```

## Tracciamento

### 1. Tracking Service

```php
namespace Modules\Notify\Services;

class MailTrackingService
{
    public function trackOpen(MailStat $stat): void
    {
        $stat->update([
            'opened_at' => now(),
            'device_type' => $this->getDeviceType(),
            'browser' => $this->getBrowser(),
            'platform' => $this->getPlatform(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function trackClick(MailStat $stat, string $url): void
    {
        $clickedLinks = $stat->clicked_links ?? [];
        $clickedLinks[] = [
            'url' => $url,
            'clicked_at' => now(),
        ];

        $stat->update([
            'clicked_at' => now(),
            'clicked_links' => $clickedLinks,
        ]);

        MailLink::where('tracking_url', $url)
            ->increment('clicks');
    }

    protected function getDeviceType(): string
    {
        $userAgent = request()->userAgent();
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
            return 'tablet';
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }
}
```

### 2. Tracking Pixel

```php
namespace Modules\Notify\Http\Controllers;

class TrackingController extends Controller
{
    public function pixel(string $statId)
    {
        $stat = MailStat::findOrFail($statId);
        
        app(MailTrackingService::class)->trackOpen($stat);
        
        return response()->file(
            public_path('images/pixel.gif'),
            ['Content-Type' => 'image/gif']
        );
    }

    public function click(string $linkId)
    {
        $link = MailLink::findOrFail($linkId);
        $stat = MailStat::where('mail_template_id', $link->mail_template_id)
            ->where('recipient_email', request()->query('email'))
            ->firstOrFail();
        
        app(MailTrackingService::class)->trackClick($stat, $link->tracking_url);
        
        return redirect($link->original_url);
    }
}
```

## Analytics

### 1. Analytics Service

```php
namespace Modules\Notify\Services;

class MailAnalyticsService
{
    public function getTemplateStats(MailTemplate $template): array
    {
        return [
            'total_sent' => $this->getTotalSent($template),
            'open_rate' => $this->getOpenRate($template),
            'click_rate' => $this->getClickRate($template),
            'device_stats' => $this->getDeviceStats($template),
            'browser_stats' => $this->getBrowserStats($template),
            'platform_stats' => $this->getPlatformStats($template),
            'link_stats' => $this->getLinkStats($template),
        ];
    }

    protected function getOpenRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $opened = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('opened_at')
            ->count();
            
        return $total > 0 ? ($opened / $total) * 100 : 0;
    }

    protected function getClickRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $clicked = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('clicked_at')
            ->count();
            
        return $total > 0 ? ($clicked / $total) * 100 : 0;
    }
}
```

### 2. Analytics Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailAnalyticsResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Filtri
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->label('Template'),
                    
                DatePicker::make('from')
                    ->label('Da'),
                    
                DatePicker::make('to')
                    ->label('A'),
                    
                // Statistiche
                StatsOverview::make([
                    Stat::make('Totale Invii', fn () => $this->getTotalSent())
                        ->description('Email inviate')
                        ->descriptionIcon('heroicon-m-envelope'),
                        
                    Stat::make('Tasso Apertura', fn () => $this->getOpenRate())
                        ->description('Email aperte')
                        ->descriptionIcon('heroicon-m-eye'),
                        
                    Stat::make('Tasso Click', fn () => $this->getClickRate())
                        ->description('Link cliccati')
                        ->descriptionIcon('heroicon-m-cursor-arrow-rays'),
                ]),
                
                // Grafici
                Chart::make('Aperture per Giorno')
                    ->type('line')
                    ->data($this->getOpensByDay()),
                    
                Chart::make('Click per Link')
                    ->type('bar')
                    ->data($this->getClicksByLink()),
                    
                Chart::make('Dispositivi')
                    ->type('pie')
                    ->data($this->getDeviceStats()),
            ])
        ]);
    }
}
```

## Integrazione con Filament

### 1. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Analytics
            Action::make('analytics')
                ->label('Analytics')
                ->icon('heroicon-o-chart-bar')
                ->url(fn (MailTemplate $record) => route('filament.resources.mail-analytics.index', [
                    'template' => $record->id,
                ])),
                
            // Esporta dati
            Action::make('export_analytics')
                ->label('Esporta Dati')
                ->icon('heroicon-o-download')
                ->form([
                    Select::make('format')
                        ->options([
                            'csv' => 'CSV',
                            'excel' => 'Excel',
                            'json' => 'JSON',
                        ])
                        ->required(),
                        
                    DatePicker::make('from')
                        ->label('Da'),
                        
                    DatePicker::make('to')
                        ->label('A'),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    return $this->exportAnalytics($record, $data);
                }),
        ];
    }
}
```

### 2. Widgets

```php
namespace Modules\Notify\Filament\Widgets;

class MailAnalyticsWidget extends Widget
{
    protected static string $view = 'notify::widgets.mail-analytics';

    public function getStats(): array
    {
        return app(MailAnalyticsService::class)
            ->getTemplateStats($this->getTemplate());
    }

    protected function getTemplate(): MailTemplate
    {
        return MailTemplate::find($this->templateId);
    }
}
```

## Best Practices

### 1. Privacy

```php
class MailTrackingService
{
    public function anonymizeIp(string $ip): string
    {
        return preg_replace('/\.\d+$/', '.0', $ip);
    }

    public function shouldTrack(): bool
    {
        return !$this->isBot() && 
               !$this->isPreview() && 
               $this->hasConsent();
    }

    protected function isBot(): bool
    {
        return preg_match('/bot|crawl|spider/i', request()->userAgent());
    }

    protected function hasConsent(): bool
    {
        return request()->cookie('tracking_consent') === 'true';
    }
}
```

### 2. Performance

```php
class MailAnalyticsService
{
    public function getStats(): array
    {
        return Cache::remember('mail_stats', 3600, function () {
            return [
                'opens' => $this->getOpens(),
                'clicks' => $this->getClicks(),
                'devices' => $this->getDevices(),
            ];
        });
    }

    protected function getOpens(): Collection
    {
        return MailStat::select('opened_at')
            ->whereNotNull('opened_at')
            ->where('opened_at', '>=', now()->subDays(30))
            ->get()
            ->groupBy(fn ($stat) => $stat->opened_at->format('Y-m-d'))
            ->map->count();
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Tracking non funziona**
   - Verifica pixel
   - Controlla link
   - Debug headers

2. **Dati mancanti**
   - Verifica consenso
   - Controlla filtri
   - Debug cache

3. **Performance lenta**
   - Ottimizza query
   - Usa indici
   - Cache dati

### 2. Debug

```php
class MailTrackingService
{
    public function debug(): array
    {
        return [
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'headers' => request()->headers->all(),
            'cookies' => request()->cookies->all(),
            'is_bot' => $this->isBot(),
            'has_consent' => $this->hasConsent(),
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Analytics](https://github.com/spatie/laravel-analytics)
- [Laravel Mail Tracking](https://github.com/spatie/laravel-mail-tracking)
- [Laravel Mail Preview](https://github.com/spatie/laravel-mail-preview) 
---

## email-analytics

*Consolidated from: `email-analytics.md`*


## Panoramica

Sistema di tracciamento e analisi per le email in il progetto.

## Struttura Database

### 1. Tabelle

```php
// database/migrations/create_notify_mail_stats_table.php
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('recipient_email');
    $table->string('status');
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('opened_at')->nullable();
    $table->timestamp('clicked_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('device_type')->nullable();
    $table->string('browser')->nullable();
    $table->string('platform')->nullable();
    $table->string('ip_address')->nullable();
    $table->timestamps();
});

// database/migrations/create_notify_mail_links_table.php
Schema::create('notify_mail_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('original_url');
    $table->string('tracking_url');
    $table->integer('clicks')->default(0);
    $table->timestamps();
});
```

### 2. Modelli

```php
namespace Modules\Notify\Models;

class MailStat extends Model
{
    protected $fillable = [
        'mail_template_id',
        'recipient_email',
        'status',
        'sent_at',
        'opened_at',
        'clicked_at',
        'clicked_links',
        'device_type',
        'browser',
        'platform',
        'ip_address',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'clicked_links' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}

class MailLink extends Model
{
    protected $fillable = [
        'mail_template_id',
        'original_url',
        'tracking_url',
        'clicks',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}
```

## Tracciamento

### 1. Tracking Service

```php
namespace Modules\Notify\Services;

class MailTrackingService
{
    public function trackOpen(MailStat $stat): void
    {
        $stat->update([
            'opened_at' => now(),
            'device_type' => $this->getDeviceType(),
            'browser' => $this->getBrowser(),
            'platform' => $this->getPlatform(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function trackClick(MailStat $stat, string $url): void
    {
        $clickedLinks = $stat->clicked_links ?? [];
        $clickedLinks[] = [
            'url' => $url,
            'clicked_at' => now(),
        ];

        $stat->update([
            'clicked_at' => now(),
            'clicked_links' => $clickedLinks,
        ]);

        MailLink::where('tracking_url', $url)
            ->increment('clicks');
    }

    protected function getDeviceType(): string
    {
        $userAgent = request()->userAgent();
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
            return 'tablet';
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }
}
```

### 2. Tracking Pixel

```php
namespace Modules\Notify\Http\Controllers;

class TrackingController extends Controller
{
    public function pixel(string $statId)
    {
        $stat = MailStat::findOrFail($statId);
        
        app(MailTrackingService::class)->trackOpen($stat);
        
        return response()->file(
            public_path('images/pixel.gif'),
            ['Content-Type' => 'image/gif']
        );
    }

    public function click(string $linkId)
    {
        $link = MailLink::findOrFail($linkId);
        $stat = MailStat::where('mail_template_id', $link->mail_template_id)
            ->where('recipient_email', request()->query('email'))
            ->firstOrFail();
        
        app(MailTrackingService::class)->trackClick($stat, $link->tracking_url);
        
        return redirect($link->original_url);
    }
}
```

## Analytics

### 1. Analytics Service

```php
namespace Modules\Notify\Services;

class MailAnalyticsService
{
    public function getTemplateStats(MailTemplate $template): array
    {
        return [
            'total_sent' => $this->getTotalSent($template),
            'open_rate' => $this->getOpenRate($template),
            'click_rate' => $this->getClickRate($template),
            'device_stats' => $this->getDeviceStats($template),
            'browser_stats' => $this->getBrowserStats($template),
            'platform_stats' => $this->getPlatformStats($template),
            'link_stats' => $this->getLinkStats($template),
        ];
    }

    protected function getOpenRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $opened = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('opened_at')
            ->count();
            
        return $total > 0 ? ($opened / $total) * 100 : 0;
    }

    protected function getClickRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $clicked = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('clicked_at')
            ->count();
            
        return $total > 0 ? ($clicked / $total) * 100 : 0;
    }
}
```

### 2. Analytics Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailAnalyticsResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Filtri
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->label('Template'),
                    
                DatePicker::make('from')
                    ->label('Da'),
                    
                DatePicker::make('to')
                    ->label('A'),
                    
                // Statistiche
                StatsOverview::make([
                    Stat::make('Totale Invii', fn () => $this->getTotalSent())
                        ->description('Email inviate')
                        ->descriptionIcon('heroicon-m-envelope'),
                        
                    Stat::make('Tasso Apertura', fn () => $this->getOpenRate())
                        ->description('Email aperte')
                        ->descriptionIcon('heroicon-m-eye'),
                        
                    Stat::make('Tasso Click', fn () => $this->getClickRate())
                        ->description('Link cliccati')
                        ->descriptionIcon('heroicon-m-cursor-arrow-rays'),
                ]),
                
                // Grafici
                Chart::make('Aperture per Giorno')
                    ->type('line')
                    ->data($this->getOpensByDay()),
                    
                Chart::make('Click per Link')
                    ->type('bar')
                    ->data($this->getClicksByLink()),
                    
                Chart::make('Dispositivi')
                    ->type('pie')
                    ->data($this->getDeviceStats()),
            ])
        ]);
    }
}
```

## Integrazione con Filament

### 1. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Analytics
            Action::make('analytics')
                ->label('Analytics')
                ->icon('heroicon-o-chart-bar')
                ->url(fn (MailTemplate $record) => route('filament.resources.mail-analytics.index', [
                    'template' => $record->id,
                ])),
                
            // Esporta dati
            Action::make('export_analytics')
                ->label('Esporta Dati')
                ->icon('heroicon-o-download')
                ->form([
                    Select::make('format')
                        ->options([
                            'csv' => 'CSV',
                            'excel' => 'Excel',
                            'json' => 'JSON',
                        ])
                        ->required(),
                        
                    DatePicker::make('from')
                        ->label('Da'),
                        
                    DatePicker::make('to')
                        ->label('A'),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    return $this->exportAnalytics($record, $data);
                }),
        ];
    }
}
```

### 2. Widgets

```php
namespace Modules\Notify\Filament\Widgets;

class MailAnalyticsWidget extends Widget
{
    protected static string $view = 'notify::widgets.mail-analytics';

    public function getStats(): array
    {
        return app(MailAnalyticsService::class)
            ->getTemplateStats($this->getTemplate());
    }

    protected function getTemplate(): MailTemplate
    {
        return MailTemplate::find($this->templateId);
    }
}
```

## Best Practices

### 1. Privacy

```php
class MailTrackingService
{
    public function anonymizeIp(string $ip): string
    {
        return preg_replace('/\.\d+$/', '.0', $ip);
    }

    public function shouldTrack(): bool
    {
        return !$this->isBot() && 
               !$this->isPreview() && 
               $this->hasConsent();
    }

    protected function isBot(): bool
    {
        return preg_match('/bot|crawl|spider/i', request()->userAgent());
    }

    protected function hasConsent(): bool
    {
        return request()->cookie('tracking_consent') === 'true';
    }
}
```

### 2. Performance

```php
class MailAnalyticsService
{
    public function getStats(): array
    {
        return Cache::remember('mail_stats', 3600, function () {
            return [
                'opens' => $this->getOpens(),
                'clicks' => $this->getClicks(),
                'devices' => $this->getDevices(),
            ];
        });
    }

    protected function getOpens(): Collection
    {
        return MailStat::select('opened_at')
            ->whereNotNull('opened_at')
            ->where('opened_at', '>=', now()->subDays(30))
            ->get()
            ->groupBy(fn ($stat) => $stat->opened_at->format('Y-m-d'))
            ->map->count();
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Tracking non funziona**
   - Verifica pixel
   - Controlla link
   - Debug headers

2. **Dati mancanti**
   - Verifica consenso
   - Controlla filtri
   - Debug cache

3. **Performance lenta**
   - Ottimizza query
   - Usa indici
   - Cache dati

### 2. Debug

```php
class MailTrackingService
{
    public function debug(): array
    {
        return [
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'headers' => request()->headers->all(),
            'cookies' => request()->cookies->all(),
            'is_bot' => $this->isBot(),
            'has_consent' => $this->hasConsent(),
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Analytics](https://github.com/spatie/laravel-analytics)
- [Laravel Mail Tracking](https://github.com/spatie/laravel-mail-tracking)
- [Laravel Mail Preview](https://github.com/spatie/laravel-mail-preview) 
---

## email-backup-1

*Consolidated from: `email-backup.md`*


## Panoramica

Sistema di backup per preservare e ripristinare i template email.

## Backup Template

### 1. Template Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;

class MailTemplateBackup
{
    protected const BACKUP_PATH = 'backups/templates';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailTemplate $template): string
    {
        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'content' => $template->content,
            'created_at' => $template->created_at,
            'updated_at' => $template->updated_at,
        ];

        $filename = $this->generateBackupFilename($template);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailTemplate
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);

        return MailTemplate::updateOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['name'],
                'version' => $data['version'],
                'content' => $data['content'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailTemplate $template): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $template->id,
            $template->name,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Template Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateBackup;

class MailTemplateBackupCommand extends Command
{
    protected $signature = 'mail:backup-templates';
    protected $description = 'Backup di tutti i template email';

    protected $backup;

    public function __construct(MailTemplateBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $templates = MailTemplate::all();
        $bar = $this->output->createProgressBar(count($templates));

        $this->info('Inizio backup template...');
        $bar->start();

        foreach ($templates as $template) {
            $this->backup->createBackup($template);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup template completato!');
    }
}
```

## Backup Notifiche

### 1. Notifiche Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailNotification;

class MailNotificationBackup
{
    protected const BACKUP_PATH = 'backups/notifications';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailNotification $notification): string
    {
        $data = [
            'id' => $notification->id,
            'template_id' => $notification->template_id,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'opened_at' => $notification->opened_at,
            'clicked_at' => $notification->clicked_at,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
        ];

        $filename = $this->generateBackupFilename($notification);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailNotification
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);

        return MailNotification::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'sent_at' => $data['sent_at'],
                'opened_at' => $data['opened_at'],
                'clicked_at' => $data['clicked_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailNotification $notification): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $notification->id,
            $notification->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Notifiche Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationBackup;

class MailNotificationBackupCommand extends Command
{
    protected $signature = 'mail:backup-notifications';
    protected $description = 'Backup di tutte le notifiche email';

    protected $backup;

    public function __construct(MailNotificationBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $notifications = MailNotification::all();
        $bar = $this->output->createProgressBar(count($notifications));

        $this->info('Inizio backup notifiche...');
        $bar->start();

        foreach ($notifications as $notification) {
            $this->backup->createBackup($notification);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup notifiche completato!');
    }
}
```

## Backup Queue

### 1. Queue Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailQueue;

class MailQueueBackup
{
    protected const BACKUP_PATH = 'backups/queue';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailQueue $job): string
    {
        $data = [
            'id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'error' => $job->error,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];

        $filename = $this->generateBackupFilename($job);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailQueue
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);

        return MailQueue::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'attempts' => $data['attempts'],
                'error' => $data['error'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailQueue $job): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $job->id,
            $job->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Queue Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueBackup;

class MailQueueBackupCommand extends Command
{
    protected $signature = 'mail:backup-queue';
    protected $description = 'Backup della coda email';

    protected $backup;

    public function __construct(MailQueueBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $jobs = MailQueue::all();
        $bar = $this->output->createProgressBar(count($jobs));

        $this->info('Inizio backup coda...');
        $bar->start();

        foreach ($jobs as $job) {
            $this->backup->createBackup($job);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup coda completato!');
    }
}
```

## Best Practices

### 1. Backup Retention

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MailBackupRetention
{
    protected const RETENTION_DAYS = 30;

    public function cleanup(): void
    {
        $this->cleanupTemplates();
        $this->cleanupNotifications();
        $this->cleanupQueue();
    }

    protected function cleanupTemplates(): void
    {
        $files = Storage::files('backups/templates');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupNotifications(): void
    {
        $files = Storage::files('backups/notifications');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupQueue(): void
    {
        $files = Storage::files('backups/queue');
        $this->deleteExpiredFiles($files);
    }

    protected function deleteExpiredFiles(array $files): void
    {
        $expiryDate = Carbon::now()->subDays(self::RETENTION_DAYS);

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $expiryDate->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
```

### 2. Backup Encryption

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class MailBackupEncryption
{
    public function encrypt(string $path): void
    {
        if (!Storage::exists($path)) {
            return;
        }

        $content = Storage::get($path);
        $encrypted = Crypt::encryptString($content);

        Storage::put($path, $encrypted);
    }

    public function decrypt(string $path): ?string
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $encrypted = Storage::get($path);

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Backup Falliti**
   - Verifica spazio
   - Controlla permessi
   - Debug errori

2. **Ripristino Fallito**
   - Verifica integrità
   - Controlla versioni
   - Debug errori

3. **Performance**
   - Ottimizza spazio
   - Gestisci retention
   - Monitora backup

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailBackupDebugger
{
    protected $templateBackup;
    protected $notificationBackup;
    protected $queueBackup;
    protected $retention;
    protected $encryption;

    public function __construct(
        MailTemplateBackup $templateBackup,
        MailNotificationBackup $notificationBackup,
        MailQueueBackup $queueBackup,
        MailBackupRetention $retention,
        MailBackupEncryption $encryption
    ) {
        $this->templateBackup = $templateBackup;
        $this->notificationBackup = $notificationBackup;
        $this->queueBackup = $queueBackup;
        $this->retention = $retention;
        $this->encryption = $encryption;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'storage' => $this->debugStorage(),
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
                'backups' => $this->templateBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'status' => $notification->status,
                'backups' => $this->notificationBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'backups' => $this->queueBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugStorage(): array
    {
        return [
            'templates' => [
                'path' => 'backups/templates',
                'size' => $this->getDirectorySize('backups/templates'),
                'count' => count(Storage::files('backups/templates')),
            ],
            'notifications' => [
                'path' => 'backups/notifications',
                'size' => $this->getDirectorySize('backups/notifications'),
                'count' => count(Storage::files('backups/notifications')),
            ],
            'queue' => [
                'path' => 'backups/queue',
                'size' => $this->getDirectorySize('backups/queue'),
                'count' => count(Storage::files('backups/queue')),
            ],
        ];
    }

    protected function getDirectorySize(string $path): int
    {
        $size = 0;
        $files = Storage::files($path);

        foreach ($files as $file) {
            $size += Storage::size($file);
        }

        return $size;
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan)

---

## email-backup-2

*Consolidated from: `email-backup.md`*

title: "Sistema Backup Email"
type: concept
tags: [email, backup]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-backup-2 sistema backup email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Sistema Backup Email 

## Panoramica

Sistema di backup per preservare e ripristinare i template email.

## Backup Template

### 1. Template Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;

class MailTemplateBackup
{
    protected const BACKUP_PATH = 'backups/templates';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailTemplate $template): string
    {
        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'content' => $template->content,
            'created_at' => $template->created_at,
            'updated_at' => $template->updated_at,
        ];

        $filename = $this->generateBackupFilename($template);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailTemplate
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailTemplate::updateOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['name'],
                'version' => $data['version'],
                'content' => $data['content'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailTemplate $template): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $template->id,
            $template->name,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Template Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateBackup;

class MailTemplateBackupCommand extends Command
{
    protected $signature = 'mail:backup-templates';
    protected $description = 'Backup di tutti i template email';

    protected $backup;

    public function __construct(MailTemplateBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $templates = MailTemplate::all();
        $bar = $this->output->createProgressBar(count($templates));

        $this->info('Inizio backup template...');
        $bar->start();

        foreach ($templates as $template) {
            $this->backup->createBackup($template);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup template completato!');
    }
}
```

## Backup Notifiche

### 1. Notifiche Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailNotification;

class MailNotificationBackup
{
    protected const BACKUP_PATH = 'backups/notifications';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailNotification $notification): string
    {
        $data = [
            'id' => $notification->id,
            'template_id' => $notification->template_id,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'opened_at' => $notification->opened_at,
            'clicked_at' => $notification->clicked_at,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
        ];

        $filename = $this->generateBackupFilename($notification);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailNotification
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailNotification::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'sent_at' => $data['sent_at'],
                'opened_at' => $data['opened_at'],
                'clicked_at' => $data['clicked_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailNotification $notification): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $notification->id,
            $notification->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Notifiche Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationBackup;

class MailNotificationBackupCommand extends Command
{
    protected $signature = 'mail:backup-notifications';
    protected $description = 'Backup di tutte le notifiche email';

    protected $backup;

    public function __construct(MailNotificationBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $notifications = MailNotification::all();
        $bar = $this->output->createProgressBar(count($notifications));

        $this->info('Inizio backup notifiche...');
        $bar->start();

        foreach ($notifications as $notification) {
            $this->backup->createBackup($notification);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup notifiche completato!');
    }
}
```

## Backup Queue

### 1. Queue Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailQueue;

class MailQueueBackup
{
    protected const BACKUP_PATH = 'backups/queue';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailQueue $job): string
    {
        $data = [
            'id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'error' => $job->error,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];

        $filename = $this->generateBackupFilename($job);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailQueue
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailQueue::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'attempts' => $data['attempts'],
                'error' => $data['error'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailQueue $job): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $job->id,
            $job->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Queue Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueBackup;

class MailQueueBackupCommand extends Command
{
    protected $signature = 'mail:backup-queue';
    protected $description = 'Backup della coda email';

    protected $backup;

    public function __construct(MailQueueBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $jobs = MailQueue::all();
        $bar = $this->output->createProgressBar(count($jobs));

        $this->info('Inizio backup coda...');
        $bar->start();

        foreach ($jobs as $job) {
            $this->backup->createBackup($job);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup coda completato!');
    }
}
```

## Best Practices

### 1. Backup Retention

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MailBackupRetention
{
    protected const RETENTION_DAYS = 30;

    public function cleanup(): void
    {
        $this->cleanupTemplates();
        $this->cleanupNotifications();
        $this->cleanupQueue();
    }

    protected function cleanupTemplates(): void
    {
        $files = Storage::files('backups/templates');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupNotifications(): void
    {
        $files = Storage::files('backups/notifications');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupQueue(): void
    {
        $files = Storage::files('backups/queue');
        $this->deleteExpiredFiles($files);
    }

    protected function deleteExpiredFiles(array $files): void
    {
        $expiryDate = Carbon::now()->subDays(self::RETENTION_DAYS);

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $expiryDate->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
```

### 2. Backup Encryption

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class MailBackupEncryption
{
    public function encrypt(string $path): void
    {
        if (!Storage::exists($path)) {
            return;
        }

        $content = Storage::get($path);
        $encrypted = Crypt::encryptString($content);

        Storage::put($path, $encrypted);
    }

    public function decrypt(string $path): ?string
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $encrypted = Storage::get($path);

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Backup Falliti**
   - Verifica spazio
   - Controlla permessi
   - Debug errori

2. **Ripristino Fallito**
   - Verifica integrità
   - Controlla versioni
   - Debug errori

3. **Performance**
   - Ottimizza spazio
   - Gestisci retention
   - Monitora backup

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailBackupDebugger
{
    protected $templateBackup;
    protected $notificationBackup;
    protected $queueBackup;
    protected $retention;
    protected $encryption;

    public function __construct(
        MailTemplateBackup $templateBackup,
        MailNotificationBackup $notificationBackup,
        MailQueueBackup $queueBackup,
        MailBackupRetention $retention,
        MailBackupEncryption $encryption
    ) {
        $this->templateBackup = $templateBackup;
        $this->notificationBackup = $notificationBackup;
        $this->queueBackup = $queueBackup;
        $this->retention = $retention;
        $this->encryption = $encryption;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'storage' => $this->debugStorage(),
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
                'backups' => $this->templateBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'status' => $notification->status,
                'backups' => $this->notificationBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'backups' => $this->queueBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugStorage(): array
    {
        return [
            'templates' => [
                'path' => 'backups/templates',
                'size' => $this->getDirectorySize('backups/templates'),
                'count' => count(Storage::files('backups/templates')),
            ],
            'notifications' => [
                'path' => 'backups/notifications',
                'size' => $this->getDirectorySize('backups/notifications'),
                'count' => count(Storage::files('backups/notifications')),
            ],
            'queue' => [
                'path' => 'backups/queue',
                'size' => $this->getDirectorySize('backups/queue'),
                'count' => count(Storage::files('backups/queue')),
            ],
        ];
    }

    protected function getDirectorySize(string $path): int
    {
        $size = 0;
        $files = Storage::files($path);

        foreach ($files as $file) {
            $size += Storage::size($file);
        }

        return $size;
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
---

## email-backup

*Consolidated from: `email-backup.md`*


## Panoramica

Sistema di backup per preservare e ripristinare i template email.

## Backup Template

### 1. Template Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;

class MailTemplateBackup
{
    protected const BACKUP_PATH = 'backups/templates';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailTemplate $template): string
    {
        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'content' => $template->content,
            'created_at' => $template->created_at,
            'updated_at' => $template->updated_at,
        ];

        $filename = $this->generateBackupFilename($template);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailTemplate
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailTemplate::updateOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['name'],
                'version' => $data['version'],
                'content' => $data['content'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailTemplate $template): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $template->id,
            $template->name,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Template Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateBackup;

class MailTemplateBackupCommand extends Command
{
    protected $signature = 'mail:backup-templates';
    protected $description = 'Backup di tutti i template email';

    protected $backup;

    public function __construct(MailTemplateBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $templates = MailTemplate::all();
        $bar = $this->output->createProgressBar(count($templates));

        $this->info('Inizio backup template...');
        $bar->start();

        foreach ($templates as $template) {
            $this->backup->createBackup($template);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup template completato!');
    }
}
```

## Backup Notifiche

### 1. Notifiche Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailNotification;

class MailNotificationBackup
{
    protected const BACKUP_PATH = 'backups/notifications';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailNotification $notification): string
    {
        $data = [
            'id' => $notification->id,
            'template_id' => $notification->template_id,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'opened_at' => $notification->opened_at,
            'clicked_at' => $notification->clicked_at,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
        ];

        $filename = $this->generateBackupFilename($notification);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailNotification
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailNotification::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'sent_at' => $data['sent_at'],
                'opened_at' => $data['opened_at'],
                'clicked_at' => $data['clicked_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailNotification $notification): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $notification->id,
            $notification->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Notifiche Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationBackup;

class MailNotificationBackupCommand extends Command
{
    protected $signature = 'mail:backup-notifications';
    protected $description = 'Backup di tutte le notifiche email';

    protected $backup;

    public function __construct(MailNotificationBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $notifications = MailNotification::all();
        $bar = $this->output->createProgressBar(count($notifications));

        $this->info('Inizio backup notifiche...');
        $bar->start();

        foreach ($notifications as $notification) {
            $this->backup->createBackup($notification);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup notifiche completato!');
    }
}
```

## Backup Queue

### 1. Queue Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailQueue;

class MailQueueBackup
{
    protected const BACKUP_PATH = 'backups/queue';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailQueue $job): string
    {
        $data = [
            'id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'error' => $job->error,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];

        $filename = $this->generateBackupFilename($job);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailQueue
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailQueue::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'attempts' => $data['attempts'],
                'error' => $data['error'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailQueue $job): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $job->id,
            $job->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Queue Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueBackup;

class MailQueueBackupCommand extends Command
{
    protected $signature = 'mail:backup-queue';
    protected $description = 'Backup della coda email';

    protected $backup;

    public function __construct(MailQueueBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $jobs = MailQueue::all();
        $bar = $this->output->createProgressBar(count($jobs));

        $this->info('Inizio backup coda...');
        $bar->start();

        foreach ($jobs as $job) {
            $this->backup->createBackup($job);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup coda completato!');
    }
}
```

## Best Practices

### 1. Backup Retention

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MailBackupRetention
{
    protected const RETENTION_DAYS = 30;

    public function cleanup(): void
    {
        $this->cleanupTemplates();
        $this->cleanupNotifications();
        $this->cleanupQueue();
    }

    protected function cleanupTemplates(): void
    {
        $files = Storage::files('backups/templates');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupNotifications(): void
    {
        $files = Storage::files('backups/notifications');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupQueue(): void
    {
        $files = Storage::files('backups/queue');
        $this->deleteExpiredFiles($files);
    }

    protected function deleteExpiredFiles(array $files): void
    {
        $expiryDate = Carbon::now()->subDays(self::RETENTION_DAYS);

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $expiryDate->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
```

### 2. Backup Encryption

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class MailBackupEncryption
{
    public function encrypt(string $path): void
    {
        if (!Storage::exists($path)) {
            return;
        }

        $content = Storage::get($path);
        $encrypted = Crypt::encryptString($content);

        Storage::put($path, $encrypted);
    }

    public function decrypt(string $path): ?string
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $encrypted = Storage::get($path);

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Backup Falliti**
   - Verifica spazio
   - Controlla permessi
   - Debug errori

2. **Ripristino Fallito**
   - Verifica integrità
   - Controlla versioni
   - Debug errori

3. **Performance**
   - Ottimizza spazio
   - Gestisci retention
   - Monitora backup

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailBackupDebugger
{
    protected $templateBackup;
    protected $notificationBackup;
    protected $queueBackup;
    protected $retention;
    protected $encryption;

    public function __construct(
        MailTemplateBackup $templateBackup,
        MailNotificationBackup $notificationBackup,
        MailQueueBackup $queueBackup,
        MailBackupRetention $retention,
        MailBackupEncryption $encryption
    ) {
        $this->templateBackup = $templateBackup;
        $this->notificationBackup = $notificationBackup;
        $this->queueBackup = $queueBackup;
        $this->retention = $retention;
        $this->encryption = $encryption;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'storage' => $this->debugStorage(),
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
                'backups' => $this->templateBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'status' => $notification->status,
                'backups' => $this->notificationBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'backups' => $this->queueBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugStorage(): array
    {
        return [
            'templates' => [
                'path' => 'backups/templates',
                'size' => $this->getDirectorySize('backups/templates'),
                'count' => count(Storage::files('backups/templates')),
            ],
            'notifications' => [
                'path' => 'backups/notifications',
                'size' => $this->getDirectorySize('backups/notifications'),
                'count' => count(Storage::files('backups/notifications')),
            ],
            'queue' => [
                'path' => 'backups/queue',
                'size' => $this->getDirectorySize('backups/queue'),
                'count' => count(Storage::files('backups/queue')),
            ],
        ];
    }

    protected function getDirectorySize(string $path): int
    {
        $size = 0;
        $files = Storage::files($path);

        foreach ($files as $file) {
            $size += Storage::size($file);
        }

        return $size;
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan) 
---

## email-best-practices-1

*Consolidated from: `email-best-practices.md`*

title: "Best Practices per il Sistema Email"
type: concept
tags: [email, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-best-practices-1 best practices per il sistema email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Best Practices per il Sistema Email

## Migrazioni Database

### Struttura Standard
- Utilizzare sempre `XotBaseMigration` come base
- Implementare modifiche nella sezione `tableUpdate`
- Non creare nuove migrazioni per modifiche a tabelle esistenti

### Gestione Campi
- Verificare l'esistenza delle colonne prima di modificarle
- Utilizzare i metodi helper forniti da `XotBaseMigration`
- Documentare tutte le modifiche alle strutture

### Compatibilità
- Mantenere la retrocompatibilità
- Gestire correttamente i rollback
- Testare le migrazioni in ambiente di sviluppo 

---

## email-best-practices

*Consolidated from: `email-best-practices.md`*


## Migrazioni Database

### Struttura Standard
- Utilizzare sempre `XotBaseMigration` come base
- Implementare modifiche nella sezione `tableUpdate`
- Non creare nuove migrazioni per modifiche a tabelle esistenti

### Gestione Campi
- Verificare l'esistenza delle colonne prima di modificarle
- Utilizzare i metodi helper forniti da `XotBaseMigration`
- Documentare tutte le modifiche alle strutture

### Compatibilità
- Mantenere la retrocompatibilità
- Gestire correttamente i rollback
- Testare le migrazioni in ambiente di sviluppo 

---

## email-cache-1

*Consolidated from: `email-cache.md`*

title: "Sistema Cache Email"
type: concept
tags: [email, cache]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-cache-1 sistema cache email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Sistema Cache Email 

## Panoramica

Sistema di cache per ottimizzare le performance delle email.

## Cache Template

### 1. Template Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;

class MailTemplateCache
{
    protected const CACHE_TAG = 'mail-templates';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getTemplate(int $id): ?MailTemplate
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putTemplate(MailTemplate $template): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($template->id),
            $template,
            self::CACHE_TTL
        );
    }

    public function forgetTemplate(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getTemplateStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementTemplateStats(int $id, string $stat): void
    {
        $stats = $this->getTemplateStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "template:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "template:{$id}:stats";
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateCache;

class MailTemplateObserver
{
    protected $cache;

    public function __construct(MailTemplateCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailTemplate $template): void
    {
        $this->cache->putTemplate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->cache->forgetTemplate($template->id);
    }
}
```

## Cache Notifiche

### 1. Notifiche Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailNotification;

class MailNotificationCache
{
    protected const CACHE_TAG = 'mail-notifications';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getNotification(int $id): ?MailNotification
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putNotification(MailNotification $notification): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($notification->id),
            $notification,
            self::CACHE_TTL
        );
    }

    public function forgetNotification(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getNotificationStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementNotificationStats(int $id, string $stat): void
    {
        $stats = $this->getNotificationStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "notification:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "notification:{$id}:stats";
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationCache;

class MailNotificationObserver
{
    protected $cache;

    public function __construct(MailNotificationCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailNotification $notification): void
    {
        $this->cache->putNotification($notification);
    }

    public function deleted(MailNotification $notification): void
    {
        $this->cache->forgetNotification($notification->id);
    }
}
```

## Cache Queue

### 1. Queue Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailQueue;

class MailQueueCache
{
    protected const CACHE_TAG = 'mail-queue';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getQueueStats(): array
    {
        return Cache::tags(self::CACHE_TAG)->get('queue:stats') ?? [];
    }

    public function incrementQueueStats(string $stat): void
    {
        $stats = $this->getQueueStats();
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            'queue:stats',
            $stats,
            self::CACHE_TTL
        );
    }

    public function getQueueJob(int $id): ?MailQueue
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putQueueJob(MailQueue $job): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($job->id),
            $job,
            self::CACHE_TTL
        );
    }

    public function forgetQueueJob(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    protected function getCacheKey(int $id): string
    {
        return "queue:job:{$id}";
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueCache;

class MailQueueObserver
{
    protected $cache;

    public function __construct(MailQueueCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailQueue $job): void
    {
        $this->cache->putQueueJob($job);
    }

    public function deleted(MailQueue $job): void
    {
        $this->cache->forgetQueueJob($job->id);
    }
}
```

## Best Practices

### 1. Cache Tags

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheTags
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $tag) {
            Cache::tags($tag)->flush();
        }
    }
}
```

### 2. Cache Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateCached
{
    use SerializesModels;

    public $template;

    public function __construct(MailTemplate $template)
    {
        $this->template = $template;
    }
}

class MailNotificationCached
{
    use SerializesModels;

    public $notification;

    public function __construct(MailNotification $notification)
    {
        $this->notification = $notification;
    }
}

class MailQueueCached
{
    use SerializesModels;

    public $job;

    public function __construct(MailQueue $job)
    {
        $this->job = $job;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Cache non aggiornata**
   - Verifica TTL
   - Controlla tags
   - Debug cache

2. **Performance**
   - Monitora memoria
   - Ottimizza TTL
   - Usa tags

3. **Debug**
   - Verifica chiavi
   - Controlla valori
   - Monitora hit/miss

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheDebugger
{
    protected $templateCache;
    protected $notificationCache;
    protected $queueCache;

    public function __construct(
        MailTemplateCache $templateCache,
        MailNotificationCache $notificationCache,
        MailQueueCache $queueCache
    ) {
        $this->templateCache = $templateCache;
        $this->notificationCache = $notificationCache;
        $this->queueCache = $queueCache;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'stats' => $this->debugStats(),
        ];
    }

    protected function debugTemplates(): array
    {
        $debug = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $debug[$template->id] = [
                'cached' => Cache::tags(MailCacheTags::TEMPLATES)->has($this->templateCache->getCacheKey($template->id)),
                'stats' => $this->templateCache->getTemplateStats($template->id),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'cached' => Cache::tags(MailCacheTags::NOTIFICATIONS)->has($this->notificationCache->getCacheKey($notification->id)),
                'stats' => $this->notificationCache->getNotificationStats($notification->id),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'cached' => Cache::tags(MailCacheTags::QUEUE)->has($this->queueCache->getCacheKey($job->id)),
            ];
        }

        return $debug;
    }

    protected function debugStats(): array
    {
        return [
            'templates' => [
                'hit' => Cache::tags(MailCacheTags::TEMPLATES)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::TEMPLATES)->get('miss') ?? 0,
            ],
            'notifications' => [
                'hit' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('miss') ?? 0,
            ],
            'queue' => [
                'hit' => Cache::tags(MailCacheTags::QUEUE)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::QUEUE)->get('miss') ?? 0,
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
---

## email-cache

*Consolidated from: `email-cache.md`*


## Panoramica

Sistema di cache per ottimizzare le performance delle email.

## Cache Template

### 1. Template Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;

class MailTemplateCache
{
    protected const CACHE_TAG = 'mail-templates';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getTemplate(int $id): ?MailTemplate
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putTemplate(MailTemplate $template): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($template->id),
            $template,
            self::CACHE_TTL
        );
    }

    public function forgetTemplate(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getTemplateStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementTemplateStats(int $id, string $stat): void
    {
        $stats = $this->getTemplateStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "template:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "template:{$id}:stats";
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateCache;

class MailTemplateObserver
{
    protected $cache;

    public function __construct(MailTemplateCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailTemplate $template): void
    {
        $this->cache->putTemplate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->cache->forgetTemplate($template->id);
    }
}
```

## Cache Notifiche

### 1. Notifiche Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailNotification;

class MailNotificationCache
{
    protected const CACHE_TAG = 'mail-notifications';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getNotification(int $id): ?MailNotification
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putNotification(MailNotification $notification): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($notification->id),
            $notification,
            self::CACHE_TTL
        );
    }

    public function forgetNotification(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getNotificationStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementNotificationStats(int $id, string $stat): void
    {
        $stats = $this->getNotificationStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "notification:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "notification:{$id}:stats";
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationCache;

class MailNotificationObserver
{
    protected $cache;

    public function __construct(MailNotificationCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailNotification $notification): void
    {
        $this->cache->putNotification($notification);
    }

    public function deleted(MailNotification $notification): void
    {
        $this->cache->forgetNotification($notification->id);
    }
}
```

## Cache Queue

### 1. Queue Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailQueue;

class MailQueueCache
{
    protected const CACHE_TAG = 'mail-queue';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getQueueStats(): array
    {
        return Cache::tags(self::CACHE_TAG)->get('queue:stats') ?? [];
    }

    public function incrementQueueStats(string $stat): void
    {
        $stats = $this->getQueueStats();
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            'queue:stats',
            $stats,
            self::CACHE_TTL
        );
    }

    public function getQueueJob(int $id): ?MailQueue
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putQueueJob(MailQueue $job): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($job->id),
            $job,
            self::CACHE_TTL
        );
    }

    public function forgetQueueJob(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    protected function getCacheKey(int $id): string
    {
        return "queue:job:{$id}";
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueCache;

class MailQueueObserver
{
    protected $cache;

    public function __construct(MailQueueCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailQueue $job): void
    {
        $this->cache->putQueueJob($job);
    }

    public function deleted(MailQueue $job): void
    {
        $this->cache->forgetQueueJob($job->id);
    }
}
```

## Best Practices

### 1. Cache Tags

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheTags
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $tag) {
            Cache::tags($tag)->flush();
        }
    }
}
```

### 2. Cache Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateCached
{
    use SerializesModels;

    public $template;

    public function __construct(MailTemplate $template)
    {
        $this->template = $template;
    }
}

class MailNotificationCached
{
    use SerializesModels;

    public $notification;

    public function __construct(MailNotification $notification)
    {
        $this->notification = $notification;
    }
}

class MailQueueCached
{
    use SerializesModels;

    public $job;

    public function __construct(MailQueue $job)
    {
        $this->job = $job;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Cache non aggiornata**
   - Verifica TTL
   - Controlla tags
   - Debug cache

2. **Performance**
   - Monitora memoria
   - Ottimizza TTL
   - Usa tags

3. **Debug**
   - Verifica chiavi
   - Controlla valori
   - Monitora hit/miss

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheDebugger
{
    protected $templateCache;
    protected $notificationCache;
    protected $queueCache;

    public function __construct(
        MailTemplateCache $templateCache,
        MailNotificationCache $notificationCache,
        MailQueueCache $queueCache
    ) {
        $this->templateCache = $templateCache;
        $this->notificationCache = $notificationCache;
        $this->queueCache = $queueCache;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'stats' => $this->debugStats(),
        ];
    }

    protected function debugTemplates(): array
    {
        $debug = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $debug[$template->id] = [
                'cached' => Cache::tags(MailCacheTags::TEMPLATES)->has($this->templateCache->getCacheKey($template->id)),
                'stats' => $this->templateCache->getTemplateStats($template->id),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'cached' => Cache::tags(MailCacheTags::NOTIFICATIONS)->has($this->notificationCache->getCacheKey($notification->id)),
                'stats' => $this->notificationCache->getNotificationStats($notification->id),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'cached' => Cache::tags(MailCacheTags::QUEUE)->has($this->queueCache->getCacheKey($job->id)),
            ];
        }

        return $debug;
    }

    protected function debugStats(): array
    {
        return [
            'templates' => [
                'hit' => Cache::tags(MailCacheTags::TEMPLATES)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::TEMPLATES)->get('miss') ?? 0,
            ],
            'notifications' => [
                'hit' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('miss') ?? 0,
            ],
            'queue' => [
                'hit' => Cache::tags(MailCacheTags::QUEUE)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::QUEUE)->get('miss') ?? 0,
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Observers](https://laravel.com/docs/eloquent#observers) 

---

## email-html-best-practices-1

*Consolidated from: `email-html-best-practices.md`*

title: "Best Practices HTML per Email"
type: concept
tags: [email, html, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-html-best-practices-1 best practices html per email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Best Practices HTML per Email

## Introduzione

Questo documento definisce le best practices per la creazione di template HTML per email, basate sulle esperienze di [MailPace](https://github.com/mailpace/templates) e altre fonti autorevoli.

## Struttura HTML

### 1. Doctype e Meta Tags
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ subject }}</title>
</head>
```

### 2. Layout Base
```html
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                    <!-- Contenuto -->
                </table>
            </td>
        </tr>
    </table>
</body>
```

## Best Practices

### 1. Layout e Struttura

#### ✅ Usa Table Layout
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

#### ✅ Evita Div Layout
```html
<!-- NON FARE QUESTO -->
<div style="width: 100%;">
    <div style="margin: 0 auto;">
        <!-- Contenuto -->
    </div>
</div>
```

### 2. Stili CSS

#### ✅ Inline CSS
```html
<td style="padding: 20px; background-color: #ffffff;">
    <!-- Contenuto -->
</td>
```

#### ✅ Evita CSS Esterno
```html
<!-- NON FARE QUESTO -->
<link rel="stylesheet" href="styles.css">
```

### 3. Immagini

#### ✅ Dimensioni Esplicite
```html
<img src="logo.png" width="200" height="50" alt="Logo" style="display: block;">
```

#### ✅ Alt Text
```html
<img src="banner.jpg" alt="Descrizione dettagliata" style="display: block;">
```

### 4. Link e Bottoni

#### ✅ Link Stile Button
```html
<a href="{{ url }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; text-decoration: none; border-radius: 4px;">
    {{ text }}
</a>
```

#### ✅ Evita Button HTML
```html
<!-- NON FARE QUESTO -->
<button style="padding: 12px 24px;">Click Me</button>
```

## Compatibilità Client Email

### 1. Gmail
- Supporta CSS inline
- Supporta media queries
- Supporta web fonts limitati

### 2. Outlook
- Richiede table layout
- Supporto limitato per CSS
- Problemi con immagini

### 3. Apple Mail
- Supporto completo per CSS
- Supporto per web fonts
- Supporto per media queries

## Responsive Design

### 1. Media Queries
```html
<style>
    @media screen and (max-width: 600px) {
        .container {
            width: 100% !important;
        }
        .mobile-padding {
            padding: 10px !important;
        }
    }
</style>
```

### 2. Fluid Layout
```html
<table role="presentation" width="100%" style="max-width: 600px;">
    <tr>
        <td style="padding: 20px;">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

## Performance

### 1. Ottimizzazione Immagini
- Usa formati appropriati (PNG, JPG)
- Comprimi le immagini
- Specifica dimensioni

### 2. CSS
- Minimizza CSS inline
- Usa shorthand properties
- Evita proprietà non supportate

### 3. HTML
- Minimizza markup
- Evita tag non necessari
- Usa attributi HTML base

## Testing

### 1. Client Email
- Gmail (Web, Mobile)
- Outlook (Desktop, Web)
- Apple Mail
- Yahoo Mail

### 2. Dispositivi
- Desktop
- Mobile
- Tablet

### 3. Browser
- Chrome
- Firefox
- Safari
- Edge

## Strumenti di Testing

1. **Email on Acid**
   - Test cross-client
   - Preview in tempo reale
   - Report dettagliati

2. **Litmus**
   - Test di compatibilità
   - Preview responsive
   - Analisi spam

3. **Mailtrap**
   - Test in ambiente sicuro
   - Preview HTML
   - Analisi deliverability

## Note Importanti

1. **Compatibilità**
   - Testare su vari client
   - Verificare responsive
   - Controllare spam score

2. **Accessibilità**
   - Alt text per immagini
   - Contrasto colori
   - Struttura semantica

3. **Performance**
   - Ottimizzare immagini
   - Minimizzare codice
   - Testare velocità

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Struttura Template](./mail-templates-structure.md)
- [Template Base](./base-templates.md)
- [Struttura Template](./mail-templates-structure.md)
- [Template Base](./base-templates.md)
- [Template Base](../../base-templates.md)
- [Struttura Template](./mail-templates-structure.md)
- [Template Base](../../base-templates.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
---

## email-html-best-practices

*Consolidated from: `email-html-best-practices.md`*


## Introduzione

Questo documento definisce le best practices per la creazione di template HTML per email, basate sulle esperienze di [MailPace](https://github.com/mailpace/templates) e altre fonti autorevoli.

## Struttura HTML

### 1. Doctype e Meta Tags
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ subject }}</title>
</head>
```

### 2. Layout Base
```html
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                    <!-- Contenuto -->
                </table>
            </td>
        </tr>
    </table>
</body>
```

## Best Practices

### 1. Layout e Struttura

#### ✅ Usa Table Layout
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

#### ✅ Evita Div Layout
```html
<!-- NON FARE QUESTO -->
<div style="width: 100%;">
    <div style="margin: 0 auto;">
        <!-- Contenuto -->
    </div>
</div>
```

### 2. Stili CSS

#### ✅ Inline CSS
```html
<td style="padding: 20px; background-color: #ffffff;">
    <!-- Contenuto -->
</td>
```

#### ✅ Evita CSS Esterno
```html
<!-- NON FARE QUESTO -->
<link rel="stylesheet" href="styles.css">
```

### 3. Immagini

#### ✅ Dimensioni Esplicite
```html
<img src="logo.png" width="200" height="50" alt="Logo" style="display: block;">
```

#### ✅ Alt Text
```html
<img src="banner.jpg" alt="Descrizione dettagliata" style="display: block;">
```

### 4. Link e Bottoni

#### ✅ Link Stile Button
```html
<a href="{{ url }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; text-decoration: none; border-radius: 4px;">
    {{ text }}
</a>
```

#### ✅ Evita Button HTML
```html
<!-- NON FARE QUESTO -->
<button style="padding: 12px 24px;">Click Me</button>
```

## Compatibilità Client Email

### 1. Gmail
- Supporta CSS inline
- Supporta media queries
- Supporta web fonts limitati

### 2. Outlook
- Richiede table layout
- Supporto limitato per CSS
- Problemi con immagini

### 3. Apple Mail
- Supporto completo per CSS
- Supporto per web fonts
- Supporto per media queries

## Responsive Design

### 1. Media Queries
```html
<style>
    @media screen and (max-width: 600px) {
        .container {
            width: 100% !important;
        }
        .mobile-padding {
            padding: 10px !important;
        }
    }
</style>
```

### 2. Fluid Layout
```html
<table role="presentation" width="100%" style="max-width: 600px;">
    <tr>
        <td style="padding: 20px;">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

## Performance

### 1. Ottimizzazione Immagini
- Usa formati appropriati (PNG, JPG)
- Comprimi le immagini
- Specifica dimensioni

### 2. CSS
- Minimizza CSS inline
- Usa shorthand properties
- Evita proprietà non supportate

### 3. HTML
- Minimizza markup
- Evita tag non necessari
- Usa attributi HTML base

## Testing

### 1. Client Email
- Gmail (Web, Mobile)
- Outlook (Desktop, Web)
- Apple Mail
- Yahoo Mail

### 2. Dispositivi
- Desktop
- Mobile
- Tablet

### 3. Browser
- Chrome
- Firefox
- Safari
- Edge

## Strumenti di Testing

1. **Email on Acid**
   - Test cross-client
   - Preview in tempo reale
   - Report dettagliati

2. **Litmus**
   - Test di compatibilità
   - Preview responsive
   - Analisi spam

3. **Mailtrap**
   - Test in ambiente sicuro
   - Preview HTML
   - Analisi deliverability

## Note Importanti

1. **Compatibilità**
   - Testare su vari client
   - Verificare responsive
   - Controllare spam score

2. **Accessibilità**
   - Alt text per immagini
   - Contrasto colori
   - Struttura semantica

3. **Performance**
   - Ottimizzare immagini
   - Minimizzare codice
   - Testare velocità

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Struttura Template](./MAIL_TEMPLATES_STRUCTURE.md)
- [Template Base](./BASE_TEMPLATES.md)
- [Struttura Template](../../mail_templates_structure.md)
- [Template Base](../../base_templates.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 

---

## email-integration

*Consolidated from: `email-integration.md`*


---

## email-logs-1

*Consolidated from: `email-logs.md`*

title: "Sistema Log Email"
type: concept
tags: [email, logs]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-logs-1 sistema log email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Sistema Log Email 

## Panoramica

Sistema di log per tracciare e monitorare le attività del sistema email.

## Log Template

### 1. Template Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailTemplate;

class MailTemplateLog
{
    protected const LOG_CHANNEL = 'mail-templates';

    public function logCreate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template creato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'created_at' => now(),
        ]);
    }

    public function logUpdate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template aggiornato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'updated_at' => now(),
        ]);
    }

    public function logDelete(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template eliminato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'deleted_at' => now(),
        ]);
    }

    public function logError(MailTemplate $template, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore template', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateLog;

class MailTemplateObserver
{
    protected $log;

    public function __construct(MailTemplateLog $log)
    {
        $this->log = $log;
    }

    public function created(MailTemplate $template): void
    {
        $this->log->logCreate($template);
    }

    public function updated(MailTemplate $template): void
    {
        $this->log->logUpdate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->log->logDelete($template);
    }
}
```

## Log Notifiche

### 1. Notifiche Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailNotification;

class MailNotificationLog
{
    protected const LOG_CHANNEL = 'mail-notifications';

    public function logSend(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica inviata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'recipients' => $notification->recipients,
            'sent_at' => now(),
        ]);
    }

    public function logOpen(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica aperta', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'opened_at' => now(),
        ]);
    }

    public function logClick(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica cliccata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'clicked_at' => now(),
        ]);
    }

    public function logError(MailNotification $notification, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore notifica', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationLog;

class MailNotificationObserver
{
    protected $log;

    public function __construct(MailNotificationLog $log)
    {
        $this->log = $log;
    }

    public function saved(MailNotification $notification): void
    {
        if ($notification->wasRecentlyCreated) {
            $this->log->logSend($notification);
        }
    }

    public function updated(MailNotification $notification): void
    {
        if ($notification->isDirty('opened_at')) {
            $this->log->logOpen($notification);
        }

        if ($notification->isDirty('clicked_at')) {
            $this->log->logClick($notification);
        }
    }
}
```

## Log Queue

### 1. Queue Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailQueue;

class MailQueueLog
{
    protected const LOG_CHANNEL = 'mail-queue';

    public function logAdd(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job aggiunto', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'added_at' => now(),
        ]);
    }

    public function logProcess(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job processato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'processed_at' => now(),
        ]);
    }

    public function logFail(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Job fallito', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'error' => $job->error,
            'failed_at' => now(),
        ]);
    }

    public function logRetry(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job riprovato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'retried_at' => now(),
        ]);
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueLog;

class MailQueueObserver
{
    protected $log;

    public function __construct(MailQueueLog $log)
    {
        $this->log = $log;
    }

    public function created(MailQueue $job): void
    {
        $this->log->logAdd($job);
    }

    public function updated(MailQueue $job): void
    {
        if ($job->isDirty('status')) {
            switch ($job->status) {
                case 'processing':
                    $this->log->logProcess($job);
                    break;
                case 'failed':
                    $this->log->logFail($job);
                    break;
                case 'retrying':
                    $this->log->logRetry($job);
                    break;
            }
        }
    }
}
```

## Best Practices

### 1. Log Channels

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogChannels
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $channel) {
            Log::channel($channel)->info('Log cleared', [
                'cleared_at' => now(),
            ]);
        }
    }
}
```

### 2. Log Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateLogged
{
    use SerializesModels;

    public $template;
    public $action;

    public function __construct(MailTemplate $template, string $action)
    {
        $this->template = $template;
        $this->action = $action;
    }
}

class MailNotificationLogged
{
    use SerializesModels;

    public $notification;
    public $action;

    public function __construct(MailNotification $notification, string $action)
    {
        $this->notification = $notification;
        $this->action = $action;
    }
}

class MailQueueLogged
{
    use SerializesModels;

    public $job;
    public $action;

    public function __construct(MailQueue $job, string $action)
    {
        $this->job = $job;
        $this->action = $action;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Log non scritti**
   - Verifica permessi
   - Controlla canali
   - Debug log

2. **Performance**
   - Monitora spazio
   - Ottimizza rotazione
   - Usa canali

3. **Debug**
   - Verifica livelli
   - Controlla formati
   - Monitora errori

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogDebugger
{
    protected $templateLog;
    protected $notificationLog;
    protected $queueLog;

    public function __construct(
        MailTemplateLog $templateLog,
        MailNotificationLog $notificationLog,
        MailQueueLog $queueLog
    ) {
        $this->templateLog = $templateLog;
        $this->notificationLog = $notificationLog;
        $this->queueLog = $queueLog;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'channels' => $this->debugChannels(),
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
                'created_at' => $template->created_at,
                'updated_at' => $template->updated_at,
                'deleted_at' => $template->deleted_at,
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'recipients' => $notification->recipients,
                'sent_at' => $notification->sent_at,
                'opened_at' => $notification->opened_at,
                'clicked_at' => $notification->clicked_at,
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'attempts' => $job->attempts,
                'error' => $job->error,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at,
            ];
        }

        return $debug;
    }

    protected function debugChannels(): array
    {
        return [
            'templates' => [
                'enabled' => Log::channel(MailLogChannels::TEMPLATES)->isEnabled(),
                'level' => Log::channel(MailLogChannels::TEMPLATES)->getLevel(),
            ],
            'notifications' => [
                'enabled' => Log::channel(MailLogChannels::NOTIFICATIONS)->isEnabled(),
                'level' => Log::channel(MailLogChannels::NOTIFICATIONS)->getLevel(),
            ],
            'queue' => [
                'enabled' => Log::channel(MailLogChannels::QUEUE)->isEnabled(),
                'level' => Log::channel(MailLogChannels::QUEUE)->getLevel(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
---

## email-logs

*Consolidated from: `email-logs.md`*


## Panoramica

Sistema di log per tracciare e monitorare le attività del sistema email.

## Log Template

### 1. Template Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailTemplate;

class MailTemplateLog
{
    protected const LOG_CHANNEL = 'mail-templates';

    public function logCreate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template creato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'created_at' => now(),
        ]);
    }

    public function logUpdate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template aggiornato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'updated_at' => now(),
        ]);
    }

    public function logDelete(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template eliminato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'deleted_at' => now(),
        ]);
    }

    public function logError(MailTemplate $template, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore template', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateLog;

class MailTemplateObserver
{
    protected $log;

    public function __construct(MailTemplateLog $log)
    {
        $this->log = $log;
    }

    public function created(MailTemplate $template): void
    {
        $this->log->logCreate($template);
    }

    public function updated(MailTemplate $template): void
    {
        $this->log->logUpdate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->log->logDelete($template);
    }
}
```

## Log Notifiche

### 1. Notifiche Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailNotification;

class MailNotificationLog
{
    protected const LOG_CHANNEL = 'mail-notifications';

    public function logSend(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica inviata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'recipients' => $notification->recipients,
            'sent_at' => now(),
        ]);
    }

    public function logOpen(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica aperta', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'opened_at' => now(),
        ]);
    }

    public function logClick(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica cliccata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'clicked_at' => now(),
        ]);
    }

    public function logError(MailNotification $notification, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore notifica', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationLog;

class MailNotificationObserver
{
    protected $log;

    public function __construct(MailNotificationLog $log)
    {
        $this->log = $log;
    }

    public function saved(MailNotification $notification): void
    {
        if ($notification->wasRecentlyCreated) {
            $this->log->logSend($notification);
        }
    }

    public function updated(MailNotification $notification): void
    {
        if ($notification->isDirty('opened_at')) {
            $this->log->logOpen($notification);
        }

        if ($notification->isDirty('clicked_at')) {
            $this->log->logClick($notification);
        }
    }
}
```

## Log Queue

### 1. Queue Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailQueue;

class MailQueueLog
{
    protected const LOG_CHANNEL = 'mail-queue';

    public function logAdd(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job aggiunto', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'added_at' => now(),
        ]);
    }

    public function logProcess(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job processato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'processed_at' => now(),
        ]);
    }

    public function logFail(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Job fallito', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'error' => $job->error,
            'failed_at' => now(),
        ]);
    }

    public function logRetry(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job riprovato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'retried_at' => now(),
        ]);
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueLog;

class MailQueueObserver
{
    protected $log;

    public function __construct(MailQueueLog $log)
    {
        $this->log = $log;
    }

    public function created(MailQueue $job): void
    {
        $this->log->logAdd($job);
    }

    public function updated(MailQueue $job): void
    {
        if ($job->isDirty('status')) {
            switch ($job->status) {
                case 'processing':
                    $this->log->logProcess($job);
                    break;
                case 'failed':
                    $this->log->logFail($job);
                    break;
                case 'retrying':
                    $this->log->logRetry($job);
                    break;
            }
        }
    }
}
```

## Best Practices

### 1. Log Channels

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogChannels
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $channel) {
            Log::channel($channel)->info('Log cleared', [
                'cleared_at' => now(),
            ]);
        }
    }
}
```

### 2. Log Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateLogged
{
    use SerializesModels;

    public $template;
    public $action;

    public function __construct(MailTemplate $template, string $action)
    {
        $this->template = $template;
        $this->action = $action;
    }
}

class MailNotificationLogged
{
    use SerializesModels;

    public $notification;
    public $action;

    public function __construct(MailNotification $notification, string $action)
    {
        $this->notification = $notification;
        $this->action = $action;
    }
}

class MailQueueLogged
{
    use SerializesModels;

    public $job;
    public $action;

    public function __construct(MailQueue $job, string $action)
    {
        $this->job = $job;
        $this->action = $action;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Log non scritti**
   - Verifica permessi
   - Controlla canali
   - Debug log

2. **Performance**
   - Monitora spazio
   - Ottimizza rotazione
   - Usa canali

3. **Debug**
   - Verifica livelli
   - Controlla formati
   - Monitora errori

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogDebugger
{
    protected $templateLog;
    protected $notificationLog;
    protected $queueLog;

    public function __construct(
        MailTemplateLog $templateLog,
        MailNotificationLog $notificationLog,
        MailQueueLog $queueLog
    ) {
        $this->templateLog = $templateLog;
        $this->notificationLog = $notificationLog;
        $this->queueLog = $queueLog;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'channels' => $this->debugChannels(),
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
                'created_at' => $template->created_at,
                'updated_at' => $template->updated_at,
                'deleted_at' => $template->deleted_at,
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'recipients' => $notification->recipients,
                'sent_at' => $notification->sent_at,
                'opened_at' => $notification->opened_at,
                'clicked_at' => $notification->clicked_at,
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'attempts' => $job->attempts,
                'error' => $job->error,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at,
            ];
        }

        return $debug;
    }

    protected function debugChannels(): array
    {
        return [
            'templates' => [
                'enabled' => Log::channel(MailLogChannels::TEMPLATES)->isEnabled(),
                'level' => Log::channel(MailLogChannels::TEMPLATES)->getLevel(),
            ],
            'notifications' => [
                'enabled' => Log::channel(MailLogChannels::NOTIFICATIONS)->isEnabled(),
                'level' => Log::channel(MailLogChannels::NOTIFICATIONS)->getLevel(),
            ],
            'queue' => [
                'enabled' => Log::channel(MailLogChannels::QUEUE)->isEnabled(),
                'level' => Log::channel(MailLogChannels::QUEUE)->getLevel(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Observers](https://laravel.com/docs/eloquent#observers) 

---

## email-monitoring-1

*Consolidated from: `email-monitoring.md`*

title: "Sistema Monitoraggio Email"
type: concept
tags: [email, monitoring]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-monitoring-1 sistema monitoraggio email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

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
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
- [Laravel Events](https://laravel.com/project_docs/events) 
---

## email-monitoring

*Consolidated from: `email-monitoring.md`*


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
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
- [Laravel Events](https://laravel.com/project_docs/events) 
- [Laravel Cache](https://laravel.com/docs/cache)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Commands](https://laravel.com/docs/artisan) 
- [Laravel Events](https://laravel.com/docs/events) 

---

## email-notifications-1

*Consolidated from: `email-notifications.md`*

title: "Sistema Notifiche Email - il progetto"
type: concept
tags: [email, notifications]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-notifications-1 sistema notifiche email - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Sistema Notifiche Email - il progetto

## Panoramica

Sistema di notifiche per eventi e azioni in il progetto.

## Struttura Notifiche

### 1. Notifiche Base

```php
namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notify\Mail\TemplatedMail;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $template;
    protected $data;

    public function __construct(MailTemplate $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): TemplatedMail
    {
        return (new TemplatedMail($this->template, $this->data))
            ->to($notifiable->email);
    }

    public function toArray($notifiable): array
    {
        return [
            'template_id' => $this->template->id,
            'data' => $this->data,
        ];
    }
}
```

### 2. Notifiche Specifiche

```php
namespace Modules\Notify\Notifications;

class AppointmentNotification extends GenericNotification
{
    public function __construct(Appointment $appointment)
    {
        $template = MailTemplate::where('type', 'appointment')->first();
        
        $data = [
            'appointment' => $appointment,
            'patient' => $appointment->patient,
            'doctor' => $appointment->doctor,
            'date' => $appointment->date->format('d/m/Y'),
            'time' => $appointment->time->format('H:i'),
        ];

        parent::__construct($template, $data);
    }
}

class PaymentNotification extends GenericNotification
{
    public function __construct(Payment $payment)
    {
        $template = MailTemplate::where('type', 'payment')->first();
        
        $data = [
            'payment' => $payment,
            'amount' => $payment->amount,
            'date' => $payment->date->format('d/m/Y'),
            'method' => $payment->method,
        ];

        parent::__construct($template, $data);
    }
}
```

## Eventi

### 1. Event Listeners

```php
namespace Modules\Notify\Listeners;

class SendAppointmentNotification
{
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        
        // Notifica paziente
        $appointment->patient->notify(new AppointmentNotification($appointment));
        
        // Notifica medico
        $appointment->doctor->notify(new AppointmentNotification($appointment));
    }
}

class SendPaymentNotification
{
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        
        // Notifica paziente
        $payment->patient->notify(new PaymentNotification($payment));
        
        // Notifica amministrazione
        User::where('role', 'admin')->get()
            ->each->notify(new PaymentNotification($payment));
    }
}
```

### 2. Event Service Provider

```php
namespace Modules\Notify\Providers;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AppointmentCreated::class => [
            SendAppointmentNotification::class,
        ],
        PaymentReceived::class => [
            SendPaymentNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        // Registra eventi
        Event::listen('appointment.*', function ($event, $payload) {
            // Log evento
            Log::info('Appointment event', [
                'event' => $event,
                'payload' => $payload,
            ]);
        });
    }
}
```

## Integrazione con Filament

### 1. Notifications Resource

```php
namespace Modules\Notify\Filament\Resources;

class NotificationResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Template
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->required()
                    ->label('Template'),
                    
                // Dati
                KeyValue::make('data')
                    ->label('Dati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),
                    
                // Destinatari
                Select::make('recipients')
                    ->multiple()
                    ->options([
                        'patient' => 'Paziente',
                        'doctor' => 'Medico',
                        'admin' => 'Amministrazione',
                    ])
                    ->required()
                    ->label('Destinatari'),
                    
                // Programma
                DateTimePicker::make('scheduled_at')
                    ->label('Programma')
                    ->nullable(),
            ])
        ]);
    }
}
```

### 2. Notifications Actions

```php
class NotificationActions
{
    public static function make(): array
    {
        return [
            // Invia ora
            Action::make('send_now')
                ->label('Invia Ora')
                ->icon('heroicon-o-paper-airplane')
                ->action(function (Notification $record) {
                    $record->send();
                }),
                
            // Programma
            Action::make('schedule')
                ->label('Programma')
                ->icon('heroicon-o-clock')
                ->form([
                    DateTimePicker::make('scheduled_at')
                        ->required()
                        ->label('Data e Ora'),
                ])
                ->action(function (array $data, Notification $record) {
                    $record->schedule($data['scheduled_at']);
                }),
                
            // Duplica
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Notification $record) {
                    $record->replicate()->save();
                }),
        ];
    }
}
```

## Best Practices

### 1. Gestione Template

```php
class NotificationTemplate
{
    public static function make(string $type, array $data = []): MailTemplate
    {
        $template = MailTemplate::where('type', $type)->first();
        
        if (!$template) {
            throw new \Exception("Template {$type} not found");
        }
        
        // Verifica placeholder
        $placeholders = $template->getPlaceholders();
        $missing = array_diff($placeholders, array_keys($data));
        
        if (!empty($missing)) {
            throw new \Exception("Missing placeholders: " . implode(', ', $missing));
        }
        
        return $template;
    }
}
```

### 2. Validazione Dati

```php
class NotificationValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Verifica template
        if (!isset($data['template'])) {
            $errors[] = 'Template is required';
        }

        // Verifica destinatari
        if (empty($data['recipients'])) {
            $errors[] = 'Recipients are required';
        }

        // Verifica dati
        if (!$this->validateData($data['data'])) {
            $errors[] = 'Invalid data';
        }

        return $errors;
    }

    protected function validateData(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Notifiche non inviate**
   - Verifica template
   - Controlla destinatari
   - Debug eventi

2. **Dati mancanti**
   - Verifica placeholder
   - Controlla validazione
   - Debug payload

3. **Errori invio**
   - Verifica configurazione
   - Controlla log
   - Debug queue

### 2. Debug

```php
class NotificationDebugger
{
    public function debug(Notification $notification): array
    {
        return [
            'template' => [
                'id' => $notification->template->id,
                'type' => $notification->template->type,
                'placeholders' => $notification->template->getPlaceholders(),
            ],
            'data' => $notification->data,
            'recipients' => $notification->recipients,
            'scheduled' => $notification->scheduled_at,
            'status' => $notification->status,
            'error' => $notification->error,
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Mail](https://laravel.com/project_docs/mail) 
---

## email-notifications

*Consolidated from: `email-notifications.md`*


## Panoramica

Sistema di notifiche per eventi e azioni in il progetto.

## Struttura Notifiche

### 1. Notifiche Base

```php
namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notify\Mail\TemplatedMail;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $template;
    protected $data;

    public function __construct(MailTemplate $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): TemplatedMail
    {
        return (new TemplatedMail($this->template, $this->data))
            ->to($notifiable->email);
    }

    public function toArray($notifiable): array
    {
        return [
            'template_id' => $this->template->id,
            'data' => $this->data,
        ];
    }
}
```

### 2. Notifiche Specifiche

```php
namespace Modules\Notify\Notifications;

class AppointmentNotification extends GenericNotification
{
    public function __construct(Appointment $appointment)
    {
        $template = MailTemplate::where('type', 'appointment')->first();
        
        $data = [
            'appointment' => $appointment,
            'patient' => $appointment->patient,
            'doctor' => $appointment->doctor,
            'date' => $appointment->date->format('d/m/Y'),
            'time' => $appointment->time->format('H:i'),
        ];

        parent::__construct($template, $data);
    }
}

class PaymentNotification extends GenericNotification
{
    public function __construct(Payment $payment)
    {
        $template = MailTemplate::where('type', 'payment')->first();
        
        $data = [
            'payment' => $payment,
            'amount' => $payment->amount,
            'date' => $payment->date->format('d/m/Y'),
            'method' => $payment->method,
        ];

        parent::__construct($template, $data);
    }
}
```

## Eventi

### 1. Event Listeners

```php
namespace Modules\Notify\Listeners;

class SendAppointmentNotification
{
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        
        // Notifica paziente
        $appointment->patient->notify(new AppointmentNotification($appointment));
        
        // Notifica medico
        $appointment->doctor->notify(new AppointmentNotification($appointment));
    }
}

class SendPaymentNotification
{
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        
        // Notifica paziente
        $payment->patient->notify(new PaymentNotification($payment));
        
        // Notifica amministrazione
        User::where('role', 'admin')->get()
            ->each->notify(new PaymentNotification($payment));
    }
}
```

### 2. Event Service Provider

```php
namespace Modules\Notify\Providers;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AppointmentCreated::class => [
            SendAppointmentNotification::class,
        ],
        PaymentReceived::class => [
            SendPaymentNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        // Registra eventi
        Event::listen('appointment.*', function ($event, $payload) {
            // Log evento
            Log::info('Appointment event', [
                'event' => $event,
                'payload' => $payload,
            ]);
        });
    }
}
```

## Integrazione con Filament

### 1. Notifications Resource

```php
namespace Modules\Notify\Filament\Resources;

class NotificationResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Template
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->required()
                    ->label('Template'),
                    
                // Dati
                KeyValue::make('data')
                    ->label('Dati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),
                    
                // Destinatari
                Select::make('recipients')
                    ->multiple()
                    ->options([
                        'patient' => 'Paziente',
                        'doctor' => 'Medico',
                        'admin' => 'Amministrazione',
                    ])
                    ->required()
                    ->label('Destinatari'),
                    
                // Programma
                DateTimePicker::make('scheduled_at')
                    ->label('Programma')
                    ->nullable(),
            ])
        ]);
    }
}
```

### 2. Notifications Actions

```php
class NotificationActions
{
    public static function make(): array
    {
        return [
            // Invia ora
            Action::make('send_now')
                ->label('Invia Ora')
                ->icon('heroicon-o-paper-airplane')
                ->action(function (Notification $record) {
                    $record->send();
                }),
                
            // Programma
            Action::make('schedule')
                ->label('Programma')
                ->icon('heroicon-o-clock')
                ->form([
                    DateTimePicker::make('scheduled_at')
                        ->required()
                        ->label('Data e Ora'),
                ])
                ->action(function (array $data, Notification $record) {
                    $record->schedule($data['scheduled_at']);
                }),
                
            // Duplica
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Notification $record) {
                    $record->replicate()->save();
                }),
        ];
    }
}
```

## Best Practices

### 1. Gestione Template

```php
class NotificationTemplate
{
    public static function make(string $type, array $data = []): MailTemplate
    {
        $template = MailTemplate::where('type', $type)->first();
        
        if (!$template) {
            throw new \Exception("Template {$type} not found");
        }
        
        // Verifica placeholder
        $placeholders = $template->getPlaceholders();
        $missing = array_diff($placeholders, array_keys($data));
        
        if (!empty($missing)) {
            throw new \Exception("Missing placeholders: " . implode(', ', $missing));
        }
        
        return $template;
    }
}
```

### 2. Validazione Dati

```php
class NotificationValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Verifica template
        if (!isset($data['template'])) {
            $errors[] = 'Template is required';
        }

        // Verifica destinatari
        if (empty($data['recipients'])) {
            $errors[] = 'Recipients are required';
        }

        // Verifica dati
        if (!$this->validateData($data['data'])) {
            $errors[] = 'Invalid data';
        }

        return $errors;
    }

    protected function validateData(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Notifiche non inviate**
   - Verifica template
   - Controlla destinatari
   - Debug eventi

2. **Dati mancanti**
   - Verifica placeholder
   - Controlla validazione
   - Debug payload

3. **Errori invio**
   - Verifica configurazione
   - Controlla log
   - Debug queue

### 2. Debug

```php
class NotificationDebugger
{
    public function debug(Notification $notification): array
    {
        return [
            'template' => [
                'id' => $notification->template->id,
                'type' => $notification->template->type,
                'placeholders' => $notification->template->getPlaceholders(),
            ],
            'data' => $notification->data,
            'recipients' => $notification->recipients,
            'scheduled' => $notification->scheduled_at,
            'status' => $notification->status,
            'error' => $notification->error,
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Mail](https://laravel.com/project_docs/mail) 
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Mail](https://laravel.com/docs/mail) 

---

## email-plugins-analysis-1

*Consolidated from: `email-plugins-analysis.md`*

title: "Analisi Plugin Email per Filament - il progetto"
type: concept
tags: [email, plugins, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-plugins-analysis-1 analisi plugin email per filament - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Analisi Plugin Email per Filament - il progetto

## Panoramica

Analisi comparativa dei principali plugin per la gestione email in Filament, con focus sulle funzionalità che possiamo integrare nel nostro sistema.

## Plugin Analizzati

### 1. Filament Error Mailer (hugomyb/filament-error-mailer)
**Punti di Forza:**
- Notifica errori via email
- Integrazione con Filament
- Configurazione semplice

**Limitazioni:**
- Solo per errori
- Funzionalità limitate
- No template personalizzati

### 2. Filament Mails (vormkracht10/filament-mails)
**Punti di Forza:**
- Gestione template
- Preview email
- Test invio

**Limitazioni:**
- No versionamento
- No multilingua
- No statistiche

### 3. Email Templates (visualbuilder/email-templates)
**Punti di Forza:**
- Editor WYSIWYG
- Template responsive
- Preview live

**Limitazioni:**
- Dipendenze esterne
- Performance
- Complessità

### 4. Database Mail (martin-petricko/database-mail)
**Punti di Forza:**
- Template in database
- Multilingua
- Cache

**Limitazioni:**
- Costo
- Limitazioni tecniche
- No versionamento

## Nostra Implementazione

### 1. Caratteristiche Uniche

```php
// Esempio di implementazione avanzata
class MailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'variables' => 'array',
        'layout' => 'array',
        'is_active' => 'boolean',
    ];

    // Versionamento
    public function versions()
    {
        return $this->hasMany(MailTemplateVersion::class);
    }

    // Statistiche
    public function stats()
    {
        return $this->hasMany(MailStats::class);
    }

    // Cache
    public function getCachedTemplate()
    {
        return Cache::remember(
            "mail_template_{$this->id}",
            now()->addDay(),
            fn() => $this->html_template
        );
    }
}
```

### 2. Miglioramenti Proposti

1. **Sistema di Versionamento**
   - Storico completo modifiche
   - Rollback versioni
   - Confronto versioni
   - Note di cambiamento

2. **Editor Avanzato**
   - WYSIWYG migliorato
   - Supporto componenti
   - Preview multi-device
   - Validazione in tempo reale

3. **Gestione Layout**
   - Layout personalizzabili
   - Componenti riutilizzabili
   - Responsive design
   - Branding dinamico

4. **Analytics**
   - Tracking aperture
   - Click tracking
   - A/B testing
   - Report avanzati

5. **Performance**
   - Cache intelligente
   - Lazy loading
   - Ottimizzazione query
   - Compressione assets

### 3. Integrazione Filament

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor avanzato
                RichEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview live
                ViewField::make('preview')
                    ->view('notify::mail.preview'),

                // Versionamento
                Repeater::make('versions')
                    ->schema([
                        TextInput::make('version')
                            ->required(),
                        Textarea::make('changes')
                            ->required(),
                    ]),

                // Analytics
                StatsOverview::make([
                    'opens' => fn() => $this->getOpenStats(),
                    'clicks' => fn() => $this->getClickStats(),
                    'conversion' => fn() => $this->getConversionRate(),
                ]),
            ])
        ]);
    }
}
```

### 4. Sistema di Cache

```php
class MailTemplateCache
{
    public function getTemplate(string $key): ?string
    {
        return Cache::tags(['mail_templates'])
            ->remember(
                "template:{$key}",
                now()->addDay(),
                fn() => $this->loadTemplate($key)
            );
    }

    public function invalidate(string $key): void
    {
        Cache::tags(['mail_templates'])->forget("template:{$key}");
    }
}
```

### 5. Analytics e Tracking

```php
class MailAnalytics
{
    public function trackOpen(MailTemplate $template, string $email): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'open',
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }

    public function trackClick(MailTemplate $template, string $email, string $url): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'click',
            'metadata' => [
                'url' => $url,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }
}
```

## Vantaggi della Nostra Soluzione

1. **Completezza**
   - Funzionalità complete
   - Integrazione nativa
   - Estensibilità

2. **Performance**
   - Ottimizzazione
   - Cache intelligente
   - Scalabilità

3. **Manutenibilità**
   - Codice pulito
   - Documentazione
   - Test coverage

4. **Sicurezza**
   - Validazione
   - Sanitizzazione
   - Permessi

5. **UX/UI**
   - Interfaccia intuitiva
   - Preview live
   - Feedback immediato

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor base
   - [x] Preview

2. **Fase 2 - Avanzato**
   - [ ] Versionamento
   - [ ] Analytics
   - [ ] A/B testing

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Queue](database-mail-queue.md)
- [Testing](database-mail-system-tests.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Queue](../../database-mail-queue.md)
- [Testing](../../database-mail-system-tests.md)

## Vedi Anche
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Spatie Packages](https://spatie.be/open-source) 
---

## email-plugins-analysis

*Consolidated from: `email-plugins-analysis.md`*


## Panoramica

Analisi comparativa dei principali plugin per la gestione email in Filament, con focus sulle funzionalità che possiamo integrare nel nostro sistema.

## Plugin Analizzati

### 1. Filament Error Mailer (hugomyb/filament-error-mailer)
**Punti di Forza:**
- Notifica errori via email
- Integrazione con Filament
- Configurazione semplice

**Limitazioni:**
- Solo per errori
- Funzionalità limitate
- No template personalizzati

### 2. Filament Mails (vormkracht10/filament-mails)
**Punti di Forza:**
- Gestione template
- Preview email
- Test invio

**Limitazioni:**
- No versionamento
- No multilingua
- No statistiche

### 3. Email Templates (visualbuilder/email-templates)
**Punti di Forza:**
- Editor WYSIWYG
- Template responsive
- Preview live

**Limitazioni:**
- Dipendenze esterne
- Performance
- Complessità

### 4. Database Mail (martin-petricko/database-mail)
**Punti di Forza:**
- Template in database
- Multilingua
- Cache

**Limitazioni:**
- Costo
- Limitazioni tecniche
- No versionamento

## Nostra Implementazione

### 1. Caratteristiche Uniche

```php
// Esempio di implementazione avanzata
class MailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'variables' => 'array',
        'layout' => 'array',
        'is_active' => 'boolean',
    ];

    // Versionamento
    public function versions()
    {
        return $this->hasMany(MailTemplateVersion::class);
    }

    // Statistiche
    public function stats()
    {
        return $this->hasMany(MailStats::class);
    }

    // Cache
    public function getCachedTemplate()
    {
        return Cache::remember(
            "mail_template_{$this->id}",
            now()->addDay(),
            fn() => $this->html_template
        );
    }
}
```

### 2. Miglioramenti Proposti

1. **Sistema di Versionamento**
   - Storico completo modifiche
   - Rollback versioni
   - Confronto versioni
   - Note di cambiamento

2. **Editor Avanzato**
   - WYSIWYG migliorato
   - Supporto componenti
   - Preview multi-device
   - Validazione in tempo reale

3. **Gestione Layout**
   - Layout personalizzabili
   - Componenti riutilizzabili
   - Responsive design
   - Branding dinamico

4. **Analytics**
   - Tracking aperture
   - Click tracking
   - A/B testing
   - Report avanzati

5. **Performance**
   - Cache intelligente
   - Lazy loading
   - Ottimizzazione query
   - Compressione assets

### 3. Integrazione Filament

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor avanzato
                RichEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview live
                ViewField::make('preview')
                    ->view('notify::mail.preview'),

                // Versionamento
                Repeater::make('versions')
                    ->schema([
                        TextInput::make('version')
                            ->required(),
                        Textarea::make('changes')
                            ->required(),
                    ]),

                // Analytics
                StatsOverview::make([
                    'opens' => fn() => $this->getOpenStats(),
                    'clicks' => fn() => $this->getClickStats(),
                    'conversion' => fn() => $this->getConversionRate(),
                ]),
            ])
        ]);
    }
}
```

### 4. Sistema di Cache

```php
class MailTemplateCache
{
    public function getTemplate(string $key): ?string
    {
        return Cache::tags(['mail_templates'])
            ->remember(
                "template:{$key}",
                now()->addDay(),
                fn() => $this->loadTemplate($key)
            );
    }

    public function invalidate(string $key): void
    {
        Cache::tags(['mail_templates'])->forget("template:{$key}");
    }
}
```

### 5. Analytics e Tracking

```php
class MailAnalytics
{
    public function trackOpen(MailTemplate $template, string $email): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'open',
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }

    public function trackClick(MailTemplate $template, string $email, string $url): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'click',
            'metadata' => [
                'url' => $url,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }
}
```

## Vantaggi della Nostra Soluzione

1. **Completezza**
   - Funzionalità complete
   - Integrazione nativa
   - Estensibilità

2. **Performance**
   - Ottimizzazione
   - Cache intelligente
   - Scalabilità

3. **Manutenibilità**
   - Codice pulito
   - Documentazione
   - Test coverage

4. **Sicurezza**
   - Validazione
   - Sanitizzazione
   - Permessi

5. **UX/UI**
   - Interfaccia intuitiva
   - Preview live
   - Feedback immediato

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor base
   - [x] Preview

2. **Fase 2 - Avanzato**
   - [ ] Versionamento
   - [ ] Analytics
   - [ ] A/B testing

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Queue](database-mail-queue.md)
- [Testing](database-mail-system-tests.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Queue](../../database-mail-queue.md)
- [Testing](../../database-mail-system-tests.md)

## Vedi Anche
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Spatie Packages](https://spatie.be/open-source) 
---

## email-plugins

*Consolidated from: `email-plugins.md`*


## Panoramica

Analisi comparativa dei principali plugin per la gestione email in Filament, con focus sulle funzionalità che possiamo integrare nel nostro sistema.

## Plugin Analizzati

### 1. Filament Error Mailer (hugomyb/filament-error-mailer)
**Punti di Forza:**
- Notifica errori via email
- Integrazione con Filament
- Configurazione semplice

**Limitazioni:**
- Solo per errori
- Funzionalità limitate
- No template personalizzati

### 2. Filament Mails (vormkracht10/filament-mails)
**Punti di Forza:**
- Gestione template
- Preview email
- Test invio

**Limitazioni:**
- No versionamento
- No multilingua
- No statistiche

### 3. Email Templates (visualbuilder/email-templates)
**Punti di Forza:**
- Editor WYSIWYG
- Template responsive
- Preview live

**Limitazioni:**
- Dipendenze esterne
- Performance
- Complessità

### 4. Database Mail (martin-petricko/database-mail)
**Punti di Forza:**
- Template in database
- Multilingua
- Cache

**Limitazioni:**
- Costo
- Limitazioni tecniche
- No versionamento

## Nostra Implementazione

### 1. Caratteristiche Uniche

```php
// Esempio di implementazione avanzata
class MailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'variables' => 'array',
        'layout' => 'array',
        'is_active' => 'boolean',
    ];

    // Versionamento
    public function versions()
    {
        return $this->hasMany(MailTemplateVersion::class);
    }

    // Statistiche
    public function stats()
    {
        return $this->hasMany(MailStats::class);
    }

    // Cache
    public function getCachedTemplate()
    {
        return Cache::remember(
            "mail_template_{$this->id}",
            now()->addDay(),
            fn() => $this->html_template
        );
    }
}
```

### 2. Miglioramenti Proposti

1. **Sistema di Versionamento**
   - Storico completo modifiche
   - Rollback versioni
   - Confronto versioni
   - Note di cambiamento

2. **Editor Avanzato**
   - WYSIWYG migliorato
   - Supporto componenti
   - Preview multi-device
   - Validazione in tempo reale

3. **Gestione Layout**
   - Layout personalizzabili
   - Componenti riutilizzabili
   - Responsive design
   - Branding dinamico

4. **Analytics**
   - Tracking aperture
   - Click tracking
   - A/B testing
   - Report avanzati

5. **Performance**
   - Cache intelligente
   - Lazy loading
   - Ottimizzazione query
   - Compressione assets

### 3. Integrazione Filament

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor avanzato
                RichEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview live
                ViewField::make('preview')
                    ->view('notify::mail.preview'),

                // Versionamento
                Repeater::make('versions')
                    ->schema([
                        TextInput::make('version')
                            ->required(),
                        Textarea::make('changes')
                            ->required(),
                    ]),

                // Analytics
                StatsOverview::make([
                    'opens' => fn() => $this->getOpenStats(),
                    'clicks' => fn() => $this->getClickStats(),
                    'conversion' => fn() => $this->getConversionRate(),
                ]),
            ])
        ]);
    }
}
```

### 4. Sistema di Cache

```php
class MailTemplateCache
{
    public function getTemplate(string $key): ?string
    {
        return Cache::tags(['mail_templates'])
            ->remember(
                "template:{$key}",
                now()->addDay(),
                fn() => $this->loadTemplate($key)
            );
    }

    public function invalidate(string $key): void
    {
        Cache::tags(['mail_templates'])->forget("template:{$key}");
    }
}
```

### 5. Analytics e Tracking

```php
class MailAnalytics
{
    public function trackOpen(MailTemplate $template, string $email): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'open',
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }

    public function trackClick(MailTemplate $template, string $email, string $url): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'click',
            'metadata' => [
                'url' => $url,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }
}
```

## Vantaggi della Nostra Soluzione

1. **Completezza**
   - Funzionalità complete
   - Integrazione nativa
   - Estensibilità

2. **Performance**
   - Ottimizzazione
   - Cache intelligente
   - Scalabilità

3. **Manutenibilità**
   - Codice pulito
   - Documentazione
   - Test coverage

4. **Sicurezza**
   - Validazione
   - Sanitizzazione
   - Permessi

5. **UX/UI**
   - Interfaccia intuitiva
   - Preview live
   - Feedback immediato

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor base
   - [x] Preview

2. **Fase 2 - Avanzato**
   - [ ] Versionamento
   - [ ] Analytics
   - [ ] A/B testing

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Queue](database-mail-queue.md)
- [Testing](database-mail-system-tests.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Queue](../../database-mail-queue.md)
- [Testing](../../database-mail-system-tests.md)

## Vedi Anche
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Spatie Packages](https://spatie.be/open-source) 
---

## email-queue-1

*Consolidated from: `email-queue.md`*

title: "Sistema Code Email - il progetto"
type: concept
tags: [email, queue]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-queue-1 sistema code email - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Sistema Code Email - il progetto

## Panoramica

Sistema di gestione code per l'invio di email in il progetto.

## Struttura Code

### 1. Job

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;

    protected $template;
    protected $recipient;
    protected $data;

    public function __construct(MailTemplate $template, string $recipient, array $data = [])
    {
        $this->template = $template;
        $this->recipient = $recipient;
        $this->data = $data;
    }

    public function handle(): void
    {
        try {
            // Crea stat
            $stat = MailStat::create([
                'mail_template_id' => $this->template->id,
                'recipient_email' => $this->recipient,
                'status' => 'pending',
            ]);

            // Invia email
            Mail::to($this->recipient)
                ->send(new TemplatedMail($this->template, $this->data));

            // Aggiorna stat
            $stat->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Log errore
            Log::error('Mail send failed', [
                'template' => $this->template->id,
                'recipient' => $this->recipient,
                'error' => $e->getMessage(),
            ]);

            // Aggiorna stat
            $stat->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        // Notifica amministratore
        Notification::route('mail', config('notify.admin_email'))
            ->notify(new MailFailedNotification(
                $this->template,
                $this->recipient,
                $exception
            ));
    }
}
```

### 2. Queue Manager

```php
namespace Modules\Notify\Services;

class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Verifica limiti
        $this->checkLimits($template);

        // Crea job
        $job = new SendMailJob($template, $recipient, $data);

        // Imposta priorità
        $job->onQueue($this->getQueueName($template));

        // Dispatch
        dispatch($job);
    }

    protected function checkLimits(MailTemplate $template): void
    {
        $count = MailStat::where('mail_template_id', $template->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($count >= $template->hourly_limit) {
            throw new \Exception('Hourly limit exceeded');
        }
    }

    protected function getQueueName(MailTemplate $template): string
    {
        return $template->priority === 'high' ? 'mail-high' : 'mail-default';
    }
}
```

## Configurazione

### 1. Queue Config

```php
// config/queue.php
return [
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => 'database',
        'database' => 'mysql',
        'table' => 'failed_jobs',
    ],
];

// config/notify.php
return [
    'queue' => [
        'high_priority' => 'mail-high',
        'default_priority' => 'mail-default',
        'hourly_limit' => 1000,
        'retry_after' => 60,
        'tries' => 3,
    ],
];
```

### 2. Supervisor Config

```ini
[program:laravel-mail-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/base_<nome progetto>/laravel/artisan queue:work redis --queue=mail-high,mail-default --tries=3 --timeout=60
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/mail-worker.log
```

## Monitoraggio

### 1. Queue Monitor

```php
namespace Modules\Notify\Services;

class MailQueueMonitor
{
    public function getStats(): array
    {
        return [
            'pending' => $this->getPendingCount(),
            'processing' => $this->getProcessingCount(),
            'failed' => $this->getFailedCount(),
            'processed' => $this->getProcessedCount(),
            'retry' => $this->getRetryCount(),
        ];
    }

    protected function getPendingCount(): int
    {
        return Redis::connection()->llen('queues:mail-high') +
               Redis::connection()->llen('queues:mail-default');
    }

    protected function getFailedCount(): int
    {
        return DB::table('failed_jobs')
            ->where('queue', 'like', 'mail%')
            ->count();
    }
}
```

### 2. Queue Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailQueueResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Statistiche
                StatsOverview::make([
                    Stat::make('In Coda', fn () => $this->getPendingCount())
                        ->description('Job in attesa')
                        ->descriptionIcon('heroicon-m-clock'),
                        
                    Stat::make('In Elaborazione', fn () => $this->getProcessingCount())
                        ->description('Job in corso')
                        ->descriptionIcon('heroicon-m-arrow-path'),
                        
                    Stat::make('Falliti', fn () => $this->getFailedCount())
                        ->description('Job falliti')
                        ->descriptionIcon('heroicon-m-x-circle'),
                ]),
                
                // Grafici
                Chart::make('Job per Ora')
                    ->type('line')
                    ->data($this->getJobsByHour()),
                    
                Chart::make('Tempo di Elaborazione')
                    ->type('bar')
                    ->data($this->getProcessingTime()),
                    
                Chart::make('Fallimenti per Causa')
                    ->type('pie')
                    ->data($this->getFailureReasons()),
            ])
        ]);
    }
}
```

## Best Practices

### 1. Rate Limiting

```php
class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Rate limiting per template
        $this->rateLimitTemplate($template);

        // Rate limiting per destinatario
        $this->rateLimitRecipient($recipient);

        // Dispatch
        $this->dispatchJob($template, $recipient, $data);
    }

    protected function rateLimitTemplate(MailTemplate $template): void
    {
        $key = "mail:template:{$template->id}";
        
        if (RateLimiter::tooManyAttempts($key, $template->hourly_limit)) {
            throw new \Exception('Template rate limit exceeded');
        }
        
        RateLimiter::hit($key);
    }

    protected function rateLimitRecipient(string $recipient): void
    {
        $key = "mail:recipient:{$recipient}";
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw new \Exception('Recipient rate limit exceeded');
        }
        
        RateLimiter::hit($key);
    }
}
```

### 2. Error Handling

```php
class SendMailJob
{
    public function handle(): void
    {
        try {
            // Verifica template
            if (!$this->template->isValid()) {
                throw new \Exception('Invalid template');
            }

            // Verifica destinatario
            if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid recipient');
            }

            // Invia email
            $this->sendMail();

        } catch (\Exception $e) {
            // Log errore
            $this->logError($e);

            // Notifica fallimento
            $this->notifyFailure($e);

            // Riprova se possibile
            if ($this->attempts() < $this->tries) {
                $this->release(30);
            }

            throw $e;
        }
    }

    protected function logError(\Exception $e): void
    {
        Log::error('Mail send failed', [
            'template' => $this->template->id,
            'recipient' => $this->recipient,
            'attempt' => $this->attempts(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Code bloccate**
   - Verifica worker
   - Controlla timeout
   - Debug job

2. **Job falliti**
   - Verifica errori
   - Controlla retry
   - Debug log

3. **Performance lenta**
   - Ottimizza query
   - Aumenta worker
   - Monitora risorse

### 2. Debug

```php
class MailQueueManager
{
    public function debug(): array
    {
        return [
            'redis' => [
                'pending' => $this->getRedisPending(),
                'processing' => $this->getRedisProcessing(),
                'failed' => $this->getRedisFailed(),
            ],
            'supervisor' => [
                'status' => $this->getSupervisorStatus(),
                'workers' => $this->getSupervisorWorkers(),
            ],
            'database' => [
                'failed_jobs' => $this->getFailedJobs(),
                'mail_stats' => $this->getMailStats(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Horizon](https://laravel.com/project_docs/horizon)
- [Laravel Supervisor](https://laravel.com/project_docs/queues#supervisor-configuration) 
---

## email-queue

*Consolidated from: `email-queue.md`*


## Panoramica

Sistema di gestione code per l'invio di email in il progetto.

## Struttura Code

### 1. Job

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;

    protected $template;
    protected $recipient;
    protected $data;

    public function __construct(MailTemplate $template, string $recipient, array $data = [])
    {
        $this->template = $template;
        $this->recipient = $recipient;
        $this->data = $data;
    }

    public function handle(): void
    {
        try {
            // Crea stat
            $stat = MailStat::create([
                'mail_template_id' => $this->template->id,
                'recipient_email' => $this->recipient,
                'status' => 'pending',
            ]);

            // Invia email
            Mail::to($this->recipient)
                ->send(new TemplatedMail($this->template, $this->data));

            // Aggiorna stat
            $stat->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Log errore
            Log::error('Mail send failed', [
                'template' => $this->template->id,
                'recipient' => $this->recipient,
                'error' => $e->getMessage(),
            ]);

            // Aggiorna stat
            $stat->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        // Notifica amministratore
        Notification::route('mail', config('notify.admin_email'))
            ->notify(new MailFailedNotification(
                $this->template,
                $this->recipient,
                $exception
            ));
    }
}
```

### 2. Queue Manager

```php
namespace Modules\Notify\Services;

class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Verifica limiti
        $this->checkLimits($template);

        // Crea job
        $job = new SendMailJob($template, $recipient, $data);

        // Imposta priorità
        $job->onQueue($this->getQueueName($template));

        // Dispatch
        dispatch($job);
    }

    protected function checkLimits(MailTemplate $template): void
    {
        $count = MailStat::where('mail_template_id', $template->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($count >= $template->hourly_limit) {
            throw new \Exception('Hourly limit exceeded');
        }
    }

    protected function getQueueName(MailTemplate $template): string
    {
        return $template->priority === 'high' ? 'mail-high' : 'mail-default';
    }
}
```

## Configurazione

### 1. Queue Config

```php
// config/queue.php
return [
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => 'database',
        'database' => 'mysql',
        'table' => 'failed_jobs',
    ],
];

// config/notify.php
return [
    'queue' => [
        'high_priority' => 'mail-high',
        'default_priority' => 'mail-default',
        'hourly_limit' => 1000,
        'retry_after' => 60,
        'tries' => 3,
    ],
];
```

### 2. Supervisor Config

```ini
[program:laravel-mail-worker]
process_name=%(program_name)s_%(process_num)02d
command=php artisan queue:work redis --queue=mail-high,mail-default --tries=3 --timeout=60
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/mail-worker.log
```

## Monitoraggio

### 1. Queue Monitor

```php
namespace Modules\Notify\Services;

class MailQueueMonitor
{
    public function getStats(): array
    {
        return [
            'pending' => $this->getPendingCount(),
            'processing' => $this->getProcessingCount(),
            'failed' => $this->getFailedCount(),
            'processed' => $this->getProcessedCount(),
            'retry' => $this->getRetryCount(),
        ];
    }

    protected function getPendingCount(): int
    {
        return Redis::connection()->llen('queues:mail-high') +
               Redis::connection()->llen('queues:mail-default');
    }

    protected function getFailedCount(): int
    {
        return DB::table('failed_jobs')
            ->where('queue', 'like', 'mail%')
            ->count();
    }
}
```

### 2. Queue Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailQueueResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Statistiche
                StatsOverview::make([
                    Stat::make('In Coda', fn () => $this->getPendingCount())
                        ->description('Job in attesa')
                        ->descriptionIcon('heroicon-m-clock'),

                    Stat::make('In Elaborazione', fn () => $this->getProcessingCount())
                        ->description('Job in corso')
                        ->descriptionIcon('heroicon-m-arrow-path'),

                    Stat::make('Falliti', fn () => $this->getFailedCount())
                        ->description('Job falliti')
                        ->descriptionIcon('heroicon-m-x-circle'),
                ]),

                // Grafici
                Chart::make('Job per Ora')
                    ->type('line')
                    ->data($this->getJobsByHour()),

                Chart::make('Tempo di Elaborazione')
                    ->type('bar')
                    ->data($this->getProcessingTime()),

                Chart::make('Fallimenti per Causa')
                    ->type('pie')
                    ->data($this->getFailureReasons()),
            ])
        ]);
    }
}
```

## Best Practices

### 1. Rate Limiting

```php
class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Rate limiting per template
        $this->rateLimitTemplate($template);

        // Rate limiting per destinatario
        $this->rateLimitRecipient($recipient);

        // Dispatch
        $this->dispatchJob($template, $recipient, $data);
    }

    protected function rateLimitTemplate(MailTemplate $template): void
    {
        $key = "mail:template:{$template->id}";

        if (RateLimiter::tooManyAttempts($key, $template->hourly_limit)) {
            throw new \Exception('Template rate limit exceeded');
        }

        RateLimiter::hit($key);
    }

    protected function rateLimitRecipient(string $recipient): void
    {
        $key = "mail:recipient:{$recipient}";

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw new \Exception('Recipient rate limit exceeded');
        }

        RateLimiter::hit($key);
    }
}
```

### 2. Error Handling

```php
class SendMailJob
{
    public function handle(): void
    {
        try {
            // Verifica template
            if (!$this->template->isValid()) {
                throw new \Exception('Invalid template');
            }

            // Verifica destinatario
            if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid recipient');
            }

            // Invia email
            $this->sendMail();

        } catch (\Exception $e) {
            // Log errore
            $this->logError($e);

            // Notifica fallimento
            $this->notifyFailure($e);

            // Riprova se possibile
            if ($this->attempts() < $this->tries) {
                $this->release(30);
            }

            throw $e;
        }
    }

    protected function logError(\Exception $e): void
    {
        Log::error('Mail send failed', [
            'template' => $this->template->id,
            'recipient' => $this->recipient,
            'attempt' => $this->attempts(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Code bloccate**
   - Verifica worker
   - Controlla timeout
   - Debug job

2. **Job falliti**
   - Verifica errori
   - Controlla retry
   - Debug log

3. **Performance lenta**
   - Ottimizza query
   - Aumenta worker
   - Monitora risorse

### 2. Debug

```php
class MailQueueManager
{
    public function debug(): array
    {
        return [
            'redis' => [
                'pending' => $this->getRedisPending(),
                'processing' => $this->getRedisProcessing(),
                'failed' => $this->getRedisFailed(),
            ],
            'supervisor' => [
                'status' => $this->getSupervisorStatus(),
                'workers' => $this->getSupervisorWorkers(),
            ],
            'database' => [
                'failed_jobs' => $this->getFailedJobs(),
                'mail_stats' => $this->getMailStats(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Horizon](https://laravel.com/project_docs/horizon)
- [Laravel Supervisor](https://laravel.com/project_docs/queues#supervisor-configuration)
- [Laravel Queue](https://laravel.com/docs/queues)
- [Laravel Horizon](https://laravel.com/docs/horizon)
- [Laravel Supervisor](https://laravel.com/docs/queues#supervisor-configuration)
# Sistema Code Email - il progetto

## Panoramica

Sistema di gestione code per l'invio di email in il progetto.

## Struttura Code

### 1. Job

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;

    protected $template;
    protected $recipient;
    protected $data;

    public function __construct(MailTemplate $template, string $recipient, array $data = [])
    {
        $this->template = $template;
        $this->recipient = $recipient;
        $this->data = $data;
    }

    public function handle(): void
    {
        try {
            // Crea stat
            $stat = MailStat::create([
                'mail_template_id' => $this->template->id,
                'recipient_email' => $this->recipient,
                'status' => 'pending',
            ]);

            // Invia email
            Mail::to($this->recipient)
                ->send(new TemplatedMail($this->template, $this->data));

            // Aggiorna stat
            $stat->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Log errore
            Log::error('Mail send failed', [
                'template' => $this->template->id,
                'recipient' => $this->recipient,
                'error' => $e->getMessage(),
            ]);

            // Aggiorna stat
            $stat->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        // Notifica amministratore
        Notification::route('mail', config('notify.admin_email'))
            ->notify(new MailFailedNotification(
                $this->template,
                $this->recipient,
                $exception
            ));
    }
}
```

### 2. Queue Manager

```php
namespace Modules\Notify\Services;

class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Verifica limiti
        $this->checkLimits($template);

        // Crea job
        $job = new SendMailJob($template, $recipient, $data);

        // Imposta priorità
        $job->onQueue($this->getQueueName($template));

        // Dispatch
        dispatch($job);
    }

    protected function checkLimits(MailTemplate $template): void
    {
        $count = MailStat::where('mail_template_id', $template->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($count >= $template->hourly_limit) {
            throw new \Exception('Hourly limit exceeded');
        }
    }

    protected function getQueueName(MailTemplate $template): string
    {
        return $template->priority === 'high' ? 'mail-high' : 'mail-default';
    }
}
```

## Configurazione

### 1. Queue Config

```php
// config/queue.php
return [
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => 'database',
        'database' => 'mysql',
        'table' => 'failed_jobs',
    ],
];

// config/notify.php
return [
    'queue' => [
        'high_priority' => 'mail-high',
        'default_priority' => 'mail-default',
        'hourly_limit' => 1000,
        'retry_after' => 60,
        'tries' => 3,
    ],
];
```

### 2. Supervisor Config

```ini
[program:laravel-mail-worker]
process_name=%(program_name)s_%(process_num)02d
command=php artisan queue:work redis --queue=mail-high,mail-default --tries=3 --timeout=60
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/mail-worker.log
```

## Monitoraggio

### 1. Queue Monitor

```php
namespace Modules\Notify\Services;

class MailQueueMonitor
{
    public function getStats(): array
    {
        return [
            'pending' => $this->getPendingCount(),
            'processing' => $this->getProcessingCount(),
            'failed' => $this->getFailedCount(),
            'processed' => $this->getProcessedCount(),
            'retry' => $this->getRetryCount(),
        ];
    }

    protected function getPendingCount(): int
    {
        return Redis::connection()->llen('queues:mail-high') +
               Redis::connection()->llen('queues:mail-default');
    }

    protected function getFailedCount(): int
    {
        return DB::table('failed_jobs')
            ->where('queue', 'like', 'mail%')
            ->count();
    }
}
```

### 2. Queue Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailQueueResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Statistiche
                StatsOverview::make([
                    Stat::make('In Coda', fn () => $this->getPendingCount())
                        ->description('Job in attesa')
                        ->descriptionIcon('heroicon-m-clock'),

                    Stat::make('In Elaborazione', fn () => $this->getProcessingCount())
                        ->description('Job in corso')
                        ->descriptionIcon('heroicon-m-arrow-path'),

                    Stat::make('Falliti', fn () => $this->getFailedCount())
                        ->description('Job falliti')
                        ->descriptionIcon('heroicon-m-x-circle'),
                ]),

                // Grafici
                Chart::make('Job per Ora')
                    ->type('line')
                    ->data($this->getJobsByHour()),

                Chart::make('Tempo di Elaborazione')
                    ->type('bar')
                    ->data($this->getProcessingTime()),

                Chart::make('Fallimenti per Causa')
                    ->type('pie')
                    ->data($this->getFailureReasons()),
            ])
        ]);
    }
}
```

## Best Practices

### 1. Rate Limiting

```php
class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Rate limiting per template
        $this->rateLimitTemplate($template);

        // Rate limiting per destinatario
        $this->rateLimitRecipient($recipient);

        // Dispatch
        $this->dispatchJob($template, $recipient, $data);
    }

    protected function rateLimitTemplate(MailTemplate $template): void
    {
        $key = "mail:template:{$template->id}";

        if (RateLimiter::tooManyAttempts($key, $template->hourly_limit)) {
            throw new \Exception('Template rate limit exceeded');
        }

        RateLimiter::hit($key);
    }

    protected function rateLimitRecipient(string $recipient): void
    {
        $key = "mail:recipient:{$recipient}";

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw new \Exception('Recipient rate limit exceeded');
        }

        RateLimiter::hit($key);
    }
}
```

### 2. Error Handling

```php
class SendMailJob
{
    public function handle(): void
    {
        try {
            // Verifica template
            if (!$this->template->isValid()) {
                throw new \Exception('Invalid template');
            }

            // Verifica destinatario
            if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid recipient');
            }

            // Invia email
            $this->sendMail();

        } catch (\Exception $e) {
            // Log errore
            $this->logError($e);

            // Notifica fallimento
            $this->notifyFailure($e);

            // Riprova se possibile
            if ($this->attempts() < $this->tries) {
                $this->release(30);
            }

            throw $e;
        }
    }

    protected function logError(\Exception $e): void
    {
        Log::error('Mail send failed', [
            'template' => $this->template->id,
            'recipient' => $this->recipient,
            'attempt' => $this->attempts(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Code bloccate**
   - Verifica worker
   - Controlla timeout
   - Debug job

2. **Job falliti**
   - Verifica errori
   - Controlla retry
   - Debug log

3. **Performance lenta**
   - Ottimizza query
   - Aumenta worker
   - Monitora risorse

### 2. Debug

```php
class MailQueueManager
{
    public function debug(): array
    {
        return [
            'redis' => [
                'pending' => $this->getRedisPending(),
                'processing' => $this->getRedisProcessing(),
                'failed' => $this->getRedisFailed(),
            ],
            'supervisor' => [
                'status' => $this->getSupervisorStatus(),
                'workers' => $this->getSupervisorWorkers(),
            ],
            'database' => [
                'failed_jobs' => $this->getFailedJobs(),
                'mail_stats' => $this->getMailStats(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Horizon](https://laravel.com/project_docs/horizon)
- [Laravel Supervisor](https://laravel.com/project_docs/queues#supervisor-configuration)

---

## email-sending-troubleshooting-1

*Consolidated from: `email-sending-troubleshooting.md`*

title: "Troubleshooting: Sistema di Invio Email in Notify"
type: concept
tags: [email, sending, troubleshooting]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-sending-troubleshooting-1 troubleshooting: sistema di invio email in notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Troubleshooting: Sistema di Invio Email in Notify

## Problema: `SendEmail.php` vs `TestSmtpPage.php`

È stato rilevato che nel modulo Notify:
- `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php` funziona correttamente
- `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php` non funziona

Questa guida spiega le differenze e come risolvere il problema.

## Analisi delle Differenze

### 1. Estensione Base

```php
// TestSmtpPage.php (funzionante)
class TestSmtpPage extends XotBasePage implements HasForms

// SendEmail.php (non funzionante)
class SendEmail extends Page implements HasForms
```

**Problema**: `SendEmail` estende direttamente `Filament\Pages\Page` invece di `Modules\Xot\Filament\Pages\XotBasePage`.

### 2. Gestione della Configurazione SMTP

```php
// TestSmtpPage.php (funzionante)
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    // ...permette di inserire i dati SMTP
}

// SendEmail.php (non funzionante)
public function emailForm(Form $form): Form
{
    // Non gestisce la configurazione SMTP, ma usa solo quella predefinita
}
```

**Problema**: `SendEmail` non permette di configurare le impostazioni SMTP, ma usa direttamente la configurazione di sistema.

### 3. Metodo di Invio Email

```php
// TestSmtpPage.php (funzionante)
public function sendEmail(): void
{
    try {
        // Crea nuovo mailer con configurazione dinamica
        // Gestisce gli errori
    }

// SendEmail.php (non funzionante)
public function sendEmail(): void
{
    $data = $this->emailForm->getState();
    $email_data = EmailData::from($data);

    Mail::to($data['to'])->send(
        new EmailDataEmail($email_data)
    );
    // Nessuna gestione errori
}
```

**Problema**: `SendEmail` usa il mailer di sistema senza override di configurazione o gestione errori.

## Soluzioni

### Approccio 1: Estendere `XotBasePage`

Modifica `SendEmail.php` per estendere `XotBasePage` anziché `Page`:

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage implements HasForms
```

### Approccio 2: Implementare la Configurazione SMTP 

Aggiungere campi di configurazione nel form:

```php
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    
    return $form
        ->schema(
            [
                Forms\Components\Section::make('SMTP')
                    ->schema(
                        [
                            Forms\Components\TextInput::make('host'),
                            Forms\Components\TextInput::make('port')->numeric(),
                            Forms\Components\TextInput::make('username'),
                            Forms\Components\TextInput::make('password'),
                            Forms\Components\TextInput::make('encryption'),
                        ]
                    )->columns(3),
                // Resto del form
            ]
        );
}
```

### Approccio 3: Override della Configurazione nel Metodo `sendEmail()`

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);
        
        // Crea configurazione temporanea
        $config = [
            'transport' => 'smtp',
            'host' => $data['host'] ?? env('MAIL_HOST'),
            'port' => $data['port'] ?? env('MAIL_PORT'),
            'encryption' => $data['encryption'] ?? env('MAIL_ENCRYPTION'),
            'username' => $data['username'] ?? env('MAIL_USERNAME'),
            'password' => $data['password'] ?? env('MAIL_PASSWORD'),
        ];
        
        // Crea mailer temporaneo
        $mailer = app('mail.manager')->createTransport($config);
        $symfony_mailer = new \Symfony\Component\Mailer\Mailer($mailer);
        
        // Invia usando mailer temporaneo
        $symfony_mailer->send(new EmailDataEmail($email_data));
        
        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
    }
}
```

### Approccio 4: Configurazione del file `.env`

Se si desidera utilizzare il mailer di sistema, assicurarsi che il file `.env` contenga le corrette impostazioni:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="Your Name"
```

> **Nota**: Il mailer di default è configurato come 'log' nel file `config/mail.php`. Modificare `.env` per utilizzare 'smtp' o altro mailer.

## Soluzione Raccomandata

La soluzione migliore è combinare gli approcci 1 e 3:

1. Estendere `XotBasePage` per sfruttare le funzionalità base
2. Implementare la gestione della configurazione SMTP
3. Utilizzare un blocco try/catch per gestire gli errori

## Esempi di Implementazione

Un esempio completo di implementazione è disponibile in `TestSmtpPage.php`. Si consiglia di studiare questo file come riferimento per risolvere i problemi in `SendEmail.php`.

## Best Practices

1. Utilizzare sempre le classi base di Xot quando disponibili
2. Implementare la gestione degli errori per operazioni che potrebbero fallire
3. Offrire opzioni flessibili per la configurazione SMTP
4. Testare l'invio di email in diversi ambienti (sviluppo, test, produzione)

## Riferimenti

- [Documentazione Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Modulo Xot - XotBasePage](mdc:../../Xot/docs/pages.md)
- [Modulo Xot - XotBasePage](mdc:../../Xot/docs/pages.md)
---

## email-sending-troubleshooting

*Consolidated from: `email-sending-troubleshooting.md`*


## Problema: `SendEmail.php` vs `TestSmtpPage.php`

È stato rilevato che nel modulo Notify:
- `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php` funziona correttamente
- `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php` non funziona

Questa guida spiega le differenze e come risolvere il problema.

## Analisi delle Differenze

### 1. Estensione Base

```php
// TestSmtpPage.php (funzionante)
class TestSmtpPage extends XotBasePage implements HasForms

// SendEmail.php (non funzionante)
class SendEmail extends Page implements HasForms
```

**Problema**: `SendEmail` estende direttamente `Filament\Pages\Page` invece di `Modules\Xot\Filament\Pages\XotBasePage`.

### 2. Gestione della Configurazione SMTP

```php
// TestSmtpPage.php (funzionante)
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    // ...permette di inserire i dati SMTP
}

// SendEmail.php (non funzionante)
public function emailForm(Form $form): Form
{
    // Non gestisce la configurazione SMTP, ma usa solo quella predefinita
}
```

**Problema**: `SendEmail` non permette di configurare le impostazioni SMTP, ma usa direttamente la configurazione di sistema.

### 3. Metodo di Invio Email

```php
// TestSmtpPage.php (funzionante)
public function sendEmail(): void
{
    try {
        // Crea nuovo mailer con configurazione dinamica
        // Gestisce gli errori
    }

// SendEmail.php (non funzionante)
public function sendEmail(): void
{
    $data = $this->emailForm->getState();
    $email_data = EmailData::from($data);

    Mail::to($data['to'])->send(
        new EmailDataEmail($email_data)
    );
    // Nessuna gestione errori
}
```

**Problema**: `SendEmail` usa il mailer di sistema senza override di configurazione o gestione errori.

## Soluzioni

### Approccio 1: Estendere `XotBasePage`

Modifica `SendEmail.php` per estendere `XotBasePage` anziché `Page`:

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage implements HasForms
```

### Approccio 2: Implementare la Configurazione SMTP 

Aggiungere campi di configurazione nel form:

```php
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    
    return $form
        ->schema(
            [
                Forms\Components\Section::make('SMTP')
                    ->schema(
                        [
                            Forms\Components\TextInput::make('host'),
                            Forms\Components\TextInput::make('port')->numeric(),
                            Forms\Components\TextInput::make('username'),
                            Forms\Components\TextInput::make('password'),
                            Forms\Components\TextInput::make('encryption'),
                        ]
                    )->columns(3),
                // Resto del form
            ]
        );
}
```

### Approccio 3: Override della Configurazione nel Metodo `sendEmail()`

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);
        
        // Crea configurazione temporanea
        $config = [
            'transport' => 'smtp',
            'host' => $data['host'] ?? env('MAIL_HOST'),
            'port' => $data['port'] ?? env('MAIL_PORT'),
            'encryption' => $data['encryption'] ?? env('MAIL_ENCRYPTION'),
            'username' => $data['username'] ?? env('MAIL_USERNAME'),
            'password' => $data['password'] ?? env('MAIL_PASSWORD'),
        ];
        
        // Crea mailer temporaneo
        $mailer = app('mail.manager')->createTransport($config);
        $symfony_mailer = new \Symfony\Component\Mailer\Mailer($mailer);
        
        // Invia usando mailer temporaneo
        $symfony_mailer->send(new EmailDataEmail($email_data));
        
        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
    }
}
```

### Approccio 4: Configurazione del file `.env`

Se si desidera utilizzare il mailer di sistema, assicurarsi che il file `.env` contenga le corrette impostazioni:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="Your Name"
```

> **Nota**: Il mailer di default è configurato come 'log' nel file `config/mail.php`. Modificare `.env` per utilizzare 'smtp' o altro mailer.

## Soluzione Raccomandata

La soluzione migliore è combinare gli approcci 1 e 3:

1. Estendere `XotBasePage` per sfruttare le funzionalità base
2. Implementare la gestione della configurazione SMTP
3. Utilizzare un blocco try/catch per gestire gli errori

## Esempi di Implementazione

Un esempio completo di implementazione è disponibile in `TestSmtpPage.php`. Si consiglia di studiare questo file come riferimento per risolvere i problemi in `SendEmail.php`.

## Best Practices

1. Utilizzare sempre le classi base di Xot quando disponibili
2. Implementare la gestione degli errori per operazioni che potrebbero fallire
3. Offrire opzioni flessibili per la configurazione SMTP
4. Testare l'invio di email in diversi ambienti (sviluppo, test, produzione)

## Riferimenti

- [Documentazione Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Modulo Xot - XotBasePage](mdc:../../xot/docs/pages.md)
---

## email-translations-1

*Consolidated from: `email-translations.md`*

title: "Integrazione Traduzioni Email - il progetto"
type: concept
tags: [email, translations]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-translations-1 integrazione traduzioni email - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Integrazione Traduzioni Email - il progetto

## Panoramica

Sistema di traduzione multilingua per i template email in il progetto.

## Struttura Traduzioni

### 1. File di Traduzione

```php
// resources/lang/it/notify.php
return [
    'mail' => [
        'templates' => [
            'welcome' => [
                'subject' => 'Benvenuto in il progetto',
                'greeting' => 'Ciao {{ $name }}',
                'content' => 'Grazie per esserti registrato...',
                'button' => [
                    'text' => 'Inizia Ora',
                    'tooltip' => 'Clicca per iniziare',
                ],
            ],
            'appointment' => [
                'subject' => 'Appuntamento Confermato',
                'greeting' => 'Gentile {{ $name }}',
                'content' => 'Il tuo appuntamento è stato confermato...',
                'button' => [
                    'text' => 'Vedi Dettagli',
                    'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
                ],
            ],
        ],
        'components' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
            ],
            'footer' => [
                'text' => '© {{ $year }} il progetto',
                'privacy' => 'Privacy Policy',
                'terms' => 'Termini e Condizioni',
            ],
        ],
    ],
];
```

### 2. Gestione Traduzioni

```php
namespace Modules\Notify\Services;

class MailTranslationService
{
    public function translate(string $key, array $replace = [], string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = trans("notify::mail.{$key}", $replace, $locale);
        
        if ($translation === "notify::mail.{$key}") {
            return $this->fallbackTranslation($key, $replace);
        }
        
        return $translation;
    }

    protected function fallbackTranslation(string $key, array $replace): string
    {
        return trans("notify::mail.{$key}", $replace, 'en');
    }
}
```

### 3. Integrazione con Editor

```php
namespace Modules\Notify\Filament\Forms\Components;

class TranslatableEmailEditor extends EmailEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslatableEmailEditor $component, $state) {
            $component->state($this->translateState($state));
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->untranslateState($state);
        });
    }

    protected function translateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->translate($matches[1]);
            },
            $state
        );
    }

    protected function untranslateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->untranslate($matches[1]);
            },
            $state
        );
    }
}
```

## Componenti Traducibili

### 1. Button Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableButtonBlock extends ButtonBlock
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.button.text'))
                    ->tooltip(trans('notify::mail.components.button.tooltip')),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label(trans('notify::mail.components.button.url')),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label(trans('notify::mail.components.button.color')),
            ]);
    }
}
```

### 2. Footer Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableFooterBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.footer.text')),
                TextInput::make('privacy')
                    ->required()
                    ->label(trans('notify::mail.components.footer.privacy')),
                TextInput::make('terms')
                    ->required()
                    ->label(trans('notify::mail.components.footer.terms')),
            ]);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor traducibile
                TranslatableEmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Lingua
                Select::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                    ])
                    ->default('it')
                    ->required(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => trans('notify::mail.components.button.label'),
                        'footer' => trans('notify::mail.components.footer.label'),
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Traduci
            Action::make('translate')
                ->label(trans('notify::mail.actions.translate'))
                ->icon('heroicon-o-translate')
                ->form([
                    Select::make('target_locale')
                        ->options([
                            'en' => 'English',
                            'de' => 'Deutsch',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    $record->translate($data['target_locale']);
                }),

            // Esporta traduzioni
            Action::make('export_translations')
                ->label(trans('notify::mail.actions.export_translations'))
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo json_encode($record->getTranslations(), JSON_PRETTY_PRINT);
                    }, "translations-{$record->id}.json");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura Chiavi

```php
// Struttura consigliata
[
    'module' => [
        'feature' => [
            'element' => [
                'property' => 'value',
                'tooltip' => 'tooltip value',
                'placeholder' => 'placeholder value',
            ],
        ],
    ],
]

// Esempio
[
    'notify' => [
        'mail' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
                'placeholder' => 'Inserisci testo...',
            ],
        ],
    ],
]
```

### 2. Gestione Placeholder

```php
class TranslationPlaceholder
{
    public static function make(string $key, array $attributes = []): array
    {
        return [
            'key' => $key,
            'label' => trans("notify::mail.placeholders.{$key}.label"),
            'tooltip' => trans("notify::mail.placeholders.{$key}.tooltip"),
            'attributes' => $attributes,
        ];
    }
}

// Uso
$placeholders = [
    TranslationPlaceholder::make('name', ['required' => true]),
    TranslationPlaceholder::make('date', ['format' => 'd/m/Y']),
];
```

### 3. Validazione Traduzioni

```php
class TranslationValidator
{
    public function validate(array $translations): array
    {
        $errors = [];

        foreach ($translations as $locale => $data) {
            // Verifica chiavi mancanti
            if (!$this->hasRequiredKeys($data)) {
                $errors[$locale][] = 'Chiavi richieste mancanti';
            }

            // Verifica placeholder
            if (!$this->hasValidPlaceholders($data)) {
                $errors[$locale][] = 'Placeholder non validi';
            }

            // Verifica lunghezza
            if (!$this->hasValidLength($data)) {
                $errors[$locale][] = 'Lunghezza non valida';
            }
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Traduzioni mancanti**
   - Verifica file di traduzione
   - Controlla namespace
   - Debug fallback

2. **Placeholder non funzionano**
   - Verifica sintassi
   - Controlla escape
   - Debug replace

3. **Cache traduzioni**
   - Pulisci cache
   - Ricarica traduzioni
   - Verifica locale

### 2. Performance

1. **Caricamento lento**
   - Cache traduzioni
   - Lazy loading
   - Ottimizza query

2. **Memoria alta**
   - Limita traduzioni
   - Pulisci cache
   - Monitora uso

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Localization](https://laravel.com/project_docs/localization)
- [Laravel Lang](https://github.com/Laravel-Lang/lang)
- [Laravel Translation Manager](https://github.com/barryvdh/laravel-translation-manager) 
---

## email-translations

*Consolidated from: `email-translations.md`*


## Panoramica

Sistema di traduzione multilingua per i template email in il progetto.

## Struttura Traduzioni

### 1. File di Traduzione

```php
// resources/lang/it/notify.php
return [
    'mail' => [
        'templates' => [
            'welcome' => [
                'subject' => 'Benvenuto in il progetto',
                'greeting' => 'Ciao {{ $name }}',
                'content' => 'Grazie per esserti registrato...',
                'button' => [
                    'text' => 'Inizia Ora',
                    'tooltip' => 'Clicca per iniziare',
                ],
            ],
            'appointment' => [
                'subject' => 'Appuntamento Confermato',
                'greeting' => 'Gentile {{ $name }}',
                'content' => 'Il tuo appuntamento è stato confermato...',
                'button' => [
                    'text' => 'Vedi Dettagli',
                    'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
                ],
            ],
        ],
        'components' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
            ],
            'footer' => [
                'text' => '© {{ $year }} il progetto',
                'privacy' => 'Privacy Policy',
                'terms' => 'Termini e Condizioni',
            ],
        ],
    ],
];
```

### 2. Gestione Traduzioni

```php
namespace Modules\Notify\Services;

class MailTranslationService
{
    public function translate(string $key, array $replace = [], string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = trans("notify::mail.{$key}", $replace, $locale);
        
        if ($translation === "notify::mail.{$key}") {
            return $this->fallbackTranslation($key, $replace);
        }
        
        return $translation;
    }

    protected function fallbackTranslation(string $key, array $replace): string
    {
        return trans("notify::mail.{$key}", $replace, 'en');
    }
}
```

### 3. Integrazione con Editor

```php
namespace Modules\Notify\Filament\Forms\Components;

class TranslatableEmailEditor extends EmailEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslatableEmailEditor $component, $state) {
            $component->state($this->translateState($state));
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->untranslateState($state);
        });
    }

    protected function translateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->translate($matches[1]);
            },
            $state
        );
    }

    protected function untranslateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->untranslate($matches[1]);
            },
            $state
        );
    }
}
```

## Componenti Traducibili

### 1. Button Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableButtonBlock extends ButtonBlock
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.button.text'))
                    ->tooltip(trans('notify::mail.components.button.tooltip')),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label(trans('notify::mail.components.button.url')),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label(trans('notify::mail.components.button.color')),
            ]);
    }
}
```

### 2. Footer Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableFooterBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.footer.text')),
                TextInput::make('privacy')
                    ->required()
                    ->label(trans('notify::mail.components.footer.privacy')),
                TextInput::make('terms')
                    ->required()
                    ->label(trans('notify::mail.components.footer.terms')),
            ]);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor traducibile
                TranslatableEmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Lingua
                Select::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                    ])
                    ->default('it')
                    ->required(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => trans('notify::mail.components.button.label'),
                        'footer' => trans('notify::mail.components.footer.label'),
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Traduci
            Action::make('translate')
                ->label(trans('notify::mail.actions.translate'))
                ->icon('heroicon-o-translate')
                ->form([
                    Select::make('target_locale')
                        ->options([
                            'en' => 'English',
                            'de' => 'Deutsch',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    $record->translate($data['target_locale']);
                }),

            // Esporta traduzioni
            Action::make('export_translations')
                ->label(trans('notify::mail.actions.export_translations'))
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo json_encode($record->getTranslations(), JSON_PRETTY_PRINT);
                    }, "translations-{$record->id}.json");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura Chiavi

```php
// Struttura consigliata
[
    'module' => [
        'feature' => [
            'element' => [
                'property' => 'value',
                'tooltip' => 'tooltip value',
                'placeholder' => 'placeholder value',
            ],
        ],
    ],
]

// Esempio
[
    'notify' => [
        'mail' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
                'placeholder' => 'Inserisci testo...',
            ],
        ],
    ],
]
```

### 2. Gestione Placeholder

```php
class TranslationPlaceholder
{
    public static function make(string $key, array $attributes = []): array
    {
        return [
            'key' => $key,
            'label' => trans("notify::mail.placeholders.{$key}.label"),
            'tooltip' => trans("notify::mail.placeholders.{$key}.tooltip"),
            'attributes' => $attributes,
        ];
    }
}

// Uso
$placeholders = [
    TranslationPlaceholder::make('name', ['required' => true]),
    TranslationPlaceholder::make('date', ['format' => 'd/m/Y']),
];
```

### 3. Validazione Traduzioni

```php
class TranslationValidator
{
    public function validate(array $translations): array
    {
        $errors = [];

        foreach ($translations as $locale => $data) {
            // Verifica chiavi mancanti
            if (!$this->hasRequiredKeys($data)) {
                $errors[$locale][] = 'Chiavi richieste mancanti';
            }

            // Verifica placeholder
            if (!$this->hasValidPlaceholders($data)) {
                $errors[$locale][] = 'Placeholder non validi';
            }

            // Verifica lunghezza
            if (!$this->hasValidLength($data)) {
                $errors[$locale][] = 'Lunghezza non valida';
            }
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Traduzioni mancanti**
   - Verifica file di traduzione
   - Controlla namespace
   - Debug fallback

2. **Placeholder non funzionano**
   - Verifica sintassi
   - Controlla escape
   - Debug replace

3. **Cache traduzioni**
   - Pulisci cache
   - Ricarica traduzioni
   - Verifica locale

### 2. Performance

1. **Caricamento lento**
   - Cache traduzioni
   - Lazy loading
   - Ottimizza query

2. **Memoria alta**
   - Limita traduzioni
   - Pulisci cache
   - Monitora uso

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Localization](https://laravel.com/project_docs/localization)
- [Laravel Localization](https://laravel.com/docs/localization)
- [Laravel Lang](https://github.com/Laravel-Lang/lang)
- [Laravel Translation Manager](https://github.com/barryvdh/laravel-translation-manager) 
---

## email-wysiwyg-editor-1

*Consolidated from: `email-wysiwyg-editor.md`*

title: "Editor WYSIWYG per Email - il progetto"
type: concept
tags: [email, wysiwyg, editor]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-wysiwyg-editor-1 editor wysiwyg per email - il progetto"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Editor WYSIWYG per Email - il progetto

## Panoramica

Implementazione di un editor WYSIWYG avanzato per la creazione e modifica dei template email in il progetto.

## Caratteristiche

### 1. Editor Base

```php
namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Component;

class EmailEditor extends Field
{
    protected string $view = 'notify::forms.components.email-editor';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (EmailEditor $component, $state) {
            $component->state($state);
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->sanitizeHtml($state);
        });
    }

    protected function sanitizeHtml(string $html): string
    {
        return clean($html, [
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,u,a[href],p,br,ul,ol,li,img[src|alt|width|height],table,thead,tbody,tr,td,th',
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]);
    }
}
```

### 2. Componenti Personalizzati

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class ButtonBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label('Testo'),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label('URL'),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label('Colore'),
            ])
            ->view('notify::forms.components.blocks.button');
    }
}

class ImageBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->label('Immagine'),
                TextInput::make('alt')
                    ->required()
                    ->label('Testo alternativo'),
            ])
            ->view('notify::forms.components.blocks.image');
    }
}
```

### 3. Preview Live

```php
namespace Modules\Notify\Filament\Forms\Components;

class EmailPreview extends Field
{
    protected string $view = 'notify::forms.components.email-preview';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function ($state) {
            $this->dispatch('preview-updated', [
                'html' => $this->renderPreview($state)
            ]);
        });
    }

    protected function renderPreview($state): string
    {
        return view('notify::mail.preview', [
            'content' => $state,
            'layout' => $this->getLayout(),
        ])->render();
    }
}
```

### 4. Validazione

```php
namespace Modules\Notify\Rules;

class EmailTemplateRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Verifica struttura HTML
        if (!$this->isValidHtml($value)) {
            return false;
        }

        // Verifica placeholder
        if (!$this->hasValidPlaceholders($value)) {
            return false;
        }

        // Verifica responsive
        if (!$this->isResponsive($value)) {
            return false;
        }

        return true;
    }

    protected function isValidHtml(string $html): bool
    {
        $dom = new \DOMDocument();
        return @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    protected function hasValidPlaceholders(string $html): bool
    {
        preg_match_all('/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/', $html, $matches);
        
        foreach ($matches[1] as $placeholder) {
            if (!in_array($placeholder, $this->allowedPlaceholders)) {
                return false;
            }
        }

        return true;
    }

    protected function isResponsive(string $html): bool
    {
        return str_contains($html, '<meta name="viewport"') &&
               str_contains($html, '@media');
    }
}
```

### 5. Gestione Assets

```php
namespace Modules\Notify\Services;

class EmailAssetManager
{
    public function uploadImage($file): string
    {
        $path = $file->store('email-assets', 'public');
        
        // Ottimizza immagine
        $this->optimizeImage($path);
        
        // Genera URL pubblico
        return Storage::url($path);
    }

    public function optimizeImage(string $path): void
    {
        $image = Image::make(storage_path("app/public/{$path}"));
        
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $image->save(null, 80);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor principale
                EmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => 'Pulsante',
                        'image' => 'Immagine',
                        'divider' => 'Divisore',
                        'spacer' => 'Spaziatore',
                    ]),

                // Layout
                Select::make('layout')
                    ->options([
                        'default' => 'Default',
                        'sidebar' => 'Sidebar',
                        'centered' => 'Centrato',
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Test invio
            Action::make('test')
                ->label('Test Email')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    Mail::to($data['email'])
                        ->send(new TestMail($record));
                }),

            // Duplica template
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (MailTemplate $record) {
                    $record->replicate()->save();
                }),

            // Esporta
            Action::make('export')
                ->label('Esporta')
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo $record->html_template;
                    }, "template-{$record->id}.html");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura HTML

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili base */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $content }}
    </div>
</body>
</html>
```

### 2. Componenti Riutilizzabili

```php
// Button component
class ButtonComponent
{
    public static function render(string $text, string $url, string $color = '#000000'): string
    {
        return view('notify::mail.components.button', [
            'text' => $text,
            'url' => $url,
            'color' => $color,
        ])->render();
    }
}

// Image component
class ImageComponent
{
    public static function render(string $src, string $alt, int $width = 600): string
    {
        return view('notify::mail.components.image', [
            'src' => $src,
            'alt' => $alt,
            'width' => $width,
        ])->render();
    }
}
```

### 3. Validazione Template

```php
class TemplateValidator
{
    public function validate(MailTemplate $template): array
    {
        $errors = [];

        // Verifica struttura
        if (!$this->validateStructure($template->html_template)) {
            $errors[] = 'Struttura HTML non valida';
        }

        // Verifica placeholder
        if (!$this->validatePlaceholders($template)) {
            $errors[] = 'Placeholder non validi';
        }

        // Verifica responsive
        if (!$this->validateResponsive($template->html_template)) {
            $errors[] = 'Template non responsive';
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Editor non carica**
   - Verifica dipendenze JS
   - Controlla console errori
   - Verifica permessi file

2. **Preview non funziona**
   - Verifica stato live
   - Controlla renderizzazione
   - Debug template

3. **Validazione fallisce**
   - Controlla struttura HTML
   - Verifica placeholder
   - Debug regole

### 2. Performance

1. **Editor lento**
   - Ottimizza JS
   - Riduci dipendenze
   - Usa lazy loading

2. **Preview lenta**
   - Cache preview
   - Ottimizza template
   - Riduci complessità

3. **Upload lento**
   - Compressi immagini
   - Usa CDN
   - Ottimizza storage

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Mail Queue](database-mail-queue.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)
- [Mail Queue](../../database-mail-queue.md)

## Vedi Anche
- [TinyMCE Documentation](https://www.tiny.cloud/docs)
- [CKEditor Documentation](https://ckeditor.com/docs)
- [Quill Documentation](https://quilljs.com/docs) 
---

## email-wysiwyg-editor

*Consolidated from: `email-wysiwyg-editor.md`*


## Panoramica

Implementazione di un editor WYSIWYG avanzato per la creazione e modifica dei template email in il progetto.

## Caratteristiche

### 1. Editor Base

```php
namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Component;

class EmailEditor extends Field
{
    protected string $view = 'notify::forms.components.email-editor';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (EmailEditor $component, $state) {
            $component->state($state);
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->sanitizeHtml($state);
        });
    }

    protected function sanitizeHtml(string $html): string
    {
        return clean($html, [
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,u,a[href],p,br,ul,ol,li,img[src|alt|width|height],table,thead,tbody,tr,td,th',
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]);
    }
}
```

### 2. Componenti Personalizzati

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class ButtonBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label('Testo'),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label('URL'),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label('Colore'),
            ])
            ->view('notify::forms.components.blocks.button');
    }
}

class ImageBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->label('Immagine'),
                TextInput::make('alt')
                    ->required()
                    ->label('Testo alternativo'),
            ])
            ->view('notify::forms.components.blocks.image');
    }
}
```

### 3. Preview Live

```php
namespace Modules\Notify\Filament\Forms\Components;

class EmailPreview extends Field
{
    protected string $view = 'notify::forms.components.email-preview';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function ($state) {
            $this->dispatch('preview-updated', [
                'html' => $this->renderPreview($state)
            ]);
        });
    }

    protected function renderPreview($state): string
    {
        return view('notify::mail.preview', [
            'content' => $state,
            'layout' => $this->getLayout(),
        ])->render();
    }
}
```

### 4. Validazione

```php
namespace Modules\Notify\Rules;

class EmailTemplateRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Verifica struttura HTML
        if (!$this->isValidHtml($value)) {
            return false;
        }

        // Verifica placeholder
        if (!$this->hasValidPlaceholders($value)) {
            return false;
        }

        // Verifica responsive
        if (!$this->isResponsive($value)) {
            return false;
        }

        return true;
    }

    protected function isValidHtml(string $html): bool
    {
        $dom = new \DOMDocument();
        return @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    protected function hasValidPlaceholders(string $html): bool
    {
        preg_match_all('/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/', $html, $matches);
        
        foreach ($matches[1] as $placeholder) {
            if (!in_array($placeholder, $this->allowedPlaceholders)) {
                return false;
            }
        }

        return true;
    }

    protected function isResponsive(string $html): bool
    {
        return str_contains($html, '<meta name="viewport"') &&
               str_contains($html, '@media');
    }
}
```

### 5. Gestione Assets

```php
namespace Modules\Notify\Services;

class EmailAssetManager
{
    public function uploadImage($file): string
    {
        $path = $file->store('email-assets', 'public');
        
        // Ottimizza immagine
        $this->optimizeImage($path);
        
        // Genera URL pubblico
        return Storage::url($path);
    }

    public function optimizeImage(string $path): void
    {
        $image = Image::make(storage_path("app/public/{$path}"));
        
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $image->save(null, 80);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor principale
                EmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => 'Pulsante',
                        'image' => 'Immagine',
                        'divider' => 'Divisore',
                        'spacer' => 'Spaziatore',
                    ]),

                // Layout
                Select::make('layout')
                    ->options([
                        'default' => 'Default',
                        'sidebar' => 'Sidebar',
                        'centered' => 'Centrato',
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Test invio
            Action::make('test')
                ->label('Test Email')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    Mail::to($data['email'])
                        ->send(new TestMail($record));
                }),

            // Duplica template
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (MailTemplate $record) {
                    $record->replicate()->save();
                }),

            // Esporta
            Action::make('export')
                ->label('Esporta')
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo $record->html_template;
                    }, "template-{$record->id}.html");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura HTML

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili base */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $content }}
    </div>
</body>
</html>
```

### 2. Componenti Riutilizzabili

```php
// Button component
class ButtonComponent
{
    public static function render(string $text, string $url, string $color = '#000000'): string
    {
        return view('notify::mail.components.button', [
            'text' => $text,
            'url' => $url,
            'color' => $color,
        ])->render();
    }
}

// Image component
class ImageComponent
{
    public static function render(string $src, string $alt, int $width = 600): string
    {
        return view('notify::mail.components.image', [
            'src' => $src,
            'alt' => $alt,
            'width' => $width,
        ])->render();
    }
}
```

### 3. Validazione Template

```php
class TemplateValidator
{
    public function validate(MailTemplate $template): array
    {
        $errors = [];

        // Verifica struttura
        if (!$this->validateStructure($template->html_template)) {
            $errors[] = 'Struttura HTML non valida';
        }

        // Verifica placeholder
        if (!$this->validatePlaceholders($template)) {
            $errors[] = 'Placeholder non validi';
        }

        // Verifica responsive
        if (!$this->validateResponsive($template->html_template)) {
            $errors[] = 'Template non responsive';
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Editor non carica**
   - Verifica dipendenze JS
   - Controlla console errori
   - Verifica permessi file

2. **Preview non funziona**
   - Verifica stato live
   - Controlla renderizzazione
   - Debug template

3. **Validazione fallisce**
   - Controlla struttura HTML
   - Verifica placeholder
   - Debug regole

### 2. Performance

1. **Editor lento**
   - Ottimizza JS
   - Riduci dipendenze
   - Usa lazy loading

2. **Preview lenta**
   - Cache preview
   - Ottimizza template
   - Riduci complessità

3. **Upload lento**
   - Compressi immagini
   - Usa CDN
   - Ottimizza storage

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Mail Queue](database-mail-queue.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)
- [Mail Queue](../../database-mail-queue.md)

## Vedi Anche
- [TinyMCE Documentation](https://www.tiny.cloud/docs)
- [CKEditor Documentation](https://ckeditor.com/docs)
- [Quill Documentation](https://quilljs.com/docs) 
---

## email_analytics

*Consolidated from: `email_analytics.md`*


## Panoramica

Sistema di tracciamento e analisi per le email in il progetto.

## Struttura Database

### 1. Tabelle

```php
// database/migrations/create_notify_mail_stats_table.php
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('recipient_email');
    $table->string('status');
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('opened_at')->nullable();
    $table->timestamp('clicked_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('device_type')->nullable();
    $table->string('browser')->nullable();
    $table->string('platform')->nullable();
    $table->string('ip_address')->nullable();
    $table->timestamps();
});

// database/migrations/create_notify_mail_links_table.php
Schema::create('notify_mail_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mail_template_id')->constrained('notify_mail_templates');
    $table->string('original_url');
    $table->string('tracking_url');
    $table->integer('clicks')->default(0);
    $table->timestamps();
});
```

### 2. Modelli

```php
namespace Modules\Notify\Models;

class MailStat extends Model
{
    protected $fillable = [
        'mail_template_id',
        'recipient_email',
        'status',
        'sent_at',
        'opened_at',
        'clicked_at',
        'clicked_links',
        'device_type',
        'browser',
        'platform',
        'ip_address',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'clicked_links' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}

class MailLink extends Model
{
    protected $fillable = [
        'mail_template_id',
        'original_url',
        'tracking_url',
        'clicks',
    ];

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }
}
```

## Tracciamento

### 1. Tracking Service

```php
namespace Modules\Notify\Services;

class MailTrackingService
{
    public function trackOpen(MailStat $stat): void
    {
        $stat->update([
            'opened_at' => now(),
            'device_type' => $this->getDeviceType(),
            'browser' => $this->getBrowser(),
            'platform' => $this->getPlatform(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function trackClick(MailStat $stat, string $url): void
    {
        $clickedLinks = $stat->clicked_links ?? [];
        $clickedLinks[] = [
            'url' => $url,
            'clicked_at' => now(),
        ];

        $stat->update([
            'clicked_at' => now(),
            'clicked_links' => $clickedLinks,
        ]);

        MailLink::where('tracking_url', $url)
            ->increment('clicks');
    }

    protected function getDeviceType(): string
    {
        $userAgent = request()->userAgent();
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
            return 'tablet';
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }
}
```

### 2. Tracking Pixel

```php
namespace Modules\Notify\Http\Controllers;

class TrackingController extends Controller
{
    public function pixel(string $statId)
    {
        $stat = MailStat::findOrFail($statId);
        
        app(MailTrackingService::class)->trackOpen($stat);
        
        return response()->file(
            public_path('images/pixel.gif'),
            ['Content-Type' => 'image/gif']
        );
    }

    public function click(string $linkId)
    {
        $link = MailLink::findOrFail($linkId);
        $stat = MailStat::where('mail_template_id', $link->mail_template_id)
            ->where('recipient_email', request()->query('email'))
            ->firstOrFail();
        
        app(MailTrackingService::class)->trackClick($stat, $link->tracking_url);
        
        return redirect($link->original_url);
    }
}
```

## Analytics

### 1. Analytics Service

```php
namespace Modules\Notify\Services;

class MailAnalyticsService
{
    public function getTemplateStats(MailTemplate $template): array
    {
        return [
            'total_sent' => $this->getTotalSent($template),
            'open_rate' => $this->getOpenRate($template),
            'click_rate' => $this->getClickRate($template),
            'device_stats' => $this->getDeviceStats($template),
            'browser_stats' => $this->getBrowserStats($template),
            'platform_stats' => $this->getPlatformStats($template),
            'link_stats' => $this->getLinkStats($template),
        ];
    }

    protected function getOpenRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $opened = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('opened_at')
            ->count();
            
        return $total > 0 ? ($opened / $total) * 100 : 0;
    }

    protected function getClickRate(MailTemplate $template): float
    {
        $total = $this->getTotalSent($template);
        $clicked = MailStat::where('mail_template_id', $template->id)
            ->whereNotNull('clicked_at')
            ->count();
            
        return $total > 0 ? ($clicked / $total) * 100 : 0;
    }
}
```

### 2. Analytics Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailAnalyticsResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Filtri
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->label('Template'),
                    
                DatePicker::make('from')
                    ->label('Da'),
                    
                DatePicker::make('to')
                    ->label('A'),
                    
                // Statistiche
                StatsOverview::make([
                    Stat::make('Totale Invii', fn () => $this->getTotalSent())
                        ->description('Email inviate')
                        ->descriptionIcon('heroicon-m-envelope'),
                        
                    Stat::make('Tasso Apertura', fn () => $this->getOpenRate())
                        ->description('Email aperte')
                        ->descriptionIcon('heroicon-m-eye'),
                        
                    Stat::make('Tasso Click', fn () => $this->getClickRate())
                        ->description('Link cliccati')
                        ->descriptionIcon('heroicon-m-cursor-arrow-rays'),
                ]),
                
                // Grafici
                Chart::make('Aperture per Giorno')
                    ->type('line')
                    ->data($this->getOpensByDay()),
                    
                Chart::make('Click per Link')
                    ->type('bar')
                    ->data($this->getClicksByLink()),
                    
                Chart::make('Dispositivi')
                    ->type('pie')
                    ->data($this->getDeviceStats()),
            ])
        ]);
    }
}
```

## Integrazione con Filament

### 1. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Analytics
            Action::make('analytics')
                ->label('Analytics')
                ->icon('heroicon-o-chart-bar')
                ->url(fn (MailTemplate $record) => route('filament.resources.mail-analytics.index', [
                    'template' => $record->id,
                ])),
                
            // Esporta dati
            Action::make('export_analytics')
                ->label('Esporta Dati')
                ->icon('heroicon-o-download')
                ->form([
                    Select::make('format')
                        ->options([
                            'csv' => 'CSV',
                            'excel' => 'Excel',
                            'json' => 'JSON',
                        ])
                        ->required(),
                        
                    DatePicker::make('from')
                        ->label('Da'),
                        
                    DatePicker::make('to')
                        ->label('A'),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    return $this->exportAnalytics($record, $data);
                }),
        ];
    }
}
```

### 2. Widgets

```php
namespace Modules\Notify\Filament\Widgets;

class MailAnalyticsWidget extends Widget
{
    protected static string $view = 'notify::widgets.mail-analytics';

    public function getStats(): array
    {
        return app(MailAnalyticsService::class)
            ->getTemplateStats($this->getTemplate());
    }

    protected function getTemplate(): MailTemplate
    {
        return MailTemplate::find($this->templateId);
    }
}
```

## Best Practices

### 1. Privacy

```php
class MailTrackingService
{
    public function anonymizeIp(string $ip): string
    {
        return preg_replace('/\.\d+$/', '.0', $ip);
    }

    public function shouldTrack(): bool
    {
        return !$this->isBot() && 
               !$this->isPreview() && 
               $this->hasConsent();
    }

    protected function isBot(): bool
    {
        return preg_match('/bot|crawl|spider/i', request()->userAgent());
    }

    protected function hasConsent(): bool
    {
        return request()->cookie('tracking_consent') === 'true';
    }
}
```

### 2. Performance

```php
class MailAnalyticsService
{
    public function getStats(): array
    {
        return Cache::remember('mail_stats', 3600, function () {
            return [
                'opens' => $this->getOpens(),
                'clicks' => $this->getClicks(),
                'devices' => $this->getDevices(),
            ];
        });
    }

    protected function getOpens(): Collection
    {
        return MailStat::select('opened_at')
            ->whereNotNull('opened_at')
            ->where('opened_at', '>=', now()->subDays(30))
            ->get()
            ->groupBy(fn ($stat) => $stat->opened_at->format('Y-m-d'))
            ->map->count();
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Tracking non funziona**
   - Verifica pixel
   - Controlla link
   - Debug headers

2. **Dati mancanti**
   - Verifica consenso
   - Controlla filtri
   - Debug cache

3. **Performance lenta**
   - Ottimizza query
   - Usa indici
   - Cache dati

### 2. Debug

```php
class MailTrackingService
{
    public function debug(): array
    {
        return [
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'headers' => request()->headers->all(),
            'cookies' => request()->cookies->all(),
            'is_bot' => $this->isBot(),
            'has_consent' => $this->hasConsent(),
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Analytics](https://github.com/spatie/laravel-analytics)
- [Laravel Mail Tracking](https://github.com/spatie/laravel-mail-tracking)
- [Laravel Mail Preview](https://github.com/spatie/laravel-mail-preview) 
---

## email_backup

*Consolidated from: `email_backup.md`*


## Panoramica

Sistema di backup per preservare e ripristinare i template email.

## Backup Template

### 1. Template Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;

class MailTemplateBackup
{
    protected const BACKUP_PATH = 'backups/templates';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailTemplate $template): string
    {
        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'content' => $template->content,
            'created_at' => $template->created_at,
            'updated_at' => $template->updated_at,
        ];

        $filename = $this->generateBackupFilename($template);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailTemplate
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailTemplate::updateOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['name'],
                'version' => $data['version'],
                'content' => $data['content'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailTemplate $template): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $template->id,
            $template->name,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Template Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateBackup;

class MailTemplateBackupCommand extends Command
{
    protected $signature = 'mail:backup-templates';
    protected $description = 'Backup di tutti i template email';

    protected $backup;

    public function __construct(MailTemplateBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $templates = MailTemplate::all();
        $bar = $this->output->createProgressBar(count($templates));

        $this->info('Inizio backup template...');
        $bar->start();

        foreach ($templates as $template) {
            $this->backup->createBackup($template);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup template completato!');
    }
}
```

## Backup Notifiche

### 1. Notifiche Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailNotification;

class MailNotificationBackup
{
    protected const BACKUP_PATH = 'backups/notifications';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailNotification $notification): string
    {
        $data = [
            'id' => $notification->id,
            'template_id' => $notification->template_id,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'opened_at' => $notification->opened_at,
            'clicked_at' => $notification->clicked_at,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
        ];

        $filename = $this->generateBackupFilename($notification);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailNotification
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailNotification::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'sent_at' => $data['sent_at'],
                'opened_at' => $data['opened_at'],
                'clicked_at' => $data['clicked_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailNotification $notification): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $notification->id,
            $notification->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Notifiche Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationBackup;

class MailNotificationBackupCommand extends Command
{
    protected $signature = 'mail:backup-notifications';
    protected $description = 'Backup di tutte le notifiche email';

    protected $backup;

    public function __construct(MailNotificationBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $notifications = MailNotification::all();
        $bar = $this->output->createProgressBar(count($notifications));

        $this->info('Inizio backup notifiche...');
        $bar->start();

        foreach ($notifications as $notification) {
            $this->backup->createBackup($notification);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup notifiche completato!');
    }
}
```

## Backup Queue

### 1. Queue Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailQueue;

class MailQueueBackup
{
    protected const BACKUP_PATH = 'backups/queue';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailQueue $job): string
    {
        $data = [
            'id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'error' => $job->error,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];

        $filename = $this->generateBackupFilename($job);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailQueue
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailQueue::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'attempts' => $data['attempts'],
                'error' => $data['error'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailQueue $job): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $job->id,
            $job->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Queue Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueBackup;

class MailQueueBackupCommand extends Command
{
    protected $signature = 'mail:backup-queue';
    protected $description = 'Backup della coda email';

    protected $backup;

    public function __construct(MailQueueBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $jobs = MailQueue::all();
        $bar = $this->output->createProgressBar(count($jobs));

        $this->info('Inizio backup coda...');
        $bar->start();

        foreach ($jobs as $job) {
            $this->backup->createBackup($job);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup coda completato!');
    }
}
```

## Best Practices

### 1. Backup Retention

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MailBackupRetention
{
    protected const RETENTION_DAYS = 30;

    public function cleanup(): void
    {
        $this->cleanupTemplates();
        $this->cleanupNotifications();
        $this->cleanupQueue();
    }

    protected function cleanupTemplates(): void
    {
        $files = Storage::files('backups/templates');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupNotifications(): void
    {
        $files = Storage::files('backups/notifications');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupQueue(): void
    {
        $files = Storage::files('backups/queue');
        $this->deleteExpiredFiles($files);
    }

    protected function deleteExpiredFiles(array $files): void
    {
        $expiryDate = Carbon::now()->subDays(self::RETENTION_DAYS);

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $expiryDate->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
```

### 2. Backup Encryption

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class MailBackupEncryption
{
    public function encrypt(string $path): void
    {
        if (!Storage::exists($path)) {
            return;
        }

        $content = Storage::get($path);
        $encrypted = Crypt::encryptString($content);

        Storage::put($path, $encrypted);
    }

    public function decrypt(string $path): ?string
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $encrypted = Storage::get($path);

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Backup Falliti**
   - Verifica spazio
   - Controlla permessi
   - Debug errori

2. **Ripristino Fallito**
   - Verifica integrità
   - Controlla versioni
   - Debug errori

3. **Performance**
   - Ottimizza spazio
   - Gestisci retention
   - Monitora backup

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailBackupDebugger
{
    protected $templateBackup;
    protected $notificationBackup;
    protected $queueBackup;
    protected $retention;
    protected $encryption;

    public function __construct(
        MailTemplateBackup $templateBackup,
        MailNotificationBackup $notificationBackup,
        MailQueueBackup $queueBackup,
        MailBackupRetention $retention,
        MailBackupEncryption $encryption
    ) {
        $this->templateBackup = $templateBackup;
        $this->notificationBackup = $notificationBackup;
        $this->queueBackup = $queueBackup;
        $this->retention = $retention;
        $this->encryption = $encryption;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'storage' => $this->debugStorage(),
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
                'backups' => $this->templateBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'status' => $notification->status,
                'backups' => $this->notificationBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'backups' => $this->queueBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugStorage(): array
    {
        return [
            'templates' => [
                'path' => 'backups/templates',
                'size' => $this->getDirectorySize('backups/templates'),
                'count' => count(Storage::files('backups/templates')),
            ],
            'notifications' => [
                'path' => 'backups/notifications',
                'size' => $this->getDirectorySize('backups/notifications'),
                'count' => count(Storage::files('backups/notifications')),
            ],
            'queue' => [
                'path' => 'backups/queue',
                'size' => $this->getDirectorySize('backups/queue'),
                'count' => count(Storage::files('backups/queue')),
            ],
        ];
    }

    protected function getDirectorySize(string $path): int
    {
        $size = 0;
        $files = Storage::files($path);

        foreach ($files as $file) {
            $size += Storage::size($file);
        }

        return $size;
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Storage](https://laravel.com/project_docs/storage)
- [Laravel Encryption](https://laravel.com/project_docs/encryption)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
---

## email_best_practices

*Consolidated from: `email_best_practices.md`*


## Migrazioni Database

### Struttura Standard
- Utilizzare sempre `XotBaseMigration` come base
- Implementare modifiche nella sezione `tableUpdate`
- Non creare nuove migrazioni per modifiche a tabelle esistenti

### Gestione Campi
- Verificare l'esistenza delle colonne prima di modificarle
- Utilizzare i metodi helper forniti da `XotBaseMigration`
- Documentare tutte le modifiche alle strutture

### Compatibilità
- Mantenere la retrocompatibilità
- Gestire correttamente i rollback
- Testare le migrazioni in ambiente di sviluppo 

---

## email_cache

*Consolidated from: `email_cache.md`*


## Panoramica

Sistema di cache per ottimizzare le performance delle email.

## Cache Template

### 1. Template Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailTemplate;

class MailTemplateCache
{
    protected const CACHE_TAG = 'mail-templates';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getTemplate(int $id): ?MailTemplate
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putTemplate(MailTemplate $template): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($template->id),
            $template,
            self::CACHE_TTL
        );
    }

    public function forgetTemplate(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getTemplateStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementTemplateStats(int $id, string $stat): void
    {
        $stats = $this->getTemplateStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "template:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "template:{$id}:stats";
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateCache;

class MailTemplateObserver
{
    protected $cache;

    public function __construct(MailTemplateCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailTemplate $template): void
    {
        $this->cache->putTemplate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->cache->forgetTemplate($template->id);
    }
}
```

## Cache Notifiche

### 1. Notifiche Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailNotification;

class MailNotificationCache
{
    protected const CACHE_TAG = 'mail-notifications';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getNotification(int $id): ?MailNotification
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putNotification(MailNotification $notification): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($notification->id),
            $notification,
            self::CACHE_TTL
        );
    }

    public function forgetNotification(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    public function getNotificationStats(int $id): array
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getStatsKey($id)) ?? [];
    }

    public function incrementNotificationStats(int $id, string $stat): void
    {
        $stats = $this->getNotificationStats($id);
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            $this->getStatsKey($id),
            $stats,
            self::CACHE_TTL
        );
    }

    protected function getCacheKey(int $id): string
    {
        return "notification:{$id}";
    }

    protected function getStatsKey(int $id): string
    {
        return "notification:{$id}:stats";
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationCache;

class MailNotificationObserver
{
    protected $cache;

    public function __construct(MailNotificationCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailNotification $notification): void
    {
        $this->cache->putNotification($notification);
    }

    public function deleted(MailNotification $notification): void
    {
        $this->cache->forgetNotification($notification->id);
    }
}
```

## Cache Queue

### 1. Queue Cache

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\Models\MailQueue;

class MailQueueCache
{
    protected const CACHE_TAG = 'mail-queue';
    protected const CACHE_TTL = 3600; // 1 ora

    public function getQueueStats(): array
    {
        return Cache::tags(self::CACHE_TAG)->get('queue:stats') ?? [];
    }

    public function incrementQueueStats(string $stat): void
    {
        $stats = $this->getQueueStats();
        $stats[$stat] = ($stats[$stat] ?? 0) + 1;
        Cache::tags(self::CACHE_TAG)->put(
            'queue:stats',
            $stats,
            self::CACHE_TTL
        );
    }

    public function getQueueJob(int $id): ?MailQueue
    {
        return Cache::tags(self::CACHE_TAG)->get($this->getCacheKey($id));
    }

    public function putQueueJob(MailQueue $job): void
    {
        Cache::tags(self::CACHE_TAG)->put(
            $this->getCacheKey($job->id),
            $job,
            self::CACHE_TTL
        );
    }

    public function forgetQueueJob(int $id): void
    {
        Cache::tags(self::CACHE_TAG)->forget($this->getCacheKey($id));
    }

    protected function getCacheKey(int $id): string
    {
        return "queue:job:{$id}";
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueCache;

class MailQueueObserver
{
    protected $cache;

    public function __construct(MailQueueCache $cache)
    {
        $this->cache = $cache;
    }

    public function saved(MailQueue $job): void
    {
        $this->cache->putQueueJob($job);
    }

    public function deleted(MailQueue $job): void
    {
        $this->cache->forgetQueueJob($job->id);
    }
}
```

## Best Practices

### 1. Cache Tags

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheTags
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $tag) {
            Cache::tags($tag)->flush();
        }
    }
}
```

### 2. Cache Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateCached
{
    use SerializesModels;

    public $template;

    public function __construct(MailTemplate $template)
    {
        $this->template = $template;
    }
}

class MailNotificationCached
{
    use SerializesModels;

    public $notification;

    public function __construct(MailNotification $notification)
    {
        $this->notification = $notification;
    }
}

class MailQueueCached
{
    use SerializesModels;

    public $job;

    public function __construct(MailQueue $job)
    {
        $this->job = $job;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Cache non aggiornata**
   - Verifica TTL
   - Controlla tags
   - Debug cache

2. **Performance**
   - Monitora memoria
   - Ottimizza TTL
   - Usa tags

3. **Debug**
   - Verifica chiavi
   - Controlla valori
   - Monitora hit/miss

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Cache;

class MailCacheDebugger
{
    protected $templateCache;
    protected $notificationCache;
    protected $queueCache;

    public function __construct(
        MailTemplateCache $templateCache,
        MailNotificationCache $notificationCache,
        MailQueueCache $queueCache
    ) {
        $this->templateCache = $templateCache;
        $this->notificationCache = $notificationCache;
        $this->queueCache = $queueCache;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'stats' => $this->debugStats(),
        ];
    }

    protected function debugTemplates(): array
    {
        $debug = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $debug[$template->id] = [
                'cached' => Cache::tags(MailCacheTags::TEMPLATES)->has($this->templateCache->getCacheKey($template->id)),
                'stats' => $this->templateCache->getTemplateStats($template->id),
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'cached' => Cache::tags(MailCacheTags::NOTIFICATIONS)->has($this->notificationCache->getCacheKey($notification->id)),
                'stats' => $this->notificationCache->getNotificationStats($notification->id),
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'cached' => Cache::tags(MailCacheTags::QUEUE)->has($this->queueCache->getCacheKey($job->id)),
            ];
        }

        return $debug;
    }

    protected function debugStats(): array
    {
        return [
            'templates' => [
                'hit' => Cache::tags(MailCacheTags::TEMPLATES)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::TEMPLATES)->get('miss') ?? 0,
            ],
            'notifications' => [
                'hit' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::NOTIFICATIONS)->get('miss') ?? 0,
            ],
            'queue' => [
                'hit' => Cache::tags(MailCacheTags::QUEUE)->get('hit') ?? 0,
                'miss' => Cache::tags(MailCacheTags::QUEUE)->get('miss') ?? 0,
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
---

## email_html_best_practices

*Consolidated from: `email_html_best_practices.md`*


## Introduzione

Questo documento definisce le best practices per la creazione di template HTML per email, basate sulle esperienze di [MailPace](https://github.com/mailpace/templates) e altre fonti autorevoli.

## Struttura HTML

### 1. Doctype e Meta Tags
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ subject }}</title>
</head>
```

### 2. Layout Base
```html
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                    <!-- Contenuto -->
                </table>
            </td>
        </tr>
    </table>
</body>
```

## Best Practices

### 1. Layout e Struttura

#### ✅ Usa Table Layout
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

#### ✅ Evita Div Layout
```html
<!-- NON FARE QUESTO -->
<div style="width: 100%;">
    <div style="margin: 0 auto;">
        <!-- Contenuto -->
    </div>
</div>
```

### 2. Stili CSS

#### ✅ Inline CSS
```html
<td style="padding: 20px; background-color: #ffffff;">
    <!-- Contenuto -->
</td>
```

#### ✅ Evita CSS Esterno
```html
<!-- NON FARE QUESTO -->
<link rel="stylesheet" href="styles.css">
```

### 3. Immagini

#### ✅ Dimensioni Esplicite
```html
<img src="logo.png" width="200" height="50" alt="Logo" style="display: block;">
```

#### ✅ Alt Text
```html
<img src="banner.jpg" alt="Descrizione dettagliata" style="display: block;">
```

### 4. Link e Bottoni

#### ✅ Link Stile Button
```html
<a href="{{ url }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; text-decoration: none; border-radius: 4px;">
    {{ text }}
</a>
```

#### ✅ Evita Button HTML
```html
<!-- NON FARE QUESTO -->
<button style="padding: 12px 24px;">Click Me</button>
```

## Compatibilità Client Email

### 1. Gmail
- Supporta CSS inline
- Supporta media queries
- Supporta web fonts limitati

### 2. Outlook
- Richiede table layout
- Supporto limitato per CSS
- Problemi con immagini

### 3. Apple Mail
- Supporto completo per CSS
- Supporto per web fonts
- Supporto per media queries

## Responsive Design

### 1. Media Queries
```html
<style>
    @media screen and (max-width: 600px) {
        .container {
            width: 100% !important;
        }
        .mobile-padding {
            padding: 10px !important;
        }
    }
</style>
```

### 2. Fluid Layout
```html
<table role="presentation" width="100%" style="max-width: 600px;">
    <tr>
        <td style="padding: 20px;">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

## Performance

### 1. Ottimizzazione Immagini
- Usa formati appropriati (PNG, JPG)
- Comprimi le immagini
- Specifica dimensioni

### 2. CSS
- Minimizza CSS inline
- Usa shorthand properties
- Evita proprietà non supportate

### 3. HTML
- Minimizza markup
- Evita tag non necessari
- Usa attributi HTML base

## Testing

### 1. Client Email
- Gmail (Web, Mobile)
- Outlook (Desktop, Web)
- Apple Mail
- Yahoo Mail

### 2. Dispositivi
- Desktop
- Mobile
- Tablet

### 3. Browser
- Chrome
- Firefox
- Safari
- Edge

## Strumenti di Testing

1. **Email on Acid**
   - Test cross-client
   - Preview in tempo reale
   - Report dettagliati

2. **Litmus**
   - Test di compatibilità
   - Preview responsive
   - Analisi spam

3. **Mailtrap**
   - Test in ambiente sicuro
   - Preview HTML
   - Analisi deliverability

## Note Importanti

1. **Compatibilità**
   - Testare su vari client
   - Verificare responsive
   - Controllare spam score

2. **Accessibilità**
   - Alt text per immagini
   - Contrasto colori
   - Struttura semantica

3. **Performance**
   - Ottimizzare immagini
   - Minimizzare codice
   - Testare velocità

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Struttura Template](./MAIL_TEMPLATES_STRUCTURE.md)
- [Template Base](./BASE_TEMPLATES.md)
- [Struttura Template](../../mail_templates_structure.md)
- [Template Base](../../base_templates.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 

---

## email_logs

*Consolidated from: `email_logs.md`*


## Panoramica

Sistema di log per tracciare e monitorare le attività del sistema email.

## Log Template

### 1. Template Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailTemplate;

class MailTemplateLog
{
    protected const LOG_CHANNEL = 'mail-templates';

    public function logCreate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template creato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'created_at' => now(),
        ]);
    }

    public function logUpdate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template aggiornato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'updated_at' => now(),
        ]);
    }

    public function logDelete(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template eliminato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'deleted_at' => now(),
        ]);
    }

    public function logError(MailTemplate $template, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore template', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateLog;

class MailTemplateObserver
{
    protected $log;

    public function __construct(MailTemplateLog $log)
    {
        $this->log = $log;
    }

    public function created(MailTemplate $template): void
    {
        $this->log->logCreate($template);
    }

    public function updated(MailTemplate $template): void
    {
        $this->log->logUpdate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->log->logDelete($template);
    }
}
```

## Log Notifiche

### 1. Notifiche Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailNotification;

class MailNotificationLog
{
    protected const LOG_CHANNEL = 'mail-notifications';

    public function logSend(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica inviata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'recipients' => $notification->recipients,
            'sent_at' => now(),
        ]);
    }

    public function logOpen(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica aperta', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'opened_at' => now(),
        ]);
    }

    public function logClick(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica cliccata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'clicked_at' => now(),
        ]);
    }

    public function logError(MailNotification $notification, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore notifica', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationLog;

class MailNotificationObserver
{
    protected $log;

    public function __construct(MailNotificationLog $log)
    {
        $this->log = $log;
    }

    public function saved(MailNotification $notification): void
    {
        if ($notification->wasRecentlyCreated) {
            $this->log->logSend($notification);
        }
    }

    public function updated(MailNotification $notification): void
    {
        if ($notification->isDirty('opened_at')) {
            $this->log->logOpen($notification);
        }

        if ($notification->isDirty('clicked_at')) {
            $this->log->logClick($notification);
        }
    }
}
```

## Log Queue

### 1. Queue Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailQueue;

class MailQueueLog
{
    protected const LOG_CHANNEL = 'mail-queue';

    public function logAdd(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job aggiunto', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'added_at' => now(),
        ]);
    }

    public function logProcess(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job processato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'processed_at' => now(),
        ]);
    }

    public function logFail(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Job fallito', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'error' => $job->error,
            'failed_at' => now(),
        ]);
    }

    public function logRetry(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job riprovato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'retried_at' => now(),
        ]);
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueLog;

class MailQueueObserver
{
    protected $log;

    public function __construct(MailQueueLog $log)
    {
        $this->log = $log;
    }

    public function created(MailQueue $job): void
    {
        $this->log->logAdd($job);
    }

    public function updated(MailQueue $job): void
    {
        if ($job->isDirty('status')) {
            switch ($job->status) {
                case 'processing':
                    $this->log->logProcess($job);
                    break;
                case 'failed':
                    $this->log->logFail($job);
                    break;
                case 'retrying':
                    $this->log->logRetry($job);
                    break;
            }
        }
    }
}
```

## Best Practices

### 1. Log Channels

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogChannels
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $channel) {
            Log::channel($channel)->info('Log cleared', [
                'cleared_at' => now(),
            ]);
        }
    }
}
```

### 2. Log Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateLogged
{
    use SerializesModels;

    public $template;
    public $action;

    public function __construct(MailTemplate $template, string $action)
    {
        $this->template = $template;
        $this->action = $action;
    }
}

class MailNotificationLogged
{
    use SerializesModels;

    public $notification;
    public $action;

    public function __construct(MailNotification $notification, string $action)
    {
        $this->notification = $notification;
        $this->action = $action;
    }
}

class MailQueueLogged
{
    use SerializesModels;

    public $job;
    public $action;

    public function __construct(MailQueue $job, string $action)
    {
        $this->job = $job;
        $this->action = $action;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Log non scritti**
   - Verifica permessi
   - Controlla canali
   - Debug log

2. **Performance**
   - Monitora spazio
   - Ottimizza rotazione
   - Usa canali

3. **Debug**
   - Verifica livelli
   - Controlla formati
   - Monitora errori

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogDebugger
{
    protected $templateLog;
    protected $notificationLog;
    protected $queueLog;

    public function __construct(
        MailTemplateLog $templateLog,
        MailNotificationLog $notificationLog,
        MailQueueLog $queueLog
    ) {
        $this->templateLog = $templateLog;
        $this->notificationLog = $notificationLog;
        $this->queueLog = $queueLog;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'channels' => $this->debugChannels(),
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
                'created_at' => $template->created_at,
                'updated_at' => $template->updated_at,
                'deleted_at' => $template->deleted_at,
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'recipients' => $notification->recipients,
                'sent_at' => $notification->sent_at,
                'opened_at' => $notification->opened_at,
                'clicked_at' => $notification->clicked_at,
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'attempts' => $job->attempts,
                'error' => $job->error,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at,
            ];
        }

        return $debug;
    }

    protected function debugChannels(): array
    {
        return [
            'templates' => [
                'enabled' => Log::channel(MailLogChannels::TEMPLATES)->isEnabled(),
                'level' => Log::channel(MailLogChannels::TEMPLATES)->getLevel(),
            ],
            'notifications' => [
                'enabled' => Log::channel(MailLogChannels::NOTIFICATIONS)->isEnabled(),
                'level' => Log::channel(MailLogChannels::NOTIFICATIONS)->getLevel(),
            ],
            'queue' => [
                'enabled' => Log::channel(MailLogChannels::QUEUE)->isEnabled(),
                'level' => Log::channel(MailLogChannels::QUEUE)->getLevel(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 
---

## email_monitoring

*Consolidated from: `email_monitoring.md`*


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
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Cache](https://laravel.com/project_docs/cache)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Commands](https://laravel.com/project_docs/artisan) 
- [Laravel Events](https://laravel.com/project_docs/events) 
---

## email_notifications

*Consolidated from: `email_notifications.md`*


## Panoramica

Sistema di notifiche per eventi e azioni in il progetto.

## Struttura Notifiche

### 1. Notifiche Base

```php
namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notify\Mail\TemplatedMail;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $template;
    protected $data;

    public function __construct(MailTemplate $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): TemplatedMail
    {
        return (new TemplatedMail($this->template, $this->data))
            ->to($notifiable->email);
    }

    public function toArray($notifiable): array
    {
        return [
            'template_id' => $this->template->id,
            'data' => $this->data,
        ];
    }
}
```

### 2. Notifiche Specifiche

```php
namespace Modules\Notify\Notifications;

class AppointmentNotification extends GenericNotification
{
    public function __construct(Appointment $appointment)
    {
        $template = MailTemplate::where('type', 'appointment')->first();
        
        $data = [
            'appointment' => $appointment,
            'patient' => $appointment->patient,
            'doctor' => $appointment->doctor,
            'date' => $appointment->date->format('d/m/Y'),
            'time' => $appointment->time->format('H:i'),
        ];

        parent::__construct($template, $data);
    }
}

class PaymentNotification extends GenericNotification
{
    public function __construct(Payment $payment)
    {
        $template = MailTemplate::where('type', 'payment')->first();
        
        $data = [
            'payment' => $payment,
            'amount' => $payment->amount,
            'date' => $payment->date->format('d/m/Y'),
            'method' => $payment->method,
        ];

        parent::__construct($template, $data);
    }
}
```

## Eventi

### 1. Event Listeners

```php
namespace Modules\Notify\Listeners;

class SendAppointmentNotification
{
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        
        // Notifica paziente
        $appointment->patient->notify(new AppointmentNotification($appointment));
        
        // Notifica medico
        $appointment->doctor->notify(new AppointmentNotification($appointment));
    }
}

class SendPaymentNotification
{
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        
        // Notifica paziente
        $payment->patient->notify(new PaymentNotification($payment));
        
        // Notifica amministrazione
        User::where('role', 'admin')->get()
            ->each->notify(new PaymentNotification($payment));
    }
}
```

### 2. Event Service Provider

```php
namespace Modules\Notify\Providers;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AppointmentCreated::class => [
            SendAppointmentNotification::class,
        ],
        PaymentReceived::class => [
            SendPaymentNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        // Registra eventi
        Event::listen('appointment.*', function ($event, $payload) {
            // Log evento
            Log::info('Appointment event', [
                'event' => $event,
                'payload' => $payload,
            ]);
        });
    }
}
```

## Integrazione con Filament

### 1. Notifications Resource

```php
namespace Modules\Notify\Filament\Resources;

class NotificationResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Template
                Select::make('template')
                    ->options(MailTemplate::pluck('name', 'id'))
                    ->required()
                    ->label('Template'),
                    
                // Dati
                KeyValue::make('data')
                    ->label('Dati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),
                    
                // Destinatari
                Select::make('recipients')
                    ->multiple()
                    ->options([
                        'patient' => 'Paziente',
                        'doctor' => 'Medico',
                        'admin' => 'Amministrazione',
                    ])
                    ->required()
                    ->label('Destinatari'),
                    
                // Programma
                DateTimePicker::make('scheduled_at')
                    ->label('Programma')
                    ->nullable(),
            ])
        ]);
    }
}
```

### 2. Notifications Actions

```php
class NotificationActions
{
    public static function make(): array
    {
        return [
            // Invia ora
            Action::make('send_now')
                ->label('Invia Ora')
                ->icon('heroicon-o-paper-airplane')
                ->action(function (Notification $record) {
                    $record->send();
                }),
                
            // Programma
            Action::make('schedule')
                ->label('Programma')
                ->icon('heroicon-o-clock')
                ->form([
                    DateTimePicker::make('scheduled_at')
                        ->required()
                        ->label('Data e Ora'),
                ])
                ->action(function (array $data, Notification $record) {
                    $record->schedule($data['scheduled_at']);
                }),
                
            // Duplica
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Notification $record) {
                    $record->replicate()->save();
                }),
        ];
    }
}
```

## Best Practices

### 1. Gestione Template

```php
class NotificationTemplate
{
    public static function make(string $type, array $data = []): MailTemplate
    {
        $template = MailTemplate::where('type', $type)->first();
        
        if (!$template) {
            throw new \Exception("Template {$type} not found");
        }
        
        // Verifica placeholder
        $placeholders = $template->getPlaceholders();
        $missing = array_diff($placeholders, array_keys($data));
        
        if (!empty($missing)) {
            throw new \Exception("Missing placeholders: " . implode(', ', $missing));
        }
        
        return $template;
    }
}
```

### 2. Validazione Dati

```php
class NotificationValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Verifica template
        if (!isset($data['template'])) {
            $errors[] = 'Template is required';
        }

        // Verifica destinatari
        if (empty($data['recipients'])) {
            $errors[] = 'Recipients are required';
        }

        // Verifica dati
        if (!$this->validateData($data['data'])) {
            $errors[] = 'Invalid data';
        }

        return $errors;
    }

    protected function validateData(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Notifiche non inviate**
   - Verifica template
   - Controlla destinatari
   - Debug eventi

2. **Dati mancanti**
   - Verifica placeholder
   - Controlla validazione
   - Debug payload

3. **Errori invio**
   - Verifica configurazione
   - Controlla log
   - Debug queue

### 2. Debug

```php
class NotificationDebugger
{
    public function debug(Notification $notification): array
    {
        return [
            'template' => [
                'id' => $notification->template->id,
                'type' => $notification->template->type,
                'placeholders' => $notification->template->getPlaceholders(),
            ],
            'data' => $notification->data,
            'recipients' => $notification->recipients,
            'scheduled' => $notification->scheduled_at,
            'status' => $notification->status,
            'error' => $notification->error,
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Mail](https://laravel.com/project_docs/mail) 
---

## email_plugins_analysis

*Consolidated from: `email_plugins_analysis.md`*


## Panoramica

Analisi comparativa dei principali plugin per la gestione email in Filament, con focus sulle funzionalità che possiamo integrare nel nostro sistema.

## Plugin Analizzati

### 1. Filament Error Mailer (hugomyb/filament-error-mailer)
**Punti di Forza:**
- Notifica errori via email
- Integrazione con Filament
- Configurazione semplice

**Limitazioni:**
- Solo per errori
- Funzionalità limitate
- No template personalizzati

### 2. Filament Mails (vormkracht10/filament-mails)
**Punti di Forza:**
- Gestione template
- Preview email
- Test invio

**Limitazioni:**
- No versionamento
- No multilingua
- No statistiche

### 3. Email Templates (visualbuilder/email-templates)
**Punti di Forza:**
- Editor WYSIWYG
- Template responsive
- Preview live

**Limitazioni:**
- Dipendenze esterne
- Performance
- Complessità

### 4. Database Mail (martin-petricko/database-mail)
**Punti di Forza:**
- Template in database
- Multilingua
- Cache

**Limitazioni:**
- Costo
- Limitazioni tecniche
- No versionamento

## Nostra Implementazione

### 1. Caratteristiche Uniche

```php
// Esempio di implementazione avanzata
class MailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'variables' => 'array',
        'layout' => 'array',
        'is_active' => 'boolean',
    ];

    // Versionamento
    public function versions()
    {
        return $this->hasMany(MailTemplateVersion::class);
    }

    // Statistiche
    public function stats()
    {
        return $this->hasMany(MailStats::class);
    }

    // Cache
    public function getCachedTemplate()
    {
        return Cache::remember(
            "mail_template_{$this->id}",
            now()->addDay(),
            fn() => $this->html_template
        );
    }
}
```

### 2. Miglioramenti Proposti

1. **Sistema di Versionamento**
   - Storico completo modifiche
   - Rollback versioni
   - Confronto versioni
   - Note di cambiamento

2. **Editor Avanzato**
   - WYSIWYG migliorato
   - Supporto componenti
   - Preview multi-device
   - Validazione in tempo reale

3. **Gestione Layout**
   - Layout personalizzabili
   - Componenti riutilizzabili
   - Responsive design
   - Branding dinamico

4. **Analytics**
   - Tracking aperture
   - Click tracking
   - A/B testing
   - Report avanzati

5. **Performance**
   - Cache intelligente
   - Lazy loading
   - Ottimizzazione query
   - Compressione assets

### 3. Integrazione Filament

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor avanzato
                RichEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview live
                ViewField::make('preview')
                    ->view('notify::mail.preview'),

                // Versionamento
                Repeater::make('versions')
                    ->schema([
                        TextInput::make('version')
                            ->required(),
                        Textarea::make('changes')
                            ->required(),
                    ]),

                // Analytics
                StatsOverview::make([
                    'opens' => fn() => $this->getOpenStats(),
                    'clicks' => fn() => $this->getClickStats(),
                    'conversion' => fn() => $this->getConversionRate(),
                ]),
            ])
        ]);
    }
}
```

### 4. Sistema di Cache

```php
class MailTemplateCache
{
    public function getTemplate(string $key): ?string
    {
        return Cache::tags(['mail_templates'])
            ->remember(
                "template:{$key}",
                now()->addDay(),
                fn() => $this->loadTemplate($key)
            );
    }

    public function invalidate(string $key): void
    {
        Cache::tags(['mail_templates'])->forget("template:{$key}");
    }
}
```

### 5. Analytics e Tracking

```php
class MailAnalytics
{
    public function trackOpen(MailTemplate $template, string $email): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'open',
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }

    public function trackClick(MailTemplate $template, string $email, string $url): void
    {
        $template->stats()->create([
            'email' => $email,
            'event' => 'click',
            'metadata' => [
                'url' => $url,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ],
        ]);
    }
}
```

## Vantaggi della Nostra Soluzione

1. **Completezza**
   - Funzionalità complete
   - Integrazione nativa
   - Estensibilità

2. **Performance**
   - Ottimizzazione
   - Cache intelligente
   - Scalabilità

3. **Manutenibilità**
   - Codice pulito
   - Documentazione
   - Test coverage

4. **Sicurezza**
   - Validazione
   - Sanitizzazione
   - Permessi

5. **UX/UI**
   - Interfaccia intuitiva
   - Preview live
   - Feedback immediato

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor base
   - [x] Preview

2. **Fase 2 - Avanzato**
   - [ ] Versionamento
   - [ ] Analytics
   - [ ] A/B testing

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Queue](database-mail-queue.md)
- [Testing](database-mail-system-tests.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Queue](../../database-mail-queue.md)
- [Testing](../../database-mail-system-tests.md)

## Vedi Anche
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Spatie Packages](https://spatie.be/open-source) 
---

## email_queue

*Consolidated from: `email_queue.md`*


## Panoramica

Sistema di gestione code per l'invio di email in il progetto.

## Struttura Code

### 1. Job

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;

    protected $template;
    protected $recipient;
    protected $data;

    public function __construct(MailTemplate $template, string $recipient, array $data = [])
    {
        $this->template = $template;
        $this->recipient = $recipient;
        $this->data = $data;
    }

    public function handle(): void
    {
        try {
            // Crea stat
            $stat = MailStat::create([
                'mail_template_id' => $this->template->id,
                'recipient_email' => $this->recipient,
                'status' => 'pending',
            ]);

            // Invia email
            Mail::to($this->recipient)
                ->send(new TemplatedMail($this->template, $this->data));

            // Aggiorna stat
            $stat->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Log errore
            Log::error('Mail send failed', [
                'template' => $this->template->id,
                'recipient' => $this->recipient,
                'error' => $e->getMessage(),
            ]);

            // Aggiorna stat
            $stat->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        // Notifica amministratore
        Notification::route('mail', config('notify.admin_email'))
            ->notify(new MailFailedNotification(
                $this->template,
                $this->recipient,
                $exception
            ));
    }
}
```

### 2. Queue Manager

```php
namespace Modules\Notify\Services;

class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Verifica limiti
        $this->checkLimits($template);

        // Crea job
        $job = new SendMailJob($template, $recipient, $data);

        // Imposta priorità
        $job->onQueue($this->getQueueName($template));

        // Dispatch
        dispatch($job);
    }

    protected function checkLimits(MailTemplate $template): void
    {
        $count = MailStat::where('mail_template_id', $template->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($count >= $template->hourly_limit) {
            throw new \Exception('Hourly limit exceeded');
        }
    }

    protected function getQueueName(MailTemplate $template): string
    {
        return $template->priority === 'high' ? 'mail-high' : 'mail-default';
    }
}
```

## Configurazione

### 1. Queue Config

```php
// config/queue.php
return [
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => 'database',
        'database' => 'mysql',
        'table' => 'failed_jobs',
    ],
];

// config/notify.php
return [
    'queue' => [
        'high_priority' => 'mail-high',
        'default_priority' => 'mail-default',
        'hourly_limit' => 1000,
        'retry_after' => 60,
        'tries' => 3,
    ],
];
```

### 2. Supervisor Config

```ini
[program:laravel-mail-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/base_<nome progetto>/laravel/artisan queue:work redis --queue=mail-high,mail-default --tries=3 --timeout=60
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/mail-worker.log
```

## Monitoraggio

### 1. Queue Monitor

```php
namespace Modules\Notify\Services;

class MailQueueMonitor
{
    public function getStats(): array
    {
        return [
            'pending' => $this->getPendingCount(),
            'processing' => $this->getProcessingCount(),
            'failed' => $this->getFailedCount(),
            'processed' => $this->getProcessedCount(),
            'retry' => $this->getRetryCount(),
        ];
    }

    protected function getPendingCount(): int
    {
        return Redis::connection()->llen('queues:mail-high') +
               Redis::connection()->llen('queues:mail-default');
    }

    protected function getFailedCount(): int
    {
        return DB::table('failed_jobs')
            ->where('queue', 'like', 'mail%')
            ->count();
    }
}
```

### 2. Queue Dashboard

```php
namespace Modules\Notify\Filament\Resources;

class MailQueueResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Statistiche
                StatsOverview::make([
                    Stat::make('In Coda', fn () => $this->getPendingCount())
                        ->description('Job in attesa')
                        ->descriptionIcon('heroicon-m-clock'),
                        
                    Stat::make('In Elaborazione', fn () => $this->getProcessingCount())
                        ->description('Job in corso')
                        ->descriptionIcon('heroicon-m-arrow-path'),
                        
                    Stat::make('Falliti', fn () => $this->getFailedCount())
                        ->description('Job falliti')
                        ->descriptionIcon('heroicon-m-x-circle'),
                ]),
                
                // Grafici
                Chart::make('Job per Ora')
                    ->type('line')
                    ->data($this->getJobsByHour()),
                    
                Chart::make('Tempo di Elaborazione')
                    ->type('bar')
                    ->data($this->getProcessingTime()),
                    
                Chart::make('Fallimenti per Causa')
                    ->type('pie')
                    ->data($this->getFailureReasons()),
            ])
        ]);
    }
}
```

## Best Practices

### 1. Rate Limiting

```php
class MailQueueManager
{
    public function dispatch(MailTemplate $template, string $recipient, array $data = []): void
    {
        // Rate limiting per template
        $this->rateLimitTemplate($template);

        // Rate limiting per destinatario
        $this->rateLimitRecipient($recipient);

        // Dispatch
        $this->dispatchJob($template, $recipient, $data);
    }

    protected function rateLimitTemplate(MailTemplate $template): void
    {
        $key = "mail:template:{$template->id}";
        
        if (RateLimiter::tooManyAttempts($key, $template->hourly_limit)) {
            throw new \Exception('Template rate limit exceeded');
        }
        
        RateLimiter::hit($key);
    }

    protected function rateLimitRecipient(string $recipient): void
    {
        $key = "mail:recipient:{$recipient}";
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw new \Exception('Recipient rate limit exceeded');
        }
        
        RateLimiter::hit($key);
    }
}
```

### 2. Error Handling

```php
class SendMailJob
{
    public function handle(): void
    {
        try {
            // Verifica template
            if (!$this->template->isValid()) {
                throw new \Exception('Invalid template');
            }

            // Verifica destinatario
            if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid recipient');
            }

            // Invia email
            $this->sendMail();

        } catch (\Exception $e) {
            // Log errore
            $this->logError($e);

            // Notifica fallimento
            $this->notifyFailure($e);

            // Riprova se possibile
            if ($this->attempts() < $this->tries) {
                $this->release(30);
            }

            throw $e;
        }
    }

    protected function logError(\Exception $e): void
    {
        Log::error('Mail send failed', [
            'template' => $this->template->id,
            'recipient' => $this->recipient,
            'attempt' => $this->attempts(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Code bloccate**
   - Verifica worker
   - Controlla timeout
   - Debug job

2. **Job falliti**
   - Verifica errori
   - Controlla retry
   - Debug log

3. **Performance lenta**
   - Ottimizza query
   - Aumenta worker
   - Monitora risorse

### 2. Debug

```php
class MailQueueManager
{
    public function debug(): array
    {
        return [
            'redis' => [
                'pending' => $this->getRedisPending(),
                'processing' => $this->getRedisProcessing(),
                'failed' => $this->getRedisFailed(),
            ],
            'supervisor' => [
                'status' => $this->getSupervisorStatus(),
                'workers' => $this->getSupervisorWorkers(),
            ],
            'database' => [
                'failed_jobs' => $this->getFailedJobs(),
                'mail_stats' => $this->getMailStats(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Horizon](https://laravel.com/project_docs/horizon)
- [Laravel Supervisor](https://laravel.com/project_docs/queues#supervisor-configuration) 
---

## email_sending_troubleshooting

*Consolidated from: `email_sending_troubleshooting.md`*


## Problema: `SendEmail.php` vs `TestSmtpPage.php`

È stato rilevato che nel modulo Notify:
- `Modules/Notify/app/Filament/Clusters/Test/Pages/TestSmtpPage.php` funziona correttamente
- `Modules/Notify/app/Filament/Clusters/Test/Pages/SendEmail.php` non funziona

Questa guida spiega le differenze e come risolvere il problema.

## Analisi delle Differenze

### 1. Estensione Base

```php
// TestSmtpPage.php (funzionante)
class TestSmtpPage extends XotBasePage implements HasForms

// SendEmail.php (non funzionante)
class SendEmail extends Page implements HasForms
```

**Problema**: `SendEmail` estende direttamente `Filament\Pages\Page` invece di `Modules\Xot\Filament\Pages\XotBasePage`.

### 2. Gestione della Configurazione SMTP

```php
// TestSmtpPage.php (funzionante)
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    // ...permette di inserire i dati SMTP
}

// SendEmail.php (non funzionante)
public function emailForm(Form $form): Form
{
    // Non gestisce la configurazione SMTP, ma usa solo quella predefinita
}
```

**Problema**: `SendEmail` non permette di configurare le impostazioni SMTP, ma usa direttamente la configurazione di sistema.

### 3. Metodo di Invio Email

```php
// TestSmtpPage.php (funzionante)
public function sendEmail(): void
{
    try {
        // Crea nuovo mailer con configurazione dinamica
        // Gestisce gli errori
    }

// SendEmail.php (non funzionante)
public function sendEmail(): void
{
    $data = $this->emailForm->getState();
    $email_data = EmailData::from($data);

    Mail::to($data['to'])->send(
        new EmailDataEmail($email_data)
    );
    // Nessuna gestione errori
}
```

**Problema**: `SendEmail` usa il mailer di sistema senza override di configurazione o gestione errori.

## Soluzioni

### Approccio 1: Estendere `XotBasePage`

Modifica `SendEmail.php` per estendere `XotBasePage` anziché `Page`:

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage implements HasForms
```

### Approccio 2: Implementare la Configurazione SMTP 

Aggiungere campi di configurazione nel form:

```php
public function emailForm(Form $form): Form
{
    Assert::isArray($mail_config = config('mail'));
    $smtpConfig = Arr::get($mail_config, 'mailers.smtp');
    
    return $form
        ->schema(
            [
                Forms\Components\Section::make('SMTP')
                    ->schema(
                        [
                            Forms\Components\TextInput::make('host'),
                            Forms\Components\TextInput::make('port')->numeric(),
                            Forms\Components\TextInput::make('username'),
                            Forms\Components\TextInput::make('password'),
                            Forms\Components\TextInput::make('encryption'),
                        ]
                    )->columns(3),
                // Resto del form
            ]
        );
}
```

### Approccio 3: Override della Configurazione nel Metodo `sendEmail()`

```php
public function sendEmail(): void
{
    try {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);
        
        // Crea configurazione temporanea
        $config = [
            'transport' => 'smtp',
            'host' => $data['host'] ?? env('MAIL_HOST'),
            'port' => $data['port'] ?? env('MAIL_PORT'),
            'encryption' => $data['encryption'] ?? env('MAIL_ENCRYPTION'),
            'username' => $data['username'] ?? env('MAIL_USERNAME'),
            'password' => $data['password'] ?? env('MAIL_PASSWORD'),
        ];
        
        // Crea mailer temporaneo
        $mailer = app('mail.manager')->createTransport($config);
        $symfony_mailer = new \Symfony\Component\Mailer\Mailer($mailer);
        
        // Invia usando mailer temporaneo
        $symfony_mailer->send(new EmailDataEmail($email_data));
        
        Notification::make()
            ->success()
            ->title(__('Email inviata con successo'))
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->danger()
            ->title(__('Errore nell\'invio dell\'email'))
            ->body($e->getMessage())
            ->send();
    }
}
```

### Approccio 4: Configurazione del file `.env`

Se si desidera utilizzare il mailer di sistema, assicurarsi che il file `.env` contenga le corrette impostazioni:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="Your Name"
```

> **Nota**: Il mailer di default è configurato come 'log' nel file `config/mail.php`. Modificare `.env` per utilizzare 'smtp' o altro mailer.

## Soluzione Raccomandata

La soluzione migliore è combinare gli approcci 1 e 3:

1. Estendere `XotBasePage` per sfruttare le funzionalità base
2. Implementare la gestione della configurazione SMTP
3. Utilizzare un blocco try/catch per gestire gli errori

## Esempi di Implementazione

Un esempio completo di implementazione è disponibile in `TestSmtpPage.php`. Si consiglia di studiare questo file come riferimento per risolvere i problemi in `SendEmail.php`.

## Best Practices

1. Utilizzare sempre le classi base di Xot quando disponibili
2. Implementare la gestione degli errori per operazioni che potrebbero fallire
3. Offrire opzioni flessibili per la configurazione SMTP
4. Testare l'invio di email in diversi ambienti (sviluppo, test, produzione)

## Riferimenti

- [Documentazione Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Modulo Xot - XotBasePage](mdc:../../Xot/docs/pages.md)

---

## email_translations

*Consolidated from: `email_translations.md`*


## Panoramica

Sistema di traduzione multilingua per i template email in il progetto.

## Struttura Traduzioni

### 1. File di Traduzione

```php
// resources/lang/it/notify.php
return [
    'mail' => [
        'templates' => [
            'welcome' => [
                'subject' => 'Benvenuto in il progetto',
                'greeting' => 'Ciao {{ $name }}',
                'content' => 'Grazie per esserti registrato...',
                'button' => [
                    'text' => 'Inizia Ora',
                    'tooltip' => 'Clicca per iniziare',
                ],
            ],
            'appointment' => [
                'subject' => 'Appuntamento Confermato',
                'greeting' => 'Gentile {{ $name }}',
                'content' => 'Il tuo appuntamento è stato confermato...',
                'button' => [
                    'text' => 'Vedi Dettagli',
                    'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
                ],
            ],
        ],
        'components' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
            ],
            'footer' => [
                'text' => '© {{ $year }} il progetto',
                'privacy' => 'Privacy Policy',
                'terms' => 'Termini e Condizioni',
            ],
        ],
    ],
];
```

### 2. Gestione Traduzioni

```php
namespace Modules\Notify\Services;

class MailTranslationService
{
    public function translate(string $key, array $replace = [], string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = trans("notify::mail.{$key}", $replace, $locale);
        
        if ($translation === "notify::mail.{$key}") {
            return $this->fallbackTranslation($key, $replace);
        }
        
        return $translation;
    }

    protected function fallbackTranslation(string $key, array $replace): string
    {
        return trans("notify::mail.{$key}", $replace, 'en');
    }
}
```

### 3. Integrazione con Editor

```php
namespace Modules\Notify\Filament\Forms\Components;

class TranslatableEmailEditor extends EmailEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslatableEmailEditor $component, $state) {
            $component->state($this->translateState($state));
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->untranslateState($state);
        });
    }

    protected function translateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->translate($matches[1]);
            },
            $state
        );
    }

    protected function untranslateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->untranslate($matches[1]);
            },
            $state
        );
    }
}
```

## Componenti Traducibili

### 1. Button Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableButtonBlock extends ButtonBlock
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.button.text'))
                    ->tooltip(trans('notify::mail.components.button.tooltip')),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label(trans('notify::mail.components.button.url')),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label(trans('notify::mail.components.button.color')),
            ]);
    }
}
```

### 2. Footer Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableFooterBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.footer.text')),
                TextInput::make('privacy')
                    ->required()
                    ->label(trans('notify::mail.components.footer.privacy')),
                TextInput::make('terms')
                    ->required()
                    ->label(trans('notify::mail.components.footer.terms')),
            ]);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor traducibile
                TranslatableEmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Lingua
                Select::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                    ])
                    ->default('it')
                    ->required(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => trans('notify::mail.components.button.label'),
                        'footer' => trans('notify::mail.components.footer.label'),
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Traduci
            Action::make('translate')
                ->label(trans('notify::mail.actions.translate'))
                ->icon('heroicon-o-translate')
                ->form([
                    Select::make('target_locale')
                        ->options([
                            'en' => 'English',
                            'de' => 'Deutsch',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    $record->translate($data['target_locale']);
                }),

            // Esporta traduzioni
            Action::make('export_translations')
                ->label(trans('notify::mail.actions.export_translations'))
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo json_encode($record->getTranslations(), JSON_PRETTY_PRINT);
                    }, "translations-{$record->id}.json");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura Chiavi

```php
// Struttura consigliata
[
    'module' => [
        'feature' => [
            'element' => [
                'property' => 'value',
                'tooltip' => 'tooltip value',
                'placeholder' => 'placeholder value',
            ],
        ],
    ],
]

// Esempio
[
    'notify' => [
        'mail' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
                'placeholder' => 'Inserisci testo...',
            ],
        ],
    ],
]
```

### 2. Gestione Placeholder

```php
class TranslationPlaceholder
{
    public static function make(string $key, array $attributes = []): array
    {
        return [
            'key' => $key,
            'label' => trans("notify::mail.placeholders.{$key}.label"),
            'tooltip' => trans("notify::mail.placeholders.{$key}.tooltip"),
            'attributes' => $attributes,
        ];
    }
}

// Uso
$placeholders = [
    TranslationPlaceholder::make('name', ['required' => true]),
    TranslationPlaceholder::make('date', ['format' => 'd/m/Y']),
];
```

### 3. Validazione Traduzioni

```php
class TranslationValidator
{
    public function validate(array $translations): array
    {
        $errors = [];

        foreach ($translations as $locale => $data) {
            // Verifica chiavi mancanti
            if (!$this->hasRequiredKeys($data)) {
                $errors[$locale][] = 'Chiavi richieste mancanti';
            }

            // Verifica placeholder
            if (!$this->hasValidPlaceholders($data)) {
                $errors[$locale][] = 'Placeholder non validi';
            }

            // Verifica lunghezza
            if (!$this->hasValidLength($data)) {
                $errors[$locale][] = 'Lunghezza non valida';
            }
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Traduzioni mancanti**
   - Verifica file di traduzione
   - Controlla namespace
   - Debug fallback

2. **Placeholder non funzionano**
   - Verifica sintassi
   - Controlla escape
   - Debug replace

3. **Cache traduzioni**
   - Pulisci cache
   - Ricarica traduzioni
   - Verifica locale

### 2. Performance

1. **Caricamento lento**
   - Cache traduzioni
   - Lazy loading
   - Ottimizza query

2. **Memoria alta**
   - Limita traduzioni
   - Pulisci cache
   - Monitora uso

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Editor WYSIWYG](../../email-wysiwyg-editor.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)

## Vedi Anche
- [Laravel Localization](https://laravel.com/project_docs/localization)
- [Laravel Lang](https://github.com/Laravel-Lang/lang)
- [Laravel Translation Manager](https://github.com/barryvdh/laravel-translation-manager) 
---

## email_wysiwyg_editor

*Consolidated from: `email_wysiwyg_editor.md`*


## Panoramica

Implementazione di un editor WYSIWYG avanzato per la creazione e modifica dei template email in il progetto.

## Caratteristiche

### 1. Editor Base

```php
namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Component;

class EmailEditor extends Field
{
    protected string $view = 'notify::forms.components.email-editor';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (EmailEditor $component, $state) {
            $component->state($state);
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->sanitizeHtml($state);
        });
    }

    protected function sanitizeHtml(string $html): string
    {
        return clean($html, [
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,u,a[href],p,br,ul,ol,li,img[src|alt|width|height],table,thead,tbody,tr,td,th',
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]);
    }
}
```

### 2. Componenti Personalizzati

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class ButtonBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label('Testo'),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label('URL'),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label('Colore'),
            ])
            ->view('notify::forms.components.blocks.button');
    }
}

class ImageBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->label('Immagine'),
                TextInput::make('alt')
                    ->required()
                    ->label('Testo alternativo'),
            ])
            ->view('notify::forms.components.blocks.image');
    }
}
```

### 3. Preview Live

```php
namespace Modules\Notify\Filament\Forms\Components;

class EmailPreview extends Field
{
    protected string $view = 'notify::forms.components.email-preview';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function ($state) {
            $this->dispatch('preview-updated', [
                'html' => $this->renderPreview($state)
            ]);
        });
    }

    protected function renderPreview($state): string
    {
        return view('notify::mail.preview', [
            'content' => $state,
            'layout' => $this->getLayout(),
        ])->render();
    }
}
```

### 4. Validazione

```php
namespace Modules\Notify\Rules;

class EmailTemplateRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Verifica struttura HTML
        if (!$this->isValidHtml($value)) {
            return false;
        }

        // Verifica placeholder
        if (!$this->hasValidPlaceholders($value)) {
            return false;
        }

        // Verifica responsive
        if (!$this->isResponsive($value)) {
            return false;
        }

        return true;
    }

    protected function isValidHtml(string $html): bool
    {
        $dom = new \DOMDocument();
        return @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    protected function hasValidPlaceholders(string $html): bool
    {
        preg_match_all('/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/', $html, $matches);
        
        foreach ($matches[1] as $placeholder) {
            if (!in_array($placeholder, $this->allowedPlaceholders)) {
                return false;
            }
        }

        return true;
    }

    protected function isResponsive(string $html): bool
    {
        return str_contains($html, '<meta name="viewport"') &&
               str_contains($html, '@media');
    }
}
```

### 5. Gestione Assets

```php
namespace Modules\Notify\Services;

class EmailAssetManager
{
    public function uploadImage($file): string
    {
        $path = $file->store('email-assets', 'public');
        
        // Ottimizza immagine
        $this->optimizeImage($path);
        
        // Genera URL pubblico
        return Storage::url($path);
    }

    public function optimizeImage(string $path): void
    {
        $image = Image::make(storage_path("app/public/{$path}"));
        
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $image->save(null, 80);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor principale
                EmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => 'Pulsante',
                        'image' => 'Immagine',
                        'divider' => 'Divisore',
                        'spacer' => 'Spaziatore',
                    ]),

                // Layout
                Select::make('layout')
                    ->options([
                        'default' => 'Default',
                        'sidebar' => 'Sidebar',
                        'centered' => 'Centrato',
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Test invio
            Action::make('test')
                ->label('Test Email')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    Mail::to($data['email'])
                        ->send(new TestMail($record));
                }),

            // Duplica template
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (MailTemplate $record) {
                    $record->replicate()->save();
                }),

            // Esporta
            Action::make('export')
                ->label('Esporta')
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo $record->html_template;
                    }, "template-{$record->id}.html");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura HTML

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili base */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $content }}
    </div>
</body>
</html>
```

### 2. Componenti Riutilizzabili

```php
// Button component
class ButtonComponent
{
    public static function render(string $text, string $url, string $color = '#000000'): string
    {
        return view('notify::mail.components.button', [
            'text' => $text,
            'url' => $url,
            'color' => $color,
        ])->render();
    }
}

// Image component
class ImageComponent
{
    public static function render(string $src, string $alt, int $width = 600): string
    {
        return view('notify::mail.components.image', [
            'src' => $src,
            'alt' => $alt,
            'width' => $width,
        ])->render();
    }
}
```

### 3. Validazione Template

```php
class TemplateValidator
{
    public function validate(MailTemplate $template): array
    {
        $errors = [];

        // Verifica struttura
        if (!$this->validateStructure($template->html_template)) {
            $errors[] = 'Struttura HTML non valida';
        }

        // Verifica placeholder
        if (!$this->validatePlaceholders($template)) {
            $errors[] = 'Placeholder non validi';
        }

        // Verifica responsive
        if (!$this->validateResponsive($template->html_template)) {
            $errors[] = 'Template non responsive';
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Editor non carica**
   - Verifica dipendenze JS
   - Controlla console errori
   - Verifica permessi file

2. **Preview non funziona**
   - Verifica stato live
   - Controlla renderizzazione
   - Debug template

3. **Validazione fallisce**
   - Controlla struttura HTML
   - Verifica placeholder
   - Debug regole

### 2. Performance

1. **Editor lento**
   - Ottimizza JS
   - Riduci dipendenze
   - Usa lazy loading

2. **Preview lenta**
   - Cache preview
   - Ottimizza template
   - Riduci complessità

3. **Upload lento**
   - Compressi immagini
   - Usa CDN
   - Ottimizza storage

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Mail Queue](database-mail-queue.md)
- [Database Mail System](../../database-mail-system.md)
- [Email Plugins Analysis](../../email-plugins-analysis.md)
- [Mail Queue](../../database-mail-queue.md)

## Vedi Anche
- [TinyMCE Documentation](https://www.tiny.cloud/docs)
- [CKEditor Documentation](https://ckeditor.com/docs)
- [Quill Documentation](https://quilljs.com/docs) 
---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
