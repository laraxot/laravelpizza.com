---
module: Xot
concept: XotBaseResource
last_updated: 2026-04-15
---

# XotBaseResource

`XotBaseResource` is the abstract base class for all Filament Resources in the PTVX system. It extends `Filament\Resources\Resource` and enforces standardization across modules.

## Key Principles

1. **Automatic Translations**: Labels, groups, and icons are never hardcoded. They are automatically resolved from the module's translation files using the `LangServiceProvider`.
2. **Simplified Schema**: Resources define only the `model` and the `formSchema`. Table configuration is delegated to the `ListRecords` page.
3. **Consistent UI**: Every resource follows the same visual hierarchy and behavior.

## Core Rules

### 1. No Hardcoded Icons/Labels
❌ **WRONG**:
```php
protected static ?string $navigationIcon = 'heroicon-o-user';
```
✅ **CORRECT**: Define icons in `lang/{locale}/{resource_name}.php`.

### 2. Mandatory Implementation
Every concrete resource must implement:
- `protected static ?string $model`
- `public static function getFormSchema(): array`
- `public static function getPages(): array`

### 3. Separation of Concerns
- **Resource**: Routing, Model, Form Schema.
- **List Page**: Table columns, filters, actions, and bulk actions.
- **Edit/View Pages**: Specific interaction logic.

## Table Configuration

In `XotBaseListRecords`, use standard Filament methods but ensure **string keys** for all arrays:

```php
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
    ];
}
```

## Best Practices

- **Permissions**: Control visibility in the `mount()` method of the pages.
- **Documentation**: Include a standard docblock header explaining the purpose and origin of the resource.
- **Eager Loading**: Always use `getTableQuery()` to add `with()` for required relationships to avoid N+1 issues.

---
**Related Pages:**
- [[Xot Module Architecture]]
- [[BaseModel]]
- [[Translation System]]
