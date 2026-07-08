# Code Quality Tools - Tema One

> **Data**: Gennaio 2025  
> **Tema**: One  
> **Status**: 📚 Documentazione

## 🎯 Panoramica

Documentazione sugli strumenti di qualità codice utilizzati nel progetto, con riferimento specifico al tema One.

## 📚 Documentazione Completa

Per documentazione dettagliata su tutti gli strumenti di qualità, consultare:

- [**Root: Code Quality**](../../../docs/claude/code-quality.md) - Guida completa strumenti qualità
- [**Sigma: Mago e Rector Tools**](../../../Modules/Sigma/docs/mago-rector-tools.md) - Guida Mago e Rector Laravel
- [**Xot: Quality Tools Zen**](../../../Modules/Xot/docs/quality-tools-zen.md) - Filosofia strumenti qualità

## 🔧 Strumenti Utilizzati

### PHPStan Level 10

- Analisi statica type safety
- Configurazione: `phpstan.neon` in root Laravel
- Esecuzione: `./vendor/bin/phpstan analyse --level=10`

### PHPMD

- Code smells detection
- Configurazione: `phpmd.ruleset.xml` nei moduli
- Esecuzione standard (Wrapper): `bash tools/phpmd.sh path text phpmd.ruleset.xml`
- Esecuzione PHAR: `php tools/phpmd.phar path text phpmd.ruleset.xml`

### PHP Insights

- Analisi architettura e complessità
- Installato via Composer come dipendenza di progetto
- Configurazione: `phpinsights.php` nei moduli
- Esecuzione (Wrapper): `bash tools/phpinsights.sh analyse path`
- Esecuzione (Isolata): `php tools/phpinsights/vendor/bin/phpinsights analyse path`

### Rector Laravel

- Refactoring automatico
- Configurazione: `rector.php` in root e moduli
- Esecuzione: `./vendor/bin/rector process path --dry-run`

### Mago (Toolchain PHP in Rust)

- Strumento di formattazione, linting e analisi statica ad alte prestazioni
- Installato come dipendenza di sviluppo nel progetto Laravel
- Esecuzione consigliata (dalla root Laravel):
  - `./vendor/bin/mago format Themes/One`
  - `./vendor/bin/mago lint Themes/One`
- Per dettagli completi vedere:
  - `Modules/Xot/docs/development/mago-rector-guide.md`
  - `Modules/Sigma/docs/mago-rector-tools.md`

### Laravel Pint

- Formattazione codice
- Esecuzione: `./vendor/bin/pint path`

## 🎨 Implicazioni per Tema One

### Model casting (Laravel 12)

Nei modelli Eloquent del progetto è vietato usare la proprietà `protected $casts`.
Il casting deve essere definito tramite il metodo `protected function casts(): array`.

### Form Schema con Chiavi

Il tema One assume che i form Filament abbiano chiavi stringa per mappare correttamente gli stili Tailwind:

```php
// ✅ CORRETTO
return [
    'general' => Section::make(...),
    'details' => Section::make(...),
];

// ❌ ERRATO
return [
    Section::make(...),
    Section::make(...),
];
```

Vedi [Common Errors](./common-errors.md) per dettagli.

## 🔗 Collegamenti

- [Common Errors](./common-errors.md) - Errori comuni tema One
- [Root: Code Quality](../../../docs/claude/code-quality.md) - Guida completa

**Ultimo Aggiornamento**: Gennaio 2025
