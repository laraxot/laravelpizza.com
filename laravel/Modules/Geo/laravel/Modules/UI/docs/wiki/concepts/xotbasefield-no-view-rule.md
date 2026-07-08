---
name: xotbasefield-no-view-rule
description: XotBaseField subclasses must not declare a protected $view property; view is computed dynamically.
type: concept
---

# XotBaseField – No `$view` Property Rule

## Summary
Classes extending `Modules\Xot\Filament\Forms\Components\XotBaseField` **must not** define a `protected string $view` property. The view path is resolved automatically by the base class based on the component name, ensuring consistent naming and avoiding duplication.

## Why
- **Single source of truth**: view resolution logic lives in `XotBaseField`; overriding it creates divergence.
- **Maintainability**: reduces boilerplate and prevents mismatches when component names change.
- **Convention**: aligns with the project‑wide rule that view paths are calculated, not hard‑coded.

## Affected Files (current violations)
- `laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php` – line 24 declares `$view = 'filament-schemas::components.grid'`.
- `laravel/Modules/UI/app/Filament/Forms/Components/OpeningHoursField.php` – line 22 declares `$view = 'ui::filament.forms.components.opening-hours-field'`.
- `laravel/Modules/UI/app/Filament/Forms/Components/RadioCollection.php` – line 13 declares `$view = 'ui::filament.forms.components.radio-collection'`.
- `laravel/Modules/UI/app/Filament/Forms/Components/Field/QrReader.php` – line 11 declares `$view = 'ui::filament.forms.components.field.qr-reader'`.

## Recommended Action
1. **Remove** the `$view` property from each listed class.
2. **Rely** on the inherited view resolution (the component name will map to a blade view under the module’s `resources/views` folder).
3. **Add** a unit test ensuring that `getView()` returns the expected path without a custom property.

## Documentation
- Add this rule to each module’s `docs/wiki/concepts/` folder.
- Update the module‑level `docs/wiki/index.md` to include a link to this rule.

---
