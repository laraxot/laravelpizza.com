# XotBaseModel Documentation

## Architecture Overview

### Model Inheritance Hierarchy

```
Illuminate\Database\Eloquent\Model
  └── Modules\Xot\Models\XotBaseModel  ← All models MUST extend this
        ├── Modules\{Module}\Models\BaseModel
        └── Modules\{Module}\Models\BasePivot (for many-to-many)
        └── Modules\{Module}\Models\BaseMorphPivot (for polymorphic)
```

### Key Principles

**1. Connection Auto-Discovery**
- Connection name is automatically extracted from namespace
- Example: `Modules\User\Models\Tenant` → connection `'user'`
- No manual `$connection` configuration needed

**2. Property Access Safety**
```php
// ❌ NEVER use property_exists() - doesn't work with magic properties
if (property_exists($model, 'email')) { ... }

// ✅ Use isset() for magic properties
if (isset($model->email)) { ... }

// ✅ Use getAttribute() for explicit checks
if ($model->getAttribute('email') !== null) { ... }

// ✅ Use array_key_exists() on attributes
if (array_key_exists('email', $model->getAttributes())) { ... }
```

**3. Type Casting**
- Always use `casts()` method, never `$casts` property
- Parent casts are automatically merged

```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'custom_field' => 'datetime',
    ]);
}
```

### Database Schema

**Required Columns (XotBaseModel Contract)**
- `id` - bigint unsigned AUTO_INCREMENT PRIMARY KEY
- `uuid` - char(36) nullable indexed (optional but recommended)

**Auto-Discovery Behavior**
- Table name: snake_case plural of model name (e.g., `users`, `tenant_roles`)
- Timestamps: automatic (`created_at`, `updated_at`, `deleted_at`)
- Audit fields: automatic (`created_by`, `updated_by`, `deleted_by`)

## Best Practices

### ✅ DO

1. **Extend BaseModel**
```php
namespace Modules\User\Models;

class Tenant extends BaseModel
{
    // Connection auto-discovered as 'user'
    // Table name auto-generated as 'tenants'
}
```

2. **Use casts() method**
```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'settings' => 'array',
        'active_at' => 'datetime',
    ]);
}
```

3. **Check magic properties safely**
```php
public function isActive(): bool
{
    return isset($this->attributes['active']) && $this->attributes['active'] == 1;
}
```

### ❌ DON'T

1. **Never extend Illuminate\Database\Eloquent.Model directly**
```php
// ❌ WRONG
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    // Missing XotBaseModel features
}
```

2. **Never use property_exists()**
```php
// ❌ WRONG - won't detect magic properties
if (property_exists($this, 'email')) {
    // This won't work for Eloquent models
}
```

3. **Never use $casts property**
```php
// ❌ WRONG - doesn't merge with parent
protected $casts = [
    'email_verified_at' => 'datetime',
];
```

## Common Patterns

### Factory Integration
```php
// Works automatically with XotFactory
$factory = XotFactory::for(Tenant::class)->create([
    'name' => 'Tenant Name',
]);
```

### Query Scopes
```php
// In BaseModel
public function scopeActive($query)
{
    return $query->where('active', 1);
}

// Usage
Tenant::active()->get();
```

### Relationships
```php
// Auto-discovery works
public function roles(): HasMany
{
    return $this->hasMany(Role::class);
}
```

## Migration Notes

When modifying models that extend XotBaseModel:

1. **Add columns via migrations** - never modify existing columns
2. **Use nullable** for new columns
3. **Backfill data** if changing existing column types

## Testing

```php
// Tests should use factories
public function test_tenant_creation()
{
    $tenant = Tenant::factory()->create([
        'name' => 'Test Tenant',
    ]);
    
    $this->assertDatabaseHas('tenants', [
        'name' => 'Test Tenant',
    ]);
}

// Verify magic properties work
public function test_model_attributes()
{
    $tenant = Tenant::factory()->make([
        'email' => 'test@example.com',
    ]);
    
    // ✅ Correct - works with magic properties
    $this->assertEquals('test@example.com', $tenant->email);
    
    // ✅ Correct - safe attribute check
    $this->assertTrue(isset($tenant->email));
}
```

## Related Documentation

- [Xot Migration Philosophy](#one-migration-per-model)
- [Model Inheritance](#model-inheritance-rules)
- [Database Schema](#database-schema)
