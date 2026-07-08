---
title: "XotBaseResource Zen Pattern"
type: concept
sources: []
confidence: high
created: 2026-05-06
updated: 2026-05-06
tags: [filament, xotbase, zen-pattern, resource]
related:
  - ../../Xot/docs/wiki/concepts/xotbase-resourceform-zen-pattern.md
  - ../../Xot/docs/wiki/concepts/xotbase-resource-table-zen-pattern.md
---

# XotBaseResource Zen Pattern

## Zen Philosophy (2026-05-06)

**Core Rule**: `XotBaseResource` base class owns the `form()` and `table()` methods. Subclasses MUST NOT override them.

The base class performs auto-discovery:
- `form()` → looks for `Schemas/<Model>Form::configure($schema)`
- `table()` → looks for `Tables/<Model>Table::configure($table)`

## Anti-Pattern (NEVER DO THIS)

```php
// WRONG: Overriding form()/table() - breaks Zen pattern
class ActivityResource extends XotBaseResource
{
    public static function form(Schema $schema): Schema
    {
        return ActivityForm::configure($schema); // WRONG: base class does this
    }
    
    public static function table(Table $table): Table
    {
        return ActivitiesTable::configure($table); // WRONG: base class does this
    }
}
```

**Remember**: "Se lo lasciavi stare tutto funzionava perché la magia la faceva XotBaseResource"

## Correct Pattern

```php
// CORRECT: Only override getPages(), nothing else for form/table
class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;
    
    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'edit' => EditActivity::route('/{record}/edit'),
        ];
    }
}
```

## Base Class Magic

```
XotBaseResource::form()
    → auto-discovers Schemas/ActivityForm::configure($schema)
    → calls ActivityForm::getFormSchema() (static method)

XotBaseResource::table()  
    → auto-discovers Tables/ActivitiesTable::configure($table)
    → calls ActivitiesTable::getTableColumns() (static method)
```

## Checklist for New Resources

- [ ] Extends `XotBaseResource`
- [ ] Only overrides `getPages()` (and `getRelations()` if needed)
- [ ] NO `form()` override
- [ ] NO `table()` override  
- [ ] `Schemas/<Model>Form.php` exists with `static getFormSchema(): array`
- [ ] `Tables/<Model>Table.php` exists with `static getTableColumns(): array`
- [ ] No `->label()` calls (LangServiceProvider owns labels)
- [ ] Safe functions preserved (`use function Safe\...`)

## References

- Base class: `Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- Example: `Modules/Activity/app/Filament/Resources/ActivityResource.php`
- Related: [[concepts/xotbase-resourceform-zen-pattern]]
- Related: [[concepts/xotbase-resource-table-zen-pattern]]
