# Sviluppo

## Pacchetti Utilizzati

### Package Tools
- [spatie/laravel-package-tools](https://github.com/spatie/laravel-package-tools)
  - Strumenti sviluppo
  - Comandi
  - Configurazione
  - Integrazione con Filament
  - Testing

### Ignition
- [spatie/laravel-ignition](https://github.com/spatie/laravel-ignition)
  - Debug
  - Error handling
  - Stack trace
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Package Tools
```php
// config/package-tools.php
return [
    'commands' => [
        \Spatie\LaravelPackageTools\Commands\InstallCommand::class,
        \Spatie\LaravelPackageTools\Commands\PublishCommand::class,
    ],
    'config' => [
        'key' => 'value',
    ],
];
```

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

## Utilizzo

### Package Tools
```php
// Installare pacchetto
Artisan::call('package:install');

// Pubblicare assets
Artisan::call('package:publish');

// Configurare pacchetto
Artisan::call('package:configure');
```

### Ignition
```php
// Abilitare debug
Ignition::enable();

// Disabilitare debug
Ignition::disable();

// Configurare editor
Ignition::editor('vscode');
```

## Documentazione Collegata

- [Testing](testing.md)
- [Performance](performance.md)
- [Debug](debug.md)
- [Panoramica](../packages.md) 
### Versione HEAD


## Collegamenti tra versioni di development.md
* [development.md](../../../Gdpr/project_docs/development.md)
* [development.md](../../../Xot/project_docs/packages/development.md)


### Versione Incoming


---

