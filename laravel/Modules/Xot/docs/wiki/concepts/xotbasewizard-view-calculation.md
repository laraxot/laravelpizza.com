# XotBaseWizardWidget View Calculation

## Overview

`XotBaseWizardWidget` calcola automaticamente la view da utilizzare in base al contesto (admin vs frontoffice). Questo permette di avere:
- **Admin**: Wizard standard Filament
- **Frontoffice**: Wizard con stile Design Comuni italiani

## View Resolution Logic

```php
public function getWizardComponent(): Component
{
    $this->wizardComponent = $this->traitGetWizardComponent()
        ->nextAction(...)
        ->previousAction(...);

    // Design Comuni styling for front-office
    if (! inAdmin()) {
        $this->wizardComponent->view('pub_theme::components.wizard');
    }

    return $this->wizardComponent;
}
```

| Contesto | View Utilizzata | Styling |
|----------|----------------|---------|
| Admin (`inAdmin() === true`) | `filament/components/wizard` | Standard Filament |
| Frontoffice (`inAdmin() === false`) | `pub_theme::components.wizard` | Design Comuni |

## Critical Rule: No $view Property

**FORBIDDEN:** Definire `protected string $view` nelle sottoclassi.

### ❌ Wrong
```php
class MyWizardWidget extends XotBaseWizardWidget
{
    protected string $view = 'my-module::filament.widgets.my-wizard';  // NEVER
}
```

### ✅ Correct
```php
/**
 * My custom wizard widget.
 * 
 * View used:
 * - Admin: filament/components/wizard (default)
 * - Frontoffice: pub_theme::components.wizard (Design Comuni styled)
 */
class MyWizardWidget extends XotBaseWizardWidget
{
    // NO $view property - inherited from parent
    
    public function getWizardSteps(): array
    {
        return [
            Step::make('step1', Step1Form::class),
            Step::make('step2', Step2Form::class),
        ];
    }
}
```

## Why This Matters

1. **Theme Consistency**: La view Design Comuni (`pub_theme::components.wizard`) fornisce:
   - Stepper conforme al Design System
   - Colori e font corretti
   - Layout responsive mobile-first

2. **Single Source of Truth**: Un solo punto di controllo per la view del wizard

3. **Automatic Context Detection**: Non serve codice condizionale nelle sottoclassi

## Related Files

- `Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`
- `Themes/Sixteen/resources/views/components/wizard.blade.php`
- `.windsurf/rules/xotbasewizard-no-view-property.mdc`

## Verification

```bash
# Check for violations
grep -r "extends XotBaseWizardWidget" laravel/Modules --include="*.php" -A 10 | grep "protected string \$view"

# Should return empty
```

## References

- [Design Comuni - Wizard Pattern](https://italia.github.io/design-comuni-pagine-statiche/)
- [Filament Wizard Documentation](https://filamentphp.com/docs/schemas/wizard)
