# Rector Laravel Integration Strategy - Modulo Sigma

> **Data**: Novembre 2025
> **Status**: 🚧 In Lavorazione
> **Priorità**: Alta

## 📋 Executive Summary

Il modulo Sigma presenta **1017 errori PHPStan livello 10** che richiedono un approccio sistematico utilizzando **Rector Laravel** per automatizzare i fix dove possibile, combinato con correzioni manuali per i pattern complessi.

## 🛠️ Analisi Strumenti Disponibili

### Rector Laravel (driftingly/rector-laravel)

**Capacità Identificate**:
- **LARAVEL_CODE_QUALITY**: Sostituisce chiamate magiche `$this->app['something']`
- **LARAVEL_COLLECTION**: Migliora utilizzo Collections Laravel
- **LARAVEL_STATIC_TO_INJECTION**: Sostituisce Facades con Dependency Injection
- **LARAVEL_FACTORIES**: Migliora factories Laravel
- **LARAVEL_TESTING**: Migliora testing Laravel

**Configurazione Attuale** (`rector.php`):
```php
$rectorConfig->sets([
    PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
    SetList::DEAD_CODE,
    SetList::CODE_QUALITY,
    LevelSetList::UP_TO_PHP_81,
    LaravelSetList::LARAVEL_100,
]);
```

**Limitazioni**:
- Configurazione attuale non include tutti i set Laravel
- Alcuni set sono commentati per problemi di compatibilità

### Mago Toolchain

**Componenti**:
- **Formatter**: Formattatore code PSR-12
- **Linter**: Rilevamento code smells
- **Analyzer**: Analisi statica avanzata
- **Architectural Guard**: Validazione architetturale
- **Lexer & Parser**: AST per debugging

## 🎯 Strategia di Integrazione Rector

### Fase 1: Enhancement Configurazione Rector

**Obiettivo**: Abilitare tutte le regole Laravel compatibili

```php
// rector.php enhancement
$rectorConfig->sets([
    // Laravel specific sets
    LaravelSetList::LARAVEL_CODE_QUALITY,
    LaravelSetList::LARAVEL_COLLECTION,
    LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
    LaravelSetList::LARAVEL_FACTORIES,
    LaravelSetList::LARAVEL_TESTING,

    // PHP quality sets
    SetList::DEAD_CODE,
    SetList::CODE_QUALITY,
    SetList::TYPE_DECLARATION, // Abilitare gradualmente
    SetList::EARLY_RETURN,

    // PHP version
    LevelSetList::UP_TO_PHP_81,
]);
```

### Fase 2: Fix Automatici con Rector

**Pattern Risolvibili Automaticamente**:

1. **Dead Code Removal**
   - Metodi non utilizzati
   - Variabili non utilizzate
   - Import non utilizzati

2. **Code Quality Improvements**
   - Semplificazione condizioni complesse
   - Estrazione metodi da blocchi complessi
   - Rimozione duplicazione codice

3. **Type Declaration** (graduale)
   - Aggiunta return types
   - Aggiunta parameter types
   - Miglioramento type hints

### Fase 3: Fix Manuali per Pattern Complessi

**Pattern NON risolvibili automaticamente**:

1. **Template Covariance Eloquent**
   ```php
   // ❌ NON risolvibile automaticamente
   public function anag(): HasOne
   {
       return $this->hasOne(Anag::class, 'matr', 'dtmatr');
   }

   // ✅ Soluzione manuale
   public function anag(): HasOne
   {
       /** @var HasOne<Anag, Dipt00f> $relation */
       $relation = $this->hasOne(Anag::class, 'matr', 'dtmatr');
       return $relation;
   }
   ```

2. **Complex Trait Methods** (`FunctionExtra.php`, `MassExtra.php`)
   - Refactoring graduale dei metodi complessi
   - Suddivisione in metodi più piccoli
   - Aggiunta type guards

3. **Mixed Type Operations**
   - Aggiunta casting esplicito
   - Type assertions
   - Null coalescing operations

## 📊 Piano di Lavoro Prioritizzato

### Settimana 1: Preparazione e Configurazione

**Obiettivo**: Setup completo toolchain e baseline

1. **Enhancement Rector Configuration**
   - Testare nuovi set Laravel
   - Verificare compatibilità
   - Creare backup configurazione

2. **Baseline Analysis**
   - Eseguire Rector dry-run
   - Identificare fix automatici
   - Documentare pattern problematici

3. **Toolchain Integration**
   - Test Mago components
   - Integrare con workflow esistente
   - Documentare procedure

### Settimana 2: Fix Automatici

**Obiettivo**: Ridurre errori del 30% (da 1017 a ~700)

1. **Dead Code Removal**
   - Eseguire Rector con SetList::DEAD_CODE
   - Verificare non regressione
   - Commit changes

2. **Code Quality Improvements**
   - Eseguire Rector con SetList::CODE_QUALITY
   - Test funzionalità
   - Documentare modifiche

3. **Laravel Specific Fixes**
   - Applicare LaravelSetList rules
   - Verificare compatibilità Laravel 10
   - Test integration

### Settimana 3-4: Fix Manuali Critici

**Obiettivo**: Ridurre errori del 50% (da ~700 a ~350)

1. **Template Covariance Fix**
   - Correggere tutte le relazioni Eloquent
   - Verificare type safety
   - Test performance

2. **Mixed Type Operations**
   - Aggiungere casting esplicito
   - Implementare type guards
   - Test binary operations

3. **Property Access Fix**
   - Aggiungere type assertions
   - Implementare null coalescing
   - Test property access

### Settimana 5-6: Refactoring Complesso

**Obiettivo**: Ridurre errori a 0

1. **Complex Trait Refactoring**
   - Suddividere `FunctionExtra.php`
   - Refactoring `MassExtra.php`
   - Test regressione

2. **Final Quality Pass**
   - PHPStan level 10 verification
   - PHPMD analysis
   - PHPInsights metrics

## 🚨 Risk Mitigation

### Risk 1: Regressione Funzionale
**Mitigazione**:
- Test approfonditi prima/after ogni batch
- Backup configurazioni
- Rollback procedure

### Risk 2: Performance Impact
**Mitigazione**:
- Benchmark critical paths
- Monitor query performance
- A/B testing dove possibile

### Risk 3: Complex Business Logic
**Mitigazione**:
- Documentazione dettagliata business logic
- Pair programming per fix critici
- Validation con domain experts

## 📈 Metriche di Successo

| Fase | PHPStan Errori | PHPMD Violations | PHPInsights Score |
|------|----------------|------------------|-------------------|
| Iniziale | 1017 | TBD | TBD |
| Post-Rector Auto | ~700 | -30% | +10% |
| Post-Fix Manuali | ~350 | -60% | +25% |
| Finale | 0 | -90% | >90% |

## 🔗 Collegamenti

- [PHPStan Level 10 Strategy](./phpstan-level10-strategy.md)
- [Comprehensive Analysis](./comprehensive-analysis.md)
- [Quality Improvements](./quality-improvements.md)
- [Rector Laravel Documentation](https://github.com/driftingly/rector-laravel)
- [Mago Tools Overview](https://mago.carthage.software/tools/overview)

## ✅ Checklist Implementazione

- [ ] Enhancement Rector configuration
- [ ] Test Rector dry-run Sigma module
- [ ] Document automatic fix patterns
- [ ] Implement manual fixes phase 1
- [ ] Verify PHPStan progress
- [ ] Complete complex refactoring
- [ ] Final quality verification

---

**Nota**: Questo documento integra la strategia esistente con focus specifico sull'utilizzo di Rector Laravel per automatizzare i fix dove possibile, riducendo il carico di lavoro manuale e migliorando l'efficienza del processo di risoluzione degli errori PHPStan livello 10.