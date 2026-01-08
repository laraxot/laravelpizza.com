# Problemi con PHPStan e Larastan in un progetto modulare

## Problema dell'integrazione Larastan con struttura modulare

Nel tentativo di utilizzare PHPStan con Larastan in un progetto modulare Laravel, abbiamo riscontrato diversi problemi:

1. **Errore del bootstrap di Larastan**:
   ```
   Error thrown in /vendor/laravel/framework/src/Illuminate/Foundation/Application.php on line 961 while loading bootstrap file /vendor/larastan/larastan/bootstrap.php: Class "\Providers\RouteServiceProvider" not found
   ```
   
   **Nota importante**: Nel progetto il progetto non estendiamo `Illuminate\Foundation\Support\Providers\RouteServiceProvider`, ma utilizziamo invece `XotBaseRouteServiceProvider`. Questo è uno dei motivi per cui Larastan può incontrare problemi nel riconoscere correttamente le classi del progetto.

2. **Configurazione dei parametri**:
   Alcune opzioni di configurazione come `checkMissingIterableValueType` non sono supportate nella versione attuale di PHPStan.

## Soluzioni

### Opzione 1: Configurazione minima

Utilizzare una configurazione minima che funzioni:

```neon
includes:
    - phpstan-baseline.neon

parameters:
    level: 3
    paths:
        - app

    excludePaths:
        - app/Filament/Pages (?)
        - build (?)
        - vendor (?)
        - Tests (?)

    ignoreErrors:
        - '#Unsafe usage of new static#'
        - '#Access to an undefined property#'
        - '#Call to an undefined method#'
```

### Opzione 2: Eseguire PHPStan a livello di progetto principale

Invece di eseguire PHPStan su singoli moduli, è possibile configurarlo per analizzare tutti i moduli dalla cartella principale del progetto.

Creare un file `phpstan.neon` nella directory principale:

```neon
includes:
    - vendor/larastan/larastan/extension.neon

parameters:
    level: 3
    paths:
        - Modules/*/app

    excludePaths:
        - Modules/*/app/Filament/Pages
        - Modules/*/build
        - Modules/*/vendor
        - Modules/*/Tests

    ignoreErrors:
        - '#Unsafe usage of new static#'
        - '#Access to an undefined property#'
        - '#Call to an undefined method#'
```

### Opzione 3: Utilizzare Safe senza Larastan

Installare [thecodingmachine/safe](https://github.com/thecodingmachine/safe) per rendere il codice più sicuro, usando le funzioni che lanciano eccezioni invece di restituire false:

```bash
composer require thecodingmachine/safe
```

Utilizzare le funzioni Safe nei tuoi moduli:

```php
use function Safe\file_get_contents;

$content = file_get_contents('file.txt'); // Lancerà un'eccezione in caso di errore
```

## Generazione del Baseline

Per progetti esistenti con molti errori, è consigliabile generare un file baseline:

```bash
./vendor/bin/phpstan analyse --generate-baseline
```

Questo creerà un file `phpstan-baseline.neon` che ignora gli errori esistenti, permettendo di concentrarsi solo sui nuovi errori. 