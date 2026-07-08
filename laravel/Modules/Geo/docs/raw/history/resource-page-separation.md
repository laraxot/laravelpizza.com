# Resource vs Page Classes - Critical Architectural Separation

## Business Logic: Why This Separation Exists

In Laraxot PTVX, the separation between **Resource classes** and **Page classes** is not arbitrary - it's a fundamental architectural decision that serves critical business purposes:

1. **Single Responsibility**: Resources define WHAT data exists, Pages define HOW it's displayed
2. **Reusability**: Resource schemas can be reused across different Page contexts
3. **Maintainability**: Display logic changes don't affect data structure definitions
4. **Testability**: Data schemas and display logic can be tested independently
5. **Performance**: Avoids loading table logic when only form logic is needed

## The Golden Rule

### ✅ Resource Classes (XotBaseResource) - DATA DEFINITION ONLY
**Purpose**: Define data structure, validation, and relationships
**Allowed Methods**:
- `getFormSchema(): array` - Form field definitions
- `getPages(): array` - Page routing configuration
- `getEloquentQuery(): Builder` - Query customization
- Properties: `$model`, `$navigationIcon`, etc.

**Business Logic**: Resources answer "WHAT data exists and HOW it's validated"

### ❌ FORBIDDEN in Resource Classes
- `getTableColumns(): array` - **NEVER** in Resource class
- `getTableFilters(): array` - **NEVER** in Resource class  
- `getTableActions(): array` - **NEVER** in Resource class
- `getTableBulkActions(): array` - **NEVER** in Resource class

### ✅ Page Classes (XotBaseListRecords) - DISPLAY LOGIC ONLY
**Purpose**: Define how data is presented and interacted with
**Required Methods**:
- `getTableColumns(): array` - **ONLY** in Page classes
- `getTableFilters(): array` - **ONLY** in Page classes
- `getTableActions(): array` - **ONLY** in Page classes
- `getTableBulkActions(): array` - **ONLY** in Page classes

**Business Logic**: Pages answer "HOW data is displayed and WHAT users can do with it"

## Correct Implementation Patterns

### ✅ Resource Class Example
```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;

class OrganizzativaResource extends XotBaseResource
{
    protected static ?string $model = Organizzativa::class;

    // ✅ CORRECT: Data definition
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('descrizione')
                ->required(),
            Forms\Components\Select::make('stato')
                ->options([
                    'attivo' => 'Attivo',
                    'inattivo' => 'Inattivo',
                ]),
        ];
    }

    // ✅ CORRECT: Query customization
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('created_at', 'desc');
    }

    // ✅ CORRECT: Page routing (overrides parent)
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOrganizzativas::route('/'),
            'create' => CreateOrganizzativa::route('/create'),
            'edit' => EditOrganizzativa::route('/{record}/edit'),
        ];
    }

    // ❌ WRONG: Table methods DON'T belong here
    // public function getTableColumns(): array { ... } // VIOLATION!
}
```

### ✅ Page Class Example
```php
<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Modules\Xot\Filament\Resources\XotBaseListRecords;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Modules\Performance\Filament\Actions\ExportOrganizzativaAction;

class ListOrganizzativas extends XotBaseListRecords
{
    protected static string $resource = OrganizzativaResource::class;

    // ✅ CORRECT: Display logic belongs here
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('descrizione')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('stato')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'attivo' => 'success',
                    'inattivo' => 'danger',
                }),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    // ✅ CORRECT: Filters belong here
    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('stato')
                ->options([
                    'attivo' => 'Attivo',
                    'inattivo' => 'Inattivo',
                ]),
        ];
    }

    // ✅ CORRECT: Actions belong here
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            ExportOrganizzativaAction::make(),
        ];
    }
}
```

## Common Violations and Fixes

### ❌ Violation 1: Table Methods in Resource Class
```php
// WRONG - In Resource class
class MyResource extends XotBaseResource {
    public function getTableColumns(): array { ... } // ERROR!
}
```

**Fix**: Move table methods to corresponding Page class

### ❌ Violation 2: Form Methods in Page Class
```php
// WRONG - In Page class
class ListMyRecords extends XotBaseListRecords {
    public static function getFormSchema(): array { ... } // ERROR!
}
```

**Fix**: Move form schema to Resource class

### ❌ Violation 3: Missing Override Attribute
```php
// WRONG - Missing override indication
public static function getPages(): array { ... }
```

**Fix**: Add `#[Override]` attribute since it overrides parent method

## Validation Checklist

Before committing, verify:

- [ ] Resource classes have NO table methods (`getTableColumns`, `getTableActions`, etc.)
- [ ] Page classes have ALL required table methods
- [ ] `getPages()` method has `#[Override]` attribute in Resource classes
- [ ] Form schema is ONLY in Resource classes
- [ ] Display logic is ONLY in Page classes
- [ ] Both classes extend correct base classes

## Business Logic Examples

### User Management Module
- **Resource**: Defines user fields (name, email, role), validation rules
- **Page**: Defines user table columns, filters by status, bulk actions

### Performance Module  
- **Resource**: Defines evaluation fields, scoring rules, relationships
- **Page**: Defines evaluation table, filters by period, export actions

### Why This Matters for Business

1. **Consistent Data Validation**: Same validation rules across all contexts
2. **Flexible Display**: Same data can be displayed differently in different contexts
3. **Easier Testing**: Test data validation separately from display logic
4. **Better Performance**: Load only what you need (form vs table logic)

## Migration Strategy

When fixing violations:

1. **Identify**: Use audit script to find violations
2. **Extract**: Move table methods from Resource to Page
3. **Test**: Verify both form and table functionality work
4. **Document**: Update module documentation

## References

- [XotBaseResource](../laravel/Modules/Xot/docs/filament/resources/xot-base-resource.md)
- [XotBaseListRecords](../laravel/Modules/Xot/docs/filament/pages/xot-base-list-records.md)
- [Filament Best Practices](../laravel/Modules/Xot/docs/filament-best-practices.md)

---

**Last Updated**: 2025-01-02  
**Critical Rule**: Resource = Data Definition, Page = Display Logic  
**Violation Impact**: Architecture inconsistency, maintenance issues
