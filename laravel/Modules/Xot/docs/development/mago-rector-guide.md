# Mago e Rector Laravel - Guida Completa

> **File**: `Modules/Xot/docs/development/mago-rector-guide.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active

## 🎯 Panoramica

Questa guida documenta l'utilizzo di **Mago** e **Rector Laravel** nel progetto Laraxot PTVX per migliorare la qualità del codice e automatizzare il refactoring.

## 📚 Mago - Suite di Strumenti PHP

### Cos'è Mago

**Mago** è una suite completa di strumenti PHP scritta in Rust, progettata per migliorare la qualità del codice PHP attraverso:

- **Formatter**: Formattazione automatica del codice
- **Linter**: Rilevamento errori e problemi di stile
- **Static Analyzer**: Analisi statica del codice
- **Architectural Guard**: Verifica conformità architetturale

### Caratteristiche Principali

1. **Alte Prestazioni**: Scritto in Rust, molto più veloce degli strumenti PHP tradizionali
2. **Integrazione Completa**: Lavora insieme con altri strumenti del progetto
3. **Configurabile**: Regole personalizzabili per il progetto
4. **CI/CD Ready**: Integrabile facilmente in pipeline CI/CD

### Installazione

```bash
# Installazione consigliata nel progetto Laravel (dipendenza di sviluppo)
composer require --dev "carthage-software/mago:^1.0.0-rc.4"

# Verifica installazione dal progetto
./vendor/bin/mago --version
```

### Configurazione

Crea un file `.mago.toml` nella root del progetto:

```toml
[formatter]
indent_style = "space"
indent_size = 4
line_ending = "lf"
max_line_length = 120

[linter]
rules = [
    "unused_imports",
    "unused_variables",
    "dead_code"
]

[static_analyzer]
level = "strict"
```

### Utilizzo Base

```bash
# Formattazione automatica
mago format Modules/Sigma/

# Linting
mago lint Modules/Sigma/

# Analisi statica
mago analyze Modules/Sigma/

# Tutto insieme
mago check Modules/Sigma/
```

### Integrazione nel Workflow

```bash
#!/bin/bash
# scripts/quality-check.sh

echo "=== Mago Format ==="
mago format Modules/Sigma/

echo "=== Mago Lint ==="
mago lint Modules/Sigma/

echo "=== Mago Analyze ==="
mago analyze Modules/Sigma/
```

### Best Practices

1. **Eseguire prima della formattazione**: Mago formatta il codice prima di altri controlli
2. **Usare in pre-commit hook**: Formattazione automatica prima di ogni commit
3. **Integrare con PHPStan**: Mago per formattazione, PHPStan per type checking
4. **CI/CD Integration**: Eseguire Mago in pipeline CI/CD per garantire consistenza

## 🔧 Rector Laravel - Refactoring Automatico

### Cos'è Rector Laravel

**Rector Laravel** è un'estensione di Rector specifica per Laravel che fornisce regole di refactoring automatizzate per:

- Migrazione tra versioni Laravel
- Modernizzazione codice PHP
- Applicazione best practices Laravel
- Refactoring pattern comuni

### Repository

- **GitHub**: https://github.com/driftingly/rector-laravel
- **Documentazione**: https://github.com/driftingly/rector-laravel#readme

### Installazione

```bash
# Installazione come dipendenza di sviluppo
composer require --dev driftingly/rector-laravel

# Verifica installazione
./vendor/bin/rector --version
```

### Configurazione Base

Crea un file `rector.php` nella root Laravel:

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/Modules/Sigma',
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_90,  // Regole per Laravel 9.0
        LaravelSetList::LARAVEL_100, // Regole per Laravel 10.0
    ]);

    $rectorConfig->skip([
        // Skip specifici file o pattern
        __DIR__ . '/Modules/Sigma/vendor',
        __DIR__ . '/Modules/Sigma/tests',
    ]);
};
```

### Set di Regole Disponibili

```php
use RectorLaravel\Set\LaravelSetList;

// Migrazione Laravel
LaravelSetList::LARAVEL_80  // Laravel 8.0
LaravelSetList::LARAVEL_90  // Laravel 9.0
LaravelSetList::LARAVEL_100 // Laravel 10.0
LaravelSetList::LARAVEL_110 // Laravel 11.0

// Best Practices
LaravelSetList::LARAVEL_CODE_QUALITY
LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL
```

### Utilizzo Base

```bash
# Dry run (preview delle modifiche)
./vendor/bin/rector process Modules/Sigma --dry-run

# Applica modifiche
./vendor/bin/rector process Modules/Sigma

# Con configurazione specifica
./vendor/bin/rector process Modules/Sigma --config=Modules/Sigma/rector.php

# Solo file specifici
./vendor/bin/rector process Modules/Sigma/app/Models/Scheda.php
```

### Esempi di Refactoring

#### 1. Migrazione Facade a Dependency Injection

**Prima**:
```php
use Illuminate\Support\Facades\DB;

public function getData()
{
    return DB::table('users')->get();
}
```

**Dopo** (con Rector):
```php
use Illuminate\Database\Connection;

public function __construct(
    private Connection $db
) {}

public function getData()
{
    return $this->db->table('users')->get();
}
```

#### 2. Modernizzazione Stringhe

**Prima**:
```php
$message = 'Hello ' . $name . '!';
```

**Dopo** (con Rector):
```php
$message = "Hello {$name}!";
```

#### 3. Type Hints Migliorati

**Prima**:
```php
public function process($data)
{
    // ...
}
```

**Dopo** (con Rector):
```php
public function process(array $data): void
{
    // ...
}
```

### Configurazione per Modulo Specifico

Per il modulo Sigma, crea `Modules/Sigma/rector.php`:

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_100,
        LaravelSetList::LARAVEL_CODE_QUALITY,
    ]);

    $rectorConfig->skip([
        // Skip trait complessi che richiedono refactoring manuale
        __DIR__ . '/app/Models/Traits/Extras/FunctionExtra.php',
        __DIR__ . '/app/Models/Traits/Extras/MassExtra.php',
    ]);
};
```

### Workflow Consigliato

```bash
#!/bin/bash
# scripts/rector-refactor.sh

MODULE=$1

if [ -z "$MODULE" ]; then
    echo "Usage: $0 <module-name>"
    exit 1
fi

echo "=== Rector Dry Run per $MODULE ==="
./vendor/bin/rector process "Modules/$MODULE" --dry-run --config="Modules/$MODULE/rector.php"

read -p "Applicare modifiche? (y/n) " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "=== Applicazione modifiche ==="
    ./vendor/bin/rector process "Modules/$MODULE" --config="Modules/$MODULE/rector.php"
    
    echo "=== Verifica PHPStan ==="
    ./vendor/bin/phpstan analyse "Modules/$MODULE" --level=10
fi
```

### Best Practices

1. **Sempre dry-run prima**: Verifica le modifiche prima di applicarle
2. **Commit incrementali**: Applica Rector su piccoli gruppi di file
3. **Verifica PHPStan dopo**: Assicurati che Rector non introduca errori
4. **Skip file complessi**: Alcuni file possono richiedere refactoring manuale
5. **Documenta modifiche**: Registra quali regole sono state applicate

## 🔄 Integrazione nel Workflow Completo

### Workflow Pre-Commit

```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "=== Mago Format ==="
mago format --check || mago format

echo "=== Rector Check ==="
./vendor/bin/rector process --dry-run

echo "=== PHPStan Check ==="
./vendor/bin/phpstan analyse --level=10 --no-progress
```

### Workflow CI/CD

```yaml
# .github/workflows/quality.yml
name: Code Quality

on: [push, pull_request]

jobs:
  quality:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install Dependencies
        run: composer install
      
      - name: Mago Format Check
        run: mago format --check
      
      - name: Rector Check
        run: ./vendor/bin/rector process --dry-run
      
      - name: PHPStan
        run: ./vendor/bin/phpstan analyse --level=10
```

## 📊 Confronto con Altri Strumenti

| Strumento | Scopo | Quando Usare |
|-----------|-------|--------------|
| **Mago** | Formattazione, Linting, Analisi | Sempre, prima di altri controlli |
| **Rector** | Refactoring automatico | Migrazioni, modernizzazione codice |
| **PHPStan** | Type checking statico | Verifica type safety |
| **PHPMD** | Code smells detection | Identificazione problemi complessità |
| **PHP Insights** | Analisi qualità completa | Metriche qualità codice |

## 🎯 Strategia di Utilizzo nel Progetto

### Fase 1: Setup e Configurazione

1. Installare Mago e Rector Laravel
2. Configurare `.mago.toml` e `rector.php`
3. Creare configurazioni per modulo specifico

### Fase 2: Applicazione Incrementale

1. Iniziare con moduli più piccoli
2. Applicare Mago per formattazione
3. Applicare Rector con dry-run
4. Verificare con PHPStan
5. Commit incrementali

### Fase 3: Automatizzazione

1. Pre-commit hooks
2. CI/CD integration
3. Documentazione aggiornata

## 📚 Risorse Aggiuntive

### Mago

- **Sito Web**: https://mago.carthage.software
- **Tools Overview**: https://mago.carthage.software/tools/overview
- **Documentazione**: https://mago.carthage.software/docs

### Rector Laravel

- **GitHub**: https://github.com/driftingly/rector-laravel
- **Rector Main**: https://getrector.com
- **Documentazione**: https://github.com/driftingly/rector-laravel#readme

## 🔗 Collegamenti Correlati

- [PHPStan Workflow](../rules/phpstan-workflow.md)
- [Code Quality Tools Guide](../code-quality-tools-guide.md)
- [Development Guidelines](../development-guidelines.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active  
**Maintainer**: Team Laraxot

