# Activity Log Override in Progressioni - Rationale

## Business Logic

### Perché Progressioni Override getActivitylogOptions()

**Contesto**:
- `BaseScheda` definisce Activity Log con `->logAll()` attivo
- `Progressioni` fa **override** disabilitando `->logAll()`

### Differenze Implementazione

#### BaseScheda (Default)

```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()  // ← ATTIVO: traccia TUTTI i campi fillable
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**Use Case**: Schede generiche con volume moderato di dati.

#### Progressioni (Override)

```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        //->logAll()  // ← COMMENTATO: NON traccia tutti i campi
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**Use Case**: Schede progressioni con **migliaia di record** e aggiornamenti frequenti.

## Motivazione Performance

### Impatto di ->logAll()

**Con logAll() ATTIVO**:
```php
// Edit di 1 campo
$progressione->stabi = 999;
$progressione->save();

// Activity Log serializza:
{
  "attributes": {
    "id": 10660,
    "stabi": 999,
    "matr": 21870,
    "cognome": "FORNER",
    "nome": "MAURO",
    // ... TUTTI i 150+ campi fillable!
  },
  "old": {
    // ... TUTTI i 150+ campi fillable!
  }
}
```

**Overhead**:
- 150+ campi serializzati
- 150+ accessor chiamati (alcuni con calcoli costosi)
- DB query per salvare JSON gigante
- **Tempo**: ~500-1000ms per save

### Con logAll() COMMENTATO

**Senza logAll()**:
```php
// Edit di 1 campo
$progressione->stabi = 999;
$progressione->save();

// Activity Log serializza SOLO dirty:
{
  "attributes": {
    "stabi": 999  // ← Solo campo modificato
  },
  "old": {
    "stabi": 71
  }
}
```

**Vantaggio**:
- 1 campo serializzato
- Nessun accessor calcolato chiamato
- JSON minimale
- **Tempo**: ~50-100ms per save

**Performance Gain**: **10x più veloce** ⚡

## Filosofia: Override vs Duplicazione

### ❌ Duplicazione (DRY Violation)

**Caratteristiche**:
- Stesso codice in più posti
- Stessa business logic
- Stessa implementazione

**Esempio**:
```php
// File A
public function method() {
    return $this->calculate();
}

// File B
public function method() {  // ❌ DUPLICATO!
    return $this->calculate();
}
```

### ✅ Override (Polymorphism)

**Caratteristiche**:
- Stesso metodo signature
- **Business logic DIVERSA**
- Implementazione personalizzata

**Esempio**:
```php
// Base
public function getOptions() {
    return ->all();  // Tutte le opzioni
}

// Derived
public function getOptions() {  // ✅ OVERRIDE!
    return ->filtered();  // Solo opzioni filtrate
}
```

## Regola DRY Applicata Correttamente

### ✅ DO: Override Quando Comportamento Diverso

```php
class Progressioni extends BaseScheda
{
    // ✅ Override perché implementazione DIVERSA
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //->logAll()  // Disabilitato per performance
            ->logOnlyDirty();
    }
}
```

### ❌ DON'T: Duplicare Quando Comportamento Identico

```php
class Progressioni extends BaseScheda
{
    // ❌ Duplicazione se identico a BaseScheda
    use SchedaTrait, SigmaModelTrait { ... }  // BaseScheda già lo fa
}
```

## Checklist Override vs Duplicazione

**Prima di fare override, verificare**:
- [ ] L'implementazione è **DIVERSA** dalla base?
- [ ] C'è una **business logic** che lo giustifica?
- [ ] Il comportamento base **non è appropriato** per questa classe?

**Se SÌ a tutte**: ✅ Override legittimo  
**Se NO ad almeno una**: ❌ Probabile duplicazione (rimuovere)

## Caso Progressioni

- [x] L'implementazione è **DIVERSA** dalla base? → **SÌ** (`logAll()` commentato)
- [x] C'è una **business logic** che lo giustifica? → **SÌ** (performance su migliaia di record)
- [x] Il comportamento base **non è appropriato** per questa classe? → **SÌ** (`logAll()` troppo pesante)

**Conclusione**: ✅ **Override legittimo e necessario**

## Collegamenti

- [BaseScheda Activity Log Configuration](../../Ptv/docs/models/base-scheda-activity-log.md)
- [Spatie Activity Log Documentation](https://spatie.be/docs/laravel-activitylog)
- [Performance Optimization Guide](../../Xot/docs/performance-optimization.md)

---

**Creato**: Gennaio 2026  
**Principio**: **Polymorphism > Duplication**  
**Lesson Learned**: Override con business logic diversa ≠ Duplicazione

