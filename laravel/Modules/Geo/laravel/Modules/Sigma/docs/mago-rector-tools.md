# Mago e Rector Laravel - Guida Completa

> **Data**: Gennaio 2025  
> **Status**: 📚 Documentazione  
> **Filosofia**: "Gli strumenti sono estensioni della mente del programmatore"

## 🎯 Panoramica

### Mago - Toolchain PHP in Rust

**Mago** è una toolchain completa per PHP scritta in **Rust**, che offre strumenti ad alte prestazioni per migliorare il codice PHP:

- **Formatter**: Formattazione codice ad alta velocità
- **Linter**: Analisi statica veloce
- **Analizzatore Statico**: Type checking avanzato
- **Guardiano Architetturale**: Controllo struttura e design

**Caratteristiche Chiave**:
- ⚡ **Performance**: Scritto in Rust, 10-100x più veloce di strumenti PHP equivalenti
- 🔍 **Precisione**: Analisi statica avanzata
- 🎯 **Focus**: Type safety e architettura
- 🚀 **Integrazione**: Compatibile con workflow esistenti

**Riferimenti**:
- [Mago Overview](https://mago.carthage.software/tools/overview)
- Toolchain completa per PHP moderno

### Rector Laravel - Refactoring Automatico

**Rector Laravel** è un'estensione di Rector sviluppata dalla comunità Laravel che fornisce regole specifiche per:

- **Aggiornamento Versioni**: Migrazione automatica tra versioni Laravel
- **Refactoring Pattern**: Applicazione automatica di best practices
- **Type Safety**: Aggiunta automatica di type hints
- **Code Quality**: Miglioramento qualità codice

**Caratteristiche Chiave**:
- 🔄 **Refactoring Automatico**: Trasformazioni sicure e testate
- 📦 **Set Predefiniti**: Regole organizzate per versione Laravel
- ✅ **Dry Run**: Preview modifiche prima dell'applicazione
- 🎯 **Laravel-Specific**: Regole ottimizzate per Laravel

**Riferimenti**:
- [Rector Laravel GitHub](https://github.com/driftingly/rector-laravel)
- Estensione ufficiale per Laravel

## 🔧 Integrazione nel Progetto

### Configurazione Mago (Installato nel progetto)

Mago è installato come **dipendenza di sviluppo** del progetto Laravel tramite Composer e viene eseguito dal vendor bin. In Sigma viene usato come pre‑pass veloce prima di Rector e PHPStan.

- **Complemento a PHPStan**: per una prima analisi statica veloce
- **Complemento a Laravel Pint**: per formattazione ad alte prestazioni
- **Complemento a PHPMD**: per scrematura rapida dei problemi

**Installazione nel progetto**:
```bash
cd laravel
composer require --dev "carthage-software/mago:^1.0.0-rc.4"

# Verifica installazione
./vendor/bin/mago --version
```

**Uso base su Sigma** (dalla root Laravel):
```bash
./vendor/bin/mago format Modules/Sigma/app
./vendor/bin/mago lint   Modules/Sigma/app
./vendor/bin/mago analyze Modules/Sigma/app
./vendor/bin/mago check  Modules/Sigma/app
```

### Configurazione Rector Laravel (Attuale)

Rector Laravel è già configurato nel progetto:

**File Configurazione**: `laravel/rector.php` e `laravel/Modules/Sigma/rector.php`

**Configurazione Attuale Sigma**:
```php
<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/app',
    ]);

    $rectorConfig->skip([
        __DIR__.'/vendor',
        __DIR__.'/docs',
        __DIR__.'/app/Models/Traits/Extras/FunctionExtra.php', // Skip per refactoring manuale
        __DIR__.'/app/Models/Traits/Extras/MassExtra.php', // Skip per refactoring manuale
    ]);

    $rectorConfig->phpVersion(\Rector\ValueObject\PhpVersion::PHP_83);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
    ]);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
};
```

## 📋 Workflow Integrato

### Workflow Completo Qualità Codice

```
┌─────────────────────────────────────────────────────┐
│              QUALITY WORKFLOW                        │
│                                                      │
│  1. PHPStan Level 10 (Type Safety)                  │
│     ↓                                                │
│  2. PHPMD (Code Smells)                              │
│     ↓                                                │
│  3. PHP Insights (Architecture)                     │
│     ↓                                                │
│  4. Rector Laravel (Refactoring)                    │
│     ↓                                                │
│  5. Laravel Pint (Formatting)                       │
│     ↓                                                │
│  6. ✅ Code Ready                                    │
└─────────────────────────────────────────────────────┘
```

### Uso Pratico

#### 1. PHPStan Level 10
```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Sigma --level=10 --memory-limit=2G
```

#### 2. PHPMD
```bash
./vendor/bin/phpmd Modules/Sigma/app text phpmd.ruleset.xml
```

#### 3. PHP Insights
```bash
./vendor/bin/phpinsights analyse Modules/Sigma/ --disable-security-check
```

#### 4. Rector Laravel (Dry Run)
```bash
./vendor/bin/rector process Modules/Sigma/app --dry-run
```

#### 5. Rector Laravel (Apply)
```bash
./vendor/bin/rector process Modules/Sigma/app
```

#### 6. Laravel Pint
```bash
./vendor/bin/pint Modules/Sigma/
```

## 🎯 Regole Rector Laravel Disponibili

### Set Predefiniti

**LaravelSetList**:
- `LARAVEL_100`: Regole per Laravel 10.0
- `LARAVEL_101`: Regole per Laravel 10.1
- `LARAVEL_110`: Regole per Laravel 11.0
- `LARAVEL_111`: Regole per Laravel 11.1

**Regole Comuni**:
- `RedirectRouteToToRouteHelperRector`: Migrazione `redirect()->route()` a `to_route()`
- `FacadeToHelperRector`: Migrazione Facade a helper functions
- `ModelPropertyPromotionRector`: Promozione proprietà nel costruttore
- `QueryBuilderMethodCallRector`: Migrazione metodi query builder

### Esempio Applicazione

**Prima**:
```php
return redirect()->route('users.index');
```

**Dopo Rector**:
```php
return to_route('users.index');
```

## 🚀 Best Practices

### Quando Usare Rector

✅ **DO**:
- Migrazione tra versioni Laravel
- Applicazione pattern comuni
- Refactoring sicuro e testato
- Aggiunta type hints automatica

❌ **DON'T**:
- Refactoring complesso che richiede comprensione business logic
- Modifiche a trait complessi (es. `FunctionExtra`, `MassExtra`)
- Modifiche che cambiano comportamento runtime

### Strategia Applicazione

1. **Dry Run Prima**: Sempre eseguire `--dry-run` prima di applicare
2. **Commit Separato**: Applicare Rector in commit dedicato
3. **Test Dopo**: Eseguire test dopo applicazione
4. **Review Manuale**: Verificare modifiche automatiche

## 📊 Confronto Strumenti

| Strumento | Scopo | Velocità | Precisione | Uso |
|-----------|-------|----------|------------|-----|
| **PHPStan** | Type Safety | Media | Alta | ✅ Attivo |
| **PHPMD** | Code Smells | Media | Media | ✅ Attivo |
| **PHP Insights** | Architecture | Lenta | Alta | ✅ Attivo |
| **Rector** | Refactoring | Media | Alta | ✅ Attivo |
| **Mago** | All-in-One | **Molto Alta** | Alta | ⏳ Futuro |
| **Laravel Pint** | Formatting | Media | Media | ✅ Attivo |

## 🔗 Collegamenti

### Documentazione Progetto
- [PHPStan Strategy](./phpstan-level10-strategy.md) - Strategia PHPStan livello 10
- [PHPStan Progress](./phpstan-progress.md) - Report progresso
- [Code Quality](../Xot/docs/quality-tools-zen.md) - Filosofia strumenti qualità

### Documentazione Esterna
- [Mago Overview](https://mago.carthage.software/tools/overview)
- [Rector Laravel GitHub](https://github.com/driftingly/rector-laravel)
- [Rector Documentation](https://getrector.com/documentation)

## 📝 Note Implementative

### Configurazione Rector Sigma

Il modulo Sigma ha configurazione Rector dedicata che:
- Skip trait complessi (`FunctionExtra`, `MassExtra`)
- Target PHP 8.3
- Applica regole CODE_QUALITY, DEAD_CODE, EARLY_RETURN
- Importa nomi completi per chiarezza

### Integrazione Futura Mago

Quando Mago sarà disponibile, può essere integrato come:
- **Sostituto Parziale**: Per formattazione e linting veloce
- **Complemento**: Per analisi statica aggiuntiva
- **Pre-Commit Hook**: Per controlli rapidi pre-commit

## ✅ Checklist Integrazione

- [x] Documentazione Rector Laravel completa
- [x] Configurazione Rector Sigma verificata
- [ ] Test applicazione Rector su file sample
- [ ] Integrazione Mago (quando disponibile)
- [ ] Workflow CI/CD aggiornato
- [ ] Documentazione team aggiornata

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: 📚 Documentazione completa  
**Prossimi Passi**: Test applicazione Rector, valutazione integrazione Mago

