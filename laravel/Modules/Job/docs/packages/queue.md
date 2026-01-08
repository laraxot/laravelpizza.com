# Queue

## Pacchetti Utilizzati

### Horizon
- [laravel/horizon](https://github.com/laravel/horizon)
  - Monitoraggio queue
  - Dashboard
  - Metriche
  - Configurazione dettagliata
  - Integrazione con Filament

### Queueable Actions
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
  - Azioni in coda
  - Job wrapper
  - Retry logic
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Horizon
```php
// config/horizon.php
return [
    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 10,
                'tries' => 3,
            ],
        ],
    ],
];
```

### Queueable Actions
```php
// config/queueable-action.php
return [
    'queue' => [
        'connection' => env('QUEUE_CONNECTION', 'sync'),
        'queue' => env('QUEUE_QUEUE', 'default'),
        'retry_after' => 90,
        'tries' => 3,
    ],
];
```

## Utilizzo

### Horizon
```php
// Monitorare queue
Artisan::call('horizon:status');

// Pausa queue
Artisan::call('horizon:pause');

// Riprendi queue
Artisan::call('horizon:continue');
```

### Queueable Actions
```php
// Eseguire azione in coda
$action = new ProcessOrder($order);
$action->onQueue('high')->execute();

// Eseguire azione in background
$action->executeInBackground();

// Eseguire azione con retry
$action->onQueue('high')->retry(3)->execute();
```

## Documentazione Collegata

- [Monitoraggio](monitoring.md)
- [Performance](performance.md)
- [Integrazioni](integrations.md)
- [Panoramica](../packages.md) 
