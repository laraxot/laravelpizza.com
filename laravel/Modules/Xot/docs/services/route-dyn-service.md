# RouteDynService

Il RouteDynService è un servizio fondamentale per la gestione dinamica delle rotte in Laraxot. Fornisce un'interfaccia flessibile per la generazione e configurazione delle rotte basata su array di configurazione.

## Caratteristiche Principali

- Generazione dinamica di rotte da array di configurazione
- Gestione automatica di prefissi e namespace
- Supporto per parametri di rotta personalizzabili
- Configurazione flessibile dei controller
- Generazione automatica di nomi di rotta

## Metodi Principali

### `getGroupOpts(array $v, ?string $namespace): array`
Genera le opzioni di gruppo per le rotte, includendo:
- prefix: Il prefisso della rotta
- namespace: Il namespace del controller
- as: Il nome della rotta

### `getPrefix(array $v, ?string $namespace): string`
Determina il prefisso della rotta basandosi sulla configurazione o sul nome.

### `getAs(array $v, ?string $namespace): string`
Genera il nome della rotta in formato dot-notation.

### `getNamespace(array $v, ?string $namespace): ?string`
Gestisce il namespace del controller.

### `getController(array $v, ?string $namespace): string`
Determina il nome del controller basandosi sulla configurazione.

## Schema di Configurazione

```php
[
    'name' => 'NomeRotta',           // Obbligatorio: Nome base della rotta
    'prefix' => 'prefisso-rotta',    // Opzionale: Prefisso personalizzato
    'namespace' => 'App\\Http',      // Opzionale: Namespace personalizzato
    'as' => 'nome.rotta',           // Opzionale: Nome rotta personalizzato
    'controller' => 'UserController', // Opzionale: Controller personalizzato
    'param_name' => 'id_custom',     // Opzionale: Nome parametro personalizzato
    'only' => ['index', 'show']      // Opzionale: Limita le azioni disponibili
]
```

## Best Practices

1. **Organizzazione delle Rotte**
   - Raggruppare le rotte correlate usando prefissi comuni
   - Utilizzare namespace significativi per i controller
   - Mantenere coerenza nei nomi delle rotte

2. **Parametri di Rotta**
   - Usare nomi descrittivi per i parametri
   - Implementare vincoli appropriati usando `where`
   - Documentare i parametri richiesti

3. **Gestione dei Controller**
   - Seguire le convenzioni di naming di Laravel
   - Mantenere i controller snelli e focalizzati
   - Utilizzare il type hinting appropriato

## Dipendenze

- Illuminate\Support\Facades\Route
- Illuminate\Support\Str
- Webmozart\Assert\Assert

## Esempio di Utilizzo

```php
$config = [
    'name' => 'users',
    'prefix' => 'admin',
    'namespace' => 'App\\Http\\Controllers\\Admin',
    'only' => ['index', 'show', 'edit', 'update']
];

$opts = RouteDynService::getGroupOpts($config, null);
Route::group($opts, function () use ($config) {
    Route::resource('users', RouteDynService::getController($config, null))
        ->only($config['only']);
});
```

## Note di Sviluppo

- Il servizio utilizza strict typing per garantire la type safety
- Implementa validazione dei parametri tramite Webmozart\Assert
- Supporta la personalizzazione completa delle rotte attraverso la configurazione
- Mantiene la compatibilità con le convenzioni di Laravel

## Test

Il servizio è coperto da test unitari completi che verificano:
- Generazione corretta delle opzioni di gruppo
- Gestione appropriata dei prefissi e namespace
- Validazione dei parametri di input
- Generazione corretta dei nomi dei controller

Per eseguire i test:
```bash
php artisan test --filter=RouteDynServiceTest
``` 