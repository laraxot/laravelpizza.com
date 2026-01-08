# Inheritance Analysis Rule - Critical Requirement

## Critical Rule

**ABSOLUTE REQUIREMENT**: Always analyze parent classes before adding traits or methods to extending classes.

## The Problem

Models extending `BaseModel` or `XotBaseModel` MUST NEVER include:
- `HasFactory` trait (already in BaseModel)
- `newFactory()` method (already provided by BaseModel)
- Any trait or method already present in the inheritance chain

**IMPORTANT**: This rule applies ONLY to models extending BaseModel/XotBaseModel. Models extending third-party classes (e.g., SpatiePermission, SpatieRole) should be analyzed case-by-case as they may legitimately need HasFactory.

## Examples

### ❌ WRONG - Duplication
```php
class County extends BaseModel
{
    use \Modules\Xot\Models\Traits\HasXotFactory; // WRONG - BaseModel already has this
    
    protected static function newFactory(): CountyFactory // WRONG - BaseModel already provides this
    {
        return CountyFactory::new();
    }
}
```

### ✅ CORRECT - Clean inheritance (BaseModel extension)

```php
class County extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'state_id',
        'county',
        'state_index',
    ];
}
```

### ✅ CORRECT - Third-party extension needing HasFactory

```php
class Permission extends SpatiePermission
{
    use \Modules\Xot\Models\Traits\HasXotFactory; // CORRECT - SpatiePermission doesn't include HasFactory
    
    protected static function newFactory() // CORRECT - needed for factory functionality
    {
        return app(\Modules\Xot\Actions\Factory\GetFactoryAction::class)->execute(static::class);
    }
}
```

## Mandatory Process

1. **Study Parent Class**: Always examine the parent class before extending
2. **Check Traits**: Verify which traits are already included
3. **Check Methods**: Verify which methods are already implemented
4. **Avoid Duplication**: Never add what's already provided

## BaseModel Analysis

The `Modules\Geo\Models\BaseModel` already provides:
- `HasFactory` trait
- `Updater` trait
- Factory functionality
- Standard Eloquent methods
- Casting configuration
- Connection configuration

## Affected Classes

All models extending:
- `BaseModel`
- `XotBaseModel`
- Any other base model classes

## Validation

Before committing any model changes:
1. Check inheritance chain
2. Remove duplicate traits
3. Remove duplicate methods
4. Verify functionality still works

## Priority

**ABSOLUTE CRITICAL** - This violates DRY principle and can cause conflicts.

## Related Documentation

- [Model Extension Rules](model-extension-rules.md)
- [DRY Principles](dry-principles.md)
- [Laraxot Architecture](laraxot-architecture.md)
