# HasRecursiveRelationshipsContract Documentation

## Overview

The `HasRecursiveRelationshipsContract` defines the interface for models that support recursive relationships using the Laravel Adjacency List package.

## Purpose

This contract ensures type safety and consistency across all tree-structured models in the Laraxot ecosystem, providing:

- **Type Safety**: All methods have proper return types
- **Consistency**: Standardized interface across modules
- **PHPStan Compatibility**: Level 10 static analysis compliance

## Implementation Architecture

### BaseTreeModel
```php
abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
}
```

### TypedHasRecursiveRelationships Trait
The trait acts as a wrapper around the vendor package, providing:
- **Return Type Safety**: All methods return properly typed objects
- **PHPStan Compliance**: Type annotations for static analysis
- **Method Aliasing**: Vendor methods are aliased and re-exposed with types

## Key Methods

### Core Identification
- `getParentKeyName(): string` - Parent key column name
- `getQualifiedParentKeyName(): string` - Qualified parent key (table.column)
- `getLocalKeyName(): string` - Local key column name (primary key)
- `getQualifiedLocalKeyName(): string` - Qualified local key (table.column)
- `getDepthName(): string` - Depth column name
- `getPathName(): string` - Path column name
- `getPathSeparator(): string` - Path separator character
- `getCustomPaths(): array<int|string, string>` - Additional custom paths
- `getExpressionName(): string` - Common Table Expression name

### Relationship Methods
- `parent(): BelongsTo` - Direct parent relationship
- `children(): HasMany` - Direct children relationship
- `ancestors(): Ancestors` - All recursive parents
- `descendants(): Descendants` - All recursive children
- `siblings(): Siblings` - Nodes with same parent

### Advanced Relationships
- `ancestorsAndSelf(): Ancestors` - Parents including self
- `descendantsAndSelf(): Descendants` - Children including self
- `bloodline(): Bloodline` - Complete tree (ancestors + descendants + self)
- `rootAncestor(): RootAncestor` - Top-level parent
- `rootAncestorOrSelf(): RootAncestorOrSelf` - Root or self if already root

## Usage Example

```php
class LimeQuestion extends BaseTreeModel
{
    public function getParentKeyName(): string
    {
        return 'parent_qid';
    }

    public function getLocalKeyName(): string
    {
        return 'qid';
    }
}

// Usage
$question = LimeQuestion::find(1);
$parent = $question->parent; // BelongsTo relation
$children = $question->children; // HasMany relation
$ancestors = $question->ancestors; // Ancestors relation
$descendants = $question->descendants; // Descendants relation
```

## Module Integration

### Models Using This Contract
- **Limesurvey/LimeQuestion**: Survey question hierarchy
- **Any tree structure**: Categories, menus, organizational charts

### Required Implementation
Models must extend `BaseTreeModel` and optionally override:
- `getParentKeyName()` if parent key differs from default
- `getLocalKeyName()` if primary key differs from default
- `getDepthName()` if depth column has custom name
- `getPathName()` if path column has custom name

## PHPStan Level 10 Compliance

The contract and trait ensure:
- **Zero mixed return types**: All methods have specific return types
- **Type safety**: Static analysis catches type errors
- **Documentation**: Complete PHPDoc annotations

## Migration from Direct Vendor Usage

**Before** (not type-safe):
```php
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MyModel extends Model {
    use HasRecursiveRelationships;
}
```

**After** (type-safe):
```php
use Modules\Xot\Models\BaseTreeModel;

class MyModel extends BaseTreeModel {
    // Inherits type-safe recursive relationships
}
```

## Troubleshooting

### Common Issues
1. **"Declaration must be compatible"**: Ensure method signatures match contract exactly
2. **Missing return types**: Use BaseTreeModel instead of direct vendor trait
3. **PHPStan errors**: Verify all methods have proper return type declarations

### Debug Steps
1. Check model extends `BaseTreeModel`
2. Verify overridden methods have correct return types
3. Run PHPStan level 10 analysis
4. Check trait aliasing in `TypedHasRecursiveRelationships`

## Best Practices

1. **Always extend BaseTreeModel** for tree structures
2. **Override only necessary methods** (parent/local key names)
3. **Use proper return types** when overriding methods
4. **Test with PHPStan level 10** for compliance
5. **Document custom key names** in model PHPDoc

## Related Documentation

- [BaseTreeModel](models/base-tree-model.md)
- [TypedHasRecursiveRelationships](traits/typed-has-recursive-relationships.md)
- [Laravel Adjacency List](https://github.com/staudenmeir/laravel-adjacency-list)
