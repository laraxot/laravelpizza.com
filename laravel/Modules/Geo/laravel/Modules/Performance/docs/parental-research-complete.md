# Parental STI Pattern - Complete Research & Implementation Guide

## Executive Summary

**Research Question**: Do we really need global scopes in Parental child models, or is there a better way?

**Answer**: **YES, global scopes are required** when querying child models directly. However, there are **alternative patterns** worth understanding.

---

## Problem Analysis

### The Core Issue

When using Tighten/Parental for Single Table Inheritance (STI):

```php
// Querying PARENT - works perfectly with Parental
Individuale::all();
// ✅ Returns: Collection with correct child instances
// ✅ type='dip' → IndividualeDip instance
// ✅ type='po' → IndividualePo instance
// ✅ type='regionale' → IndividualeRegionale instance
```

```php
// Querying CHILD directly - PROBLEM!
IndividualeRegionale::all();
// ❌ Without global scope: Returns ALL records
// ✅ With global scope: Returns only type='regionale'
```

### Why This Happens

**Parental's `HasParent` trait does TWO things:**
1. ✅ Makes child use parent's table (`performance_individuale` instead of `individuale_regionale`)
2. ✅ Automatically sets `type` column on save

**What `HasParent` does NOT do:**
- ❌ Does NOT add automatic filtering when querying child models
- ❌ Does NOT prevent `ChildModel::all()` from returning all records

---

## Three Possible Solutions

### Solution 1: Global Scope in `boot()` (CURRENT IMPLEMENTATION) ✅

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**Pros:**
- ✅ Explicit and clear
- ✅ Works with all Eloquent query methods
- ✅ Easy to understand and debug
- ✅ Standard Laravel pattern
- ✅ Can be removed locally if needed (`withoutGlobalScope()`)

**Cons:**
- ❌ Must be added to EVERY child model
- ❌ Slight performance overhead (scope applied to all queries)
- ❌ Can be forgotten (human error)

**Used in:** This codebase (confirmed working)

---

### Solution 2: Override `newModelQuery()` (ALTERNATIVE)

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    public function newModelQuery()
    {
        return parent::newModelQuery()
            ->where('type', 'regionale');
    }
}
```

**Pros:**
- ✅ No need for `boot()` method
- ✅ Applied at query builder level
- ✅ Slightly more performant (no event overhead)

**Cons:**
- ❌ Less familiar to Laravel developers
- ❌ Harder to remove scope if needed
- ❌ Not standard Laravel pattern
- ❌ Can conflict with other query builder customizations

**Used in:** Some legacy Laravel applications

---

### Solution 3: Use Parent Model + Scope (HYBRID)

```php
// In Filament Resource
protected static string $model = Individuale::class;

// Add default filter
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where('type', 'regionale');
}
```

**Pros:**
- ✅ Only one place to configure (Resource, not Model)
- ✅ Can use Parental's automatic child instantiation
- ✅ More flexible (can change filter per context)

**Cons:**
- ❌ Must be configured in EVERY Resource
- ❌ Not model-level (can be bypassed)
- ❌ Doesn't work outside Filament context

**Used in:** Some Filament-specific implementations

---

## Recommended Approach: **Solution 1 (Global Scope)** ✅

After thorough research, **Solution 1** (global scope in `boot()`) is the **best choice** because:

1. **Laravel Standard**: Uses official Laravel global scope pattern
2. **Explicit**: Clear what's happening, easy to debug
3. **Flexible**: Can be removed with `withoutGlobalScope()` if needed
4. **Testable**: Easy to write tests for
5. **Documented**: Well-documented in Laravel docs
6. **Maintainable**: Other Laravel developers will understand it

---

## Implementation Checklist

### Parent Model (Individuale)

```php
use Parental\HasChildren;

class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    protected string $childColumn = 'type';

    protected array $childTypes = [
        'dip' => IndividualeDip::class,
        'po' => IndividualePo::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];
}
```

### Child Models (ALL must have this)

```php
use Parental\HasParent;
use Illuminate\Database\Eloquent\Builder;

class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function (Builder $query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**Repeat for each child:**
- `IndividualeDip` → `where('type', 'dip')`
- `IndividualePo` → `where('type', 'po')`
- `IndividualeDirigente` → `where('type', 'dirigente')`

---

## Testing Verification

```php
// Test 1: Child model returns only its type
public function test_child_model_filters_by_type(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    
    $result = IndividualeRegionale::all();
    
    expect($result)->toHaveCount(1);
    expect($result->first()->type)->toBe('regionale');
}

// Test 2: Parent model returns all with correct types
public function test_parent_model_returns_all_children(): void
{
    IndividualeRegionale::factory()->create(['type' => 'regionale']);
    IndividualeDip::factory()->create(['type' => 'dip']);
    IndividualePo::factory()->create(['type' => 'po']);
    
    $result = Individuale::all();
    
    expect($result)->toHaveCount(3);
    expect($result->where('type', 'regionale')->first())->toBeInstanceOf(IndividualeRegionale::class);
    expect($result->where('type', 'dip')->first())->toBeInstanceOf(IndividualeDip::class);
}

// Test 3: Creating child sets type automatically
public function test_creating_child_sets_type_automatically(): void
{
    $regionale = IndividualeRegionale::factory()->create();
    
    expect($regionale->type)->toBe('regionale');
}
```

---

## Common Mistakes to Avoid

### ❌ Mistake 1: Forgetting boot() in child

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;
    // ❌ No boot() = returns ALL records!
}
```

### ❌ Mistake 2: Wrong type value

```php
static::addGlobalScope(function ($query) {
    // ❌ Wrong: Using class name instead of DB value
    $query->where('type', IndividualeRegionale::class);
    
    // ✅ Correct: Using the value from $childTypes
    $query->where('type', 'regionale');
});
```

### ❌ Mistake 3: Not calling parent::boot()

```php
protected static function boot(): void
{
    // ❌ Forgot parent::boot()!
    static::addGlobalScope(...);
}
```

### ❌ Mistake 4: Child extends wrong parent

```php
class IndividualeRegionale extends BaseModel  // ❌
class IndividualeRegionale extends Individuale  // ✅
```

---

## Performance Considerations

### Query Count Comparison

**Without Global Scope (WRONG):**
```php
IndividualeRegionale::all();
// Query: SELECT * FROM performance_individuale
// Returns: 1000 records (all types)
// PHP filters: 1000 → 200 regionale (980 discarded in PHP)
// ❌ Wasteful!
```

**With Global Scope (CORRECT):**
```php
IndividualeRegionale::all();
// Query: SELECT * FROM performance_individuale WHERE type = 'regionale'
// Returns: 200 records (only regionale)
// ✅ Efficient!
```

### Memory Usage

| Approach | Records Fetched | Memory Used | Performance |
|----------|----------------|-------------|-------------|
| ❌ No scope | 1000 (all) | ~5 MB | Slow |
| ✅ Global scope | 200 (filtered) | ~1 MB | Fast |

---

## Advanced Patterns

### Removing Global Scope When Needed

```php
// Get ALL records (ignoring global scope)
IndividualeRegionale::withoutGlobalScopes()->get();

// Get all with specific condition
IndividualeRegionale::withoutGlobalScope('type')
    ->where('altro_campo', 'value')
    ->get();
```

### Dynamic Scopes

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();

        // Dynamic scope based on context
        static::addGlobalScope(function ($query) {
            if (auth()->check()) {
                $query->where('ente', auth()->user()->ente_id);
            }
            $query->where('type', 'regionale');
        });
    }
}
```

### Multiple Scopes

```php
protected static function boot(): void
{
    parent::boot();

    static::addGlobalScope('type', function ($query) {
        $query->where('type', 'regionale');
    });

    static::addGlobalScope('active', function ($query) {
        $query->where('ha_diritto', 1);
    });
}
```

---

## Documentation Updates Required

### Module Documentation

Create/update these files:

1. **`Modules/Performance/docs/parental-sti-pattern.md`**
   - Architecture overview
   - Parent model configuration
   - Child model requirements
   - Global scope pattern

2. **`Modules/Performance/docs/models/individuale-regionale.md`**
   - Model-specific documentation
   - Global scope explanation
   - Usage examples

3. **`Modules/Performance/docs/testing/parental-testing.md`**
   - Test patterns for STI
   - Verification examples
   - Common pitfalls

### Theme Documentation

If theme uses Parental models:

1. **`Themes/Zero/docs/integration/parental-models.md`**
   - How theme interacts with Parental models
   - UI components for STI models
   - Filament resource configuration

### Rules & Memories

Update:

1. **`QWEN.md`** or **`AGENTS.md`**:
   ```markdown
   ## Parental STI Pattern Rule
   
   When using Tighten/Parental for Single Table Inheritance:
   - Parent models use `HasChildren` trait
   - Child models use `HasParent` trait
   - ALL child models MUST have `boot()` method with global scope
   - Global scope filters by type column value
   
   Example:
   ```php
   class ChildModel extends ParentModel
   {
       use HasParent;
       
       protected static function boot(): void
       {
           parent::boot();
           static::addGlobalScope(fn ($q) => $q->where('type', 'child_type'));
       }
   }
   ```
   ```

2. **Agent Skills**: Add skill for Parental pattern verification

3. **Project Memories**: Store pattern as learned knowledge

---

## Conclusion

**Final Answer**: YES, global scopes are **required** in Parental child models when querying them directly.

**Why:**
- `HasParent` trait only enables table sharing, NOT automatic filtering
- Querying `ChildModel::all()` without scope returns ALL records
- Global scope in `boot()` is the Laravel-standard solution

**Alternative patterns exist** (newModelQuery, Filament-level scoping) but are:
- Less standard
- Harder to maintain
- Less flexible

**Recommendation**: Keep using global scopes in `boot()` method. It's the correct, Laravel-idiomatic solution.

---

## References

- [Tighten Parental GitHub](https://github.com/tighten/parental)
- [Laravel Global Scopes Documentation](https://laravel.com/docs/eloquent#global-scopes)
- [Single Table Inheritance Pattern](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)
- [Laravel Eloquent Boot Method](https://laravel.com/docs/eloquent#events-using-traits)

---

## Related Documentation

- `Modules/Performance/docs/parental-sti-filtering.md` - Implementation guide
- `Modules/Performance/docs/bugfix-individuale-regionale-parental-scope.md` - Bug fix report
- `docs/rules/parental-sti-pattern.md` - Project-wide rules
