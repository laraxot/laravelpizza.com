# Models - Xot Module

## Architecture

All models in this module follow the Laraxot architecture pattern:

```
Model → Module BaseModel → XotBaseModel → Laravel Model
```

### Base Classes

#### BaseModel
For regular Eloquent models.

**Example:**
```php
namespace Modules\Xot\Models;

class ExampleModel extends BaseModel
{
    protected $fillable = ['name', 'description'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'published_at' => 'datetime',
        ]);
    }
}
```

#### BasePivot
For many-to-many relationship pivot tables.

#### BaseMorphPivot
For polymorphic pivot tables.

## Models in this Module

[List all models here with brief descriptions]

### [ModelName]

**Purpose:** [Description]

**Key Relationships:**
- `belongsTo`: [Related models]
- `hasMany`: [Related models]
- `belongsToMany`: [Related models]

**Important Methods:**
- `methodName()`: [Description]

## Best Practices

1. **Never extend `Illuminate\Database\Eloquent\Model` directly**
2. **Use `casts()` method instead of `$casts` property**
3. **Connection is auto-discovered** from namespace (e.g., `Modules\Xot` → `'xot'`)
4. **Use magic properties** - `isset()` instead of `property_exists()`

## References

- [Xot Model Architecture](../../Xot/docs/models/model-architecture.md)
- [CLAUDE.md - Model Inheritance Rules](../../CLAUDE.md#model-inheritance-rules)

---

**Last Updated**: 2025-11-15
