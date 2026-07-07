# DRY Principle for Trait Methods

## Critical Rule: Never Duplicate Trait Methods

**ALWAYS** implement trait methods ONCE in the trait itself, NEVER duplicate them in individual models.

### Why This Matters

1. **DRY Compliance**: Single source of truth
2. **Maintainability**: Bug fix in one place, not multiple
3. **Type Safety**: Consistent implementation
4. **PHPStan Compliance**: Trait methods are properly discoverable
5. **Testing**: Test once, not per model

### Correct Implementation Pattern

```php
// ✅ CORRECT - Method in trait

trait SushiToJsons
{
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();

        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

        $filename = 'database/content/'.$stringTbl.'/'.$stringId.'.json';

        return base_path($filename);
    }
}

// Models automatically inherit the method
class Attachment extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}

class Menu extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}
```

### When to Add Methods to Models vs Traits

- **Add to trait**: If the method is called by the trait and needed by all models using it
- **Add to model**: If the method is model-specific or needs different implementation per model
- **Add to interface**: If the method should be available via type hints and contracts

### Common PHPStan Errors This Prevents

- `Access to an undefined property`
- `Call to an undefined method`
- `Class not found`
- `offsetAccess.nonOffsetAccessible`

### Documentation Updates

- Updated: `laravel/Modules/Tenant/docs/it/TRAIT_METHOD_IMPLEMENTATION.md`
- Updated: `laravel/Modules/Tenant/docs/roadmap.md`
- Updated: `laravel/Modules/Cms/docs/it/TRAIT_METHOD_IMPLEMENTATION.md`

### Current Status

- ✅ Fixed: Removed duplicate `getJsonFile()` methods from Attachment, Menu, PageContent, Section
- ✅ Fixed: Moved `getBlocksBySlug()` to HasBlocks trait
- ✅ Updated: Documentation and roadmap
- ✅ Verified: PHPStan Level 10 compliance maintained

### Next Steps

1. Review all traits for duplicate method implementations
2. Update documentation with these patterns
3. Add tests for trait methods
4. Verify no breaking changes in dependent modules

**Last Updated**: 2 Marzo 2026