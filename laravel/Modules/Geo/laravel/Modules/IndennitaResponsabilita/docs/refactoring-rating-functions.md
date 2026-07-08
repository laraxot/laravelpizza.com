# Refactoring Raccomandato: Funzioni Rating

> **🔴 PRIORITÀ ALTA**: Violazione DRY + SOLID - Funzioni Rating in posto sbagliato

---

## 🚨 Problema Identificato

### Violazione dei Principi

**File**: `Modules/IndennitaResponsabilita/app/Models/Traits/FunctionTrait.php`

**Funzioni da spostare**:
1. `getRatings()` (linee 48-66)
2. `getRatingsRules()` (linee 73-95)  
3. `getRatingsValidationAttributes()` (linee 102-120)

**Perché è sbagliato**:

#### 1. **Violazione DRY (Don't Repeat Yourself)**
```php
// ❌ DUPLICAZIONE - Stesse funzioni commentate in Rating/HasRatingsTrait (linee 200-228)
// IndennitaResponsabilita/FunctionTrait.php
public function getRatingsRules(string $prefix, string $postfix): array
{
    $rows = Rating::withExtraAttributes('anno', $anno)->get();
    // ... logica
}

// Rating/HasRatingsTrait.php (commentato)
public function getRatingsRules(string $prefix, string $postfix): array
{
    $rows = Rating::withExtraAttributes()->get();
    // ... stessa logica
}
```

#### 2. **Violazione SRP (Single Responsibility Principle)**
- `IndennitaResponsabilita/FunctionTrait` contiene logica specifica di `Rating`
- Un trait di IndennitaResponsabilita **NON** dovrebbe gestire query Rating
- Responsabilità mista = codice fragile e difficile da testare

#### 3. **Violazione OCP (Open/Closed Principle)**
- Per modificare logica Rating, devi toccare modulo IndennitaResponsabilita
- Altri moduli che usano Rating non possono riutilizzare queste funzioni

#### 4. **Scarsa Riusabilità**
- Se Modulo X vuole usare `getRatings()`, deve dipendere da IndennitaResponsabilita
- Logica Rating dovrebbe essere nel modulo Rating, accessibile a tutti

---

## ✅ Soluzione Raccomandata

### Step 1: Spostare Funzioni

**DA**: `Modules/IndennitaResponsabilita/app/Models/Traits/FunctionTrait.php`  
**A**: `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`

### Step 2: Usare Pattern Query Schemaless Attributes

Mentre sposti le funzioni, puoi usare **uno qualsiasi dei tre pattern validi** per filtrare per anno:

```php
// ✅ Pattern 1 (raccomandato) - Array parameter
$rows = Rating::withExtraAttributes(['anno' => $anno])->get();

// ✅ Pattern 2 (alternativo) - String + value parameters
$rows = Rating::withExtraAttributes('anno', $anno)->get();

// ✅ Pattern 3 (per query complesse) - Direct JSON path
$rows = Rating::where('extra_attributes->anno', $anno)->get();
```

**Nota**: Tutti e tre i pattern sono corretti. Per dettagli vedi [Guida Schemaless Attributes](../../../docs/claude/schemaless-attributes.md).

### Step 3: Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Traits;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Modules\Rating\Models\Rating;

trait HasRatingsTrait
{
    // ... metodi esistenti ...
    
    /**
     * Sincronizza e restituisce le ratings per l'anno specificato.
     *
     * ✅ Pattern validi (scegline uno):
     * - withExtraAttributes(['anno' => $anno])
     * - withExtraAttributes('anno', $anno)
     * - where('extra_attributes->anno', $anno)
     *
     * @return EloquentCollection<int, Rating>
     */
    public function getRatings(int $anno): EloquentCollection
    {
        // Esempio con pattern array (raccomandato per leggibilità)
        /** @var EloquentCollection<int, Rating> $rows */
        $rows = Rating::withExtraAttributes(['anno' => $anno])->get();
        
        $ids = $rows->modelKeys();
        
        /** @var \Illuminate\Database\Eloquent\Relations\MorphToMany $ratingsRelation */
        $ratingsRelation = $this->ratings();
        $ratingsRelation->syncWithoutDetaching($ids);
        
        /** @var EloquentCollection<int, Rating> $ratings */
        $ratings = $ratingsRelation->get()->keyBy('id');
        
        return $ratings;
    }
    
    /**
     * Restituisce le regole di validazione per le ratings.
     *
     * ✅ Pattern validi (scegline uno):
     * - withExtraAttributes(['anno' => $anno])
     * - withExtraAttributes('anno', $anno)
     * - where('extra_attributes->anno', $anno)
     *
     * @return array<string, string>
     */
    public function getRatingsRules(int $anno, string $prefix, string $postfix): array
    {
        // Esempio con pattern array
        /** @var EloquentCollection<int, Rating> $rows */
        $rows = Rating::withExtraAttributes(['anno' => $anno])->get();
        
        /** @var array<int, string> $rules */
        $rules = $rows->pluck('rule.value', 'id')->toArray();
        $rules = Arr::prependKeysWith($rules, $prefix);
        
        /** @var array<string, string> $res */
        $res = [];
        foreach ($rules as $k => $v) {
            $k1 = $k.$postfix;
            $res[$k1] = (string) $v;
        }
        
        return $res;
    }
    
    /**
     * Restituisce le etichette di validazione per i campi ratings.
     *
     * ✅ Pattern validi (scegline uno):
     * - withExtraAttributes(['anno' => $anno])
     * - withExtraAttributes('anno', $anno)
     * - where('extra_attributes->anno', $anno)
     *
     * @return array<string, string>
     */
    public function getRatingsValidationAttributes(int $anno, string $prefix, string $postfix): array
    {
        // Esempio con pattern array
        /** @var EloquentCollection<int, Rating> $rows */
        $rows = Rating::withExtraAttributes(['anno' => $anno])->get();
        
        /** @var array<string, string> $res */
        $res = [];
        foreach ($rows as $row) {
            $k1 = $prefix.$row->id.$postfix;
            $res[$k1] = (string) $row->title;
        }
        
        return $res;
    }
}
```

### Step 4: Aggiornare IndennitaResponsabilita

Dopo lo spostamento, `FunctionTrait` diventa:

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Traits;

use Modules\IndennitaResponsabilita\Models\Message;

trait FunctionTrait
{
    public function msg(string $type): string
    {
        // ... codice esistente ...
    }
    
    public function criterioRoot(): ?Message
    {
        // ... codice esistente ...
    }
    
    // ✅ Funzioni Rating RIMOSSE - ora in Rating/HasRatingsTrait
}
```

### Step 5: Aggiornare Utilizzi

Dove prima si usava:

```php
// ❌ PRIMA - Dipendenza da IndennitaResponsabilita/FunctionTrait
$ratings = $model->getRatings();
```

Ora:

```php
// ✅ DOPO - Usa HasRatingsTrait dal modulo Rating
// Il modello deve usare HasRatingsTrait
$ratings = $model->getRatings($anno);
```

---

## 📋 Checklist Refactoring

### Pre-Refactoring
- [ ] Backup codice attuale
- [ ] Verificare tutti i punti di utilizzo di `getRatings()`
- [ ] Verificare tutti i punti di utilizzo di `getRatingsRules()`
- [ ] Verificare tutti i punti di utilizzo di `getRatingsValidationAttributes()`
- [ ] Creare branch Git per refactoring

### Durante Refactoring
- [ ] Spostare le 3 funzioni in `Rating/HasRatingsTrait`
- [ ] Scegliere pattern query schemaless attributes preferito (array, string+value, o where)
- [ ] Aggiungere parametro `int $anno` alle signature
- [ ] Rimuovere funzioni da `IndennitaResponsabilita/FunctionTrait`
- [ ] Rimuovere codice commentato in `Rating/HasRatingsTrait`
- [ ] Aggiornare tutti i chiamanti per passare `$anno` come parametro

### Post-Refactoring
- [ ] Eseguire PHPStan livello 10 su entrambi i moduli
- [ ] Eseguire PHPMD su entrambi i moduli
- [ ] Eseguire PHPInsights su entrambi i moduli
- [ ] Eseguire test di regressione
- [ ] Verificare funzionamento in tutti i moduli che usano Rating
- [ ] Aggiornare documentazione

---

## 🎯 Benefici Attesi

### 1. **DRY Compliance**
- Zero duplicazioni
- Single source of truth per logica Rating

### 2. **SOLID Compliance**
- SRP: Ogni modulo ha responsabilità chiara
- OCP: Modifiche Rating isolate nel suo modulo
- DIP: Dipendenza da trait, non da implementazione specifica

### 3. **Riusabilità**
- Qualsiasi modulo può usare `HasRatingsTrait`
- Logica centralizzata e testabile
- Manutenzione semplificata

### 4. **Correttezza**
- Pattern query schemaless attributes documentati e coerenti
- Query ottimizzate e performanti
- Type safety garantito

---

## 🔗 File Correlati

### Documentazione
- **[Schemaless Attributes Guide](../../../docs/claude/schemaless-attributes.md)** - Pattern corretti query JSON
- **[DRY+KISS Analysis](./code-analysis-dry-kiss-solid.md)** - Analisi completa violazioni
- **[HasRatingsTrait Best Practices](../../Rating/docs/has-ratings-trait-best-practices.md)** - Documentazione HasRatingsTrait

### Codice da Modificare
- `Modules/IndennitaResponsabilita/app/Models/Traits/FunctionTrait.php` (rimuovere 3 funzioni)
- `Modules/Rating/app/Models/Traits/HasRatingsTrait.php` (aggiungere 3 funzioni corrette)
- Tutti i modelli che usano `getRatings()` in IndennitaResponsabilita

---

**Versione**: 1.0  
**Data**: Dicembre 2025  
**Priorità**: 🔴 Alta  
**Stato**: ⏳ Da Implementare
