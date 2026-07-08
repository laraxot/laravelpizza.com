# 🧘 Accessor/Mutator Philosophy - Zen del Tipo Sicuro

> **La Via dell'Accessor Corretto**  
> **Aggiornato**: 2025-03-25  
> **Versione**: 1.0 (SACRO 🔴)

---

## 🎯 Panoramica

Questo documento definisce la **filosofia corretta** per scrivere accessor e mutator in Laravel, seguendo i principi di:
- **Type Safety** (PHPStan Level 10)
- **Forward-Only** (mai regressione)
- **Auto-Persistenza** (calcolo e salvataggio automatico)
- **ActivityLog-Safe** (previene recursion crash)

---

## 📋 Il Problema Fondamentale

### ❌ SBAGLIATO - Ignorare il Tipo del Valore

```php
// ❌ QUESTO È SBAGLIATO!
protected function getPercPTimeDaterangeAttribute(mixed $_value): int|float
{
    // $_value viene IGNORATO (underscore = "non mi serve")
    // Questo rompe il contratto di Laravel accessor!
    
    $rows = $this->qua00fDaterange();
    // ... calcolo complesso ...
    
    return $ore / $giorni;
}
```

**Problemi**:
1. ❌ `mixed $_value` = tipo debole (PHPStan Level 10 fallisce)
2. ❌ `$_value` ignorato = rompi il contratto Laravel
3. ❌ Nessuna persistenza automatica del calcolo
4. ❌ Se chiami `$model->perc_ptime_daterange`, ricalcola SEMPRE
5. ❌ ActivityLog può andare in crash (recursive update)

---

### ✅ CORRETTO - Accettare e Controllare il Tipo

```php
// ✅ QUESTO È CORRETTO!
protected function getPercParttimeDalalAttribute(?float $value): ?float
{
    // ✅ CORRETTO: Controllo se il valore esiste già dal DB
    if (is_float($value)) {
        return $value;  // ✅ Ritorno subito, nessun ricalcolo inutile
    }

    // ✅ Calcolo il valore solo se NULL dal DB
    $date_min = $this->dal;
    $date_max = $this->al;
    if ($date_min === null || $date_max === null) {
        return null;
    }

    // ... calcolo complesso ...
    
    $value = $perc / $peso;
    
    // ✅ Persisto automaticamente il calcolo
    $this->perc_parttime_dalal = $value;
    
    // ✅ ActivityLog-Safe: prevengo ricorsione
    if ($this->getKey() !== null) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['perc_parttime_dalal' => $value]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $value;
}
```

**Vantaggi**:
1. ✅ `?float $value` = tipo forte (PHPStan Level 10 OK)
2. ✅ Controllo `is_float($value)` = rispetto il contratto Laravel
3. ✅ Persistenza automatica = calcolo una volta, uso molte
4. ✅ ActivityLog-Safe = prevengo crash da ricorsione
5. ✅ Performance = non ricalcolo se già esiste

---

## 🧘 La Filosofia Profonda

### Il Contratto dell'Accessor

> **"Un accessor non è una funzione - è un ponte tra DB e oggetto"**

Quando Laravel chiama un accessor:
```php
$model->attribute  // → getAttributeAttribute($value)
```

Il parametro `$value` è:
- **NULL** se il campo non è mai stato caricato dal DB
- **Il valore dal DB** se il campo esiste già
- **Il valore impostato** se hai fatto `$model->attribute = X`

**Ignorare `$value` significa rompere questo contratto sacro.**

---

### Lo Zen del Tipo Sicuro

```php
// ❌ SBAGLIATO - Tipo debole
protected function getFooAttribute(mixed $value): mixed
{
    // "mixed" = "non so cosa entra, non so cosa esce"
    // PHPStan Level 10: ERROR
}

// ✅ CORRETTO - Tipo forte
protected function getFooAttribute(?float $value): ?float
{
    // "?float" = "so cosa entra, so cosa esce"
    // PHPStan Level 10: OK
}
```

**La bellezza del tipo forte**:
- Il compilatore (PHPStan) ti protegge
- Il codice è auto-documentante
- I refactoring sono sicuri
- I bug si scoprono prima

---

### La Via della Persistenza Automatica

> **"Calcola una volta, usa molte volte - questa è la via dello Zen"**

```php
// ❌ SBAGLIATO - Ricalcola SEMPRE
protected function getFooAttribute(mixed $value): float
{
    // Ogni volta che accedi, ricalcola
    return $this->complexCalculation();  // ❌ LENTO!
}

// ✅ CORRETTO - Calcola e persisti
protected function getFooAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // ✅ Già calcolato, uso DB
    }
    
    $calculated = $this->complexCalculation();
    $this->foo = $calculated;  // ✅ Persisto per dopo
    
    // ✅ Salvo nel DB (una volta sola)
    if ($this->exists) {
        $this->update(['foo' => $calculated]);
    }
    
    return $calculated;
}
```

**Performance**:
- Primo accesso: calcolo + salvataggio (100ms)
- Accessi successivi: lettura DB (1ms)
- **100x più veloce** dopo il primo accesso

---

### La Religione dell'ActivityLog-Safe

> **"La ricorsione è il demone che divora i log"**

Quando usi `spatie/laravel-activitylog`:
```php
// ❌ SENZA GUARD → CRASH
protected function getFooAttribute(?float $value): ?float
{
    if ($value === null) {
        $this->update(['foo' => 42]);  // ❌ LogsActivity legge attributes
                                       // → Chiama accessor di nuovo
                                       // → Aggiorna di nuovo
                                       // → RICORSIONE INFINITA!
                                       // → CRASH: "attributeRawValues null"
    }
}

// ✅ CON GUARD → SICURO
protected function getFooAttribute(?float $value): ?float
{
    if (! static::$isUpdatingFromAccessor) {
        static::$isUpdatingFromAccessor = true;
        try {
            $this->update(['foo' => 42]);  // ✅ ActivityLog ignora
                                           // ✅ Nessun loop
        } finally {
            static::$isUpdatingFromAccessor = false;  // ✅ Reset
        }
    }
}
```

**ActivityLog-Safe significa**:
- ✅ Nessun crash da ricorsione
- ✅ Log puliti e accurati
- ✅ Transazioni atomiche
- ✅ Sonni tranquilli la notte

---

## 📝 Pattern Completo (Template SACRO)

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Models\Traits\Mutators;

use Illuminate\Database\Eloquent\Model;

trait YourTraitName
{
    /**
     * Guard contro aggiornamenti ricorsivi da accessor.
     * Previene crash con spatie/activitylog.
     */
    private static bool $isUpdatingFromAccessor = false;

    /**
     * Get [attribute] attribute.
     *
     * Pattern corretto: accetta SEMPRE il valore grezzo dal database.
     * Se il valore esiste già (è float), lo restituisco immediatamente.
     * Altrimenti, calcolo il valore personalizzato e lo persisto.
     */
    protected function getYourAttribute(?float $value): ?float
    {
        // ✅ CORRETTO: Controllo se il valore esiste già dal database
        if (is_float($value)) {
            return $value;
        }

        // ✅ Controllo prerequisiti
        if ($this->prerequisite === null) {
            return null;
        }

        // ✅ Calcolo complesso
        $result = $this->complexCalculation();
        
        // ✅ Persisto nel modello
        $this->your_attribute = $result;

        // ✅ Persisto nel DB (solo se il modello esiste già)
        if ($this->getKey() !== null) {
            // ✅ ActivityLog-Safe: prevengo ricorsione
            if (! static::$isUpdatingFromAccessor) {
                static::$isUpdatingFromAccessor = true;
                try {
                    static::withoutEvents(function () use ($result): void {
                        $this->update(['your_attribute' => $result]);
                    });
                } finally {
                    static::$isUpdatingFromAccessor = false;
                }
            }
        }

        return $result;
    }
}
```

---

## 🔍 Confronto Diretto

### Prima (SBAGLIATO ❌)

```php
protected function getPercPTimeDaterangeAttribute(mixed $_value): int|float
{
    // ❌ mixed = tipo debole
    // ❌ $_value = ignorato (underscore = "non mi serve")
    // ❌ Nessuna persistenza
    // ❌ Ricalcola SEMPRE
    
    $rows = $this->qua00fDaterange();
    // ... calcolo ...
    
    return $ore / $giorni;
}
```

### Dopo (CORRETTO ✅)

```php
protected function getPercPTimeDaterangeAttribute(?float $value): ?float
{
    // ✅ ?float = tipo forte
    // ✅ $value = accettato e controllato
    // ✅ Persistenza automatica
    // ✅ Calcola una volta, usa molte
    
    if (is_float($value)) {
        return $value;  // ✅ Già calcolato, torno subito
    }

    $rows = $this->qua00fDaterange();
    if ($rows === null) {
        return 0.0;
    }
    
    // ... calcolo ...
    
    $result = $ore / $giorni;
    
    // ✅ Persisto
    $this->perc_ptime_daterange = $result;
    
    // ✅ ActivityLog-Safe
    if ($this->getKey() !== null) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['perc_ptime_daterange' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $result;
}
```

---

## 🚨 Regole SACRE

### ❌ MAI FARE

```php
// MAI usare mixed come tipo
protected function getFooAttribute(mixed $value): mixed  // ❌

// MAI ignorare il parametro con underscore
protected function getFooAttribute(mixed $_value)  // ❌

// MAI ricalcolare SEMPRE
protected function getFooAttribute(?float $value): ?float
{
    return $this->complexCalculation();  // ❌ Ignora $value!
}

// MAI aggiornare senza guard
protected function getFooAttribute(?float $value): ?float
{
    if ($value === null) {
        $this->update(['foo' => 42]);  // ❌ RICORSIONE!
    }
}
```

### ✅ SEMPRE FARE

```php
// SEMPRE usare tipo forte
protected function getFooAttribute(?float $value): ?float  // ✅

// SEMPRE controllare il valore
if (is_float($value)) {
    return $value;  // ✅
}

// SEMPRE persistere il calcolo
$this->foo = $result;  // ✅

// SEMPRE usare guard per ActivityLog
if (! static::$isUpdatingFromAccessor) {  // ✅
    static::$isUpdatingFromAccessor = true;
    try {
        static::withoutEvents(function () use ($result): void {
            $this->update(['foo' => $result]);
        });
    } finally {
        static::$isUpdatingFromAccessor = false;
    }
}
```

---

## 📊 Performance Comparison

| Scenario | SBAGLIATO (mixed) | CORRETTO (?float) |
|----------|-------------------|-------------------|
| **Primo accesso** | 100ms (calcolo) | 100ms (calcolo + save) |
| **Secondo accesso** | 100ms (ricalcolo) | 1ms (lettura DB) |
| **Terzo accesso** | 100ms (ricalcolo) | 1ms (lettura DB) |
| **Totale (10 accessi)** | **1000ms** | **109ms** |
| **Speedup** | 1x | **9.2x** |

---

## 🧪 Testing

### Test Unitario (Esempio)

```php
it('calculates and persists perc_ptime_daterange correctly', function (): void {
    // Arrange
    $model = YourModel::factory()->create([
        'perc_ptime_daterange' => null,  // NULL nel DB
    ]);

    // Act
    $result = $model->perc_ptime_daterange;  // Primo accesso

    // Assert
    expect($result)->toBeFloat();  // Tipo corretto
    expect($result)->toBeGreaterThan(0.0);  // Valore calcolato
    
    // Assert: persistenza
    $model->refresh();
    expect($model->perc_ptime_daterange)->toBeFloat();  // Ancora float
    expect($model->perc_ptime_daterange)->toEqual($result);  // Stesso valore
});

it('returns cached value from database', function (): void {
    // Arrange
    $model = YourModel::factory()->create([
        'perc_ptime_daterange' => 42.5,  // Valore nel DB
    ]);

    // Act
    $result = $model->perc_ptime_daterange;  // Primo accesso

    // Assert: nessun ricalcolo, valore dal DB
    expect($result)->toBe(42.5);  // Valore esatto dal DB
});
```

---

## 🔗 Riferimenti

- [Laravel Accessors](https://laravel.com/docs/eloquent-mutators#defining-an-accessor)
- [PHPStan Level 10](https://phpstan.org/user-guide/rule-levels)
- [Spatie ActivityLog](https://spatie.be/docs/laravel-activitylog/v4)
- [Type Safe PHP](https://www.php.net/manual/en/language.types.declarations.php)

---

## 📿 Il Mantra

```
Prima di scrivere un accessor, ripeti:

"Accetto il valore, non lo ignoro"
"Controllo il tipo, non uso mixed"
"Persisto il calcolo, non ricalcolo"
"Uso la guard, non vado in ricorsione"

Respira. Scrivi. PHPStan approva.
```

---

*Documento SACRO per accessor/mutator. Violazioni = Errori di tipo.*  
*Ultimo aggiornamento: 2025-03-25*  
*Stato: ✅ APPROVATO DALLO ZEN*
