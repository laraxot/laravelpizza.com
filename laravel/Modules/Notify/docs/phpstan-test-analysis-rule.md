# 🚨 REGOLA CRITICA: Test e Analisi PHPStan

## ⚠️ REGOLA ASSOLUTA

**MAI ESCLUDERE I TEST DALL'ANALISI PHPSTAN!**

Questa è una regola fondamentale per la qualità del codice del progetto.

## ❌ Cosa NON Fare

```neon
# ❌ COMPLETAMENTE SBAGLIATO!
excludePaths:
    - ./tests/*
    - ./Modules/*/tests/*
    - ./*/tests/*
```

```php
// ❌ COMPLETAMENTE SBAGLIATO!
/**
 * @phpstan-ignore-file
 */
```

## ✅ Approccio Corretto

I test **DEVONO** essere analizzati da PHPStan con lo stesso livello di rigore del codice di produzione.

### Motivazioni Fondamentali

1. **Qualità Codice**: Test type-safe = codice affidabile
2. **Bug Prevention**: Errori nei test mascherano bug reali
3. **Manutenibilità**: Type hints facilitano refactoring
4. **Documentazione Vivente**: Type hints documentano comportamento
5. **Continuous Integration**: PHPStan deve passare su TUTTO il codice

## 🛠️ Come Correggere Errori PHPStan nei Test

### Type Hints per Factory

```php
// ✅ CORRETTO
/** @var User */
$user = User::factory()->create();

/** @var \Illuminate\Database\Eloquent\Collection<int, Activity> */
$activities = Activity::factory()->count(10)->create();
```

### Assert per Type Narrowing

```php
// ✅ CORRETTO
$model = Model::find($id);
assert($model instanceof Model);
$model->doSomething();  // PHPStan sa che è Model
```

### Gestione Pest Expectations

```php
// ✅ Meglio accesso diretto
expect($activity->log_name)->toBe('test');

// Invece di chaining proprietà (richiede ignore)
/** @phpstan-ignore-next-line property.notFound */
expect($activity)->log_name->toBe('test');
```

## 📋 Checklist per Test PHPStan-Compliant

- [ ] Ogni factory call ha type hint appropriato
- [ ] Collections hanno type hint completo con generic
- [ ] Assert usato per type narrowing quando necessario
- [ ] phpstan-ignore usato SOLO dove strettamente necessario
- [ ] Ogni ignore ha commento esplicativo del motivo
- [ ] 0 errori PHPStan su test e codice produzione

## 🎯 Best Practices Progetto

### 1. Analisi Completa

```bash
# SEMPRE analizzare tutto il modulo
./vendor/bin/phpstan analyse Modules/ModuleName

# Output atteso: [OK] No errors (inclusi test!)
```

### 2. Correzione Sistematica

- Leggere ogni errore attentamente
- Capire la causa radice
- Applicare fix corretto (type hint, assert, refactor)
- phpstan-ignore SOLO come ultima risorsa

### 3. Documentazione

- Ogni correzione documentata
- Pattern comuni identificati
- Anti-pattern documentati
- Knowledge base aggiornato

## 🚫 Anti-Pattern Proibiti

| Anti-Pattern | Perché è Sbagliato | Soluzione Corretta |
|--------------|-------------------|-------------------|
| Escludere tests/* | Nasconde errori critici | Correggere gli errori |
| @phpstan-ignore-file | Troppo generico | Ignore specifici per linea |
| Ignorare troppi errori | Perde valore analisi | Refactoring codice |
| Baseline troppo grande | Accumula debito | Correzione graduale |

## 📚 Pattern Comuni nei Test

### Factory Pattern

```php
// ✅ Pattern corretto per factory
/** @var User */
$user = User::factory()->create();

/** @var \Illuminate\Database\Eloquent\Collection<int, Activity> */
$activities = Activity::factory()->count(5)->create();
```

### Pest Property Access

```php
// ✅ Meglio evitare chaining proprietà
expect($model->property)->toBe('value');

// Invece di (richiede ignore)
expect($model)->property->toBe('value');
```

### Mixed Return Types

```php
// ✅ Gestire mixed con assert o type hint
$result = someMethodThatReturnsMixed();
assert(is_string($result));
// Ora PHPStan sa che $result è string
```

## 🔧 Correzioni Specifiche Activity Module

### Prima di Iniziare

```bash
# Verifica errori attuali
./vendor/bin/phpstan analyse Modules/Activity

# Expected: ~230 errori da correggere MANUALMENTE
```

### Categorie Errori

1. **method.nonObject** - Factory ritorna mixed
2. **property.notFound** - Pest dynamic properties
3. **argument.templateType** - Template types non risolti
4. **property.nonObject** - Property access su mixed
5. **offsetAccess.nonOffsetAccessible** - Array access su mixed

### Approccio Sistematico

1. Aggiungere type hints a tutti i factory
2. Usare assert per type narrowing
3. Refactorare chaining proprietà Pest
4. phpstan-ignore solo per Pest internals
5. Verificare 0 errori

## 📖 Link Documentazione

- [Correzioni PHPStan Activity](./correzioni-2025-10-10.md)
- [Testing Guidelines](../testing-guidelines.md)
- [Type Safety Best Practices](../../../docs/type-safety.md)

## 🎓 Memorandum

> **"I test sono codice di prima classe. Se il codice di produzione deve passare PHPStan level 10, anche i test devono passare PHPStan level 10."**
> 
> **"Escludere i test da PHPStan è come disattivare i test di sicurezza in aeroporto perché fanno perdere tempo."**

---

**Data Creazione:** 10 Ottobre 2025  
**Motivo:** Errore critico durante correzione PHPStan Activity  
**Importanza:** ⚠️ MASSIMA  
**Categoria:** Anti-Pattern / Regola Critica  

