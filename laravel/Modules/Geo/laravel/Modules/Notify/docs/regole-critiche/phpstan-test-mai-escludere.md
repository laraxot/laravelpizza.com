# 🚨 REGOLA CRITICA PROGETTO: PHPStan e Test

## ⚠️ REGOLA ASSOLUTA - NON DEROGABILE

**MAI, IN NESSUN CASO, ESCLUDERE I TEST DALL'ANALISI PHPSTAN!**

## ❌ Proibito Categoricamente

### 1. Esclusione Path Test
```neon
# ❌ VIETATO!
excludePaths:
    - ./tests/*
    - ./Modules/*/tests/*
```

### 2. Ignore File Interi
```php
# ❌ VIETATO!
/**
 * @phpstan-ignore-file
 */
```

### 3. Baseline Giganti
```bash
# ❌ VIETATO generare baseline senza correggere!
./vendor/bin/phpstan analyse --generate-baseline
```

## ✅ Filosofia del Progetto

### Test = Codice di Prima Classe

I test non sono "secondari" o "meno importanti". Sono parte integrante dell'applicazione e devono rispettare gli stessi standard di qualità del codice di produzione.

### Type Safety Ovunque

```
PHPStan Level 10 su:
✅ Models
✅ Controllers  
✅ Services
✅ Resources Filament
✅ Listeners
✅ ✅ ✅ TEST ✅ ✅ ✅
```

## 🎯 Benefici Test Type-Safe

| Beneficio | Descrizione |
|-----------|-------------|
| **Bug Prevention** | Errori rilevati prima del runtime |
| **Refactoring Sicuro** | Cambi signature rilevati subito |
| **Documentazione** | Type hints documentano uso corretto |
| **Code Review** | Più facile capire cosa fa il test |
| **CI/CD** | Build fallisce se test hanno errori tipo |

## 🔧 Approccio Correzione Errori Test

### Step 1: Identificare Errori
```bash
./vendor/bin/phpstan analyse Modules/ModuleName
```

### Step 2: Categorizzare
- method.nonObject → Type hints mancanti
- property.notFound → Pest dynamic properties
- argument.type → Cast o conversioni
- offsetAccess → Array access su mixed

### Step 3: Correggere Sistematicamente
1. Aggiungere type hints a factory
2. Refactorare property chains
3. Aggiungere assert per narrowing
4. phpstan-ignore SOLO per Pest internals

### Step 4: Verifica
```bash
./vendor/bin/phpstan analyse Modules/ModuleName
# [OK] No errors ← INCLUSI I TEST!
```

## 📊 Statistiche Progetto

### Target di Qualità

- **PHPStan Level:** 10 (Massimo)
- **Coverage Test:** > 80%
- **Errori PHPStan Test:** 0
- **Type Safety:** 100%

### Metriche Attuali

Ogni modulo deve avere:
- ✅ 0 errori PHPStan su codice produzione
- ✅ 0 errori PHPStan su test
- ✅ Coverage >= 80%
- ✅ Documentazione aggiornata

## 🎓 Cultura del Team

### Principio Fondamentale

> **"Se non è type-safe, non è pronto per produzione. Questo vale ANCHE per i test."**

### Responsabilità

Ogni developer deve:
1. Scrivere test type-safe
2. Correggere errori PHPStan nei test
3. Non usare scorciatoie (esclusioni, baseline)
4. Documentare pattern e anti-pattern

## 📖 Riferimenti Progetto

- [Regola Critica Activity Module](../laravel/Modules/Activity/docs/phpstan/regola-critica-test-phpstan.md)
- [PHPStan Compliance](../laravel/Modules/*/docs/phpstan-compliance.md)
- [Testing Guidelines](./testing-guidelines.md)

## 🔄 Processo di Review

### Code Review Checklist

- [ ] Test hanno 0 errori PHPStan?
- [ ] Factory hanno type hints?
- [ ] Collections hanno generic types?
- [ ] phpstan-ignore giustificati e documentati?
- [ ] Nessuna esclusione test in config?

### PR Requirements

- ✅ PHPStan clean su tutto (codice + test)
- ✅ Test coverage >= 80%
- ✅ Documentazione aggiornata
- ✅ No baseline additions per test

## 💡 Esempi Reali

### Caso Activity Module

**Errore Iniziale:** Esclusi test da PHPStan (230 errori)  
**Correzione:** RIMOSSA esclusione, correzione manuale errori  
**Risultato:** Type safety completa su tutto il modulo  

## ⚖️ Eccezioni

**Non esistono eccezioni a questa regola.**

I test devono sempre essere analizzati da PHPStan.

---

**Data:** 10 Ottobre 2025  
**Priorità:** 🚨 MASSIMA  
**Categoria:** Regola Critica Non Derogabile  
**Owner:** Intero Team di Sviluppo  

