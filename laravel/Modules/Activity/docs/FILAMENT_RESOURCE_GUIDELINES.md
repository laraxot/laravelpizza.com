# Activity Module Filament Resource Guidelines

## Extension Patterns

All Filament resources in the Activity module MUST extend `XotBaseResource` and follow the Laraxot extension patterns.

### ✅ Correct Pattern

```php
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;

    public static function getFormSchema(): array
    {
        return [
            // Form schema components only
        ];
    }
}
```

### ❌ Forbidden Patterns

**DO NOT implement these methods if they return standard/default values:**

```php
// ❌ WRONG - Don't implement getPages() for standard pages
public static function getPages(): array
{
    return [
        'index' => Pages\ListActivities::route('/'),
        'create' => Pages\CreateActivity::route('/create'),
        'edit' => Pages\EditActivity::route('/{record}/edit'),
    ];
}

// ❌ WRONG - Don't implement getRelations() for empty relations
public static function getRelations(): array
{
    return [];
}

// ❌ WRONG - Don't implement form() or table() directly
public static function form(Form $form): Form { ... }
public static function table(Table $table): Table { ... }
```

### Current Resource Status

#### ✅ ActivityResource - CORRECT
- Extends XotBaseResource ✓
- Only implements getFormSchema() ✓
- No unnecessary method overrides ✓

#### ❌ SnapshotResource - NEEDS REFACTORING
- Extends XotBaseResource ✓
- Implements unnecessary getPages() and getRelations() methods ✗
- These methods return standard/default values and should be removed

#### ❌ StoredEventResource - NEEDS REFACTORING
- Extends XotBaseResource ✓
- Implements unnecessary getPages() and getRelations() methods ✗
- These methods return standard/default values and should be removed

### Refactoring Instructions

For SnapshotResource and StoredEventResource, remove these methods:

```php
// REMOVE THESE METHODS:
public static function getPages(): array
{
    return [
        'index' => Pages\ListSnapshots::route('/'),
        'create' => Pages\CreateSnapshot::route('/create'),
        'edit' => Pages\EditSnapshot::route('/{record}/edit'),
    ];
}

public static function getRelations(): array
{
    return [];
}
```

The XotBaseResource automatically provides these standard implementations:
- `getPages()` - Auto-generates standard pages based on naming conventions
- `getRelations()` - Auto-discovers relation managers from RelationManagers directory
- `form()` - Uses `getFormSchema()` method
- `table()` - Uses `getListTableColumns()` method if implemented

### Testing Requirements

All resources must be tested to ensure:
1. They extend XotBaseResource
2. They don't implement unnecessary methods
3. They provide the required getFormSchema() method
4. They work correctly with the auto-generated functionality

### Related Documentation

- [XotBaseResource Documentation](../../Xot/project_docs/filament/resources/xot-base-resource.md)
- [Filament Best Practices](../../Xot/project_docs/filament-best-practices.md)
- [Laraxot Extension Patterns](../../Xot/project_docs/base-classes.md)
