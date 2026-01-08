# Debug

## Pacchetti Utilizzati

### Ignition
- [spatie/laravel-ignition](https://github.com/spatie/laravel-ignition)
  - Debug
  - Error handling
  - Stack trace
  - Configurazione dettagliata
  - Integrazione con Filament

### Ray
- [spatie/laravel-ray](https://github.com/spatie/laravel-ray)
  - Debug avanzato
  - Profiling
  - Logging
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Ignition
```php
// config/ignition.php
return [
    'editor' => env('IGNITION_EDITOR', 'phpstorm'),
    'theme' => env('IGNITION_THEME', 'light'),
    'enable_share_button' => env('IGNITION_SHARING_ENABLED', true),
    'register_commands' => env('IGNITION_REGISTER_COMMANDS', true),
];
```

### Ray
```php
// config/ray.php
return [
    'enable' => env('RAY_ENABLED', true),
    'host' => env('RAY_HOST', 'localhost'),
    'port' => env('RAY_PORT', 23517),
    'always_send_raw_values' => false,
];
```

## Utilizzo

### Ignition
```php
// Abilitare debug
Ignition::enable();

// Disabilitare debug
Ignition::disable();

// Configurare editor
Ignition::editor('vscode');
```

### Ray
```php
// Debug variabile
ray($variable);

// Debug query
ray()->showQueries();

// Debug request
ray()->showRequests();

// Debug cache
ray()->showCache();
```

## Documentazione Collegata

- [Sviluppo](development.md)
- [Testing](testing.md)
- [Performance](performance.md)
- [Panoramica](../packages.md) 
