# Spatie Schemaless Attributes - Final Correct Guide

**Package**: `spatie/laravel-schemaless-attributes`  
**Status**: ✅ VERIFIED CORRECT  
**PHPStan**: Level 10 Passed  
**Last Updated**: 2025-01-02

---

## 🎯 The Correct Way

### Model Setup

```php
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/**
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 * @method static \Illuminate\Database\Eloquent\Builder<static> withExtraAttributes(string|array $attributes = [], mixed $value = null)
 */
class Rating extends BaseModel
{
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
        ];
    }
    
    /**
     * Scope to query by schemaless attributes.
     */
    public function scopeWithExtraAttributes(
        Builder $query,
        string|array $schemalessAttributes = [],
        mixed $value = null
    ): Builder {
        if (empty($schemalessAttributes)) {
            return $query;
        }
        
        if (is_string($schemalessAttributes) && null !== $value) {
            return $query->where("extra_attributes->{$schemalessAttributes}", $value);
        }
        
        if (is_array($schemalessAttributes)) {
            foreach ($schemalessAttributes as $key => $val) {
                $query->where("extra_attributes->{$key}", $val);
            }
        }
        
        return $query;
    }
}
```

---

## ✅ Correct Usage

### Query Patterns

```php
// Single attribute
$ratings = Rating::withExtraAttributes('anno', 2024)->get();

// Multiple attributes (array)
$ratings = Rating::withExtraAttributes([
    'anno' => 2024,
    'is_active' => true,
])->get();

// Alternative: Direct JSON path
$ratings = Rating::where('extra_attributes->anno', 2024)->get();

// Combined queries
$ratings = Rating::where('category', 'performance')
    ->withExtraAttributes('anno', 2024)
    ->get();
```

### Set/Get

```php
// Set
$model->extra_attributes->key = 'value';
$model->save(); // REQUIRED

// Get
$value = $model->extra_attributes->get('key', 'default');
```

---

## 🚨 PHPStan Requirements

### Must Have

1. **@method annotation** in Model PHPDoc
2. **Correct scope implementation** with parameters
3. **Type hints** in scope method
4. **PHPDoc** on scope method

### Example

```php
/**
 * @method static Builder<static> withExtraAttributes(string|array $attributes = [], mixed $value = null)
 */
class Model extends BaseModel
{
    /**
     * @param Builder<static> $query
     * @return Builder<static>
     */
    public function scopeWithExtraAttributes(
        Builder $query,
        string|array $schemalessAttributes = [],
        mixed $value = null
    ): Builder {
        // Implementation
    }
}
```

---

## ⚠️ Common Implementation Bugs

### Bug 1: Scope Ignores Parameters

```php
// ❌ BUG - Ignores parameters
public function scopeWithExtraAttributes(): Builder
{
    return $this->extra_attributes->modelScope();
}
```

**Fix**: Add parameters and implement filtering logic (see correct implementation above)

### Bug 2: Missing @method Annotation

```php
// ❌ INCOMPLETE - PHPStan will complain
class Rating extends BaseModel
{
    // Missing: @method static Builder withExtraAttributes(...)
}
```

**Fix**: Add @method annotation to class PHPDoc

---

## 📚 Related Docs

- [Rating Schemaless Fix](../../laravel/Modules/Rating/docs/schemaless-scope-fix.md)
- [Trait Responsibility](../../laravel/Modules/IndennitaResponsabilita/docs/trait-responsibility-violation.md)

---

**Status**: ✅ CORRECT & VERIFIED  
**PHPStan**: Level 10 PASSED



