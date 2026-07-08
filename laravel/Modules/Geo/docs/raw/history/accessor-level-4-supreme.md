# 🧘🧘 Livello 4 - Maestro Supremo dell'Accessor

> **La Via della Delegazione e Purezza**  
> **Livello**: MAESTRO SUPREMO 🧘🧘🧘🧘  
> **Aggiornato**: 2025-03-25  
> **Versione**: FINAL FINAL (SACRO 🔴🔴🔴🔴)

---

## 🎯 La Verità Suprema

### L'Evoluzione dell'Accessor

#### Livello 1: ❌ PRINCIPIANTE
```php
protected function getAttribute(mixed $_value): int|float
{
    return $this->calculate();  // ❌ Ignora tutto
}
```

#### Livello 2: ✅ DISCEPOLO
```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    return $this->calculate();  // ✅ Controllo, ma niente persistenza
}
```

#### Livello 3: 🧘 MAESTRO ZEN
```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    $result = $this->calculate();
    $this->attribute = $result;
    
    if ($this->exists) {
        $this->update(['attribute' => $result]);
    }
    
    return $result;  // ✅ Persiste, ma calcolo nell'accessore
}
```

#### Livello 4: 🧘🧘 MAESTRO SUPREMO
```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    // ✅ Delega il calcolo a metodo separato
    $value = $this->calculateAttribute();
    
    // ✅ Persiste AUTOMATICAMENTE
    if ($this->exists) {
        static::withoutEvents(function () use ($value): void {
            $this->update(['attribute' => $value]);
        });
    }
    
    return $value;  // ✅ Accessore PULITO e LEGGIBILE
}

// ✅ Metodo separato per il calcolo
protected function calculateAttribute(): float
{
    // Calcolo complesso qui
    // Accessore rimane pulito
}
```

---

## 🧘 La Filosofia del Livello 4

### Il Principio di Separazione

> **"L'accessore deve orchestrare, non calcolare"**

#### Livello 3: Calcolo nell'Accessore
```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    // ❌ Calcolo complesso MESCOLATO con persistenza
    $rows = $this->relation();
    $array = $rows->get()->toArray();
    $ore = 0.0;
    foreach ($array as $v) {
        // ... 50 righe di calcolo ...
    }
    $result = $ore / $giorni;
    
    // Persistenza
    $this->attribute = $result;
    $this->update(['attribute' => $result]);
    
    return $result;
}
```

**Problemi**:
- ❌ Accessore LUNGO (100+ righe)
- ❌ Calcolo MESCOLATO con persistenza
- ❌ Difficile da testare
- ❌ Difficile da leggere

#### Livello 4: Delega del Calcolo
```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    // ✅ Accessore PULITO (10 righe)
    $value = $this->calculateAttribute();
    
    // ✅ Persistenza PULITA
    if ($this->exists) {
        static::withoutEvents(function () use ($value): void {
            $this->update(['attribute' => $value]);
        });
    }
    
    return $value;
}

// ✅ Calcolo SEPARATO
protected function calculateAttribute(): float
{
    // 50 righe di calcolo QUI
    // Non inquinano l'accessore
}
```

**Vantaggi**:
- ✅ Accessore PULITO e LEGGIBILE
- ✅ Calcolo SEPARATO e testabile
- ✅ Persistenza PULITA
- ✅ **Single Responsibility Principle** (SOLID)

---

## 📋 Il Pattern SACRO del Livello 4

### Template Completo

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Models\Traits\Mutators;

trait YourTraitName
{
    /**
     * Get [attribute] attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getYourAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;  // Già calcolato, torno subito
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateYourAttribute();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['your_attribute' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola il valore di [attribute].
     *
     * Metodo separato per il calcolo complesso.
     * Questo mantiene l'accessore pulito e leggibile (Livello 4).
     */
    protected function calculateYourAttribute(): float
    {
        // ✅ Tutto il calcolo complesso QUI
        // ✅ Accessore rimane pulito
        
        $rows = $this->relation();
        $array = $rows->get()->toArray();
        
        // ... calcolo complesso ...
        
        return $result;
    }
}
```

---

## 🧪 Testing del Livello 4

### Test dell'Accessore (Pulito)

```php
it('returns cached value from database', function (): void {
    $model = YourModel::factory()->create([
        'your_attribute' => 42.5,
    ]);

    expect($model->your_attribute)->toBe(42.5);
});

it('calculates and persists on first access', function (): void {
    $model = YourModel::factory()->create([
        'your_attribute' => null,
    ]);

    $result = $model->your_attribute;

    expect($result)->toBeFloat();
    
    // Verifica persistenza
    $model->refresh();
    expect($model->your_attribute)->toBe($result);
});
```

### Test del Metodo di Calcolo (Separato)

```php
it('calculates complex value correctly', function (): void {
    $model = YourModel::factory()->make();
    
    // Test diretto del metodo di calcolo
    $result = $model->calculateYourAttribute();
    
    expect($result)->toBeFloat();
    expect($result)->toBeGreaterThan(0.0);
});
```

---

## 📊 Confronto dei Livelli

| Caratteristica | Livello 3 🧘 | Livello 4 🧘🧘 |
|---------------|-------------|---------------|
| **Accessore** | 50+ righe | **10 righe** |
| **Calcolo** | Nell'accessore | **Metodo separato** |
| **Leggibilità** | Media | **Alta** |
| **Testabilità** | Difficile | **Facile** |
| **SRP (SOLID)** | ❌ Viola | ✅ **Rispetta** |
| **Manutenibilità** | Media | **Alta** |

---

## 🚨 Regole del Livello 4

### ❌ MAI FARE

```php
// MAI mescolare calcolo e persistenza nell'accessore
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    // ❌ 100 righe di calcolo QUI
    $rows = $this->relation();
    $array = $rows->get()->toArray();
    $ore = 0.0;
    foreach ($array as $v) {
        // ... calcolo complesso ...
    }
    
    // ❌ Persistenza MESCOLATA con calcolo
    $this->update(['attribute' => $result]);
    
    return $result;
}
```

### ✅ SEMPRE FARE

```php
// SEMPRE separare calcolo e persistenza
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    
    // ✅ Delega calcolo
    $value = $this->calculateAttribute();
    
    // ✅ Persistenza PULITA
    if ($this->exists) {
        static::withoutEvents(function () use ($value): void {
            $this->update(['attribute' => $value]);
        });
    }
    
    return $value;
}

// ✅ Calcolo SEPARATO
protected function calculateAttribute(): float
{
    // Tutto il calcolo complesso QUI
}
```

---

## 📿 Il Mantra del Livello 4

```
Prima di scrivere un accessor, ripeti 3 volte:

"Separo il calcolo dalla persistenza"
"L'accessore orchestra, non calcola"
"Il metodo di calcolo è testabile"
"L'accessore è pulito e leggibile"

Respira. Scrivi. Raggiungi il Livello 4.
```

---

## 🔗 Riferimenti

- [Livello 3](docs/accessor-zen-level-3.md) - Auto-persistenza
- [Livello 4](QUESTO FILE) - **Delegazione e Purezza**
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID) - Single Responsibility
- [Clean Code](https://en.wikipedia.org/wiki/Clean_Code) - Robert C. Martin

---

*Documento SACRO del Livello 4. Raggiungi la purezza suprema.*  
*Ultimo aggiornamento: 2025-03-25*  
*Stato: 🧘🧘🧘🧘 LIVELLO 4 RAGGIUNTO*
