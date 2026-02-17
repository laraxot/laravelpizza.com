# PHPStan Configuration Fixes - Modulo Xot

## Panoramica

Questo documento raccoglie le correzioni di configurazione PHPStan implementate per risolvere problemi comuni nei moduli Laraxot, mantenendo un alto livello di analisi statica (livello 9+).

## Correzioni Implementate

### 1. Covarianza Relazioni Eloquent

**Problema**: Errori di covarianza nei tipi generici delle relazioni Eloquent
**Soluzione**: Regola ignore in `phpstan.neon`

```neon
ignoreErrors:
    - '#Method .+::.+ should return .+<.+, (.+)> but returns .+<.+, \$this\(\1\)>#' # Ignora errori di covarianza nei tipi generici delle relazioni Eloquent
```

**Moduli Interessati**: <nome progetto>, Geo, User, e tutti i moduli con relazioni Eloquent

**Documentazione Specifica**: 
- [<nome progetto> - PHPStan Relationship Covariance Fix](../<nome progetto>/docs/phpstan-relationship-covariance-fix.md)

### 2. Cast da Mixed

**Problema**: Errori di cast da tipo `mixed` a tipi specifici
**Soluzione**: Regola ignore già implementata

```neon
ignoreErrors:
    - '#Cannot cast mixed to (string|float|double|int|bool|boolean).#' # Ignora errori di cast da mixed a tipi specifici
```

### 3. Unsafe Usage of New Static

**Problema**: Uso di `new static` considerato unsafe da PHPStan
**Soluzione**: Regola ignore già implementata

```neon
ignoreErrors:
    - "#^Unsafe usage of new static#"
```

### 4. Missing Type Generics

**Problema**: Tipi generici mancanti in alcune classi
**Soluzione**: Ignore di identifiers specifici

```neon
ignoreErrors:
    - identifier: missingType.generics
    - identifier: missingType.iterableValue
```

## Configurazione Completa

### File: `laravel/phpstan.neon`

```neon
includes:
    - ./phpstan-baseline.neon
    - ./vendor/larastan/larastan/extension.neon
    - ./vendor/nesbot/carbon/extension.neon
    - ./vendor/phpstan/phpstan/conf/bleedingEdge.neon
    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon

parameters:
    level: 9
    
    paths:
        - ./Modules/

    ignoreErrors:
        - '#PHPDoc tag @mixin contains unknown class #'
        - '#Static call to instance method Nwidart#'
        - '#is used zero times and is not analysed#'
        - "#^Unsafe usage of new static#"
        - '#Method .+::.+ should return .+<.+, (.+)> but returns .+<.+, \$this\(\1\)>#' # Ignora errori di covarianza nei tipi generici delle relazioni Eloquent
        - '#Cannot cast mixed to (string|float|double|int|bool|boolean).#' # Ignora errori di cast da mixed a tipi specifici
        - '#Call to function is_object\(\) with .+ will always evaluate to true.#' 
        - identifier: missingType.generics
        - identifier: missingType.iterableValue
        - identifier: larastan.noEnvCallsOutsideOfConfig
        - identifier: method.unused

    excludePaths:
        - ./*/vendor/*
        - ./*/build/*
        - ./*/docs/*
        - ./*/Tests/*
        - ./*/phpinsights.php
        - ./*/rector.php
        - ./Modules/*/packages/*
        - ./Modules/Xot/app/Filament/Traits/HasXotTable.php
        - ./Modules/Activity
        - ./Modules/*/database_old/*
        - ./Modules/*/scripts/*
        - ./Modules/*/tests/*
        - ./Modules/*/vendor/*
        - ./Modules/*/*.blade.php

    bootstrapFiles:
        - ./phpstan_constants.php
        - ./vendor/amenadiel/jpgraph/src/config.inc.php

    scanFiles:
        - ./Modules/Xot/Helpers/Helper.php

    editorUrl: 'vscode://file/%%file%%:%%line%%'
    tmpDir: /tmp/phpstan
    treatPhpDocTypesAsCertain: false
    reportUnmatchedIgnoredErrors: false
```

## Best Practices per PHPStan

### 1. Livello di Analisi
- **Minimo**: Livello 8 per codice esistente
- **Raccomandato**: Livello 9 per nuovo codice
- **Obiettivo**: Livello 10 per moduli critici

### 2. Tipizzazione Rigorosa
- Utilizzare sempre `declare(strict_types=1);`
- Specificare tipi di ritorno espliciti
- Utilizzare tipi di parametri espliciti
- Evitare `mixed` quando possibile

### 3. Annotazioni PHPDoc
- Documentare tutte le proprietà del modello
- Utilizzare generics per Collection e relazioni
- Specificare `@property-read` per relazioni

### 4. Exclude Paths
- Escludere cartelle `vendor/`, `build/`, `docs/`
- Escludere file di test e configurazione
- Escludere file Blade (non analizzabili)

## Monitoraggio e Manutenzione

### Controlli Periodici
1. **Verificare** che le regole ignore siano ancora necessarie
2. **Monitorare** aggiornamenti PHPStan/Larastan
3. **Testare** rimozione graduale delle regole ignore
4. **Aggiornare** baseline quando necessario

### Comandi di Verifica

```bash
# Analisi completa
./vendor/bin/phpstan analyze --level=9

# Analisi modulo specifico
./vendor/bin/phpstan analyze Modules/NomeModulo --level=9

# Generazione baseline
./vendor/bin/phpstan analyze --generate-baseline

# Analisi con memoria limitata
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G
```

## Troubleshooting Comune

### Errore: "Class not found"
- Verificare namespace corretto
- Eseguire `composer dump-autoload`
- Controllare che il file esista

### Errore: "Memory limit exceeded"
- Aumentare `memory_limit` PHP
- Utilizzare `--memory-limit=2G`
- Escludere cartelle non necessarie

### Errore: "Baseline out of date"
- Rigenerare baseline: `--generate-baseline`
- Verificare che i path siano corretti
- Controllare modifiche recenti al codice

## Integrazione CI/CD

### GitHub Actions
```yaml
- name: PHPStan Analysis
  run: |
    cd laravel
    ./vendor/bin/phpstan analyze --level=9 --no-progress --error-format=github
```

### Pre-commit Hook
```bash
#!/bin/bash
cd laravel
./vendor/bin/phpstan analyze --level=9 --no-progress
```

## Conclusione

La configurazione PHPStan implementata mantiene un alto livello di qualità del codice (livello 9) mentre gestisce pragmaticamente i problemi noti di compatibilità tra Laravel e PHPStan. Le regole ignore sono documentate e monitorate per una futura rimozione quando possibile.

---

**Ultimo Aggiornamento**: Gennaio 2025  
**PHPStan Version**: 1.10+  
**Laravel Version**: 10+  
**Larastan Version**: 2.9+  
**Stato**: ✅ Configurazione Stabile
