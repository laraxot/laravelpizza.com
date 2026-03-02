# Sistema di Code per Email - il progetto

## Panoramica

Implementazione del sistema di code per l'invio di email in il progetto, con integrazione completa con il nostro sistema di template basato su database.

## Componenti

### 1. Job di Invio Email

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateManager;

class SendTemplatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Timeout del job in secondi.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Costruttore del job.
     *
     * @param string $to Email destinatario
     * @param string $mailable Classe mailable
     * @param array<string, mixed> $data Dati per il template
     * @param string|null $locale Lingua del template
     */
    public function __construct(
        protected string $to,
        protected string $mailable,
        protected array $data = [],
        protected ?string $locale = null
    ) {}

    /**
     * Esegue il job.
     */
    public function handle(MailTemplateManager $manager): void
    {
        $template = $manager->getTemplate($this->mailable, $this->locale);

        if (!$template) {
            throw new TemplateNotFoundException($this->mailable, $this->locale);
        }

        Mail::to($this->to)
            ->send(new DatabaseTemplateMailable($template, $this->data));

        // Traccia statistiche
        $this->trackMailStats($template);
    }

    /**
     * Gestisce il fallimento del job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email sending failed', [
            'to' => $this->to,
            'mailable' => $this->mailable,
            'exception' => $exception->getMessage(),
        ]);

        // Notifica amministratori
        Notification::route('slack', config('notify.error_channel'))
            ->notify(new FailedMailNotification($this->to, $this->mailable));
    }

    /**
     * Traccia le statistiche di invio.
     */
    protected function trackMailStats(MailTemplate $template): void
    {
        $template->stats()->create([
            'email' => $this->to,
            'sent_at' => now(),
            'status' => 'sent',
            'metadata' => [
                'locale' => $this->locale,
                'data_keys' => array_keys($this->data),
            ],
        ]);
    }
}
```

### 2. Configurazione Code

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### 3. Worker Manager

```php
namespace Modules\Notify\Services;

class QueueWorkerManager
{
    /**
     * Avvia i worker necessari.
     */
    public function startWorkers(): void
    {
        $workerCount = config('notify.queue.workers', 2);
        
        for ($i = 0; $i < $workerCount; $i++) {
            Process::run('php artisan queue:work --queue=emails --tries=3');
        }
    }

    /**
     * Monitora lo stato dei worker.
     */
    public function monitorWorkers(): array
    {
        return [
            'active_workers' => $this->getActiveWorkers(),
            'processed_jobs' => $this->getProcessedJobs(),
            'failed_jobs' => $this->getFailedJobs(),
        ];
    }
}
```

## Utilizzo

### 1. Accodamento Email

```php
// Invio singolo
SendTemplatedEmailJob::dispatch(
    'user@example.com',
    WelcomeEmail::class,
    ['user' => $user]
);

// Invio multiplo
$users->each(function ($user) {
    SendTemplatedEmailJob::dispatch(
        $user->email,
        WelcomeEmail::class,
        ['user' => $user]
    )->onQueue('emails');
});
```

### 2. Gestione Worker

```bash
# Avvia worker dedicato
php artisan queue:work --queue=emails

# Monitora code
php artisan queue:monitor

# Gestione failed jobs
php artisan queue:failed
php artisan queue:retry all
```

## Best Practices

### 1. Configurazione Code

```php
// Priorità code
'queues' => [
    'emails-high',    // Email critiche
    'emails-normal',  // Email standard
    'emails-bulk',    // Email massive
],

// Limiti rate
'throttle' => [
    'emails-high' => 100,  // 100/min
    'emails-normal' => 50, // 50/min
    'emails-bulk' => 10,   // 10/min
],
```

### 2. Monitoraggio

```php
// Prometheus metrics
$counter = Counter::create('emails_sent_total', 'Total emails sent')
    ->inc();

$histogram = Histogram::create('email_sending_duration_seconds', 'Time spent sending emails')
    ->observe($duration);
```

### 3. Retry Strategy

```php
public function backoff(): array
{
    return [
        10,  // 10 secondi
        30,  // 30 secondi
        60,  // 1 minuto
    ];
}

public function retryUntil(): \DateTime
{
    return now()->addHours(24);
}
```

## Gestione Errori

### 1. Logging

```php
Log::channel('mail')->error('Email sending failed', [
    'to' => $this->to,
    'template' => $this->template->id,
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString(),
]);
```

### 2. Notifiche

```php
Notification::route('slack', config('notify.error_channel'))
    ->notify(new FailedMailNotification([
        'to' => $this->to,
        'error' => $e->getMessage(),
    ]));
```

### 3. Cleanup

```php
// Rimuovi job falliti vecchi
$this->call('queue:prune-failed', [
    '--hours' => 168 // 1 settimana
]);

// Rimuovi job completati
$this->call('queue:prune-batches', [
    '--hours' => 24
]);
```

## Scaling

### 1. Orizzontale

```bash
# Supervisor config
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/_bases/base_<nome progetto>/laravel/artisan queue:work redis --queue=emails
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
```

### 2. Rate Limiting

```php
// Rate limiter per dominio
RateLimiter::for('mail-domain', function ($job) {
    return Limit::perMinute(100)->by($job->getDomain());
});

// Rate limiter globale
RateLimiter::for('mail-global', function () {
    return Limit::perMinute(1000);
});
```

### 3. Sharding

```php
// Distribuzione su multiple code
$queue = 'emails-' . ($user->id % 4); // 4 code

SendTemplatedEmailJob::dispatch($user->email, $template)
    ->onQueue($queue);
```

## Monitoraggio

### 1. Metriche

```php
// Prometheus metrics
$metrics = [
    'emails_sent_total' => [
        'type' => 'counter',
        'help' => 'Total emails sent',
    ],
    'email_sending_duration' => [
        'type' => 'histogram',
        'help' => 'Email sending duration',
    ],
    'failed_jobs_total' => [
        'type' => 'counter',
        'help' => 'Total failed jobs',
    ],
];
```

### 2. Dashboard

```php
// Horizon metrics
Horizon::metrics([
    'emails' => [
        'total' => fn() => MailStats::count(),
        'sent' => fn() => MailStats::sent()->count(),
        'failed' => fn() => MailStats::failed()->count(),
    ],
]);
```

### 3. Alerting

```php
// Alert su errori
if ($failedJobs > $threshold) {
    Alert::channel('slack')
        ->error("High email failure rate detected")
        ->send();
}
```

## Manutenzione

### 1. Pulizia

```bash
# Pulizia job vecchi
php artisan queue:prune-failed --hours=168
php artisan queue:prune-batches --hours=24

# Pulizia statistiche
php artisan notify:prune-mail-stats --days=30
```

### 2. Backup

```php
// Backup configurazione
php artisan backup:run --only-db --filename=queue_backup

// Backup failed jobs
php artisan queue:failed-table > failed_jobs_backup.sql
```

### 3. Ripristino

```php
// Ripristino job falliti
php artisan queue:retry all
php artisan queue:restart
```

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Templates](database-mail-templates.md)
- [Queue Configuration](../../../docs/queue-configuration.md)

## Vedi Anche
- [Laravel Queues](https://laravel.com/docs/queues)
- [Horizon Documentation](https://laravel.com/docs/horizon)
- [Redis Documentation](https://redis.io/documentation)
