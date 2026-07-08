# Parental STI Pattern Rules for Laraxot

## 🔴 CRITICAL: Parental Package Behavior

### What Parental Does Automatically

The **Tighten Parental** package (`tightenco/parental`) provides Single Table Inheritance (STI) for Laravel Eloquent models.

**Key Discovery**: The `HasParent` trait **automatically adds a global scope** that filters child models by their type!

From `vendor/tightenco/parental/src/HasParent.php`:

```php
public static function bootHasParent(): void
{
    static::creating(function ($model) {
        if ($model->parentHasHasChildrenTrait()) {
            $model->forceFill([
                $model->getInheritanceColumn() => $model->classToAlias(get_class($model))
            ]);
        }
    });

    // ✅ AUTOMATIC GLOBAL SCOPE - Filters by type automatically
    static::addGlobalScope(function ($query) {
        $instance = new static;
        if ($instance->parentHasHasChildrenTrait()) {
            $query->where(
                $query->getModel()->getTable() . '.' . $instance->getInheritanceColumn(),
                $instance->classToAlias(get_class($instance))
            );
        }
    });
}
```

### ✅ CORRECT Implementation (Minimal)

**You DO NOT need a custom `boot()` method!** Just use the trait:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ That's all you need!

    // No boot() needed - HasParent handles filtering automatically
    
    public function mails(): HasMany
    {
        // ... your relationships
    }
}
```

### ❌ WRONG: Redundant boot() Method

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // ❌ DON'T DO THIS - Redundant and useless!
    // HasParent ALREADY adds the global scope automatically
    protected static function boot(): void
    {
        parent::boot();
        
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

**Why it's wrong:**
- 🗑️ **Useless redundancy** - HasParent already filters by type
- 🗑️ **Double filtering** - Two identical global scopes execute
- 🗑️ **Confusion** - Developers think manual scope is required
- 🗑️ **Performance** - Minimal but unnecessary overhead
- 🗑️ **Violates KISS** - Keep It Simple, Stupid! |

## ✅ DO: Implementation Checklist

When creating a new child model with Parental:

### 1. Parent Model Setup

```php
class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    protected string $childColumn = 'type';  // Or custom column name

    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];

    protected $fillable = ['type', /* other fields */];  // ← type MUST be fillable
}
```

### 2. Child Model Setup

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ Required trait - handles EVERYTHING!

    // ✅ NO boot() needed!
    // HasParent automatically:
    // 1. Sets type column on create
    // 2. Adds global scope to filter queries by type
    
    public function mails(): HasMany
    {
        // ... your relationships
    }
}
```

**Note**: If you need custom boot logic for OTHER reasons (not type filtering), you can add it, but call `parent::boot()` first and DON'T add redundant global scopes:

```php
// ✅ ONLY if you need OTHER boot logic
protected static function boot(): void
{
    parent::boot();  // Calls HasParent's automatic filtering
    
    // Your OTHER custom logic (not type filtering!)
    static::created(function ($model) {
        // Custom event handling
    });
}
```

### 3. Database Migration

```php
Schema::create('performance_individuale', function (Blueprint $table) {
    $table->id();
    $table->string('type')->nullable();  // ✅ REQUIRED for Parental STI
    $table->string('post_type')->nullable();
    // ... other fields
    $table->timestamps();
});
```

## ❌ DON'T: Common Mistakes

### Mistake 1: Adding Redundant boot() Method

```php
// ❌ WRONG - Useless redundancy!
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();
        
        // ❌ DON'T - HasParent ALREADY does this!
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}

// ✅ CORRECT - Just use the trait!
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // No boot() needed - HasParent handles everything!
    
    public function mails(): HasMany
    {
        // ... your relationships
    }
}
```

### Mistake 2: Thinking You Need Manual Filtering

```php
// ❌ WRONG - Overcomplicating!
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();
        
        // ❌ HasParent ALREADY adds this scope automatically!
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}

// ✅ CORRECT - Trust the trait!
class IndividualeRegionale extends Individuale
{
    use HasParent;

    // HasParent automatically filters by type = 'regionale'
    // No manual scope needed!
}
```

### Mistake 3: Missing type in $fillable

```php
// ❌ WRONG - Can't create child models
class Individuale extends Model
{
    use HasChildren;
    
    protected $fillable = ['matr', 'cognome', 'nome'];  // ❌ Missing 'type'
}

// ✅ CORRECT
class Individuale extends Model
{
    use HasChildren;
    
    protected $fillable = ['type', 'matr', 'cognome', 'nome'];  // ✅ type included
}
```

### Mistake 4: Mismatched Type Values

```php
// Parent model
class Individuale extends Model
{
    use HasChildren;
    
    protected array $childTypes = [
        'regionale' => IndividualeRegionale::class,  // ← Key is 'regionale'
    ];
}

// Child model
class IndividualeRegionale extends Individuale
{
    use HasParent;
    
    protected static function boot(): void
    {
        parent::boot();
        
        static::addGlobalScope(function ($query) {
            $query->where('type', 'dip');  // ❌ WRONG - Should be 'regionale'
        });
    }
}
```

## 🔍 Troubleshooting

### Problem: Child Model Shows All Types

**Symptoms**: Querying `IndividualeRegionale::all()` returns records of all types

**Debug Steps**:

1. **Verify Model Configuration**
   ```php
   $model = new IndividualeRegionale();
   echo $model->getTable();  // Should be 'performance_individuale'
   echo $model->getInheritanceColumn();  // Should be 'type'
   echo $model->classToAlias(get_class($model));  // Should be 'regionale'
   ```

2. **Check Global Scopes**
   ```php
   $query = IndividualeRegionale::query();
   dd($query->getQuery()->wheres);  // Should show type filter
   ```

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```

4. **Check OpCache**
   - Restart PHP-FPM: `sudo systemctl restart php-fpm`
   - Or restart Apache: `sudo systemctl restart apache2`

5. **Verify Database Data**
   ```sql
   SELECT DISTINCT type FROM performance_individuale;
   -- Should show: 'regionale', 'dip', 'po', 'dirigente'
   ```

### Problem: Type Column Not Auto-Filled

**Symptoms**: Creating child model doesn't set type column

**Solution**: Verify `bootHasParent()` is running:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();  // ✅ This calls bootHasParent() from trait
        
        // Your additional logic...
    }
}
```

## 📚 Reference Files

- `Modules/Performance/app/Models/Individuale.php` - Parent model example
- `Modules/Performance/app/Models/IndividualeRegionale.php` - Child model example
- `Modules/Performance/docs/parental-sti-pattern.md` - Complete pattern guide
- `vendor/tightenco/parental/src/HasParent.php` - Trait source code
- `vendor/tightenco/parental/src/HasChildren.php` - Parent trait source

## Related Patterns

- **Single Table Inheritance (STI)**: One table, multiple model types
- **Polymorphic Relations**: Different models can belong to same parent
- **Eloquent Global Scopes**: Automatically filter queries

## Laravel Version Compatibility

- ✅ Laravel 10+
- ✅ Laravel 11+ (with enhanced eager loading support)
- ✅ Filament v5
- ✅ PHP 8.3+

## Testing

### Unit Test Example

```php
it('only returns regionale records', function () {
    IndividualeRegionale::factory()->count(3)->create();
    IndividualeDip::factory()->count(2)->create();

    $regionales = IndividualeRegionale::query()->get();

    expect($regionales)->toHaveCount(3);
    expect($regionales->first()->type->value)->toBe('regionale');
});

it('automatically sets type on create', function () {
    $regionale = IndividualeRegionale::factory()->create();

    expect($regionale->type->value)->toBe('regionale');
});
```

### Filament Test Example

```php
it('can list only regionale records in Filament', function () {
    IndividualeRegionale::factory()->count(3)->create();
    IndividualeDip::factory()->count(2)->create();

    Livewire::test(ListIndividualeRegionales::class)
        ->assertCanSeeTableRecords(IndividualeRegionale::all())
        ->assertCanNotSeeTableRecords(IndividualeDip::all());
});
```

---

**Last Updated**: 2026-04-01  
**Verified**: ✅ Parental v2.x  
**Status**: Active Pattern in Laraxot
