# Laraxot model rules

> Source: [IFLOW.md](../../bashscripts/ai/IFLOW.md)
> Back: [index](index.md) | [critical-rules.md](critical-rules.md)

## NEVER use property_exists() on Eloquent models

Eloquent models use magic properties via `__get()` and `__set()`. `property_exists()` only checks explicitly declared properties - it always returns `false` for database attributes.

```php
// WRONG
if (property_exists($model, 'email')) { ... }

// CORRECT
if (isset($model->email)) { ... }
if ($model->getAttribute('email') !== null) { ... }
if (array_key_exists('email', $model->getAttributes())) { ... }
```

## Base class hierarchy

```
Model -> Module BaseModel -> XotBaseModel -> Laravel Model
```

**CRITICAL**: No model within modules should extend `Illuminate\Database\Eloquent\Model` directly.

## Which base class to extend

| Situation | Extend |
|-----------|--------|
| Regular Eloquent model with own table | `Modules\{ModuleName}\Models\BaseModel` |
| Pivot table (many-to-many) | `Modules\{ModuleName}\Models\BasePivot` |
| Polymorphic pivot table | `Modules\{ModuleName}\Models\BaseMorphPivot` |

Connection name is **auto-discovered** from namespace: `Modules\User\Models\*` → `'user'`.

## Correct usage

```php
namespace Modules\User\Models;

// Regular model
class Tenant extends BaseModel {
    // Connection auto-discovered as 'user'
    // No $connection needed unless overriding
    protected $fillable = ['name'];
}

// Pivot model
class TeamUser extends BasePivot {
    protected $table = 'team_user';
}

// Morph pivot
class ModelHasRole extends BaseMorphPivot {
    // Connection auto-discovered
}
```

## Do NOT replicate parent casts

```php
// WRONG - these casts are already in XotBaseModel
protected function casts(): array {
    return array_merge(parent::casts(), [
        'id' => 'string',    // already in parent
        'uuid' => 'string',  // already in parent
    ]);
}

// CORRECT - only add module-specific casts
protected function casts(): array {
    return array_merge(parent::casts(), [
        'published_at' => 'datetime',  // only what's NEW
    ]);
}
```

## Third-party package models

When working with third-party packages that provide their own Eloquent models, extend those package models directly, NOT module BaseModel classes.

```php
// CORRECT - Direct package model extension
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $connection = 'user';
    use RelationX;
    use HasXotFactory;
}

// WRONG - breaks package functionality
class Permission extends BaseModel { }
```

### Current third-party models in PTVX

| Module | Model | Package |
|--------|-------|---------|
| User | Permission, Role | spatie/laravel-permission |
| Activity | Activity, StoredEvent, Snapshot | spatie/laravel-activitylog, spatie/laravel-event-sourcing |
| Media | Media | spatie/laravel-medialibrary |
| Notify | MailTemplate | spatie/laravel-mail-templates |
| Xot | BaseActivity | spatie/laravel-activitylog |

## Casts method (not property)

```php
// WRONG - deprecated property
protected $casts = ['email_verified_at' => 'datetime'];

// CORRECT - method with inheritance
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'email_verified_at' => 'datetime',
    ]);
}
```

## Relationship method naming (CRITICAL)

Method name MUST match the cardinality of what it returns:

| Return type | Method name |
|---|---|
| `HasMany`, `BelongsToMany`, `HasManyThrough`, `MorphMany`, `MorphToMany` | **PLURAL** |
| `HasOne`, `BelongsTo`, `MorphOne`, `MorphTo`, `HasOneThrough` | **SINGULAR** |

```php
// WRONG - singular name but returns multiple records
public function scheda(): HasMany
{
    return $this->hasMany(Scheda::class);
}

// CORRECT - plural name matches HasMany
public function schedas(): HasMany
{
    return $this->hasMany(Scheda::class);
}

// CORRECT - singular name matches HasOne
public function scheda(): HasOne
{
    return $this->hasOne(Scheda::class);
}
```

This is standard Laravel convention. Even for Italian names, use the `s` suffix (e.g., `schedas()`) or the Italian plural (e.g., `schede()`). Never use a singular name for a `HasMany` relationship.

## Do not replicate useless methods

```php
// WRONG - useless replication
class User extends BaseModel {
    public function save(array $options = []): bool {
        return parent::save($options);  // adds nothing
    }
}

// CORRECT - only override if you add/change behavior
class User extends BaseModel {
    // No save() method needed - parent handles it
}
```
