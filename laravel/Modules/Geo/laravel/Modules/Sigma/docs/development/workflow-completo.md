# Workflow Completo Qualità Codice - Modulo Sigma

> **Data**: Gennaio 2025  
> **Status**: 🚧 In Esecuzione  
> **Filosofia**: "Mago per scrematura → Rector per refactoring → PHPStan per affinamento"

## 🎯 Strategia Completa

### Fase 1: Pre-Analisi con Mago ✅

**Status**: ✅ Mago installato e pronto (versione 1.0.0-rc.4)

**Path**: `mago`

**Comandi Disponibili**:
```bash
cd laravel

# Analisi AST per debugging problemi sintassi
./mago ast --names Modules/Sigma/app/Models/Scheda.php

# Analisi token stream per problemi sintassi complessi
./mago ast --tokens Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php --json

# Linting veloce (solo semantica)
./mago lint Modules/Sigma/app/ --semantics

# Verifica formattazione
./mago format Modules/Sigma/app/ --check

# Analisi statica completa
./mago analyze Modules/Sigma/app/
```

**Report Completo**: [Mago Usage Results](./mago-usage-results.md)

### Fase 2: Refactoring Automatico con Rector Laravel ✅

**Status**: ✅ Completato

**Comando Eseguito**:
```bash
./vendor/bin/rector process Modules/Sigma/app --config=Modules/Sigma/rector.php
```

**Risultati**:
- **47 file modificati**
- **-26 errori PHPStan** (da 892 a 866)
- **Modifiche principali**:
  - Migrazione Carbon a Date facade
  - Cambio visibilità accessor da `public` a `protected`
  - Early return pattern applicato
  - Dead code removal
  - Code quality improvements

**Report Completo**: [Rector Application Report](./rector-application-report.md)

### Fase 3: Affinamento con PHPStan Level 10 🚧

**Status**: 🚧 In Corso

**Errori Attuali**: 866 errori PHPStan livello 10

**Strategia**:
1. Identificare pattern comuni di errori
2. Correggere file per file partendo dai più semplici
3. Documentare pattern identificati
4. Aggiornare documentazione con soluzioni

**Comando**:
```bash
./vendor/bin/phpstan analyse Modules/Sigma/app --level=10 --memory-limit=2G --no-progress
```

## 📊 Progresso Complessivo

| Fase | Status | Errori PHPStan | Note |
|------|--------|----------------|------|
| **Iniziale** | ✅ | 1017 | Baseline iniziale |
| **Fix Manuali** | ✅ | 892 | Qua00k1, Qua03f, Sto00f, Rep00f, Asz00k1 |
| **Rector Laravel** | ✅ | 866 | 47 file modificati, -26 errori |
| **PHPStan Affinamento** | 🚧 | 866 | In corso |

**Riduzione Totale**: -151 errori (-14.8%)

## 🔄 Workflow Iterativo

### Ciclo di Affinamento

```
1. Esegui PHPStan → Identifica errori
   ↓
2. Raggruppa errori per pattern
   ↓
3. Correggi pattern comuni
   ↓
4. Verifica con PHPStan
   ↓
5. Documenta pattern e soluzioni
   ↓
6. Ripeti fino a 0 errori
```

### Pattern Identificati

1. **Carbon Constructor Arguments**: Risolto con type guards
2. **Binary Operations Mixed**: Risolto con explicit casting
3. **Property Access Mixed**: Risolto con type assertions
4. **Extract() Usage**: Risolto con direct array access
5. **Return Type Mismatches**: Risolto con generics corretti
6. **Date Facade Migration**: Applicato da Rector

## 📝 Documentazione Pattern

### Pattern 1: Carbon Constructor con Mixed Types

**Problema**: PHPStan errore su `new Carbon($mixedValue)`

**Soluzione**:
```php
// ❌ ERRATO
$carbon = new Carbon($this->attributes['date']);

// ✅ CORRETTO
$dateValue = $this->attributes['date'] ?? null;
if (!is_numeric($dateValue)) {
    throw new \InvalidArgumentException('date must be numeric');
}
$dateStr = (string) $dateValue;
$carbon = new Carbon($dateStr);
```

### Pattern 2: Binary Operations con Mixed

**Problema**: PHPStan errore su concatenazioni stringhe con mixed

**Soluzione**:
```php
// ❌ ERRATO
echo 'Value: '.$this->mixedProperty;

// ✅ CORRETTO
echo 'Value: '.(string) $this->mixedProperty;
```

### Pattern 3: Property Access su Mixed

**Problema**: PHPStan errore su accesso proprietà da relazioni

**Soluzione**:
```php
// ❌ ERRATO
$value = $this->relation->property;

// ✅ CORRETTO
/** @var RelatedModel|null $relation */
$relation = $this->relation;
if ($relation === null) {
    return null;
}
$value = $relation->property ?? null;
```

### Pattern 4: Sostituzione extract()

**Problema**: PHPStan errore su variabili non definite da extract()

**Soluzione**:
```php
// ❌ ERRATO
extract($params);
// Usa $date_min, $date_max

// ✅ CORRETTO
$dateMin = $params['date_min'] ?? null;
$dateMax = $params['date_max'] ?? null;
```

## 🎯 Prossimi Passi

### Priorità Alta

1. **Fix Pattern Comuni**: Applicare pattern identificati ai file rimanenti
2. **Trait Complessi**: Refactoring manuale `FunctionExtra.php` e `MassExtra.php`
3. **Services**: Correggere errori in `TxtdService.php` e altri services

### Priorità Media

1. **Generics Relazioni**: Correggere covariance issues nelle relazioni Eloquent
2. **Return Types**: Allineare return types con generics corretti
3. **Type Guards**: Aggiungere type guards dove necessario

### Priorità Bassa

1. **Code Smells**: Risolvere code smells identificati da PHPMD
2. **Architecture**: Migliorare architettura con PHP Insights
3. **Formatting**: Applicare Laravel Pint per consistenza

## 🔗 Collegamenti

- [Mago e Rector Usage](./mago-rector-usage.md) - Guida completa strumenti
- [Rector Application Report](./rector-application-report.md) - Report applicazione Rector
- [PHPStan Progress](../phpstan-progress.md) - Report progresso PHPStan
- [PHPStan Strategy](../phpstan-level10-strategy.md) - Strategia risoluzione errori

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: 🚧 Workflow in esecuzione, 866 errori PHPStan rimanenti  
**Prossimi Passi**: Continuare affinamento PHPStan livello 10

