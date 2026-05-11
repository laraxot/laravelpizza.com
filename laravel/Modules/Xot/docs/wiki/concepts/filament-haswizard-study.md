# Filament HasWizard: Study Notes

## Date
2026-05-05

## Available HasWizard Traits in Filament 5

### 1. `Filament\Actions\Concerns\HasWizard`
**Location:** `vendor/filament/actions/src/Concerns/HasWizard.php`
**Used by:** `Filament\Actions\Action` (base action class)
**Provides:**
- `steps(array|Closure $steps)` - sets wizard steps
- `startOnStep(int|Closure $startStep)` - sets initial step  
- `skippableSteps(bool|Closure $condition)` - makes steps skippable
- `isWizard()` - checks if widget is wizard
- `isWizardSkippable()` - checks if skippable
- `modifyWizardUsing(?Closure $callback)` - allows wizard modification
- `getWizardStartStep()` - returns evaluated start step
- **Uses:** `$this->schema($steps)` (not `$this->form()`)

### 2. `Filament\Resources\Pages\Concerns\HasWizard`
**Location:** `vendor/filament/filament/src/Resources/Pages/Concerns/HasWizard.php`
**Used by:** `CreateRecord`, `EditRecord` pages (admin panel)
**Provides:**
- `getStartStep()` - returns 1 (can be overridden)
- `getWizardComponent()` - creates `Wizard::make($this->getSteps())->startOnStep(...)`
- `getSteps()` - abstract, must be implemented
- `hasSkippableSteps()` - returns false by default
- **Uses:** `$this->form($schema)->components([$this->getWizardComponent()])`

### 3. `Filament\Schemas\Components\Wizard` (Component)
**Location:** `vendor/filament/schemas/src/Components/Wizard.php`
**The actual UI component:**
- Renders via `filament-schemas::components.wizard` Blade view
- Handles Alpine.js navigation (`nextStep()`, `previousStep()`, `goToStep()`)
- Manages `startOnStep()`, `persistStepInQueryString()`, `skippable()`
- Dispatches events: `next-wizard-step`, `go-to-wizard-step`

## What XotBaseWizardWidget Should Do

### Current Problem
`XotBaseWizardWidget` (545 lines) **reinvents** what `Wizard` component + `HasWizard` traits already do:
- Custom `resolveInitialStepFromQuery()` - already in `Wizard::getStartStep()`
- Custom `queryStepOverrideAllowed()` + `persistStepInQueryString()` - already in `Wizard`
- Custom `nextStep()`, `previousStep()` - already in `Wizard` component
- Custom `wizardMaxStep()` - not needed, `Wizard` handles this

### Correct Approach
```php
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    // Use Filament's traits ONLY if they match our base class
    // XotBaseWidget uses InteractsWithSchemas, not InteractsWithForms
    // So Actions\HasWizard (which uses ->schema()) might work
    
    // BUT: Keep Xot-specific additions:
    // - LangServiceProvider integration
    // - Security policy (query step override)
    // - Theme view switching (pub_theme::components.wizard)
}
```

### Key Insight
The `Wizard` component already handles 90% of what `XotBaseWizardWidget` does manually. The Xot layer should ONLY add:
1. **Security policy** - `queryStepOverrideAllowed()` 
2. **LangServiceProvider** - auto-label integration
3. **Theme switching** - `->view('pub_theme::components.wizard')`
4. **XotBaseResourceForm pattern** - `getWizardSteps()`, `getStepByName()`

## Philosophy / Zen
- **Don't reinvent** - `Wizard` component is battle-tested
- **Layer appropriately** - Xot layer = policy + lang + theme, NOT wizard mechanics
- **study before coding** - Vendor code is documentation

## References
- `vendor/filament/actions/src/Concerns/HasWizard.php`
- `vendor/filament/filament/src/Resources/Pages/Concerns/HasWizard.php`  
- `vendor/filament/schemas/src/Components/Wizard.php`
- `vendor/filament/schemas/resources/views/components/wizard.blade.php`
