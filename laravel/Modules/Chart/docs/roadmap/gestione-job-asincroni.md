# Gestione Job Asincroni per Operazioni Pesanti

> [Torna alla Roadmap Principale](../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

La gestione dei job asincroni per operazioni pesanti è attualmente completata al 15%. Questo componente è fondamentale per ottimizzare le prestazioni della piattaforma il progetto, permettendo di spostare operazioni computazionalmente intensive o di lunga durata in processi background, migliorando così l'esperienza utente e la scalabilità del sistema.

## Obiettivi dell'Implementazione

L'implementazione del sistema di gestione job asincroni mira a:

1. Migliorare le prestazioni dell'applicazione spostando operazioni pesanti in background
2. Gestire in modo efficiente processi di lunga durata senza bloccare l'interfaccia utente
3. Implementare code prioritizzate per differenti tipi di operazioni
4. Fornire un sistema di monitoraggio e gestione dei job in esecuzione
5. Garantire robustezza tramite meccanismi di retry e gestione degli errori

## Componenti Implementati (15%)

- ✅ Configurazione base del sistema di code Laravel
- ✅ Implementazione worker base per l'elaborazione job
- ✅ Integrazione Supervisor per gestione processi
- ✅ Dispatching job semplice per alcune operazioni

## Componenti da Implementare (85%)

- 🚧 Infrastruttura avanzata job (20%)
  - 🚧 Code multiple con prioritizzazione
  - 🚧 Scheduling job ricorrenti ottimizzato
  - 🚧 Limite consumo risorse per job
  - 📅 Distribuzione job su worker multipli
- 🚧 Gestione fallimenti e resilienza (10%)
  - 🚧 Strategia di retry configurabile
  - 🚧 Gestione fallimenti permanenti
  - 📅 Dead letter queue per job problematici
  - 📅 Ripristino automatico job interrotti
- 🚧 Monitoraggio e analisi (5%)
  - 🚧 Dashboard job in esecuzione
  - 📅 Metriche prestazionali per job
  - 📅 Sistema alerting per job bloccati
  - 📅 Strumenti diagnostici
- 📅 Ottimizzazioni avanzate
  - 📅 Bilanciamento carico automatico
  - 📅 Throttling job basato su metriche sistema
  - 📅 Prioritizzazione dinamica
  - 📅 Auto-scaling worker basato su carico

## Architettura del Sistema

Il sistema di gestione job asincroni è progettato secondo un'architettura a code multiple con gestione centralizzata e monitoraggio:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Job Dispatcher   │       │  Queue Manager    │       │  Worker Processes │
│  (Action Pattern) │─────►│                  │◄─────►│                  │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Failed Job       │◄─────►│  Monitoring &     │◄─────►│  Supervisor       │
│  Handler          │       │  Dashboard        │       │  Process Control  │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
```

## Implementazione con Action Pattern

Seguendo la regola di utilizzo di Spatie Laravel-Queueable-Action invece di Service Classes, implementiamo le funzionalità principali tramite Action Pattern:

```php
// Modules/Job/Actions/ProcessReportGenerationAction.php
namespace Modules\Job\Actions;

use Modules\Reporting\Models\Report;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Log;

class ProcessReportGenerationAction
{
    use QueueableAction;
    
    /**
     * Configurazione avanzata della coda.
     */
    public string $queue = 'reports';
    public int $tries = 3;
    public int $maxExceptions = 2;
    public int $backoff = 60; // secondi
    public int $timeout = 600; // 10 minuti
    
    /**
     * Elabora la generazione di un report complesso.
     *
     * @param \Modules\Reporting\Models\Report $report Report da generare
     * @param array $parameters Parametri di configurazione
     * 
     * @return bool
     */
    public function execute(Report $report, array $parameters = []): bool
    {
        try {
            // Log inizio elaborazione
            Log::info("Inizio generazione report #{$report->id} di tipo {$report->type}", [
                'report_id' => $report->id,
                'parameters' => $parameters,
            ]);
            
            // Aggiorna stato report
            $report->update([
                'status' => Report::STATUS_PROCESSING,
                'started_at' => now(),
            ]);
            
            // Esegui elaborazione in base al tipo
            switch ($report->type) {
                case 'clinical':
                    $this->processClinicalReport($report, $parameters);
                    break;
                case 'financial':
                    $this->processFinancialReport($report, $parameters);
                    break;
                case 'performance':
                    $this->processPerformanceReport($report, $parameters);
                    break;
                default:
                    throw new \Exception("Tipo di report non supportato: {$report->type}");
            }
            
            // Aggiorna report con successo
            $report->update([
                'status' => Report::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);
            
            // Log completamento
            Log::info("Report #{$report->id} generato con successo", [
                'report_id' => $report->id,
                'execution_time' => now()->diffInSeconds($report->started_at),
            ]);
            
            return true;
        } catch (\Exception $e) {
            // Gestione errore
            Log::error("Errore nella generazione del report #{$report->id}: {$e->getMessage()}", [
                'report_id' => $report->id,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Aggiorna stato report
            $report->update([
                'status' => Report::STATUS_FAILED,
                'error_message' => $e->getMessage(),
                'completed_at' => now(),
            ]);
            
            // Rilancia eccezione per gestione retry
            throw $e;
        }
    }
    
    /**
     * Elabora un report clinico.
     */
    private function processClinicalReport(Report $report, array $parameters): void
    {
        // Implementazione elaborazione report clinico
        // Potenzialmente intensivo su database e calcoli statistici
    }
    
    /**
     * Elabora un report finanziario.
     */
    private function processFinancialReport(Report $report, array $parameters): void
    {
        // Implementazione elaborazione report finanziario
        // Potenzialmente con calcoli complessi
    }
    
    /**
     * Elabora un report sulle performance.
     */
    private function processPerformanceReport(Report $report, array $parameters): void
    {
        // Implementazione elaborazione report performance
        // Potenzialmente con aggregazioni estese
    }
}
```

## Esempio di Utilizzo nell'Applicazione

Esempio di come utilizzare l'action pattern con job asincroni nel controller Filament:

```php
// Modules/Reporting/Filament/Resources/ReportResource/Pages/CreateReport.php
namespace Modules\Reporting\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Reporting\Filament\Resources\ReportResource;
use Modules\Reporting\Models\Report;
use Modules\Job\Actions\ProcessReportGenerationAction;
use Illuminate\Support\Facades\DB;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;
    
    protected function afterCreate(): void
    {
        $report = $this->record;
        
        // Dispatch al job asincrono con QueueableAction
        app(ProcessReportGenerationAction::class)
            ->onQueue('reports')
            ->execute($report, [
                'date_range' => [
                    'from' => $report->parameters['date_from'],
                    'to' => $report->parameters['date_to'],
                ],
                'filters' => $report->parameters['filters'] ?? [],
            ]);
        
        // Notifica all'utente
        $this->notify('success', 'Report creato e messo in coda per l\'elaborazione');
    }
}
```

## Configurazione Code Multiple

La configurazione delle code multiple permette di ottimizzare l'esecuzione di diverse tipologie di job:

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
    
    'queues' => [
        'high' => [
            'workers' => 2,
            'tries' => 3,
            'timeout' => 60,
        ],
        'default' => [
            'workers' => 2,
            'tries' => 2,
            'timeout' => 180,
        ],
        'reports' => [
            'workers' => 1,
            'tries' => 3,
            'timeout' => 1800, // 30 minuti
        ],
        'emails' => [
            'workers' => 1,
            'tries' => 2,
            'timeout' => 120,
        ],
        'low' => [
            'workers' => 1,
            'tries' => 1,
            'timeout' => 300,
        ],
    ],
];
```

## Monitoraggio Job con Filament

```php
// Modules/Job/Filament/Resources/QueueMonitorResource.php
namespace Modules\Job\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Job\Models\QueueMonitor;
use Modules\Xot\Filament\Resources\XotBaseResource;

class QueueMonitorResource extends XotBaseResource
{
    protected static ?string $model = QueueMonitor::class;
    
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_id')
                    ->label('ID Job')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('queue')
                    ->label('Coda')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'primary' => 'queued',
                        'warning' => 'executing',
                        'success' => 'finished',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Inizio')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Fine')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_elapsed')
                    ->label('Durata')
                    ->formatStateUsing(fn ($state) => $state ? "{$state}s" : '-'),
                Tables\Columns\TextColumn::make('attempt')
                    ->label('Tentativi')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'queued' => 'In coda',
                        'executing' => 'In esecuzione',
                        'finished' => 'Completati',
                        'failed' => 'Falliti',
                    ]),
                Tables\Filters\SelectFilter::make('queue')
                    ->options([
                        'high' => 'Alta priorità',
                        'default' => 'Standard',
                        'reports' => 'Report',
                        'emails' => 'Email',
                        'low' => 'Bassa priorità',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('retry')
                    ->label('Riprova')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn (QueueMonitor $record) => $record->status === 'failed')
                    ->action(fn (QueueMonitor $record) => $record->retry()),
            ])
            ->defaultSort('started_at', 'desc');
    }
}
```

## Gestione Failed Jobs e Retry

Per implementare una gestione più robusta dei job falliti con strategie di retry configurabili:

```php
// Modules/Job/Providers/JobServiceProvider.php
namespace Modules\Job\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Modules\Job\Models\FailedJob;
use Modules\Job\Actions\HandleFailedJobAction;

class JobServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Registra listener per eventi di coda
        $this->app['events']->listen(JobProcessing::class, function (JobProcessing $event) {
            // Traccia inizio esecuzione job
        });
        
        $this->app['events']->listen(JobProcessed::class, function (JobProcessed $event) {
            // Traccia completamento job
        });
        
        $this->app['events']->listen(JobFailed::class, function (JobFailed $event) {
            // Gestione job fallito con Action pattern
            app(HandleFailedJobAction::class)->execute(
                $event->job, 
                $event->exception
            );
        });
    }
}

// Modules/Job/Actions/HandleFailedJobAction.php
namespace Modules\Job\Actions;

use Illuminate\Queue\Jobs\Job;
use Modules\Job\Models\FailedJob;
use Spatie\QueueableAction\QueueableAction;

class HandleFailedJobAction
{
    /**
     * Gestisce un job fallito con strategie personalizzate.
     *
     * @param \Illuminate\Queue\Jobs\Job $job Job fallito
     * @param \Throwable $exception Eccezione che ha causato il fallimento
     */
    public function execute(Job $job, \Throwable $exception): void
    {
        // Registra fallimento nel database
        $failedJob = FailedJob::create([
            'connection' => $job->getConnectionName(),
            'queue' => $job->getQueue(),
            'payload' => $job->getRawBody(),
            'exception' => (string) $exception,
            'failed_at' => now(),
        ]);
        
        // Analizza l'errore per determinare se può essere riprovato
        $canRetry = $this->analyzeException($exception);
        
        // Se può essere riprovato e non ha superato i tentativi massimi
        if ($canRetry && $job->attempts() < $job->maxTries()) {
            // Implementa logica di retry con backoff esponenziale
            $delay = $this->calculateBackoff($job->attempts());
            
            // Re-queue il job con delay
            // ...
        } else {
            // Notifica amministratori per job falliti critici
            $this->notifyAdminsIfCritical($failedJob);
            
            // Sposta in dead letter queue
            $this->moveToDeadLetterQueue($failedJob);
        }
    }
    
    /**
     * Analizza l'eccezione per determinare se il job può essere ritentato.
     */
    private function analyzeException(\Throwable $exception): bool
    {
        // Implementazione analisi eccezioni per categorizzare:
        // - Errori temporanei (connettività, timeout) -> retry
        // - Errori permanenti (validazione, logica) -> no retry
        
        return true; // Esempio semplificato
    }
    
    /**
     * Calcola il backoff per il retry.
     */
    private function calculateBackoff(int $attempts): int
    {
        // Backoff esponenziale: 1min, 5min, 15min, 30min, 1h
        return match ($attempts) {
            1 => 60,
            2 => 300,
            3 => 900,
            4 => 1800,
            default => 3600,
        };
    }
    
    /**
     * Notifica gli amministratori per job falliti critici.
     */
    private function notifyAdminsIfCritical(FailedJob $failedJob): void
    {
        // Implementazione notifiche per job critici falliti
    }
    
    /**
     * Sposta il job in una dead letter queue.
     */
    private function moveToDeadLetterQueue(FailedJob $failedJob): void
    {
        // Implementazione dead letter queue
    }
}
```

## Configurazione Supervisor

Per garantire l'esecuzione continua dei worker delle code, utilizziamo Supervisor:

```ini
; /etc/supervisor/conf.d/<nome progetto>-workers.conf
[program:<nome progetto>-high-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/<nome progetto>/laravel/artisan queue:work redis --queue=high --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/<nome progetto>/laravel/storage/logs/worker-high.log
stopwaitsecs=3600

[program:<nome progetto>-default-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/<nome progetto>/laravel/artisan queue:work redis --queue=default --sleep=3 --tries=2 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/<nome progetto>/laravel/storage/logs/worker-default.log
stopwaitsecs=3600

[program:<nome progetto>-reports-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/<nome progetto>/laravel/artisan queue:work redis --queue=reports --sleep=3 --tries=3 --timeout=1800 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/<nome progetto>/laravel/storage/logs/worker-reports.log
stopwaitsecs=3600

[program:<nome progetto>-low-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/<nome progetto>/laravel/artisan queue:work redis --queue=emails,low --sleep=3 --tries=1 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/<nome progetto>/laravel/storage/logs/worker-low.log
stopwaitsecs=3600

[group:<nome progetto>-workers]
programs=<nome progetto>-high-worker,<nome progetto>-default-worker,<nome progetto>-reports-worker,<nome progetto>-low-worker
priority=999
```

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Code multiple | Luglio 2024 | Alta |
| Strategia retry | Luglio 2024 | Alta |
| Monitoring dashboard | Luglio 2024 | Media |
| Tracciamento performance | Agosto 2024 | Media |
| Dead letter queue | Agosto 2024 | Alta |
| Diagnostica avanzata | Agosto 2024 | Bassa |
| Bilanciamento carico | Settembre 2024 | Media |
| Auto-scaling worker | Settembre 2024 | Bassa |

## Metriche di Successo

- Tempo di risposta interfaccia utente < 300ms (spostando operazioni pesanti in background)
- Riduzione errori job critici < 0.1%
- Tempo completamento report complessi ridotto del 50% con elaborazione parallela
- Utilizzo CPU worker ottimizzato > 70%
- Resilienza sistema sotto carico 100%
