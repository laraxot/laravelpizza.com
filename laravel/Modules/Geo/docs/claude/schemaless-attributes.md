# Spatie Laravel Schemaless Attributes - Guida Completa PTVX

> **📘 DOCUMENTAZIONE CORRETTA E VERIFICATA**: Pattern corretti per l'uso di schemaless attributes in PTVX

**Ultima Verifica**: 2025-01-02
**Status**: ✅ VERIFICATO - Pattern corretti confermati dal codice sorgente

---

## 🎯 Panoramica

Questo progetto utilizza il package `spatie/laravel-schemaless-attributes` per gestire attributi dinamici JSON su modelli Eloquent, principalmente per:

- **Rating**: Anno, configurazioni dinamiche per anno
- **BaseProfile** (User): Attributi extra utente
- **BaseExtra** (Xot): Attributi extra generici

---

## ✅ PATTERN CORRETTI

### Pattern 1: Array Parameter (RACCOMANDATO)

```php
// ✅ CORRETTO - Passa un array di condizioni
$ratings = Rating::withExtraAttributes(['anno' => 2025])->get();

// ✅ CORRETTO - Condizioni multiple
$ratings = Rating::withExtraAttributes([
    'anno' => 2025,
    'is_readonly' => false
])->get();

// ✅ CORRETTO - Con altre clausole where
$ratings = Rating::withExtraAttributes(['anno' => 2025])
    ->where('is_disabled', false)
    ->get();
```

### Pattern 2: String + Value Parameters (ALTERNATIVO)

```php
// ✅ CORRETTO - Passa chiave e valore separati
$ratings = Rating::withExtraAttributes('anno', 2025)->get();

// ⚠️ NOTA: Per condizioni multiple, usa il Pattern 1 (array)
```

### Pattern 3: Direct JSON Query (PER QUERY COMPLESSE)

```php
// ✅ CORRETTO - Query diretta su JSON path per casi specifici
$ratings = Rating::where('extra_attributes->anno', 2025)->get();

// ✅ CORRETTO - Query JSON complesse con operatori
$ratings = Rating::where('extra_attributes->anno', '>=', 2024)
    ->where('extra_attributes->is_readonly', false)
    ->get();
```

---

## 🔍 Come Funziona Internamente

### Il Meccanismo in `BaseRating.php`

Quando chiami un metodo statico come `Rating::withExtraAttributes()`:

1.  **Laravel cerca**: `scopeWithExtraAttributes()` nel modello
2.  **Passa tutti i parametri** al metodo scope
3.  **L'implementazione in `BaseRating.php` gestisce direttamente i parametri**:

```php
public function scopeWithExtraAttributes(
    Builder $query,
    string|array $attributes = [],
    mixed $value = null,
): Builder {
    if (is_string($attributes) && null !== $value) {
        // Single attribute with value: withExtraAttributes('anno', 2024)
        return $query->where("extra_attributes->{$attributes}", $value);
    }

    if (is_array($attributes)) {
        // Multiple attributes: withExtraAttributes(['anno' => 2024, 'type' => 'foo'])
        foreach ($attributes as $key => $val) {
            $query = $query->where("extra_attributes->{$key}", $val);
        }
    }

    return $query;
}
```

**IMPORTANTE**:
- Il metodo **ACCETTA** i parametri (`$attributes`, `$value`)
- Li usa **direttamente** nel corpo del metodo per costruire la query.
- **Non delega a `modelScope()` né usa `debug_backtrace()`** in questa implementazione specifica del progetto PTVX.

---

## 🚨 PHPStan False Positive (e perché non sempre lo è qui)

### Il Problema

PHPStan segnala questo errore:

```
Static method Illuminate\Database\Eloquent\Builder<Modules\IndennitaResponsabilita\Models\Rating>::withExtraAttributes()
invoked with 2 parameters, 0 required.
```

### Perché può ancora essere un "False Positive" o un errore di configurazione

1.  **PHPStan non sempre comprende** il pattern Laravel scope magic methods.
2.  **Non vede** la signature completa di `scopeWithExtraAttributes()` con i parametri *senza una corretta configurazione o PHPDoc*.
3.  A differenza dell'implementazione generica di Spatie che usa `debug_backtrace()`, l'implementazione in PTVX `BaseRating` **gestisce direttamente i parametri**. Quindi, l'errore non è dovuto al `debug_backtrace()`, ma più probabilmente a una mancata risoluzione della signature del metodo da parte di PHPStan.

### Soluzione: PHPDoc Annotation e Laravel IDE Helper (RACCOMANDATO)

Il modello `Rating.php` (e `BaseRating.php`) dovrebbe avere la corretta annotazione PHPDoc:

```php
/**
 * @method static Builder|Rating withExtraAttributes(string|array $attributes = [], mixed $value = null)
 */
class Rating extends BaseModel
{
    // ...
}
```

**Questa annotazione**:
- ✅ Dichiara la signature corretta del metodo.
- ✅ Permette agli IDE di auto-completare.
- ✅ Aiuta PHPStan a risolvere la signature del metodo, riducendo i falsi positivi.

**Laravel IDE Helper (RACCOMANDATO)**

```bash
php artisan ide-helper:models --write
```

Questo genera PHPDoc più dettagliati che PHPStan può comprendere.

---

## 📋 Checklist Pattern Corretti

### ✅ Quando Usare Array Pattern

- [ ] Query con una singola condizione semplice
- [ ] Query con multiple condizioni
- [ ] Quando la leggibilità è priorità
- [ ] In codice Filament/Livewire

**Esempio**:
```php
$ratings = Rating::withExtraAttributes([
    'anno' => $this->anno,
    'is_readonly' => false
])->get();
```

### ✅ Quando Usare String + Value Pattern

- [ ] Query semplici con una sola condizione
- [ ] Quando serve brevità
- [ ] In metodi brevi o lambda

**Esempio**:
```php
$ratings = Rating::withExtraAttributes('anno', $anno)->get();
```

### ✅ Quando Usare Direct JSON Query

- [ ] Query con operatori complessi (`>=`, `LIKE`, etc.)
- [ ] Query su nested JSON paths
- [ ] Performance critical queries
- [ ] Quando serve massimo controllo SQL

**Esempio**:
```php
$ratings = Rating::where('extra_attributes->anno', '>=', $annoInizio)
    ->where('extra_attributes->anno', '<=', $annoFine)
    ->get();
```

---

## 🎓 Best Practices

### 1. Usa Type Hints

```php
/**
 * @param int $anno
 * @return \Illuminate\Database\Eloquent\Collection<int, Rating>
 */
public function getRatings(int $anno): EloquentCollection
{
    /** @var EloquentCollection<int, Rating> $rows */
    $rows = Rating::withExtraAttributes(['anno' => $anno])->get();

    return $rows;
}
```

### 2. Valida Input

```php
// ✅ CORRETTO - Validazione esplicita
public function getRatings(int $anno): Collection
{
    if ($anno < 2000 || $anno > 2100) {
        throw new \InvalidArgumentException("Anno non valido: {$anno}");
    }

    return Rating::withExtraAttributes(['anno' => $anno])->get();
}
```

### 3. Eager Loading

```php
// ✅ CORRETTO - Carica relazioni in anticipo
$ratings = Rating::withExtraAttributes(['anno' => $anno])
    ->with(['ratingMorphs', 'creator'])
    ->get();
```

### 4. Commenti Espliciti per PHPStan

```php
// ✅ CORRETTO - Aiuta PHPStan e sviluppatori
// Note: withExtraAttributes accepts parameters via Laravel scope magic.
// PHPStan may show false positive - this is expected and correct.
$ratings = Rating::withExtraAttributes('anno', $anno)->get();
```

---

## 📚 Riferimenti

### File Chiave

- **Implementazione**: `Modules/Rating/app/Models/Rating.php:133-142`
- **PHPDoc**: `Modules/Rating/app/Models/Rating.php:53`
- **Spatie Package**: `vendor/spatie/laravel-schemaless-attributes/src/SchemalessAttributesTrait.php`

### Documentazione Correlata

- **[Xot Schemaless Guide](../../laravel/Modules/Xot/docs/schemaless-attributes.md)** - Guida generale Xot
- **[Rating README](../../laravel/Modules/Rating/docs/README.md)** - Documentazione Rating module
- **[HasRatingsTrait](../../laravel/Modules/Rating/docs/has-ratings-trait.md)** - Uso del trait

### Package Documentation

- **[Spatie Laravel Schemaless Attributes](https://github.com/spatie/laravel-schemaless-attributes)** - Official docs

---

## ⚠️ Correzioni Storiche

### Documentazione Precedente Errata (2025-01-01)

Una versione precedente di questa documentazione dichiarava ERRONEAMENTE che:

- ❌ `Rating::withExtraAttributes('anno', $anno)` era SBAGLIATO
- ❌ I parametri venivano IGNORATI
- ❌ Bisognava usare solo `where('extra_attributes->anno', $anno)`

**Questo era COMPLETAMENTE ERRATO!**

### Correzione (2025-01-02)

Dopo studio approfondito del codice sorgente e test:

- ✅ `withExtraAttributes()` **ACCETTA** parametri
- ✅ I parametri **SONO USATI** (via `debug_backtrace()`)
- ✅ Tutti e tre i pattern documentati sono **VALIDI E CORRETTI**

**Riferimento Issue**: PHPStan false positive su `CompilaIndennitaResponsabilita.php:289`

---

**Versione**: 2.0 (Corretto)
**Data**: 2025-01-02
**Autore**: Development Team
**Status**: ✅ VERIFICATO
