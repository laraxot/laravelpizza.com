# Monitoraggio del Modulo Notify

## Metriche Chiave

### Performance delle Queueable Actions

#### SendNotificationAction
- Tempo medio di esecuzione
- Tasso di successo
- Numero di tentativi
- Tempo di attesa in coda

#### TrackNotificationEventAction
- Tempo di elaborazione eventi
- Tasso di eventi elaborati
- Errori di elaborazione

### Template Analytics

#### Metriche per Template
- Numero totale di invii
- Tasso di apertura
- Tasso di click
- Tasso di conversione

#### Metriche per Canale
- Email: tasso di consegna, bounce rate
- SMS: tasso di consegna, errori
- Push: tasso di consegna, engagement

## Logging

### Struttura dei Log

```php
[
    'action' => 'send_notification',
    'template_code' => 'welcome_email',
    'recipient_id' => 123,
    'channels' => ['mail'],
    'status' => 'success',
    'execution_time' => 0.5,
    'timestamp' => '2024-03-20 10:00:00',
    'metadata' => [
        'queue' => 'notifications',
        'attempt' => 1,
        'error' => null
    ]
]
```

### Eventi Monitorati

#### Invio Notifiche
```php
final class NotificationSent
{
    public function __construct(
        public readonly NotificationLog $notification,
        public readonly float $executionTime
    ) {}
}
```

#### Eventi di Tracking
```php
final class NotificationEventTracked
{
    public function __construct(
        public readonly NotificationLog $notification,
        public readonly string $eventType,
        public readonly array $eventData
    ) {}
}
```

## Dashboard

### Componenti Blade

#### NotificationStats
```php
<x-notify::stats-card
    title="Notifiche Inviate"
    :value="$stats['total_sent']"
    :trend="$stats['sent_trend']"
    icon="mail"
/>
```

#### ChannelPerformance
```php
<x-notify::channel-stats
    :channels="$channels"
    :metrics="$metrics"
/>
```

### Widget Filament

#### NotificationQueueStatus
```php
class NotificationQueueStatusWidget extends Widget
{
    protected function getStats(): array
    {
        return [
            'pending' => $this->getPendingCount(),
            'processing' => $this->getProcessingCount(),
            'failed' => $this->getFailedCount(),
        ];
    }
}
```

## Alerting

### Regole di Alert

#### Performance Degradata
```php
final class PerformanceAlertRule
{
    public function shouldAlert(array $metrics): bool
    {
        return $metrics['avg_execution_time'] > 1.0
            || $metrics['error_rate'] > 0.05;
    }
}
```

#### Errori Critici
```php
final class CriticalErrorAlertRule
{
    public function shouldAlert(array $metrics): bool
    {
        return $metrics['failed_notifications'] > 100
            || $metrics['queue_size'] > 1000;
    }
}
```

## Health Checks

### Queue Health
```php
final class NotificationQueueHealthCheck
{
    public function check(): HealthCheckResult
    {
        $queueSize = $this->getQueueSize();
        $failedJobs = $this->getFailedJobsCount();
        
        return new HealthCheckResult(
            status: $this->determineStatus($queueSize, $failedJobs),
            message: $this->getStatusMessage($queueSize, $failedJobs)
        );
    }
}
```

### Template Health
```php
final class TemplateHealthCheck
{
    public function check(): HealthCheckResult
    {
        $invalidTemplates = $this->findInvalidTemplates();
        $expiredTemplates = $this->findExpiredTemplates();
        
        return new HealthCheckResult(
            status: $this->determineStatus($invalidTemplates, $expiredTemplates),
            message: $this->getStatusMessage($invalidTemplates, $expiredTemplates)
        );
    }
}
```

## Reporting

### Report Giornalieri

#### Struttura
```php
final class DailyNotificationReport
{
    public function generate(): array
    {
        return [
            'date' => now()->format('Y-m-d'),
            'total_sent' => $this->getTotalSent(),
            'delivery_rate' => $this->getDeliveryRate(),
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'top_templates' => $this->getTopTemplates(),
            'channel_performance' => $this->getChannelPerformance(),
            'errors' => $this->getErrors(),
        ];
    }
}
```

### Report Mensili

#### Struttura
```php
final class MonthlyNotificationReport
{
    public function generate(): array
    {
        return [
            'month' => now()->format('Y-m'),
            'total_sent' => $this->getTotalSent(),
            'delivery_rate' => $this->getDeliveryRate(),
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'top_templates' => $this->getTopTemplates(),
            'channel_performance' => $this->getChannelPerformance(),
            'errors' => $this->getErrors(),
            'trends' => $this->getTrends(),
            'recommendations' => $this->getRecommendations(),
        ];
    }
}
```

## Integrazione con Strumenti Esterni

### Prometheus

#### Metriche Esportate
```php
final class NotificationMetrics
{
    public function register(): void
    {
        $this->gauge('notifications_sent_total', 'Total notifications sent');
        $this->gauge('notifications_delivered_total', 'Total notifications delivered');
        $this->gauge('notifications_opened_total', 'Total notifications opened');
        $this->gauge('notifications_clicked_total', 'Total notifications clicked');
        $this->gauge('notification_queue_size', 'Current notification queue size');
        $this->gauge('notification_processing_time', 'Average notification processing time');
    }
}
```

### Grafana

#### Dashboard Template
```json
{
  "dashboard": {
    "title": "Notify Module Dashboard",
    "panels": [
      {
        "title": "Notifications Sent",
        "type": "graph",
        "datasource": "Prometheus",
        "targets": [
          {
            "expr": "notifications_sent_total",
            "legendFormat": "Total Sent"
          }
        ]
      },
      {
        "title": "Delivery Rate",
        "type": "gauge",
        "datasource": "Prometheus",
        "targets": [
          {
            "expr": "notifications_delivered_total / notifications_sent_total * 100",
            "legendFormat": "Delivery Rate"
          }
        ]
      }
    ]
  }
}
```

## Manutenzione

### Pulizia Dati

#### Criteri di Pulizia
```php
final class NotificationCleanup
{
    public function cleanup(): void
    {
        // Rimuovi notifiche più vecchie di 30 giorni
        NotificationLog::where('created_at', '<', now()->subDays(30))->delete();
        
        // Rimuovi analytics più vecchi di 90 giorni
        TemplateAnalytics::where('created_at', '<', now()->subDays(90))->delete();
        
        // Archivia template non utilizzati
        Template::where('last_used_at', '<', now()->subMonths(6))
            ->update(['status' => TemplateStatus::ARCHIVED]);
    }
}
```

### Ottimizzazione Performance

#### Indici Database
```php
final class NotificationIndexes
{
    public function create(): void
    {
        Schema::table('notification_logs', function (Blueprint $table) {
            $table->index('template_id');
            $table->index('recipient_id');
            $table->index('created_at');
            $table->index('status');
        });
        
        Schema::table('template_analytics', function (Blueprint $table) {
            $table->index('notification_id');
            $table->index('event_type');
            $table->index('created_at');
        });
    }
}
``` 
