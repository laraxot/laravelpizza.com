# Schemaless Attributes - Errori e Correzioni

**Modulo**: Rating
**Data**: 2026-02-11
**Status**: FIX APPLICATI

---

## Errori Trovati

### 1. Rating estende BaseModel invece di BaseRating (DRY Violation)

**File**: `app/Models/Rating.php`

**Problema**: `Rating` estendeva `BaseModel` e duplicava tutto il codice di `BaseRating`:
- `casts()` identico
- `$fillable` identico
- `linkedTo()` identico
- `registerMediaConversions()` identico
- `scopeWithExtraAttributes()` diverso (conflittuale)

**Fix**: `Rating` ora estende `BaseRating`, rimuovendo tutto il codice duplicato.

**Riferimento**: https://github.com/spatie/laravel-schemaless-attributes

### 2. Scope scopeWithExtraAttributes() Conflittuale

**Problema**: Due implementazioni diverse e incompatibili:

**Rating.php** (ERRATO - senza parametri, solo `modelScope()`):
```php
public function scopeWithExtraAttributes(Builder $query): Builder
{
    if (isset($this->extra_attributes) && is_object($this->extra_attributes)
        && method_exists($this->extra_attributes, 'modelScope')) {
        $result = $this->extra_attributes->modelScope();
        if ($result instanceof Builder) {
            return $result;
        }
    }
    return $query;
}
```

**BaseRating.php** (CORRETTO - con parametri per filtrare):
```php
public function scopeWithExtraAttributes(Builder $query, array|string $attributes = [], mixed $value = null): Builder
{
    if (is_string($attributes) && $value !== null) {
        return $query->where("extra_attributes->{$attributes}", $value);
    }
    if (is_array($attributes)) {
        foreach ($attributes as $key => $val) {
            $query = $query->where("extra_attributes->{$key}", $val);
        }
    }
    return $query;
}
```

**Fix**: `Rating` eredita lo scope da `BaseRating`, che supporta:
- `Rating::withExtraAttributes('anno', 2024)->get()`
- `Rating::withExtraAttributes(['anno' => 2024, 'type' => 'foo'])->get()`

### 3. Migrazione Mancante per extra_attributes

**File**: `database/migrations/2023_01_01_000000_create_ratings_table.php`

**Problema**: La migrazione non creava la colonna `extra_attributes` (JSON).
Il modello definiva `'extra_attributes' => SchemalessAttributes::class` nei casts,
ma la colonna non esisteva nel database.

**Fix**: Aggiunta `$table->schemalessAttributes('extra_attributes')` nella sezione UPDATE.

### 4. PHPDoc Mismatch

**Problema**: Rating dichiarava `@method static Builder|Rating withExtraAttributes()`
(senza parametri), BaseRating dichiarava la versione corretta con parametri.

**Fix**: Unificato con l'ereditarieta', ora la signature corretta e' in BaseRating.

### 5. Deprecazione della Proprietà `$casts` per Schemaless Attributes ✅ RISOLTO

**Problema**: L'utilizzo della proprietà `protected $casts` è deprecato nelle versioni più recenti di Laravel. Il modello `BaseRating` è stato aggiornato per adottare il metodo `protected function casts(): array` per definire i casts, inclusi `SchemalessAttributes`.

**Fix Applicato**: La proprietà `$casts` è stata convertita nel metodo `casts()`.

```php
protected function casts(): array
{
    return [
        'extra_attributes' => \Spatie\SchemalessAttributes\Casts\SchemalessAttributes::class,
        // Altri casts...
    ];
}
```

---

## Pattern Corretto (da usare in tutti i moduli)

```php
// 1. Model setup: estendere BaseRating
class Rating extends BaseRating
{
    // Solo override specifici del modulo (connection, fillable aggiuntivi, etc.)
}

// 2. Migration: aggiungere colonna JSON
$table->schemalessAttributes('extra_attributes');

// 3. Query:
Rating::withExtraAttributes('anno', 2024)->get();
Rating::withExtraAttributes(['anno' => 2024, 'type' => 'performance'])->get();
Rating::where('extra_attributes->anno', 2024)->get();

// 4. Set attributes:
$rating->extra_attributes->set('anno', 2024);
$rating->save(); // OBBLIGATORIO!

// 5. Get attributes:
$anno = $rating->extra_attributes->get('anno', date('Y'));
```

---

## Riferimenti

- [spatie/laravel-schemaless-attributes](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel News Article](https://laravel-news.com/laravel-schemaless-attributes-package)
- [IndennitaResponsabilita Rating Usage](../../IndennitaResponsabilita/docs/rating-schemaless-usage.md)
- [Xot Schemaless Rules](../../Xot/docs/schemaless-attributes-rules.md)
