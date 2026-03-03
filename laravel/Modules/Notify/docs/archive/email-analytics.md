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

## Vedi Anche
- [Laravel Analytics](https://github.com/spatie/laravel-analytics)
- [Laravel Mail Tracking](https://github.com/spatie/laravel-mail-tracking)
- [Laravel Mail Preview](https://github.com/spatie/laravel-mail-preview) 