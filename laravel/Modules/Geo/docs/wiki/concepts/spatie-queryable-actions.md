---
name: Spatie Queryable actions for view calculation
description: Use Spatie Queryable actions to resolve view paths and other runtime data for XotBaseField subclasses.
type: concept
---

# Spatie Queryable Actions Pattern

## Overview
For components extending `XotBaseField`, view selection and other runtime decisions should be handled through **Spatie Queryable actions**. This pattern decouples the business logic from view paths and enables centralised, testable resolution strategies.

## Core Actions

### getViewBy*
A family of actions that return the Blade view string based on context (module, field type, locale, etc.). Example naming:
- `getViewByFieldType`
- `getViewByModuleAndField`
- `getViewByTheme`

Each action receives the field instance and any necessary arguments (e.g., `$field`, `$module`, `$theme`).

### ViewResolver
A dedicated resolver class that orchestrates the action chain:

```php
namespace Modules\Geo\View\Resolvers;

use Spatie\QueryBuilder\QueryBuilder;
use Modules\Geo\Entities\FieldView;

class FieldViewResolver
{
    public function resolve($field, array $context): string
    {
        return QueryBuilder::for(FieldView::class)
            ->allowedFilters(['type', 'module', 'theme'])
            ->where('field_type', $field->type)
            ->where('module', $field->module)
            ->first()
            ->view_path;
    }
}
```

## Integration with XotBaseField

In your `XotBaseField` subclass:

```php
class AddressPicker extends XotBaseField
{
    public function view(): string
    {
        return app(FieldViewResolver::class)->resolve($this, [
            'module' => $this->module,
            'theme' => $this->theme,
        ]);
    }
}
```

## Benefits
- **No static `$view` property**: views are resolved dynamically.
- **Centralised logic**: all view mapping lives in actions/resolvers, not scattered across field classes.
- **Testable**: each action can be unit‑tested independently.
- **Extensible**: add new actions to support new themes or modules without modifying core classes.

## Related Rules
- [XotBaseField view rule](xotbasefield-view-rule.md)
- [Coordinate picker field](../../Modules/Geo/docs/wiki/concepts/coordinate-picker-field.md)
