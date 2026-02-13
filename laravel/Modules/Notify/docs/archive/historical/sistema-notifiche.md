# Sistema Notifiche

## Architettura

### 1. Notifiche Base
```php
// app/Notifications/BaseNotification.php
class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $channels;

    public function __construct($data)
    {
        $this->data = $data;
        $this->channels = ['mail', 'database'];
    }

    public function via($notifiable)
    {
        return $this->channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->greeting($this->getGreeting())
            ->line($this->getContent())
            ->action($this->getActionText(), $this->getActionUrl());
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->getType(),
            'data' => $this->data,
            'created_at' => now(),
        ];
    }
}
```

### 2. Canali di Notifica
```php
// app/Notifications/Channels/CustomChannel.php
class CustomChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toCustom($notifiable);
        
        // 1. Validazione
        $this->validateMessage($message);
        
        // 2. Preparazione
        $payload = $this->preparePayload($message);
        
        // 3. Invio
        $this->sendMessage($payload);
        
        // 4. Logging
        $this->logDelivery($message, $payload);
    }
}
```

## Gestione Code

### 1. Configurazione Code
```php
// config/queue.php
return [
    'default' => env('QUEUE_CONNECTION', 'redis'),
    
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'notifications',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],
    
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### 2. Gestione Retry
```php
// app/Notifications/RetryableNotification.php
class RetryableNotification extends BaseNotification
{
    public function retryUntil()
    {
        return now()->addHours(24);
    }

    public function backoff()
    {
        return [60, 180, 360];
    }

    public function failed(Throwable $exception)
    {
        // 1. Log errore
        // 2. Notifica admin
        // 3. Fallback
        // 4. Cleanup
    }
}
```

## Rate Limiting

### 1. Configurazione
```php
// app/Providers/NotificationServiceProvider.php
class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        RateLimiter::for('notifications', function ($job) {
            return Limit::perMinute(60)->by($job->user->id);
        });
    }
}
```

### 2. Implementazione
```php
// app/Services/NotificationRateLimiter.php
class NotificationRateLimiter
{
    public function check($notifiable, $notification)
    {
        $key = $this->getKey($notifiable, $notification);
        
        return RateLimiter::attempt(
            $key,
            $this->getMaxAttempts(),
            function () {
                return true;
            },
            $this->getDecaySeconds()
        );
    }
}
```

## Analytics

### 1. Tracking
```php
// app/Services/NotificationAnalyticsService.php
class NotificationAnalyticsService
{
    public function track($notification, $status)
    {
        $metrics = [
            'notification_id' => $notification->id,
            'type' => $notification->getType(),
            'status' => $status,
            'timestamp' => now(),
            'user_id' => $notification->notifiable->id,
            'channel' => $notification->via,
        ];

        $this->storeMetrics($metrics);
        $this->updateAggregates($metrics);
    }
}
```

### 2. Reporting
```php
// app/Services/NotificationReportingService.php
class NotificationReportingService
{
    public function generateReport($period)
    {
        return [
            'delivery' => $this->getDeliveryMetrics($period),
            'engagement' => $this->getEngagementMetrics($period),
            'performance' => $this->getPerformanceMetrics($period),
            'errors' => $this->getErrorMetrics($period),
        ];
    }
}
```

## Monitoraggio

### 1. Health Check
```php
// app/Services/NotificationHealthService.php
class NotificationHealthService
{
    public function check()
    {
        return [
            'queue' => $this->checkQueue(),
            'channels' => $this->checkChannels(),
            'storage' => $this->checkStorage(),
            'performance' => $this->checkPerformance(),
        ];
    }

    private function checkQueue()
    {
        // 1. Verifica connessione
        // 2. Controlla dimensione
        // 3. Verifica worker
        // 4. Log stato
    }
}
```

### 2. Alerting
```php
// app/Services/NotificationAlertService.php
class NotificationAlertService
{
    public function alert($type, $data)
    {
        $alert = [
            'type' => $type,
            'data' => $data,
            'timestamp' => now(),
            'severity' => $this->getSeverity($type),
        ];

        $this->storeAlert($alert);
        $this->notifyAdmins($alert);
    }
}
```

## Testing

### 1. Unit Test
```php
// tests/Unit/NotificationTest.php
class NotificationTest extends TestCase
{
    public function test_notification_creation()
    {
        $notification = new TestNotification($this->getTestData());
        
        $this->assertInstanceOf(BaseNotification::class, $notification);
        $this->assertArrayHasKey('mail', $notification->via());
    }
}
```

### 2. Integration Test
```php
// tests/Integration/NotificationSystemTest.php
class NotificationSystemTest extends TestCase
{
    public function test_full_notification_workflow()
    {
        // 1. Creazione
        $notification = $this->createNotification();
        
        // 2. Invio
        $sent = $this->sendNotification($notification);
        
        // 3. Verifica
        $delivered = $this->verifyDelivery($notification);
        
        // 4. Analytics
        $metrics = $this->checkMetrics($notification);
        
        // 5. Assertions
        $this->assertNotificationSent($notification);
    }
}
```

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
