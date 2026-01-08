# Debugging Guide

## Strumenti di Debug

### Laravel Telescope
```php
// config/telescope.php
'enabled' => env('TELESCOPE_ENABLED', true),
```

- **Funzionalità**:
  - Monitoraggio delle richieste HTTP
  - Debug delle query del database
  - Tracciamento degli eventi
  - Analisi delle code
  - Monitoraggio delle notifiche
  - Log degli errori

### Laravel Debugbar
```php
// Solo in ambiente di sviluppo
if (env('APP_DEBUG')) {
    Debugbar::enable();
}
```

- **Features**:
  - Timeline delle query
  - Utilizzo della memoria
  - Variabili di sessione
  - Route corrente
  - Vista compilata

## Tecniche di Debug

### Dump and Die
```php
// Visualizza e termina
dd($variabile);

// Visualizza e continua
dump($variabile);

// Dump in console browser
logger()->debug($variabile);
```

### Query Log
```php
// Attiva il log delle query
DB::enableQueryLog();

// Esegui le query
$users = User::all();

// Visualizza il log
dd(DB::getQueryLog());
```

### Log Personalizzati
```php
Log::channel('debug')->info('Debug message', [
    'context' => 'Additional information',
    'data' => $data
]);
```

## Debug in Produzione

### Error Handling
```php
// app/Exceptions/Handler.php
public function register(): void
{
    $this->reportable(function (Throwable $e) {
        if (app()->environment('production')) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    });
}
```

### Maintenance Mode
```bash
# Attiva modalità manutenzione
php artisan down --secret="1630542a-246b-4b66-afa1-dd72a4c43515"

# Disattiva modalità manutenzione
php artisan up
```

## Debug Frontend

### Console Browser
```javascript
console.log('Debug info:', data);
console.table(arrayData);
console.trace('Trace point');
```

### Vue DevTools
- Ispezione componenti
- Timeline eventi
- Debugging Vuex
- Performance profiling

### Livewire DevTools
- Debugging componenti
- Tracciamento eventi
- Analisi delle proprietà
- Network monitoring

## Best Practices

### Environment
1. Utilizzare `.env` appropriato
2. Configurare error reporting
3. Impostare log levels
4. Gestire le eccezioni

### Security
1. Disabilitare debug in produzione
2. Sanitizzare output di debug
3. Proteggere routes di debug
4. Limitare accesso ai logs

### Performance
1. Monitorare memory usage
2. Tracciare query N+1
3. Analizzare tempi di risposta
4. Ottimizzare caricamenti

## Workflow di Debug

### 1. Identificazione
- Raccogliere informazioni sull'errore
- Verificare i log
- Controllare lo stack trace
- Identificare il contesto

### 2. Isolamento
- Riprodurre il problema
- Isolare il codice problematico
- Verificare le dipendenze
- Testare in ambiente locale

### 3. Risoluzione
- Implementare la fix
- Testare la soluzione
- Verificare effetti collaterali
- Documentare la soluzione

### 4. Prevenzione
- Aggiungere test
- Migliorare logging
- Aggiornare documentazione
- Implementare monitoring

## Tools Aggiuntivi

### Xdebug
```ini
; php.ini
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_port=9003
```

### Ray by Spatie
```php
ray($variable)->color('green');
ray()->showQueries();
ray()->measure();
```

### Clockwork
- Profiling applicazione
- Analisi performance
- Debug database
- Timeline eventi

## Checklist Debug

### Pre-Debug
- [ ] Verificare ambiente
- [ ] Controllare configurazioni
- [ ] Preparare test case
- [ ] Backup dati sensibili

### Durante Debug
- [ ] Logging strutturato
- [ ] Step-by-step debugging
- [ ] Documentare findings
- [ ] Testare assumptions

### Post-Debug
- [ ] Verificare risoluzione
- [ ] Aggiornare tests
- [ ] Documentare soluzione
- [ ] Review del codice
