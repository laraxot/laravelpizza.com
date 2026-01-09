# Monitoraggio

## Pacchetti Utilizzati

### Schedule Monitor
- [spatie/laravel-schedule-monitor](https://github.com/spatie/laravel-schedule-monitor)
  - Monitoraggio task
  - Alert
  - Metriche
  - Configurazione dettagliata
  - Integrazione con Filament

### Failed Job Monitor
- [spatie/laravel-failed-job-monitor](https://github.com/spatie/laravel-failed-job-monitor)
  - Monitoraggio job falliti
  - Notifiche
  - Retry automatico
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Schedule Monitor
```php
// config/schedule-monitor.php
return [
    'models' => [
        'monitored_scheduled_task' => \Spatie\ScheduleMonitor\Models\MonitoredScheduledTask::class,
    ],
    'notifications' => [
        'notifications' => [
            \Spatie\ScheduleMonitor\Notifications\Notifiable::class,
        ],
        'notifiable' => \Spatie\ScheduleMonitor\Notifications\Notifiable::class,
    ],
];
```

### Failed Job Monitor
```php
// config/failed-job-monitor.php
return [
    'notifications' => [
        'notifications' => [
            \Spatie\FailedJobMonitor\Notifications\Notifiable::class,
        ],
        'notifiable' => \Spatie\FailedJobMonitor\Notifications\Notifiable::class,
    ],
];
```

## Utilizzo

### Schedule Monitor
```php
// Monitorare task
Artisan::call('schedule-monitor:sync');

// Lista task
Artisan::call('schedule-monitor:list');

// Report
Artisan::call('schedule-monitor:report');
```

### Failed Job Monitor
```php
// Monitorare job falliti
Artisan::call('queue:failed');

// Riprova job falliti
Artisan::call('queue:retry', ['id' => 'all']);

// Cancella job falliti
Artisan::call('queue:forget', ['id' => 'all']);
```

## Documentazione Collegata

- [Queue](queue.md)
- [Performance](performance.md)
- [Integrazioni](integrations.md)
- [Panoramica](../packages.md)
### Versione HEAD

### Versione HEAD

## Collegamenti tra versioni di monitoring.md
* [monitoring.md](../../../Job/docs/packages/monitoring.md)
* [monitoring.md](../../../../Themes/One/docs/monitoring.md)

### Versione Incoming

---

### Versione Incoming

---
