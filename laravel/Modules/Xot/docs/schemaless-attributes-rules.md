# 🧬 Schemaless Attributes Rules

**Status:** ✅ ACTIVE
**Package:** `spatie/laravel-schemaless-attributes`
**Context:** Laraxot PTVX

---

## 🎯 Principi Fondamentali

1.  **Trait Authority**: Il trait `Spatie\SchemalessAttributes\SchemalessAttributesTrait` è l'autorità.
2.  **Scope Usage**: **USARE SEMPRE** `withExtraAttributes()` per le query.
3.  **No Raw Queries**: **EVITARE** `where('extra_attributes->key', $value)` se possibile.
4.  **No Manual Scopes**: **MAI** sovrascrivere `scopeWithExtraAttributes`.

---

## 🔍 Querying Correctly

### ✅ DO (Preferred)
```php
// Usa lo scope del pacchetto
MyModel::withExtraAttributes('year', 2025)->get();
MyModel::withExtraAttributes('meta.author', 'Admin')->get();
```

### ❌ DON'T (Avoid)
```php
// Query raw su JSON (accoppia al nome colonna e struttura DB)
MyModel::where('extra_attributes->year', 2025)->get();
```

### ❌ NEVER (Forbidden)
```php
// Override manuale dello scope che rompe la funzionalità
public function scopeWithExtraAttributes($query) { ... }
```

---

## 🏗️ Implementazione Standard

### Model Setup
```php
class MyModel extends XotBaseModel
{
    use SchemalessAttributesTrait;

    #[Override]
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
        ];
    }
}
```

---

## 📚 Riferimenti
- [Spatie Documentation](https://github.com/spatie/laravel-schemaless-attributes)
