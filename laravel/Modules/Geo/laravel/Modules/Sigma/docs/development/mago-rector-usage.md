# Mago e Rector Laravel - Guida Completa e Pratica

> **Data**: Gennaio 2025  
> **Status**: 📚 Documentazione Completa  
> **Filosofia**: "Gli strumenti sono estensioni della mente del programmatore"

## 🎯 Panoramica

### Mago - Toolchain PHP in Rust

**Mago** è una toolchain completa per PHP scritta in **Rust**, che offre strumenti ad alte prestazioni per migliorare il codice PHP.

**Componenti Disponibili**:
- **Formatter**: Formattazione codice ad alta velocità
- **Linter**: Analisi statica veloce con regole configurabili
- **Analyzer**: Type checking avanzato e analisi statica
- **Architectural Guard**: Controllo struttura e design
- **Lexer & Parser**: Analisi AST e token stream per debugging

**Caratteristiche Chiave**:
- ⚡ **Performance**: Scritto in Rust, 10-100x più veloce di strumenti PHP equivalenti
- 🔍 **Precisione**: Analisi statica avanzata con AST completo
- 🎯 **Focus**: Type safety e architettura
- 🚀 **Integrazione**: Compatibile con workflow esistenti

**Riferimenti**:
- [Mago Overview](https://mago.carthage.software/tools/overview)
- [Mago Lexer & Parser Command Reference](https://mago.carthage.software/tools/lexer-parser/command-reference)

### Rector Laravel - Refactoring Automatico

**Rector Laravel** è un'estensione di Rector sviluppata dalla comunità Laravel che fornisce regole specifiche per:

- **Aggiornamento Versioni**: Migrazione automatica tra versioni Laravel (10.0, 10.1, 11.0, 11.1)
- **Refactoring Pattern**: Applicazione automatica di best practices Laravel
- **Type Safety**: Aggiunta automatica di type hints e generics
- **Code Quality**: Miglioramento qualità codice con regole configurabili

**Caratteristiche Chiave**:
- 🔄 **Refactoring Automatico**: Trasformazioni sicure e testate
- 📦 **Set Predefiniti**: Regole organizzate per versione Laravel
- ✅ **Dry Run**: Preview modifiche prima dell'applicazione
- 🎯 **Laravel-Specific**: Regole ottimizzate per Laravel

**Riferimenti**:
- [Rector Laravel GitHub](https://github.com/driftingly/rector-laravel)
- [Rector Documentation](https://getrector.com/documentation)

## 🔧 Installazione e Configurazione

### Mago - Installazione ✅

**Metodo Utilizzato**: Dipendenza di sviluppo via Composer nel progetto Laravel

**Comando Eseguito** (dalla root `laravel/`):
```bash
composer require --dev "carthage-software/mago:^1.0.0-rc.4"
```

**Risultato**:
- ✅ Installato come pacchetto Composer dev
- ✅ Versione: `1.0.0-rc.4` (o superiore, in base a self‑update)
- ✅ Eseguibile raccomandato: `./vendor/bin/mago` dalla root Laravel

**Verifica Installazione**:
```bash
cd laravel
./vendor/bin/mago --version
```

**Riferimenti**:
- [Mago Installation Guide](https://mago.carthage.software/guide/installation)

**Metodi Alternativi Disponibili**:
- Shell installer: `curl --proto '=https' --tlsv1.2 -sSfO https://carthage.software/mago.sh && bash mago.sh`
- Cargo: `cargo install mago` (richiede Rust)

### Rector Laravel - Configurazione

Rector Laravel è già installato nel progetto (versione 2.1.3).

**File Configurazione**: `laravel/Modules/Sigma/rector.php`

**Configurazione Attuale Sigma**:
```php
<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

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
        // Laravel specific sets
        LaravelSetList::LARAVEL_100, // Laravel 10.0 rules
        LaravelSetList::LARAVEL_CODE_QUALITY, // Laravel code quality improvements
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL, // Convert array/str functions to static calls
        
        // PHP 8.3 compatibility
        LevelSetList::UP_TO_PHP_83,

        // Code quality improvements
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
    ]);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
};
```

## 📋 Comandi Mago Disponibili

### Comando `mago ast` - Analisi AST

Il comando `mago ast` è uno strumento di ispezione potente che tokenizza e analizza un singolo file PHP, fornendo insight sulla struttura lessicale e sintattica.

**Sintassi Base**:
```bash
mago ast [OPTIONS] <FILE>
```

**Opzioni Disponibili**:

#### `--tokens`
Mostra lo stream di token raw generati dal lexer invece dell'AST parsato. Utile per debugging problemi di sintassi low-level.

```bash
mago ast --tokens app/Models/Example.php
```

Può essere combinato con `--json` per output machine-readable.

#### `--json`
Mostra l'output (AST o token stream) in formato JSON pretty-printed, ideale per integrazione con altri tool e script.

```bash
mago ast --json app/Models/Example.php
```

#### `--names`
Dopo il parsing dell'AST, esegue il name resolver e stampa una lista di tutti i simboli (classi, funzioni, etc.) con i loro nomi completamente qualificati. Utile per debugging namespace e import resolution.

```bash
mago ast --names app/Models/Example.php
```

**Esempi Pratici**:

```bash
# Analisi AST base
mago ast app/Models/Scheda.php

# Analisi token stream per debugging sintassi
mago ast --tokens app/Models/Scheda.php

# Output JSON per integrazione
mago ast --json app/Models/Scheda.php > scheda-ast.json

# Analisi simboli e namespace
mago ast --names app/Models/Scheda.php
```

**Nota**: Il comando `ast` riporta solo errori di parsing. Auto-fixing e baseline non sono applicabili a questo comando.

### Altri Comandi Mago

**Formatter**:
```bash
mago format Modules/Sigma/app/
```

**Linter**:
```bash
mago lint Modules/Sigma/app/
```

**Analyzer**:
```bash
mago analyze Modules/Sigma/app/
```

## 📋 Set Rector Laravel Disponibili

### Set Predefiniti LaravelSetList

**Set per Versioni Laravel**:
- `LaravelSetList::LARAVEL_100`: Regole per Laravel 10.0
- `LaravelSetList::LARAVEL_101`: Regole per Laravel 10.1
- `LaravelSetList::LARAVEL_110`: Regole per Laravel 11.0
- `LaravelSetList::LARAVEL_111`: Regole per Laravel 11.1

**Set Qualità Codice**:
- `LaravelSetList::LARAVEL_CODE_QUALITY`: Miglioramenti qualità codice Laravel
- `LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL`: Conversione funzioni array/str a chiamate statiche
- `LaravelSetList::LARAVEL_FACADES`: Migrazione Facade a helper functions
- `LaravelSetList::LARAVEL_STATIC_TO_INJECTION`: Conversione static calls a dependency injection

**Set Testing**:
- `LaravelSetList::LARAVEL_TESTING`: Miglioramenti testing Laravel

**Set Type Safety**:
- `LaravelSetList::LARAVEL_TYPE_DECLARATIONS`: Aggiunta type hints e generics

### Regole Configurabili

Queste regole richiedono configurazione manuale nel file `rector.php`:

#### RemoveDumpDataDeadCodeRector
Rimuove chiamate a funzioni di debug come `dd()`, `dump()`, etc.

```php
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;

$rectorConfig->withConfiguredRule(RemoveDumpDataDeadCodeRector::class, [
    'dd', 'dump', 'var_dump'
]);
```

#### RouteActionCallableRector
Converte route action strings come `'UserController@index'` a callable arrays `[UserController::class, 'index']`.

```php
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;

$rectorConfig->withConfiguredRule(RouteActionCallableRector::class, [
    'NAMESPACE' => 'App\\Http\\Controllers',
]);
```

#### WhereToWhereLikeRector
Converte `where('column', 'like', 'value')` a `whereLike('column', 'value')`.

```php
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;

$rectorConfig->withConfiguredRule(WhereToWhereLikeRector::class, [
    'USING_POSTGRES_DRIVER' => false, // true per PostgreSQL
]);
```

### Regole Opinionate

Queste regole sono più opinionate e non sono incluse in nessun set di default:

- `RemoveModelPropertyFromFactoriesRector`: Rimuove la proprietà `$model` dalle Factories
- `ResponseHelperCallToJsonResponseRector`: Converte `response()->json()` a `new JsonResponse()`
- `MinutesToSecondsInCacheRector`: Cambia argomento `minutes` a `seconds` nei metodi cache
- `UseComponentPropertyWithinCommandsRector`: Usa `$this->components` property nei comandi
- `UseForwardsCallsTraitRector`: Sostituisce `call_user_func` con `CallForwarding` trait
- `EmptyToBlankAndFilledFuncRector`: Converte `empty()` a `blank()` e `filled()`

## 🔄 Workflow Integrato Completo

### Workflow Completo Qualità Codice

```
┌─────────────────────────────────────────────────────┐
│         QUALITY WORKFLOW INTEGRATO                   │
│                                                      │
│  1. Mago AST Analysis (Debugging)                   │
│     ↓                                                │
│  2. Mago Linter (Quick Check)                       │
│     ↓                                                │
│  3. Rector Laravel (Refactoring)                    │
│     ↓                                                │
│  4. PHPStan Level 10 (Type Safety)                  │
│     ↓                                                │
│  5. PHPMD (Code Smells)                              │
│     ↓                                                │
│  6. PHP Insights (Architecture)                     │
│     ↓                                                │
│  7. Laravel Pint (Formatting)                       │
│     ↓                                                │
│  8. ✅ Code Ready                                    │
└─────────────────────────────────────────────────────┘
```

### Uso Pratico per Modulo Sigma

#### 1. Mago AST Analysis (Se Installato)
```bash
# Analisi AST per debugging
mago ast --names app/Models/Scheda.php

# Analisi token stream per problemi sintassi
mago ast --tokens app/Models/Scheda.php --json > debug.json
```

#### 2. Mago Linter (Se Installato)
```bash
# Quick lint check
mago lint Modules/Sigma/app/
```

#### 3. Rector Laravel (Dry Run)
```bash
cd laravel
./vendor/bin/rector process Modules/Sigma/app --config=Modules/Sigma/rector.php --dry-run
```

#### 4. Rector Laravel (Apply)
```bash
./vendor/bin/rector process Modules/Sigma/app --config=Modules/Sigma/rector.php
```

#### 5. PHPStan Level 10
```bash
./vendor/bin/phpstan analyse Modules/Sigma/app --level=10 --memory-limit=2G
```

#### 6. PHPMD
```bash
./vendor/bin/phpmd Modules/Sigma/app text phpmd.ruleset.xml
```

#### 7. PHP Insights
```bash
./vendor/bin/phpinsights analyse Modules/Sigma/ --disable-security-check
```

#### 8. Laravel Pint
```bash
./vendor/bin/pint Modules/Sigma/
```

## 🎯 Strategia Applicazione per Modulo Sigma

### Fase 1: Pre-Analisi con Mago (Se Disponibile)

**Obiettivo**: Identificare problemi sintattici e strutturali rapidamente

```bash
# Analisi AST di file problematici
mago ast --names app/Models/Traits/Extras/FunctionExtra.php
mago ast --names app/Models/Traits/Extras/MassExtra.php

# Linting veloce
mago lint Modules/Sigma/app/
```

### Fase 2: Refactoring Automatico con Rector Laravel

**Obiettivo**: Applicare refactoring sicuri e pattern Laravel

**Dry Run Prima**:
```bash
./vendor/bin/rector process Modules/Sigma/app \
  --config=Modules/Sigma/rector.php \
  --dry-run \
  --output-format=json > rector-changes.json
```

**Applicazione**:
```bash
./vendor/bin/rector process Modules/Sigma/app \
  --config=Modules/Sigma/rector.php
```

**Modifiche Attese**:
- Conversione `redirect()->route()` a `to_route()`
- Migrazione Facade a helper functions dove appropriato
- Aggiunta type hints dove possibile
- Rimozione dead code
- Early return pattern

### Fase 3: Affinamento con PHPStan Level 10

**Obiettivo**: Garantire type safety completa

```bash
./vendor/bin/phpstan analyse Modules/Sigma/app \
  --level=10 \
  --memory-limit=2G \
  --no-progress
```

**Fix Manuali Necessari**:
- Type hints mancanti o errati
- Generics nelle relazioni Eloquent
- Property access su mixed types
- Binary operations con mixed types

## 📊 Confronto Strumenti

| Strumento | Scopo | Velocità | Precisione | Uso |
|-----------|-------|----------|------------|-----|
| **Mago AST** | Debugging Sintassi | **Molto Alta** | Alta | ⏳ Se installato |
| **Mago Linter** | Quick Check | **Molto Alta** | Media | ⏳ Se installato |
| **Rector Laravel** | Refactoring | Media | Alta | ✅ Attivo |
| **PHPStan** | Type Safety | Media | Alta | ✅ Attivo |
| **PHPMD** | Code Smells | Media | Media | ✅ Attivo |
| **PHP Insights** | Architecture | Lenta | Alta | ✅ Attivo |
| **Laravel Pint** | Formatting | Media | Media | ✅ Attivo |

## 🚀 Best Practices

### Quando Usare Mago

✅ **DO**:
- Debugging problemi sintassi complessi
- Analisi AST per comprensione struttura codice
- Quick linting durante sviluppo
- Pre-commit hooks veloci

❌ **DON'T**:
- Sostituire completamente PHPStan (complementare)
- Analisi type safety completa (usa PHPStan)

### Quando Usare Rector Laravel

✅ **DO**:
- Migrazione tra versioni Laravel
- Applicazione pattern comuni Laravel
- Refactoring sicuro e testato
- Aggiunta type hints automatica
- Rimozione dead code

❌ **DON'T**:
- Refactoring complesso che richiede comprensione business logic
- Modifiche a trait complessi (es. `FunctionExtra`, `MassExtra`) senza review
- Modifiche che cambiano comportamento runtime senza test

### Strategia Applicazione

1. **Dry Run Prima**: Sempre eseguire `--dry-run` prima di applicare Rector
2. **Commit Separato**: Applicare Rector in commit dedicato
3. **Test Dopo**: Eseguire test dopo applicazione
4. **Review Manuale**: Verificare modifiche automatiche
5. **PHPStan Dopo**: Eseguire PHPStan dopo Rector per verificare type safety

## 🔗 Collegamenti

### Documentazione Progetto
- [PHPStan Strategy](../phpstan-level10-strategy.md) - Strategia PHPStan livello 10
- [PHPStan Progress](../phpstan-progress.md) - Report progresso
- [Code Quality](../../Xot/docs/quality-tools-zen.md) - Filosofia strumenti qualità

### Documentazione Esterna
- [Mago Overview](https://mago.carthage.software/tools/overview)
- [Mago Lexer & Parser](https://mago.carthage.software/tools/lexer-parser/command-reference)
- [Rector Laravel GitHub](https://github.com/driftingly/rector-laravel)
- [Rector Documentation](https://getrector.com/documentation)

## 📝 Note Implementative

### Configurazione Rector Sigma

Il modulo Sigma ha configurazione Rector dedicata che:
- Skip trait complessi (`FunctionExtra`, `MassExtra`) per refactoring manuale
- Target PHP 8.3
- Applica regole Laravel 10.0 + CODE_QUALITY, DEAD_CODE, EARLY_RETURN
- Importa nomi completi per chiarezza
- Non importa short classes per evitare ambiguità

### Integrazione Futura Mago

Quando Mago sarà installato, può essere integrato come:
- **Pre-Analisi**: Per identificare problemi sintassi rapidamente
- **Pre-Commit Hook**: Per controlli rapidi pre-commit
- **Complemento PHPStan**: Per analisi AST e debugging

## ✅ Checklist Integrazione

- [x] Documentazione Mago completa con comandi AST
- [x] Documentazione Rector Laravel completa con set disponibili
- [x] Configurazione Rector Sigma verificata e aggiornata
- [ ] Installazione Mago (valutare necessità)
- [ ] Test applicazione Rector su file sample
- [ ] Workflow CI/CD aggiornato
- [ ] Documentazione team aggiornata

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: 📚 Documentazione completa con comandi pratici  
**Prossimi Passi**: Installazione Mago (opzionale), test applicazione Rector, workflow completo
