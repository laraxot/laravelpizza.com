# Filament HasWizard Concern vs XotBaseWizardWidget

## Date
2026-05-05

## Problem
`XotBaseWizardWidget` reinvents wizard logic already present in Filament's `HasWizard` concern.

## Filament HasWizard (vendor/filament/actions/src/Concerns/HasWizard.php)

### Location
`vendor/filament/actions/src/Concerns/HasWizard.php`

### Provides
- `steps(array|Closure $steps)` - sets wizard steps
- `startOnStep(int|Closure $startStep)` - sets initial step
- `skippableSteps(bool|Closure $condition)` - makes steps skippable
- `isWizard()` - checks if widget is wizard
- `isWizardSkippable()` - checks if skippable
- `modifyWizardUsing(?Closure $callback)` - allows wizard modification
- `getWizardStartStep()` - returns evaluated start step

### Used By
- `Filament\Actions\Concerns\HasForm` - integrates wizard with form
- `Filament\Resources\Pages\Concerns\HasWizard` (for admin pages)

## XotBaseWizardWidget Current Implementation

### Location
`Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`

### Issues
1. **Duplicates logic**: Reimplements `wizardStartStep`, `isSkippable`, step resolution
2. **Custom query string handling**: Reimplements `?step=` logic (already in `Wizard::persistStepInQueryString()`)
3. **Custom step navigation**: Reimplements `nextStep()`, `previousStep()` (already in `Wizard` component)
4. **Missing**: Does not use `HasWizard` trait

### What XotBaseWizardWidget Adds (Legitimate)
- `wizardMaxStep()` - max step calculation
- `getWizardSchemaWrapperKey()` - wrapper key for nested state
- `makeWizard()` - centralizes wizard creation with project-specific logic
- `normalizeWizardFormState()` - normalizes form state
- `queryStepOverrideAllowed()` - security check for step override
- LangServiceProvider integration notes

## Solution: Use HasWizard + Extend

### Correct Architecture
```php
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    use \Filament\Actions\Concerns\HasWizard; // Use Filament's trait
    
    // Keep Xot-specific additions:
    protected function makeWizard(array $steps): Wizard
    {
        $wizard = Wizard::make($steps)
            ->startOnStep(fn (): int => $this->getWizardStartStep()) // Uses HasWizard
            ->skippable($this->hasSkippableWizardSteps());
        
        if ($this->queryStepOverrideAllowed()) {
            $wizard->persistStepInQueryString('step'); // Uses Wizard's built-in
        }
        
        return $wizard;
    }
}
```

## Philosophy / Zen
- **DRY**: Don't reimplement what Filament already provides
- **Composition over Reinvention**: Use traits/contracts, don't copy-paste
- **Single Source of Truth**: Wizard navigation logic lives in `Wizard` component + `HasWizard` concern
- **Separation**: Xot layer adds project-specific policy (security, lang), not duplicate mechanics

## References
- https://github.com/filamentphp/filament/blob/5.x/packages/actions/src/Concerns/HasWizard.php
- https://github.com/filamentphp/filament/blob/5.x/packages/schemas/src/Components/Wizard.php
- `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`
