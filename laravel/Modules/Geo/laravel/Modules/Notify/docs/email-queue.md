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

## Vedi Anche
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Horizon](https://laravel.com/project_docs/horizon)
- [Laravel Supervisor](https://laravel.com/project_docs/queues#supervisor-configuration)
