# Gestione Code

## Configurazione Base

### Queue
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
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],
    ],
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### Supervisor
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=forge
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/worker.log
stopwaitsecs=3600
```

## Code Base

### Job Semplice
```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    public function __construct($podcast)
    {
        $this->podcast = $podcast;
    }

    public function handle()
    {
        // Processa il podcast
    }
}
```

### Job con Retry
```php
namespace App\Jobs;

class ProcessPodcast implements ShouldQueue
{
    public $tries = 3;
    public $maxExceptions = 3;
    public $timeout = 120;
    public $backoff = [60, 180, 360];

    public function handle()
    {
        // Processa il podcast
    }
}
```

## Best Practices

### 1. Struttura
- Separare i job per dominio
- Utilizzare nomi descrittivi
- Implementare interfacce appropriate
- Documentare i job

### 2. Performance
- Ottimizzare i payload
- Implementare il rate limiting
- Gestire le priorità
- Monitorare le code

### 3. Sicurezza
- Validare i dati
- Sanitizzare l'output
- Proteggere i dati sensibili
- Implementare il logging

### 4. Manutenzione
- Monitorare le code
- Gestire i fallimenti
- Implementare alerting
- Documentare i job

## Esempi di Utilizzo

### Dispatch di Job
```php
// Dispatch immediato
ProcessPodcast::dispatch($podcast);

// Dispatch su coda specifica
ProcessPodcast::dispatch($podcast)->onQueue('podcasts');

// Dispatch con delay
ProcessPodcast::dispatch($podcast)->delay(now()->addMinutes(10));

// Dispatch con priorità
ProcessPodcast::dispatch($podcast)->onQueue('high');
```

### Batch di Job
```php
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

$batch = Bus::batch([
    new ProcessPodcast(Podcast::find(1)),
    new ProcessPodcast(Podcast::find(2)),
])->then(function (Batch $batch) {
    // Tutti i job sono stati completati
})->catch(function (Batch $batch, Throwable $e) {
    // Primo job fallito
})->finally(function (Batch $batch) {
    // Batch completato
})->dispatch();
```

## Strumenti Utili

### Comandi Artisan
```bash
# Avviare il worker
php artisan queue:work

# Monitorare le code
php artisan queue:monitor

# Gestire i job falliti
php artisan queue:failed
php artisan queue:retry all
php artisan queue:forget {id}
```

### Monitoraggio
```php
use Illuminate\Support\Facades\Queue;

Queue::before(function (JobProcessing $event) {
    // Prima dell'elaborazione
});

Queue::after(function (JobProcessed $event) {
    // Dopo l'elaborazione
});
```

## Gestione degli Errori

### Job Falliti
```php
namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class ProcessPodcast implements ShouldQueue
{
    public function failed(\Throwable $exception)
    {
        Log::error('Job fallito', [
            'job' => get_class($this),
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
```

### Notifiche
```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JobFailed extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('Job Fallito')
            ->line('Un job è fallito.')
            ->line('Job: ' . $this->job)
            ->line('Errore: ' . $this->exception);
    }
}
``` 